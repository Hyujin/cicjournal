<?php
  require '../database/db_connect.php';
  require '../database/db.php';
  require '../controllers/settings_controller.php';
  require '../controllers/user_dashboard_controller.php';
  require '../controllers/posts_controller.php';
  session_start();

  $user = new UserDashboard($_SESSION['id_number'],$_SESSION['user_type']);
  $post = new Posts($_SESSION['id_number'],$_SESSION['user_type']);
  $setting = new Settings();

  if(!isset($_SESSION['id_number']) || $_SESSION['user_type'] != "SUPER"){
    header("location: ../");
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

    <title>Add User</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="..\assets\css\sb-admin-2.min.css" rel="stylesheet">

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
                <a class="nav-link" href="studentsettings.php?view_type=course">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Other Settings</span></a>
            </li>

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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['user_name'] ?></span>
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
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                          <div class="card shadow mb-4 border-bottom-danger">
                            <div class="card-header py-3 d-flex flex-row align-items-center">
                              <h6 class="m-0 font-weight-bold text-primary">Add New User</h6>
                            </div>

                            <div class="card-body">
                              <form method="post" enctype="multipart/form-data">
                                <div class="row">
                                  <div class="col-4">
                                    <h6> <b>User Profile</b> </h6>

                                    <div class="form-group">
                                      <input type="hidden" name="credentials[]" value="STUDENT">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" id="" placeholder="First name" name="user_profile[]" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" id="" placeholder="Middle name" name="user_profile[]" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" id="" placeholder="Last name" name="user_profile[]" required>
                                    </div>

                                    <div class="form-group">
                                      <select class="form-control" name="user_profile[]">
                                        <option value="MALE">Male</option>
                                        <option value="FEMALE">Female</option>
                                        <option value="NON BINARY">Non binary lol</option>
                                      </select>
                                    </div>

                                    <div class="form-group">
                                      <input type="text" class="form-control" id="text_dob" placeholder="Date of birth">
                                      <input type="hidden" class="form-control" id="dob" name="user_profile[]" required>
                                    </div>
                                  </div>

                                  <div class="col-4">

                                    <div class="d-flex justify-content-between" style="align-items:flex-start;">
                                      <h6> <b>Credentials</b> </h6>
                                      <div class='dropdown no-arrow'>
                                          <a class='dropdown-toggle no-arrow' href='#' role='button' id='dropdownMenuLink'
                                              data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                              <i class="fas fa-ellipsis-v fa-lg fa-fw text-gray-400"></i>
                                          </a>
                                          <div class='dropdown-menu dropdown-menu-right shadow animated--fade-in'
                                              aria-labelledby='dropdownMenuLink'>
                                              <div class='dropdown-header'>Actions:</div>
                                              <button class="dropdown-item" type="button" id="default_pass" onclick="showDef()">Use default password</button>
                                              <button class="dropdown-item" type="button" id="custom_pass" onclick="showCustom()">Use custom password</button>
                                          </div>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="" placeholder="ID number" name="credentials[]" required>
                                    </div>

                                    <div id="password_fields">
                                      <div class="form-group">
                                          <input type="password" class="form-control" id="pass1" placeholder="Password" name="credentials[]" required>
                                      </div>

                                      <div class="form-group">
                                          <input type="password" class="form-control" id="pass2" placeholder="Confirm password" name="credentials[]" required>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="col-4" id='to_hide'>
                                    <h6> <b>Student Info</b> </h6>
                                      <?php
                                          $course = $user->getAllCourse();
                                          $major = $user->getAllMajor();
                                        ?>
                                      <div class="form-group">
                                        <select class="form-control" name="student_info[]">
                                          <option selected hidden value='1'>Course</option>
                                          <?php
                                            for ($i=0; $i < sizeof($course); $i++) {
                                              echo "<option value='".$course[$i]['course_id']."'> ".$course[$i]['name']."</option>";
                                            }
                                           ?>
                                        </select>
                                      </div>

                                      <div class="form-group">
                                        <select class="form-control" name="student_info[]">
                                          <option selected hidden value='1'>Major</option>
                                          <?php
                                            for ($i=0; $i < sizeof($major); $i++) {
                                              echo "<option value='".$major[$i]['major_id']."'> ".$major[$i]['name']."</option>";
                                            }
                                           ?>
                                        </select>
                                      </div>

                                  </div>

                                </div>

                                <div class="row">
                                  <div class="col-12">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary form-control" name="submit_user">
                                    </div>
                                  </div>
                                </div>

                                <script type="text/javascript">
                                  var textDob = document.getElementById('text_dob');
                                  var dob = document.getElementById('dob');
                                  var userSelect = document.getElementById('user_type');
                                  var studentRow = document.getElementById('to_hide');
                                  var pass1 = document.getElementById('pass1');
                                  var pass2 = document.getElementById('pass2');
                                  var passwordFields = document.getElementById('password_fields');
                                  dob.onblur = dobBlur;
                                  textDob.onfocus = textDobFocus;

                                  function showDef() {
                                    pass1.removeAttribute('name');
                                    pass2.removeAttribute('name');
                                    passwordFields.style.display = 'none';
                                  }

                                  function showCustom() {
                                    pass1.setAttribute('name','credentials[]');
                                    pass2.setAttribute('name','credentials[]');
                                    passwordFields.style.display = 'block';
                                  }

                                  function check() {
                                      if (userSelect.value == 'STUDENT') {
                                        studentRow.style.display = 'block';
                                      }else{
                                        studentRow.style.display = 'none';
                                      }
                                  }

                                  function textDobFocus() {
                                    // if (dob.value == "") {
                                      textDob.type = 'hidden';
                                      dob.setAttribute('type','date');
                                    // }
                                    // dob.focus();
                                  }

                                  function dobBlur() {
                                    if (dob.value == "") {
                                      textDob.type = 'text';
                                      dob.setAttribute('type','hidden');
                                    }
                                  }

                                </script>

                              </form>

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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">??</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

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
  if (isset($_POST['submit_user'])) {
    require '../modal.php';
    array_pop($_POST); //Remove submit button

    if (empty($_POST['credentials'][0])) {
      $_POST['credentials'][0] = 'STUDENT';
    }

    $_POST['credentials'][0] = ($_POST['credentials'][0] != 'STUDENT' ? "STUDENT" : $_POST['credentials'][0]);

    if (!isset($_POST['student_info'])) {
      $_POST['student_info'][0] = "";
      $_POST['student_info'][1] = "";
    }

    if ($user->newUser( $_POST['user_profile'], $_POST['student_info'], $_POST['credentials'] )) {
      if ($setting->addNewActivity(array($_SESSION['id_number'],"ADDED NEW USER ID_NUM(".$_POST['credentials'][1].")"), $_SESSION['user_type'])) {
        echo "<script>
          $(document).ready(function(){
            $('.modal-header').css({
              backgroundColor : '#800000',
              color : 'white',
              textAlign: 'center'
            });
            $('.modal-title').text('CICjournal');
            $('.modal-body').text('Successfuly added user');
            $('#modal-success-save').hide();
            $('#modal-success-close').hide();
            $('#successModal').modal('show');
            setTimeout(function(){
              $('#successModal').modal('hide');
              window.location.href='manageuser.php';
            }, 2000);
          });
        </script>";
      }
    }else{
      echo "<script>
        $(document).ready(function(){
          $('.modal-header').css({
            backgroundColor : '#800000',
            color : 'white',
            textAlign: 'center'
          });
          $('.modal-title').text('CICjournal');
          $('.modal-body').text('Something went wrong. Please try again');
          $('#modal-success-save').hide();
          $('#modal-success-close').hide();
          $('#successModal').modal('show');
          setTimeout(function(){
            $('#successModal').modal('hide');
            window.location.href='manageuser.php';
          }, 2000);
        });
      </script>";
    }
  }
 ?>
