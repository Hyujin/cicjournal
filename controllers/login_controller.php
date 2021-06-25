<?php
  class Login extends DB
  {
    private $register_template = "INSERT INTO login
                                  (id_number, password, user_type)
                                  VALUES (?,?,?)";
    private $login_template = "SELECT * FROM login WHERE id_number = ?";
    private $user_info_tbl = array();
    private $login_tbl = array();
    private $login_tbl_cols = array('user_type','email','password');
    private $register_types = "sss";
    private $login_types = "s";
    private $user_type_login;
    private $error_msg;

    function __construct()
    {
      parent::__construct();
      // echo password_hash("123",PASSWORD_BCRYPT);
      $this->login_tbl = parent::getTable("login");
    }

    public function register($data)
    {
      $data['password'] = $this->sanitizePassword($data['password']);

      if (parent::prepareStmt($this->register_template)) {
        if (parent::bindStmt($this->register_types,$data)) {
          if (parent::executePreparedStmt()) {
            return true;
          }
        }
      }
    }

    public function changePassword($data)
    {
      $query = "UPDATE login SET password = ?
                WHERE id_number = ?";
      $this_user = $this->getSpecificCredentials($data['id_number']);
      if (empty($data['current_password']) || empty($data['new_password']) || empty($data['confirm_password'])) {
        return false;
      }

      if (!password_verify($data['current_password'],$this_user['password'])) {
        // $this->error_msg = 'Incorrect password';
        echo $this->error_msg;
        return false;
      }

      if (password_verify($data['new_password'],$this_user['password'])) {
        // $this->error_msg = 'New password should not be your previous password';
        echo $this->error_msg;
        return false;
      }

      if ($data['new_password'] != $data['confirm_password']) {
        // $this->error_msg = 'Password does not match';
        echo $this->error_msg;
        return false;
      }

      if (parent::bulkExecute($query, "ss", array( $this->sanitizePassword($data['new_password']), $data['id_number']))) {
        return true;
      }
      return false;
    }

    public function newLogin($data=[])
    {
      $password = $data['password'];
      array_pop($data);
      if (parent::prepareStmt($this->login_template)) {
        if (parent::bindStmt($this->login_types,$data)) {
          if (parent::executePreparedStmt()) {
            $tmp = parent::getStmtResult()->fetch_assoc();
            $hashed_password = $tmp['password'];
            if (password_verify($password,$hashed_password)) {
              $this->user_type_login = $tmp['user_type'];
              return true;
            }
          }
        }
      }
      return false;
    }

    public function getUserType()
    {
      return $this->user_type_login;
    }

    public function getSpecificCredentials($id_number)
    {
      for ($i=0; $i < sizeof($this->login_tbl); $i++) {
        if ($id_number == $this->login_tbl[$i]['id_number']) {
          return $this->login_tbl[$i];
        }
      }
    }

    public function sanitizePassword($data)
    {
      return password_hash($data,PASSWORD_BCRYPT);
    }

  }

 ?>
