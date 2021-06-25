<?php
  require '../database/db_connect.php';
  require '../database/db.php';
  require '../controllers/settings_controller.php';
  require '../controllers/user_dashboard_controller.php';
  require '../controllers/posts_controller.php';
  require '../controllers/login_controller.php';
  session_start();

  if(!isset($_SESSION['id_number']) || $_SESSION['user_type'] != "STUDENT"){
    header("location: ../");
  }

  if ($_SESSION['status'] == 'DISABLED') {
    header("location: disabled.php");
  }

  $user = new UserDashboard($_SESSION['id_number'],$_SESSION['user_type']);
  $post = new Posts($_SESSION['id_number'],$_SESSION['user_type']);
  $credentials = new Login();
  $user_obj = $user->getSpecificUser($_SESSION['id_number']);
  $default_avatar = ($user_obj['sex'] == 'MALE'? 'male_default.jpg' : 'female_default.jpg' );
  $_SESSION['user_name'] = ( $user_obj != null ? $user_obj['first_name']." ".$user_obj['last_name'] : $_SESSION['id_number']);
  $_SESSION['prof_pic'] = ($user_obj['prof_pic'] != null ? $user_obj['prof_pic'] : $default_avatar);

  if (isset($_POST['change_password'])) {
    array_pop($_POST);
    $_POST['id_number'] = $_SESSION['id_number'];

    if ($credentials->changePassword($_POST)) {
      header("location: index.php");
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

    <title>Visitors Log</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="custom.css">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-dark topbar mb-4 static-top shadow">

                    <ul class="navbar-nav ml-md-0 mr-3">
                        <a href="index.php">
                            <div class="sidebar-brand-icon">
                                <img width="60" height="60" src="../images/student-img/cic_logo.png">
                            </div>
                        </a>
                    </ul>


                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
                        method="get"
                        action="index.php">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" name="search_id" placeholder="Search paper"
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <ul class="navbar-nav ml-md-0">
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
                    </ul>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                      <ul class="navbar-nav ml-auto">
                          <li class="nav-item">
                              <a class="nav-link" href="index.php" >
                                   Home
                              </a>
                          </li>
                      </ul>

                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="profile.php?id=<?php echo $user_obj['id'] ?>" >
                                     Profile
                                </a>
                            </li>
                        </ul>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['user_name'] ?></span>
                                <img class="icon_img rounded-circle"
                                    src="../profile_pictures/<?php echo $_SESSION['prof_pic']; ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="changepass.php">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Change Password
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Visitors Log
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
                <div class="container">
                    <!-- Page Heading -->
                    <!-- BODY::: MUCH BETTER IF BOOTSTRAP FORM INYO I INSERT DRE -->
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 mx-auto">
                            <div class="card shadow mb-4 border-bottom-dark">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Your Daily Visitors</h6>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                <?php
                                  $visitors = $user->getVisitors($_SESSION['id_number']);
                                 ?>
                                 <table class="table table-dark table-hover">
                                   <thead>
                                     <tr>
                                      <th scope="col">Visitor</th>
                                      <th scope="col">Total visits</th>
                                      <th scope="col">Last Visit</th>
                                    </tr>
                                   </thead>
                                 <?php if (!empty($visitors)): $prev_visitor = array();?>

                                   <?php foreach ($visitors as $visitor): ?>
                                     <?php if ( !in_array($visitor['visitor'],$prev_visitor)): ?>
                                       <tr>
                                        <th scope="row">
                                          <?php
                                            $visitor_info = $user->getSpecificUser($visitor['visitor']);
                                            $last_visited = $user->getLastVisit($_SESSION['id_number'],$visitor['visitor']);
                                            array_push($prev_visitor,$visitor['visitor']);
                                            $default_avatar = ($visitor_info['sex'] == 'MALE'? 'male_default.jpg' : 'female_default.jpg' );
                                            $visitor_info['prof_pic'] = ($visitor_info['prof_pic'] != null ? $visitor_info['prof_pic'] : $default_avatar);
                                          ?>
                                          <div class="d-flex align-items-center mr-4">
                                              <div class="mr-2">
                                                  <img class="icon_img rounded-circle" src="../profile_pictures/<?php echo $visitor_info['prof_pic']; ?>" alt="" width="40px">
                                              </div>
                                              <div class="font-weight-bold">
                                                  <div class=""><?php echo $visitor_info['first_name']." ".$visitor_info['last_name'] ?></div>
                                              </div>
                                          </div>
                                        </th>

                                        <td>
                                          <?php echo $user->getNumberOfVisits(); ?>
                                        </td>

                                        <td>
                                          <?php
                                          echo $last_visited; ?>
                                        </td>
                                      </tr>
                                    <?php endif; ?>
                                   <?php endforeach; ?>
                                 <?php else: ?>

                                 <?php endif; ?>
                                 </table>
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
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
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
