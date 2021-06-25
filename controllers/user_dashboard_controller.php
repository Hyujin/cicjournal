<?php

  class UserDashboard extends DB
  {
    private $login_insert_template = "INSERT INTO login
                                      (user_type, id_number, password)
                                      VALUES (?,?,?)";
    private $student_edit_template = "UPDATE student SET
                                      course_id = ?, major_id = ?
                                      WHERE id_number = ?";
    private $reginfo_edit_template = "UPDATE reg_info SET
                                      first_name = ?, middle_name = ?, last_name = ?,
                                      sex = ?, dob = ? WHERE id_number = ?";
    private $login_edit_template   = "UPDATE login SET
                                      id_number = ? WHERE id_number = ?";
    private $status_edit_template  = "UPDATE reg_info SET
                                      status = ? WHERE id_number = ?";
    private $students = array();
    private $course_table = array();
    private $major_table = array();
    private $login = array();
    private $reg_info = array();
    private $visitors_log = array();
    private $number_of_visits;
    private $default_password;
    private $id_number;
    private $user_type;
    private $tmp_file_destination;
    private $file_destination;
    private $error_msg;

    function __construct($id_number,$user_type)
    {
      parent::__construct();
      $this->id_number = $id_number;
      $this->user_type = $user_type;
      $this->default_password = '123';
      $this->number_of_visits = 0;
      $this->course_table = parent::getTable("course");
      $this->major_table = parent::getTable("major");
      $this->students = parent::getTable("student");
      $this->reg_info = parent::getTable("reg_info");
      $this->login = parent::getTable("login");
      $this->visitors_log = parent::getTable("visitors_log");
    }

    /* FORCE UPDATE FUNCTIONS/METHODS */

    public function isRegisterComplete()
    {
      $user_info = $this->getUserInformation($this->id_number);

      return $user_info['reg_status'] == "COMPLETE";
    }

    public function newUser($user_profile = [], $student_info = [], $credentials = [])
    {
      //Store id number to new holder
      $id_number = $credentials[1];

      //Check for empty fields
      if (in_array("",$user_profile) || in_array("",$student_info) || in_array("",$credentials)) {
        echo "naay empty!";
        //Error: empty fields
        return false;
      }

      //Check for id_number duplication
      if ($this->idNumberExist($id_number)) {
        echo "naa nas db";
        //Error: id number alread in db
        return false;
      }

      //Check if the admin uses default password for credentials
      if (sizeof($credentials)<3) {
        array_push($credentials,$this->hashPassword($this->default_password));
      }else{
        if ($credentials[2] != $credentials[3]) {
          //Error: password does not match
          return false;
        }
        $credentials[2] = $this->hashPassword($credentials[2]);
        array_pop($credentials);
      }

      array_push($user_profile,$id_number);
      array_push($student_info,$id_number);
      //Escape all data b4 inserting to db
      $credentials = parent::escapeData($credentials);
      $user_profile = parent::escapeData($user_profile);
      $student_info = parent::escapeData($student_info);

      var_dump($credentials);
      var_dump($user_profile);
      var_dump($student_info);

      if (parent::bulkExecute($this->login_insert_template, "sss", $credentials)) {
        // $recent_id = $this->getSpecificUserById(parent::getMaxIdFrom('login','user_id'));
        if (parent::bulkExecute($this->reginfo_edit_template, "ssssss", $user_profile)) {
          if ($credentials[0] == 'STUDENT') {
            if (parent::bulkExecute($this->student_edit_template, "iis", $student_info)) {
              return true;
            }
          }
          return true;
        }
      }
      return false;
    }

    public function deleteUser($id_number)
    {
      $query = "DELETE FROM login WHERE id_number = ?";
      $query2 = "DELETE FROM react WHERE id_number = ?";
      $query3 = "DELETE FROM comment WHERE id_number = ?";
      $query4 = "DELETE FROM visitors_log WHERE visitor = ? OR visited = ?";
      $to_delete = $this->getSpecificUser($id_number);
      $id_number = parent::escapeData(array($id_number));
      $is_file_empty = ($to_delete['prof_pic'] == null ? true : false);
      $to_unlink = "../profile_pictures/".$to_delete['prof_pic'];

      if ($to_delete['user_type'] != 'SUPER') {
        if (parent::bulkExecute($query, "s", $id_number)) {
          if (parent::bulkExecute($query2, "s", $id_number)) {
            if (parent::bulkExecute($query3, "s", $id_number)) {
              array_push($id_number,$id_number[0]);
              if (parent::bulkExecute($query4, "ss", $id_number)) {
                if (!$is_file_empty) {
                  if (unlink($to_unlink)) {
                    return true;
                  }else{
                    return false;
                  }
                }else{
                  return true;
                }
              }
            }
          }

        }else{
          echo "nisulod1";
          return false;
        }
      }
      echo "nisulod 3";
      return false;
    }

    public function editProfilePic($selected_file=[])
    {
      $user = $this->getSpecificUser($selected_file['id_number']);
      $prev_profpic = $user['prof_pic'];
      $profpic_empty = ($prev_profpic == NULL ? true : false);
      $query = "UPDATE reg_info SET prof_pic = ?
                WHERE id_number = ?";
      $to_edit = array();

      if(!isset($selected_file['pic_file']['name'])){
        $this->error_msg = "Please fill out required fields";
        return false;
      }

      if ($this->validateFile($selected_file)) {

        array_push($to_edit,basename($this->file_destination));
        array_push($to_edit,$selected_file['id_number']);
        var_dump($to_edit);

        if ($profpic_empty) {
          if (parent::bulkExecute($query, "ss", $to_edit)) {
            if (move_uploaded_file($this->tmp_file_destination, $this->file_destination)) {
              return true;
            }
          }
        }else{
          //Unlink first prof_pic from local diretory
          $to_unlink = "../profile_pictures/".$prev_profpic;
          if (unlink($to_unlink)) {
            if (parent::bulkExecute($query, "ss", $to_edit)) {
              if (move_uploaded_file($this->tmp_file_destination, $this->file_destination)) {
                return true;
              }
            }
          }
        }

      }else{

        return false;
      }

      return false;

    }

    public function validateFile($file)
    {
      // var_dump($file['pic_file']);
      $original_file_name = $file['pic_file']['name'];
      $this->tmp_file_destination = $file['pic_file']['tmp_name'];
      $error = $file['pic_file']['error'];
      $file_size = $file['pic_file']['size'];
      $exploded_file_name = explode(".",$original_file_name);
      $file_extension = strtolower(end($exploded_file_name));
      $allowed_extensions = array('jpg','jpeg','png');

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
      $file['pic_file']['unique_file_name'] = uniqid("file-",true);
      $this->file_destination = "../profile_pictures/".$file['pic_file']['unique_file_name'].".".$file_extension;
      $this->tmp_file_destination = $file['pic_file']['tmp_name'];

      return true;
    }

    public function editStudentDetails($data)
    {
      $data = parent::escapeData($data);

      if (parent::bulkExecute($this->student_edit_template, "iis", $data)) {
        return true;
      }
      return false;
    }

    public function editRegInfo($data)
    {
      $data = parent::escapeData(parent::packData($data));

      if (parent::bulkExecute($this->reginfo_edit_template, "ssssss", $data)) {
        return true;
      }
      return false;
    }

    public function editLoginDetials($data)
    {
      $data = parent::escapeData($data);

      if (!$this->idNumberExistExcept($data[0],$data[1])) {
        if (parent::bulkExecute($this->login_edit_template, "ss", $data)) {
          return true;
        }
      }

      return false;
    }

    public function idNumberExistExcept($new_id_number,$old_id_number)
    {
      //Check if new id number and old id number is the same. If yes data is valid
      if ($new_id_number == $old_id_number) {
        return false;
      }

      for ($i=0; $i < sizeof($this->login); $i++) {
        if ($new_id_number == $this->login[$i]['id_number']) {
          return true;
        }
      }

      return false;
    }

    public function checkStatus($id_number)
    {
      return $this->getSpecificUser($id_number)['status'] == 'ENABLED';
    }

    public function setAccountStatus($data)
    {
      $data = parent::escapeData(parent::packData($data));

      return parent::bulkExecute($this->status_edit_template, "ss", $data);
    }

    public function idNumberExist($id_number)
    {
      for ($i=0; $i < sizeof($this->reg_info); $i++) {
        if ($id_number == $this->reg_info[$i]['id_number']) {
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

    public function getSpecificCourse($course_id='')
    {
      for ($i=0; $i < sizeof($this->course_table); $i++) {
        if ($this->course_table['course_id'] == $course_id) {
          return $this->course_table['course_id'];
        }
      }
    }

    public function getSpecificMajor($major_id='')
    {
      for ($i=0; $i < sizeof($this->major_table); $i++) {
        if ($this->major_table['major_id'] == $major_id) {
          return $this->major_table['major_id'];
        }
      }
    }

    public function getAllStudents()
    {
      return $this->students;
    }

    public function getAllCourse()
    {
      return $this->course_table;
    }

    public function getAllMajor()
    {
      return $this->major_table;
    }

    public function getSpecificUser($id_number)
    {
      for ($i=0; $i < sizeof($this->reg_info); $i++) {
        if ($id_number == $this->reg_info[$i]['id_number']) {
          $login_details = $this->getLoginDetails($id_number);
          $student_details = $this->getStudentDetails($id_number);
          $this->reg_info[$i]['user_type'] = $login_details['user_type'];
          $this->reg_info[$i]['password'] = $login_details['password'];
          $this->reg_info[$i]['course_id'] = $student_details['course_id'];
          $this->reg_info[$i]['major_id'] = $student_details['major_id'];
          return $this->reg_info[$i];
        }
      }
      return  null;
    }

    public function getSpecificUserById($id)
    {
      // $id_numbers
      for ($i=0; $i < sizeof($this->reg_info); $i++) {
        if ($id == $this->reg_info[$i]['id']) {
          $login_details = $this->getLoginDetails($this->reg_info[$i]['id_number']);
          $student_details = $this->getStudentDetails($this->reg_info[$i]['id_number']);
          $this->reg_info[$i]['user_type'] = $login_details['user_type'];
          $this->reg_info[$i]['password'] = $login_details['password'];
          $this->reg_info[$i]['course_id'] = $student_details['course_id'];
          $this->reg_info[$i]['major_id'] = $student_details['major_id'];
          return $this->reg_info[$i];
        }
      }
      return  null;
    }

    public function getLoginDetails($id_number)
    {
      for ($i=0; $i < sizeof($this->login) ; $i++) {
        if ($id_number == $this->login[$i]['id_number']) {
          return $this->login[$i];
        }
      }
      return false;
    }

    public function getStudentDetails($id_number)
    {
      for ($i=0; $i < sizeof($this->students) ; $i++) {
        if ($id_number == $this->students[$i]['id_number']) {
          return $this->students[$i];
        }
      }
      return false;
    }

    public function setVisit($visited,$visitor)
    {
      $query = "INSERT INTO visitors_log
                (visited, visitor) VALUES
                (?,?)";
      $data = parent::escapeData(array($visited,$visitor));

      if (parent::bulkExecute($query,"ss",$data)) {
        return true;
      }
      return false;
    }

    public function getVisitors($id_number)
    {
      $to_return = array();
      for ($i=0; $i < sizeof($this->visitors_log); $i++) {
        if ($this->visitors_log[$i]['visited'] == $id_number) {
          array_push($to_return, $this->visitors_log[$i]);
        }
      }

      return $to_return;
    }

    public function getLastVisit($visited,$visitor)
    {
      $last_visited = "";
      $this->number_of_visits = 0;
      for ($i=0; $i < sizeof($this->visitors_log); $i++) {
        if ($this->visitors_log[$i]['visited'] == $visited && $this->visitors_log[$i]['visitor'] == $visitor) {
          $last_visited = $this->visitors_log[$i]['date'];
          $this->number_of_visits++;
        }
      }
      $last_visited = date_create($last_visited);
      $last_visited = date_format($last_visited, "F d, Y");
      return $last_visited;
    }

    public function getNumberOfVisits()
    {
      return $this->number_of_visits;
    }

    public function hashPassword($data)
    {
      return password_hash($data,PASSWORD_BCRYPT);
    }

    public function getError()
    {
      return $this->error_msg;
    }

    public function getLoggedUserType()
    {
      return $this->user_type;
    }

  }
 ?>
