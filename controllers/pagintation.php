<?php

  class Paginate extends DBConnect
  {
    private $number_per_page;
    private $number_of_result;
    private $total_pages;
    private $starting_limit;
    private $query;
    private $posts_per_page;
    private $con;

    function __construct($number_per_page)
    {
      parent::__construct();
      $this->con = parent::getConnection();
      $this->number_per_page = $number_per_page;

    }

    public function sanitize($data)
    {
      // echo mysqli_real_escape_string($this->con,$data);
      return mysqli_real_escape_string($this->con,$data);
    }

    public function getNumberOfResult($query="")
    {
      $this->number_of_result = mysqli_query($this->con,$query);
      return $this->number_of_result;
    }

    public function getPostsPerPage($query="")
    {
      return mysqli_query($this->con,$query);
    }

    public function getTotalPages()
    {
      return ceil(mysqli_num_rows($this->number_of_result) / $this->number_per_page);
    }

    public function getNumberPerPage()
    {
      return $this->number_per_page;
    }
  }



 ?>
