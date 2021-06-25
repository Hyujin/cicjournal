<?php

  class DB extends DBConnect
  {
    private $stmt;
    private $sql_error;
    private $db_connect;
    private $packed_data;

    function __construct()
    {
      parent::__construct();
      $this->db_connect = parent::getConnection();
      $this->stmt = "";
      $this->sql_error = "";
      $this->packed_data = [];
    }

    public function prepareStmt($query)
    {
      $this->stmt = $this->db_connect->prepare($query);

      if ($this->stmt) {
        return true;
      }
      return false;
    }

    public function bindStmt($types, $data=[])
    {
      $this->packed_data = $this->packData($data);
      if ($this->stmt->bind_param($types,...$this->packed_data)) {
        return true;
      }
      return false;
    }

    public function executePreparedStmt()
    {
      if ($this->stmt->execute()) {
        return true;
      }
      return false;
    }

    public function bulkExecute($query='',$types='',$data=[])
    {
      if ($this->prepareStmt($query)) {
        if ($this->bindStmt($types,$data)) {
          if ($this->executePreparedStmt()) {
            return true;
          }
        }
      }
      echo mysqli_error($this->db_connect);
      return false;
    }

    public function changeDataStmt($data=[])
    {
      $this->packed_data = $this->packData($data);
    }

    public function getTable($table='')
    {
      $OBJECT = array();
      $query = "SELECT * FROM $table";
      $result = mysqli_query($this->db_connect,$query);
      $counter = 0;
      if(!$result){
        // echo mysqli_error($this->con);
      }
      while ($instance = mysqli_fetch_assoc($result)) {
        $OBJECT[$counter] = $instance;
        $counter++;
      }
      return $OBJECT;
    }

    public function getTableOrderBy($table='',$order='',$target_order)
    {
      $OBJECT = array();
      $query = "SELECT * FROM $table ORDER BY($target_order) $order";
      $result = mysqli_query($this->db_connect,$query);
      $counter = 0;
      if(!$result){
        // echo mysqli_error($this->con);
      }
      while ($instance = mysqli_fetch_assoc($result)) {
        $OBJECT[$counter] = $instance;
        $counter++;
      }
      return $OBJECT;
    }

    public function getStmtResult()
    {
      $tmp_result = $this->stmt->get_result();
      return $tmp_result;
    }

    public function packData($data=[])
    {
      $tmp_pack = [];
      $counter = 0;

      foreach ($data as $single_data) {
        $tmp_pack[$counter] = $single_data;
        $counter++;
      }
      return $tmp_pack;
    }

    public function escapeSingle($data)
    {
      return mysqli_real_escape_string($this->db_connect,$data);
    }

    public function escapeData($data=[])
    {
      for ($i=0; $i < sizeof($data); $i++) {
        $data[$i] = mysqli_real_escape_string($this->db_connect,$data[$i]);
      }
      return $data;
    }

    public function escapeUnpack($data=[])
    {
      foreach ($data as $key=>$value) {
        $data[$key] = mysqli_real_escape_string($this->db_connect,$value);
      }
      return $data;
    }

    public function getMaxIdFrom($table,$id)
    {
      $query = "SELECT MAX($id) AS MAX_ID FROM $table";
      $result = mysqli_query($this->db_connect,$query);

      return mysqli_fetch_assoc($result)['MAX_ID'];
    }

  }

 ?>
