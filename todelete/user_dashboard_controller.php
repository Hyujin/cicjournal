<?php

  class UserDashboard extends DB
  {
    private $user_info_view = array();
    private $user_info_table = array();
    private $course_table = array();
    private $major_table = array();
    private $user_info_cols = array(
      "first_name",
      "last_name",
      "middle_name",
      "sex",
      "address",
      "dob",
      "id_number",
      "reg_status"
    );
    private $student_detail_cols = array(
      "course_id",
      "major_id"
    );
    private $faculty_detail_cols = array(
      "employee_level"
    );
    private $user_cols_2be_used = array();
    private $user_table_name;
    private $user_email;
    private $user_type;
    private $error_msg;

    function __construct($user_email,$user_type)
    {
      parent::__construct();
      $this->user_email = $user_email;
      $this->user_type = $user_type;
      $this->course_table = parent::getTable("course");
      $this->major_table = parent::getTable("major");
      $this->user_info_table = parent::getTable("user_info");
      
    }

    /* FORCE UPDATE FUNCTIONS/METHODS */
    public function completeRegistration($data=[])
    {
      //Initialize tables 2 be used. (Student/Faculty) table
      $this->user_table_name = ($this->user_type == "STUDENT"?"student":"faculty");
      $this->user_cols_2be_used = ($this->user_type == "STUDENT"?$this->student_detail_cols:$this->faculty_detail_cols);

      array_pop($data); //remove submit button data
      $data['id_number'] = $this->normalizeSchoolId($data['id_number']);
      $escaped_school_details = array();
      $school_details_types = "";

      //Check required fields
      if(in_array("",$data)){
        $this->error_msg = "Please fill out required fields";
        return false;
      }

      if($this->idExist($data['id_number'])) {
        $this->error_msg = "This school ID is already in DB";
        return false;
      }

      //Escape data b4 inserting to db
      $escaped_data = $this->packData(parent::escapeData($data));

      for ($i=sizeof($escaped_data)-1; $i > 0; $i--) {
        if($i>7){
          array_push($escaped_school_details,$escaped_data[$i]);
          array_pop($escaped_data);
          $school_details_types.="s";
        }
      }
      array_push($escaped_data,$this->user_email);
      array_push($escaped_school_details,$this->user_email);

      $query1 = parent::constructUpdateQuery($this->user_info_cols,"user_info",array("email"));
      $query2 = parent::constructUpdateQuery($this->user_cols_2be_used,$this->user_table_name,array("email"));

      $essentials1 = array(
        "query" => $query1,
        "types" => "sssssssss",
        "data" => $escaped_data
      );
      $essentials2 = array(
        "query" => $query2,
        "types" => $school_details_types."s",
        "data" => $escaped_school_details
      );

      // Check query
      if(!parent::checkQuery($essentials1)){
        $this->error_msg = "SQL error - ERROR ID: ". parent::getSqlError();
        return false;
      }

      if(!parent::checkQuery($essentials2)){
        $this->error_msg = "SQL error - ERROR ID: ". parent::getSqlError();
        return false;
      }

      // //Execute constructed queries
      $grp_essentials = array(
        $essentials1,
        $essentials2
      );

      for ($i=0; $i < sizeof($grp_essentials); $i++) {
        if(!parent::executeQuery($grp_essentials[$i])){
          $this->error_msg = "SQL error - ERROR ID: ". parent::getSqlError();
          return false;
        }
      }

      // var_dump($escaped_data);
      // var_dump($student_details);
      return true;
    }

    public function isRegisterComplete()
    {
      $user_info = $this->getUserInformation($this->user_email);

      return $user_info['reg_status'] == "COMPLETE";
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

    public function packData($data=[])
    {
      $packed_data = array();
      $index = 0;
      foreach ($data as $dat) {
        $packed_data[$index] = $dat;
        $index++;
      }
      return $packed_data;
    }

    public function getSpecificCourse($course_id='')
    {
      for ($i=0; $i < sizeof($this->course_table); $i++) {
        if ($this->course_table['course_id'] == $course_id) {
          return $this->course_table['course_id'];
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
        if ($this->major_table['major_id'] == $major_id) {
          return $this->major_table['major_id'];
        }
      }
    }

    public function getAllStudents()
    {
      return $this->user_info_view;
    }

    public function getAllMajor()
    {
      return $this->major_table;
    }

    public function getUserInformation($email)
    {
      for ($i=0; $i < sizeof($this->user_info_view); $i++) {
        if($this->user_info_view[$i]['email'] == $email){
          return $this->user_info_view[$i];
        }
      }
      return null;
    }

    public function idExist($user_id)
    {
      // $user_index = ($this->user_type == "STUDENT" ? "stud_id" : "fac_id");
      for ($i=0; $i < sizeof($this->user_info_table); $i++) {
        if ($this->user_info_table[$i]["id_number"] == $user_id) {
          return true;
        }
      }
      return false;
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
