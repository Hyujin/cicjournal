<?php
  require '../database/db_connect.php';
  require '../database/db.php';
  require '../controllers/settings_controller.php';
  require '../controllers/user_dashboard_controller.php';
  require '../controllers/posts_controller.php';
  session_start();

  if(!isset($_SESSION['id_number']) || $_SESSION['user_type'] != "SUPER"){
    header("location: ../");
  }

  $user = new UserDashboard($_SESSION['id_number'],$_SESSION['user_type']);
  $post = new Posts($_SESSION['id_number'],$_SESSION['user_type']);
  $setting = new Settings();
  $name = $user->getSpecificUser($_SESSION['id_number']);
  $_SESSION['user_name'] = ( $name != null ? $name['first_name']." ".$name['last_name'] : $_SESSION['id_number']);
  $view_data = array();
  $index = "";
  $header_index = "";
  $to_edit = "";

  if (!isset($_GET['view_type'])) {
    header("location: index.php");
  }else{

    if ($_GET['view_type'] == 'course') {
      $view_data = $setting->getAllCourse();
      $index = "course_";
      $header_index = "Course";
    }elseif ($_GET['view_type'] == 'major') {
      $view_data = $setting->getAllMajor();
      $index = "major_";
      $header_index = "Major";
    }else{
      $view_data = $setting->getAllCategory();
      $index = "category_";
      $header_index = "Category";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Student Settings</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                      <img width="60" height="60" src="../images/student-img/cic_logo.png">
                </div>
                <div class="sidebar-brand-text mx-3">CIC Journal<sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Home</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Links
            </div>

            <li class="nav-item">
                <a class="nav-link" href="addpap.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>New Paper</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="managepap.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Manage Paper</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="manageuser.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>User Management</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="manageuser.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Student Settings</span></a>
            </li>

            <!-- Nav Item - Charts -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="viewpap.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>View paper</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="sresults.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Search results</span></a>
            </li> -->


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-dark topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
                          method='GET'
                          action='sresults.php'>

                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search paper"
                                aria-label="Search" aria-describedby="basic-addon2" name='search_id' required>
                            <div class="input-group-append">
                              <button type='submit' class="btn btn-primary" type="button">
                                  <i class="fas fa-search fa-sm"></i>
                              </button>
                            </div>
                        </div>

                    </form>



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['user_name']?></span>
                                <img class="img-profile rounded-circle"
                                    src="../images/student-img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="account/activitylog.php">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content =  -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <!-- BODY::: MUCH BETTER IF BOOTSTRAP FORM INYO I INSERT DRE -->
                    <div class="row">

                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4 border border-bottom-danger">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Student Settings</h6>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body p-4">

                                  <div class="d-flex justify-content-between mb-2">
                                    <div class="">
                                      <select class="form-control form-control-mb mr-2" name="view_type" type="submit" onchange="location = this.value">
                                        <option value="studentsettings.php?view_type=course" <?php echo ($_GET['view_type'] == "course" ? "selected": ""); ?>>Course Management</option>
                                        <option value="studentsettings.php?view_type=major" <?php echo ($_GET['view_type'] == "major" ? "selected": ""); ?>>Major Management</option>
                                        <option value="studentsettings.php?view_type=category" <?php echo ($_GET['view_type'] == "category" ? "selected": ""); ?>>Research Category Management</option>
                                      </select>
                                    </div>

                                    <div class="">
                                      <a class="btn btn btn-success" href="#" data-toggle="modal" data-target="#exampleModal">
                                        + New Entry
                                      </a>
                                    </div>
                                  </div>

                                  <table class="table table-hover">
                                    <thead>
                                      <tr>
                                        <th scope="col"><?php echo strtoupper($header_index); ?> ID</th>
                                        <th scope="col"><?php echo strtoupper($header_index); ?> NAME</th>
                                        <th scope="col">SETTINGS</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php foreach ($view_data as $value): ?>
                                        <tr>
                                          <th scope='row'><?php echo strtoupper($header_index)."-".$value[$index.'id']; ?></th>
                                          <td> <?php echo $value['name']; ?></td>
                                          <td style="width:100px;">
                                            <div class='dropdown no-arrow'style='float:right;' >
                                                <a class='btn btn-sm btn-primary dropdown-toggle' href='#' role='button' id='dropdownMenuLink'
                                                    data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                    ACTIONS
                                                </a>
                                                <div class='dropdown-menu dropdown-menu-right shadow animated--fade-in'
                                                  aria-labelledby='dropdownMenuLink'>
                                                  <div class='dropdown-header'>Actions:</div>
                                                  <input type='hidden' name='id_number' value='<?php echo $value[$index.'id']; ?>'>
                                                  <a class='dropdown-item' href="studentsettings.php?view_type=<?php echo strtolower($header_index)."&id=".$value[$index."id"]; ?>&name=<?php echo $value['name']; ?>" style='color:rgb(44, 155, 209);'>Edit</a>
                                                  <a class='dropdown-item' name='delete_item' href="studentsettings.php?view_type=<?php echo strtolower($header_index)."&id=".$value[$index."id"]; ?>" style='color:rgb(219, 49, 44);'> Delete </a>

                                                  <div class='dropdown-divider'></div>

                                                </div>
                                              </div>
                                        </td>
                                        </tr>
                                      <?php endforeach; ?>

                                    </tbody>
                                  </table>

                                  <!-- Add item -->
                                  <div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">New <?php echo $header_index; ?></h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <form method="post">
                                              <div class="form-group">
                                                <input class="form-control" type="text" name="name" placeholder='<?php echo $header_index." name"; ?>' required>
                                              </div>

                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="">Close</button>
                                                <button type="submit" name="add_item" class="btn btn-primary">Submit</button>
                                              </div>
                                          </form>

                                        </div>

                                      </div>
                                    </div>
                                  </div>

                                  <!-- Edit item -->
                                  <div class="modal" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Edit <?php echo $header_index; ?></h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <form method="post" action="studentsettings.php?view_type=<?php echo strtolower($header_index); ?>">
                                              <input type="hidden" name="to_edit" value="<?php echo $_GET['id']; ?>">
                                              <div class="form-group">
                                                <input class="form-control" type="text" name="name" placeholder='<?php echo $header_index." name"; ?>' value="<?php echo $_GET['name']; ?>" required>
                                              </div>

                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <input class="btn btn-primary" type="submit" name="edit_item" value="Submit">
                                              </div>
                                          </form>

                                        </div>

                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; CIC Journal System 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->


    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

</body>

</html>

<?php
  if (isset($_SESSION['to_delete'])) {
    require '../modal.php';
    $redirect = "studentsettings.php?view_type=".strtolower($header_index);
    $_GET['view_type'] = strtolower($header_index);
    $_GET['id'] = $_SESSION['to_delete'];

    if ($setting->deleteItem($_GET)) {
      unset($_SESSION['to_delete']);
      echo "<script>
        $(document).ready(function(){
          $('.modal-header').css({
            backgroundColor : '#800000',
            color : 'white',
            textAlign: 'center'
          });
          $('.modal-title').text('CICjournal');
          $('.modal-body').text('Successfully deleted ".strtolower($header_index)."');
          $('#modal-success-save').text('Cancel');
          $('#modal-success-close').text('Delete');
          $('#modal-success-save').hide();
          $('#modal-success-close').hide();
          $('#successModal').modal('show');
          setTimeout(function(){
            $('#successModal').modal('hide');
            window.location.href = '$redirect';
          }, 2000);
        });
      </script>";
    }else{
      echo "<script>
        $(document).ready(function(){
          $('.modal-header').css({
            backgroundColor : '#800000',
            color : 'white',
            textAlign: 'center'
          });
          $('.modal-title').text('CICjournal');
          $('.modal-body').text('Unable to delete ".strtolower($header_index)."');
          $('#modal-success-save').text('Cancel');
          $('#modal-success-close').text('Delete');
          $('#modal-success-save').hide();
          $('#modal-success-close').hide();
          $('#successModal').modal('show');
          setTimeout(function(){
            $('#successModal').modal('hide');
            window.location.href = '$redirect';
          }, 2000);
        });
      </script>";
    }
  }else{
    $redirect = "studentsettings.php?view_type=".strtolower($header_index);
    echo "<script>
            window.location.href = '$redirect';
          </script>";
  }

 ?>
