<?php
  require 'database/db_connect.php';
  require 'database/db.php';
  require 'controllers/settings_controller.php';
  session_start();
  $setting = new Settings();
  if ($setting->addNewActivity(array($_SESSION['id_number'],'LOGGED OUT'), $_SESSION['user_type'])) {
    session_destroy();
    header("location:index.php");
  }
 ?>
