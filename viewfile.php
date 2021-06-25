<?php

  if (!isset($_SESSION['id_number'])) {
    // code...
  }
  $file_name = "file_uploads/".$_GET['file_name'];
  header('Content-type: application/pdf');
  header('Content-Description: inline; filename="'.$filename.'"');
  header('Content-Transfer-Encoding:binary');
  header('Accept-Ranges:bytes');
  @readfile($file_name);

 ?>
