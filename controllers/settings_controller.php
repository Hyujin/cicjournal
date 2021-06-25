<?php

class Settings extends DB
{
  private $insert_activity_template = "INSERT INTO activity_log
                                     (id_number,activity) VALUES
                                     (?,?)";
  private $select_last_template = "SELECT * from activity_log WHERE
                                    activity = 'LOGGED IN' and id_number = ?
                                    ORDER BY id DESC";
  private $course_table = array();
  private $major_table = array();
  private $category_table = array();
  private $activity_table = array();
  private $user_cols_2be_used = array();
  private $user_table_name;
  private $error_msg;

  function __construct()
  {
    parent::__construct();
    $this->course_table = parent::getTable("course");
    $this->major_table = parent::getTable("major");
    $this->category_table = parent::getTable("category");
    $this->activity_table = parent::getTable("activity_log");
  }

  /* FORCE UPDATE FUNCTIONS/METHODS */
  public function addNewActivity($data,$user_type)
  {
    $data = parent::escapeData($data);
    if ($user_type == "SUPER") {
      if (parent::bulkExecute($this->insert_activity_template, "ss", parent::packData($data))) {
        return true;
      }
    }
    return false;
  }

  public function normalizeSchoolId($school_id)
  {
    $exploded_string = explode("-",$school_id);
    $to_return = "";
    foreach ($exploded_string as $string) {
      $to_return.=$string;
    }
    return $to_return;
  }

  public function getLastLogin($id_number)
  {
    $to_return = array();
    for ($i=0; $i < sizeof($this->activity_table); $i++) {
      if ($this->activity_table[$i]['id_number'] == $id_number && $this->activity_table[$i]['activity'] == 'LOGGED IN') {
        array_push($to_return,$this->activity_table[$i]);
      }
    }

    if (sizeof($to_return) == 0) {
      $to_return[0]['date_time'] = 'No last login';
    }

    return $to_return[sizeof($to_return)-1];
  }

  public function getAllActivity()
  {
    return $this->activity_table;
  }

  public function addItem($data=[])
  {
    $table = "";
    if ($data['index'] == 'course') {
      $table = "course";
    }elseif ($data['index'] == "major") {
      $table = "major";
    }else{
      $table = "category";
    }

    if (empty($data['name']) || empty($data['index']) ) {
      return false;
    }

    //Check if item name exist
    if ($this->nameExist($data['name'], $data['index']) ) {
      return false;
    }

    array_pop($data);

    $query = "INSERT INTO $table
              (name) VALUES (?)";

    $data = parent::escapeData(parent::packData($data));

    if (parent::bulkExecute($query, "s", $data)) {
      return true;
    }
    return false;
  }

  public function editItemName($data=[])
  {
    $table = "";
    $id = "";

    if ($data['index'] == 'course') {
      $table = "course";
      $id = "course_id";
    }elseif ($data['index'] == "major") {
      $table = "major";
      $id = "major_id";
    }else{
      $table = "category";
      $id = "category_id";
    }

    // Check if item name exist
    if ($this->nameExistExcept($data['name'], $data['to_edit'],  $data['index'])) {
      return false;
    }

    $query = "UPDATE $table SET name = ?
              WHERE $id = ?";

    $data = parent::escapeData(array($data['name'], $data['to_edit']));

    if (parent::bulkExecute($query, "si", $data)) {
      return true;
    }
    return false;
  }

  public function nameExistExcept($title='',$item_id='',$view_type)
  {
    //titleofthefuckingpaper - exist in db, title of to edit paper
    //Test tile of oaoer ni sya!!! -- exist in db, not title of to edit paper
    //test title ni sya - not existed in db, not title of to edit paper
    $to_test = array();
    $tmp_title = "";

    if ($view_type == 'course') {
      $tmp_title = $this->getSpecificCourse($item_id)['name'];
      $to_test = $this->course_table;
    }elseif ($view_type == "major") {
      $tmp_title = $this->getSpecificMajor($item_id)['name'];
      $to_test = $this->major_table;
    }else{
      $tmp_title = $this->getSpecicCategory($item_id)['name'];
      $to_test = $this->category_table;
    }

    if ($tmp_title == $title) {
      return false;
    }

    for ($i=0; $i < sizeof($to_test); $i++) {
      if($this->sanitizeName($title) == $this->sanitizeName($to_test[$i]['name'])){
        return true;
      }
    }
    return false;
  }

  public function nameExist($title='',$view_type)
  {
    //titleofthefuckingpaper - exist in db, title of to edit paper
    //Test tile of oaoer ni sya!!! -- exist in db, not title of to edit paper
    //test title ni sya - not existed in db, not title of to edit paper
    $to_test = array();

    if ($view_type == 'course') {
      $to_test = $this->course_table;
    }elseif ($view_type == "major") {
      $to_test = $this->major_table;
    }else{
      $to_test = $this->category_table;
    }

    for ($i=0; $i < sizeof($to_test); $i++) {
      if($this->sanitizeName($title) == $this->sanitizeName($to_test[$i]['name'])){
        return true;
      }
    }
    return false;
  }

  public function sanitizeName($name)
  {
    $to_return = strtolower($name);
    $to_return = preg_replace("/[\s]+/","",$to_return);

    return $to_return;
  }

  public function deleteItem($data)
  {
    $table = "";
    $id = "";
    if ($data['view_type'] == 'course') {
      $table = "course";
      $id = "course_id";
    }elseif ($data['view_type'] == "major") {
      $table = "major";
      $id = "major_id";
    }else{
      $table = "category";
      $id = "category_id";
    }

    $query = "DELETE FROM $table
              WHERE $id = ?";
    $to_delete = parent::escapeData(array($data['id']));

    if (parent::bulkExecute($query, "i", $to_delete)) {
      return true;
    }
    return false;
  }

  public function getItemInfo($view_type,$id)
  {

    if ($view_type == "course") {
      return $this->getSpecificCourse($id);
    }elseif($view_type == "major"){
      return $this->getSpecificMajor($id);
    }else{
      return $this->getSpecicCategory($id);
    }
    return null;
  }

  public function getSpecicCategory($category_id='')
  {
    for ($i=0; $i < sizeof($this->category_table); $i++) {
      if ($this->category_table[$i]['category_id'] == $category_id) {
        return $this->category_table[$i];
      }
    }
    return null;
  }

  public function getAllCategory()
  {
    return $this->category_table;
  }

  public function getSpecificCourse($course_id='')
  {
    for ($i=0; $i < sizeof($this->course_table); $i++) {
      if ($this->course_table[$i]['course_id'] == $course_id) {
        return $this->course_table[$i];
      }
    }
  }

  public function getAllCourse()
  {
    return $this->course_table;
  }

  public function getSpecificMajor($major_id='')
  {
    for ($i=0; $i < sizeof($this->major_table); $i++) {
      if ($this->major_table[$i]['major_id'] == $major_id) {
        return $this->major_table[$i];
      }
    }
  }

  public function getAllMajor()
  {
    return $this->major_table;
  }

  public function getError()
  {
    return $this->error_msg;
  }

}


 ?>
