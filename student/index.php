<?php
  require '../database/db_connect.php';
  require '../database/db.php';
  require '../controllers/settings_controller.php';
  require '../controllers/user_dashboard_controller.php';
  require '../controllers/posts_controller.php';
  require '../controllers/pagintation.php';
  session_start();

  if(!isset($_SESSION['id_number']) || $_SESSION['user_type'] != "STUDENT"){
    header("location: ../");
  }

  $user = new UserDashboard($_SESSION['id_number'],$_SESSION['user_type']);
  $post = new Posts($_SESSION['id_number'],$_SESSION['user_type']);
  $setting = new Settings();
  $paginate = new Paginate(0);
  $new_array = $post->paginate($post->getAllPost());
  $user_obj = $user->getSpecificUser($_SESSION['id_number']);
  $default_avatar = ($user_obj['sex'] == 'MALE'? 'male_default.jpg' : 'female_default.jpg' );
  $_SESSION['user_name'] = ( $user_obj != null ? $user_obj['first_name']." ".$user_obj['last_name'] : $_SESSION['id_number']);
  $_SESSION['prof_pic'] = ($user_obj['prof_pic'] != null ? $user_obj['prof_pic'] : $default_avatar);
  $_SESSION['status'] = ($user_obj['status'] == 'DISABLED' ? 'DISABLED' : 'ENABLED');

  if ($_SESSION['status'] == 'DISABLED') {
    header("location: disabled.php");
  }

  if (isset($_GET['search_id'])) {
    $_GET['search_id'] = $paginate->sanitize($_GET['search_id']);
    $query = "SELECT * FROM post WHERE title LIKE '%$_GET[search_id]%' AND status = 'ACTIVE'";
    $result = $paginate->getPostsPerPage($query);
    $new_array = array();
    while ($obj = mysqli_fetch_assoc($result)) {
      array_push($new_array,$obj);
    }
    $new_array = $post->paginate($new_array);
  }elseif (isset($_GET['category'])) {
    $categorized = $post->getAllPostByCategory($_GET['category']);
    $new_array = $post->paginate($categorized);
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

    <title>Home</title>

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
                        method="get">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search paper"
                                aria-label="Search" name='search_id'aria-describedby="basic-addon2">
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
                                <a class="dropdown-item" href="visitorslog.php">
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
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <!-- BODY::: MUCH BETTER IF BOOTSTRAP FORM INYO I INSERT DRE -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4 border-bottom-dark">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Newsfeed</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Category:</div>
                                            <a class="dropdown-item" href="index.php?">Show all</a>
                                            <?php $categories = $setting->getAllCategory();
                                            foreach ($categories as $category): ?>
                                              <?php $name= strtolower($category['name']); ?>
                                                <a class="dropdown-item" href='index.php?category=<?php echo $category['category_id']; ?>'><?php echo ucfirst($name); ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                  <?php

                                    if (!empty($new_array)) {
                                      for ($i=0; $i < sizeof($new_array); $i++) {
                                        ?>

                                        <div id="<?php echo $i; ?>"style="text-align:center;<?php echo ($i==1 ? 'display:block;':'display:none;') ?>">
                                          <button type='button' class='btn btn-dark btn-icon-split' onclick="show(<?php echo $i; ?>)">
                                              <span class='icon text-white-50'>
                                                  <i class='fas fa-chevron-circle-down'></i>
                                              </span>
                                              <span class='text'>Show more results</span>
                                          </button>
                                        </div>
                                        <?php
                                        for ($j=0; $j < sizeof($new_array[$i]); $j++) {
                                          echo "<div class='col-lg mb-2'>
                                              <div class='card ".$i."' style='width: auto; ".($i!=0 ? "display:none;":"display:block;")."'>
                                                <div class='card-body'>
                                                  <h5 class='card-title'><b>".strtoupper($new_array[$i][$j]['title'])."</b></h5>
                                                  <h6 class='card-subtitle mb-2 text-muted'>".$new_array[$i][$j]['year_publish']."</h6>
                                                  <p class='card-text text-truncate'>".$new_array[$i][$j]['synopsis']."</p>
                                                  <a href='viewpap.php?post_id=".$new_array[$i][$j]['post_id']."' class='btn btn-primary btn-icon-split'>
                                                      <span class='icon text-white-50'>
                                                          <i class='fas fa-info-circle'></i>
                                                      </span>
                                                      <span class='text'>Go to paper</span>
                                                  </a>
                                                </div>
                                              </div>
                                          </div>";
                                        }
                                      }
                                    ?>
                                    <script type="text/javascript">
                                      function show(id) {
                                        console.log(id+1);
                                        var to_show = document.getElementsByClassName(id);
                                        for (var i = 0; i < to_show.length; i++) {
                                          to_show[i].style.display = 'block';
                                        }
                                        document.getElementById(id).style.display = 'none';
                                        if (document.getElementsByClassName(id+1).length != 0) {
                                          document.getElementById(id+1).style.display = 'block';
                                        }
                                      }
                                    </script>
                                    <?php
                                    }else{
                                      echo "<i>No result</i>";
                                    }
                                   ?>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-xl-5 col-lg-4">
                            <div class="card shadow mb-4 border border-bottom-danger">

                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Recent Contents</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Category:</div>

                                        </div>
                                    </div>
                                </div>
                                Card Body
                                <div class="card-body p-4">
                                    <div>
                                        <h4 align=""><a href="">Header Title</a></h4>
                                        <p class="">
                                            Lorem  qipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                        <hr>
                                    </div>
                                    <div>
                                        <h4><a href="">Header Title</a></h4>
                                        <p class="">
                                            Lorem  qipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                        <hr>
                                    </div>
                                    <div>
                                    <h4><a href="">Header Title</a></h4>
                                        <p class=" ">
                                            Lorem  qipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div> -->
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
