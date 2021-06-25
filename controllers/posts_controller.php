<?php

  class Posts extends DB
  {
    private $post_template = "INSERT INTO post
                              (title,synopsis,year_publish,category_id,id_number,file_name)
                              VALUES(?,?,?,?,?,?)";
    private $post_edit_template = "UPDATE post SET title=?, synopsis=?, year_publish=?, category_id=?,
                                   file_name=? WHERE post_id=?";
    private $post_delete_template = "DELETE FROM post WHERE post_id = ?";
    private $author_template = "INSERT INTO author
                                (id_number,post_id)
                                VALUES(?,?)";
    private $author_delete_template = "DELETE FROM author WHERE post_id=?";
    private $status_edit_template = "UPDATE post SET status=? WHERE post_id=? ";
    private $post_table = array();
    private $authors_table = array();
    private $category_table = array();
    private $react_table = array();
    private $comment_table = array();
    private $tmp_file_destination;
    private $file_destination;
    private $id_number;
    private $user_type;
    private $error_msg;

    function __construct($id_number,$user_type)
    {
      parent:: __construct();
      $this->user_type = $user_type;
      $this->id_number = $id_number;
      $this->post_table = parent::getTable("post");
      $this->authors_table = parent::getTable("author");
      $this->category_table = parent::getTable("category");
      $this->react_table = parent::getTable("react");
      $this->comment_table = parent::getTableOrderBy("comment",'ASC','comment_date');
    }

    public function newPost($data=[],$selected_file=[])
    {
      // Check for empty fields

      if(!isset($selected_file['post_file']['name']) || in_array("",$data)){
        $this->error_msg = "Please fill out required fields";
        return false;
      }

      //Check title uniqueness
      if ($this->titleExist($this->sanitizeTitle($data['title']))) {
        $this->error_msg = "This title is already taken";
        return false;
      }

      //Check if there will be errors uploading file
      if ($this->validateFile($selected_file)) {
        //Separate authors and post data for cleaner and readable query
        $authors = (isset($data['authors']) ? array_pop($data) : array());

        //Insert file name and admin email to post array
        $data['admin'] = $this->id_number;
        $data['file_name'] = basename($this->file_destination);

        //Escape all data b4 inserting to DB
        $authors = parent::escapeData($authors);
        $data = parent::escapeUnpack($data);
        var_dump($data);
        if (parent::bulkExecute($this->post_template,"ssiiss",$data)) {
          if (move_uploaded_file($this->tmp_file_destination, $this->file_destination)) {

            if (!empty($authors)) {
              $recent_post = parent::getMaxIdFrom("post","post_id");
              if (parent::prepareStmt($this->author_template)) {
                for ($i=0; $i < sizeof($authors); $i++) {
                  if (parent::bindStmt("si",array($authors[$i],$recent_post))) {
                    if (!parent::executePreparedStmt()) {
                      return false;
                    }
                  }
                }
              }
            }

          }
        }
      }else{
        return false;
      }
      return true;
    }

    public function editPaper($data=[],$selected_file=[],$post_id)
    {

      $flag = true; //Uploaded a new file
      // Check if user uploaded a new file or not
      if ($selected_file['post_file']['error'] != 0) {
        $flag = false;
      }

      // Check for empty fields
      if(in_array("",$data)){
        $this->error_msg = "Please fill out required fields";
        return false;
      }

      //Check title uniqueness
      if ($this->titleExistExcept($this->sanitizeTitle($data['title']),$post_id) ) {
        $this->error_msg = "This title is already taken";
        return false;
      }

      if ($flag) {

        if ($this->validateFile($selected_file)) {
          //Separate authors and post data for cleaner and readable query
          $to_unlink = array_pop($data);
          $authors = (isset($data['authors']) ? array_pop($data) : array());

          //Insert file name and admin email to post array
          $data['file_name'] = basename($this->file_destination);
          $data['post_id'] = $post_id;
          var_dump($data);
          //Escape all data b4 inserting to DB
          $authors = parent::escapeData($authors);
          $data = parent::escapeUnpack($data);

          if (parent::bulkExecute($this->post_edit_template,"ssiiss",$data)) {
            unlink($to_unlink);
            if (move_uploaded_file($this->tmp_file_destination, $this->file_destination)) {
              if (parent::bulkExecute($this->author_delete_template,"i",array($data['post_id']))) {
                if (!empty($authors)) {
                  if (parent::prepareStmt($this->author_template)) {
                    for ($i=0; $i < sizeof($authors); $i++) {
                      if (parent::bindStmt("si",array($authors[$i],$data['post_id']))) {
                        if (!parent::executePreparedStmt()) {
                          return false;
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }else{
        //If no new upload from user, use the existing filename in db for update
        $existing_file_name = $this->getSpecificPaper($post_id)['file_name'];

        //Separate authors and post data for cleaner and readable query
        $to_unlink = array_pop($data);
        $authors = (isset($data['authors']) ? array_pop($data) : array());

        //Insert file name and paper id to post array
        $data['file_name'] = $existing_file_name;
        $data['post_id'] = $post_id;

        //Escape all data b4 inserting to DB
        $authors = parent::escapeData($authors);
        $data = parent::escapeUnpack($data);
        var_dump($authors);
        if (parent::bulkExecute($this->post_edit_template,"ssiisi",$data)) {
          if (parent::bulkExecute($this->author_delete_template,"i",array($data['post_id']))) {
            if (!empty($authors)) {
              if (parent::prepareStmt($this->author_template)) {
                for ($i=0; $i < sizeof($authors); $i++) {
                  if (parent::bindStmt("si",array($authors[$i],$data['post_id']))) {
                    if (!parent::executePreparedStmt()) {
                      return false;
                    }
                  }
                }
              }
            }
          }
        }
      }
      return true;
    }

    public function deletePost($post_id)
    {
      $query2 = "DELETE FROM react WHERE post_id = ?";
      $query3 = "DELETE FROM comment WHERE post_id = ?";
      $file_name = $this->getSpecificPaper($post_id)['file_name'];
      $to_unlink = '../file_uploads/'.$file_name;

      if (parent::bulkExecute($this->author_delete_template,"i",array($post_id))) {
        if (parent::bulkExecute($this->post_delete_template,"i",array($post_id))) {
          if (parent::bulkExecute($query2,"i",array($post_id))) {
            if (parent::bulkExecute($query2,"i",array($post_id))) {
              if (unlink($to_unlink)) {
                return true;
              }
            }
          }
        }
      }
      return false;
    }

    public function validateFile($file)
    {
      // var_dump($file['post_file']);
      $original_file_name = $file['post_file']['name'];
      $this->tmp_file_destination = $file['post_file']['tmp_name'];
      $error = $file['post_file']['error'];
      $file_size = $file['post_file']['size'];
      $exploded_file_name = explode(".",$original_file_name);
      $file_extension = strtolower(end($exploded_file_name));
      $allowed_extensions = array('pdf');

      if ($error!=0) {
        $this->error_msg = "Failed upon uploading file";
        return false;
      }

      if (!in_array($file_extension,$allowed_extensions)) {
        $this->error_msg = "Invalid file type";
        return false;
      }

      if ($file_size > 10000000) {
        $this->error_msg = "File is too big";
        return false;
      }
      $file['post_file']['unique_file_name'] = uniqid("file-",true);
      $this->file_destination = "../file_uploads/".$file['post_file']['unique_file_name'].".".$file_extension;
      $this->tmp_file_destination = $file['post_file']['tmp_name'];

      return true;
    }

    public function checkVisibility($post_id)
    {
      $to_return = $this->getSpecificPaper($post_id)['status'];
      return $to_return == 'ACTIVE';
    }

    public function setStatus($data)
    {
      $data = parent::escapeUnpack($data);

      return parent::bulkExecute($this->status_edit_template,"si",parent::packData($data));
    }

    public function sanitizeTitle($title)
    {
      $to_return = strtolower($title);
      $to_return = preg_replace("/[\s]+/","",$to_return);

      return $to_return;
    }

    public function titleExist($title='')
    {
      for ($i=0; $i < sizeof($this->post_table); $i++) {
        $this->post_table[$i]['title'] = $this->sanitizeTitle($this->post_table[$i]['title']);
        if($this->post_table[$i]['title'] == $title){
          return true;
        }
      }
      return false;
    }

    public function titleExistExcept($title='',$post_id='')
    {
      //titleofthefuckingpaper - exist in db, title of to edit paper
      //Test tile of oaoer ni sya!!! -- exist in db, not title of to edit paper
      //test title ni sya - not existed in db, not title of to edit paper
      $tmp_title = $this->sanitizeTitle($this->getSpecificPaper($post_id)['title']);

      if ($tmp_title == $title) {
        return false;
      }

      for ($i=0; $i < sizeof($this->post_table); $i++) {
        if($title == $this->sanitizeTitle($this->post_table[$i]['title'])){
          return true;
        }
      }
      return false;
    }

    public function getSpecificPaper($post_id)
    {
      for ($i=0; $i < sizeof($this->post_table); $i++) {
        if ($post_id == $this->post_table[$i]['post_id']) {
          return $this->post_table[$i];
        }
      }
      return null;
    }

    public function getPaperAuthors($post_id)
    {
      $to_return = array();
      for ($i=0; $i < sizeof($this->authors_table); $i++) {
        if ($post_id == $this->authors_table[$i]['post_id']) {
          array_push($to_return,$this->authors_table[$i]['id_number']);
        }
      }
      return $to_return;
    }

    public function getRecentPaper($post_size)
    {
      $to_return = array();
      if ($post_size != 0) {
        $post_limit = ($post_size > 3 ? 3 : $post_size); //will refer to array index
        $to_return = array();
        $loop_limit = sizeof($this->post_table) - ($post_limit + 1);
        for ($i=sizeof($this->post_table)-1; $i > $loop_limit; $i--) {
          array_push($to_return, $this->post_table[$i]);
        }
      }
      return $to_return;
    }

    public function setComment($data='')
    {
      $query = "INSERT INTO comment
                (post_id, id_number, comment) VALUES
                (?,?,?)";
      $data = parent::escapeData(parent::packData($data));

      if (parent::bulkExecute($query, "iss", $data)) {
        return true;
      }
      return false;
    }

    public function editComment($data)
    {
      $query = "UPDATE comment SET comment = ?
                WHERE id = ?";

      $data = parent::escapeData(parent::packData($data));

      if (parent::bulkExecute($query,"si", $data)) {
        return true;
      }
      return false;
    }

    public function deleteComment($id)
    {
      $query = "DELETE FROM comment WHERE id = ?";

      $id = parent::escapeData(array($id));

      if (parent::bulkExecute($query,"i", $id)) {
        return true;
      }
      return false;
    }

    public function getComments($post_id)
    {
      $to_return = array();
      $counter = 0;
      for ($i=0; $i < sizeof($this->comment_table); $i++) {
        if ($this->comment_table[$i]['post_id'] == $post_id) {
          $to_return[$counter]['id'] = $this->comment_table[$i]['id'];
          $to_return[$counter]['id_number'] = $this->comment_table[$i]['id_number'];
          $to_return[$counter]['comment'] = $this->comment_table[$i]['comment'];
          $to_return[$counter]['comment_date'] = $this->comment_table[$i]['comment_date'];
          $counter ++;
        }
      }
      return $to_return;
    }

    public function setReaction($data=[])
    {
      $query = "INSERT INTO react
                (post_id,id_number,react_type) VALUES
                (?,?,?)";
      $query2 = "UPDATE react SET react_type = ?
                WHERE post_id = ? AND id_number = ?";

      $query3 = "DELETE FROM react WHERE post_id = ? AND id_number = ?";

      $data = parent::escapeData(parent::packData($data));
      $post_id = $data[0];
      $id_number = $data[1];
      $react_type = $data[2];

      if (!$this->reactionExist($post_id, $id_number)) {
        if (parent::bulkExecute($query, "iss", $data)) {
          return true;
        }
      }else{
        $student_db_react = $this->getStudentReaction($post_id, $id_number);
        $flag = ($student_db_react == $react_type ? true : false);

        if (!$flag) {
          if (parent::bulkExecute($query2, "sis",array($react_type, $post_id, $id_number))) {
            return true;
          }
        }else{
          if (parent::bulkExecute($query3, "is",array($post_id, $id_number))) {
            return true;
          }
        }
      }
      return false;
    }

    public function getStudentReaction($post_id, $id_number)
    {
      for ($i=0; $i < sizeof($this->react_table); $i++) {
        if ($this->react_table[$i]['post_id'] == $post_id && $this->react_table[$i]['id_number'] == $id_number) {
          return $this->react_table[$i]['react_type'];
        }
      }
      return "";
    }

    public function reactionExist($post_id,$id_number)
    {
      for ($i=0; $i < sizeof($this->react_table); $i++) {
        if ($this->react_table[$i]['post_id'] == $post_id && $this->react_table[$i]['id_number'] == $id_number) {
          return true;
        }
      }
      return false;
    }

    public function likeExist($post_id,$id_number)
    {
      for ($i=0; $i < sizeof($this->react_table); $i++) {
        if ($this->react_table[$i]['post_id'] == $post_id &&
            $this->react_table[$i]['id_number'] == $id_number &&
            $this->react_table[$i]['react_type'] == "LIKE") {
          return true;
        }
      }
      return false;
    }

    public function getReactionCount($post_id,$react_type)
    {
      $count = 0;
      for ($i=0; $i < sizeof($this->react_table); $i++) {
        if ($this->react_table[$i]['react_type'] == $react_type && $this->react_table[$i]['post_id'] == $post_id) {
          $count++;
        }
      }
      return $count;
    }

    public function getTaggedPosts($id_number)
    {
      $posts = array();
      for ($i=0; $i < sizeof($this->authors_table); $i++) {
        if ($this->authors_table[$i]['id_number'] == $id_number) {
          array_push($posts, $this->getSpecificPaper($this->authors_table[$i]['post_id']));
        }
      }
      return $posts;
    }

    public function paginate($posts)
    {
      // 0 5
      // 5 10
      //6s posts

      $posts = $this->removeInactive($posts);
      $starting = 0;
      $limit = ( 5 > sizeof($posts) ? sizeof($posts) :  5 );
      $to_return = array();
      $to_pack = array();
      $pages_per_index = ceil(sizeof($posts) / 5); //1
      // echo $limit;
      for ($i=0; $i < $pages_per_index; $i++) {
        for ($j = $starting; $j < $limit; $j++) {
          if ($posts[$j]['status'] != 'INACTIVE') {
            array_push($to_pack,$posts[$j]);
            continue;
          }
        }
        array_push($to_return,$to_pack);
        $to_pack = array();
        $starting = $starting + 5; //5
        $limit = ( ($limit+5) > sizeof($posts) ? sizeof($posts) :  ($limit+5));
      }
      return $to_return;
    }

    public function getPostRating($post_id)
    {
      //FORMULA: (dislike / numberofreact) x 100 = x%
      //Student = 6

      $post_likes = 0;
      $post_dislikes = 0;

      for ($i=0; $i < sizeof($this->react_table); $i++) {
        if ( ($this->react_table[$i]['post_id'] == $post_id) && ($this->react_table[$i]['react_type'] == 'LIKE') ) {
          $post_likes++;
        }else if( ($this->react_table[$i]['post_id'] == $post_id) && ($this->react_table[$i]['react_type'] == 'UNLIKE') ){
          $post_dislikes++;
        }
      }

      // return ceil(($post_dislikes / $post_likes) * 100);
    }

    public function removeInactive($posts)
    {
      for ($i=0; $i < sizeof($posts); $i++) {
        if ($posts[$i]['status'] == 'INACTIVE') {
          unset($posts[$i]);
          array_splice($posts,$i,0);
        }
      }
      $to_return = array();
      $to_return = $posts;
      // var_dump($to_return);
      return $to_return;
    }

    public function getAllPostByCategory($category='')
    {
      $to_return = array();
      for ($i=0; $i < sizeof($this->post_table); $i++) {
        if ($this->post_table[$i]['category_id'] == $category) {
          array_push($to_return,$this->post_table[$i]);
        }
      }
      // var_dump($to_return);
      return $to_return;
    }

    public function getAllPost()
    {
      return $this->post_table;
    }

    public function getAllAuthor()
    {
      return $this->authors_table;
    }

    public function getError()
    {
      return $this->error_msg;
    }

  }

 ?>
