<?php
  require '../database/db_connect.php';
  require '../database/db.php';
  require '../controllers/settings_controller.php';
  require '../controllers/user_dashboard_controller.php';
  require '../controllers/posts_controller.php';
  session_start();

  if(!isset($_SESSION['id_number']) && $_SESSION['user_type'] != "STUDENT"){
    header("location: ../");
  }

  if ($_SESSION['status'] == 'DISABLED') {
    header("location: disabled.php");
  }

  $user = new UserDashboard($_SESSION['id_number'],$_SESSION['user_type']);
  $post = new Posts($_SESSION['id_number'],$_SESSION['user_type']);
  $user_obj = $user->getSpecificUserById($_GET['id']);
  $link_to_profile = $user->getSpecificUser($_SESSION['id_number']);
  $tagged_papers = $post->getTaggedPosts($user_obj['id_number']);
  $default_avatar = ($user_obj['sex'] == 'MALE'? 'male_default.jpg' : 'female_default.jpg' );

  if (!empty($user_obj)) {
    $user_obj['prof_pic'] = ($user_obj['prof_pic'] != null ? $user_obj['prof_pic'] : $default_avatar );

    if ($user_obj['user_type'] == 'SUPER' || $user_obj['user_type'] == 'ADMIN') {
      header('location:index.php');
    }


    if ($_SESSION['id_number'] != $user_obj['id_number']) {
      if (!$user->setVisit($user_obj['id_number'], $_SESSION['id_number'])) {
        // error_msg
      }
    }
  }else{
    header('location:index.php');
  }

  if (isset($_POST['edit_info'])) {
    array_pop($_POST);
    $_POST['id_number'] = $user_obj['id_number'];
    if ($user->editRegInfo($_POST)) {
      header("location: profile?id=$_GET[id]#basic_info");
    }
  }elseif (isset($_POST['edit_pic'])) {
    $_FILES['id_number'] = $user_obj['id_number'];

    var_dump($_FILES);

    if ($user->editProfilePic($_FILES)) {
      header("location: profile?id=$_GET[id]#basic_info");
    }else{
      header("location: profile?id=$_GET[id]#basic_info");
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

    <title><?php echo $user_obj['first_name']." ".$user_obj['last_name']." " ?></title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="custom.css">

<style type="text/css">
    .masthead {
        height: 10vh;
        min-height: 270px;
        background-image: url('../images/agila.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
</style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-dark topbar mb-0 static-top shadow">

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
                                <a class="nav-link" href="profile.php?id=<?php echo $link_to_profile['id']; ?>" >
                                     Profile
                                </a>
                            </li>
                        </ul>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['user_name']; ?></span>
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
                    <!-- Page Heading -->
                    <!-- BODY::: MUCH BETTER IF BOOTSTRAP FORM INYO I INSERT DRE -->

                <!-- Full Page Image Header with Vertically Centered Content -->
                <header class="masthead">
                  <div class="container h-100">
                    <div class="row h-100 align-items-center">
                      <div class="col-12 text-center">

                        <!-- <h1 class="font-weight-light">College of Information and Computing</h1> -->
                        <!-- <p class="lead">System Journal</p> -->
                      </div>
                    </div>
                  </div>

                </header>

                <div class="container-fluid">
                  <div id="circle">
                    <div class="">
                      <img class="icon_img rounded-circle"
                          src="../profile_pictures/<?php echo $user_obj['prof_pic']; ?>">
                      <?php if ($_SESSION['id_number'] == $user_obj['id_number']): ?>
                        <a id='edit_prof_pic' class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModal">
                            <i id='cam_icon' class="fas fa-camera fa-lg fa-fw text-gray-400"></i>
                        </a>
                      <?php endif; ?>
                    </div>

                   <h1 id='full_name'><?php echo $user_obj['first_name']." ".$user_obj['last_name']; ?></h1>

                  </div>
                  <hr>
                    <!-- Page Content -->
                    <section class="col-lg-12 py-4">
                      <div class="container">
                            <!-- Content Row -->
                            <div>
                                <div class="row">
                                   <div class="col-xl-5 col-lg-5">
                                      <div class="card shadow mb-4 border-bottom-dark">

                                          <div
                                              class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                              <h6 class="m-0 font-weight-bold text-primary">Student Information</h6>
                                          </div>

                                          <div class="card-body">
                                              <div class="row">
                                                  <div class="col-lg-12">
                                                      <div class="card" style="width: auto;">
                                                        <div class="card-body d-flex justify-content-between" style="align-items:flex-end;">
                                                          <div id='edit_form' class="col-12">
                                                            <form method="post">
                                                              <div class="form-group">
                                                                <input class="form-control"type="text" name="first_name" value="<?php echo $user_obj['first_name']; ?>">
                                                              </div>

                                                              <div class="form-group">
                                                                <input class="form-control"type="text" name="middle_name" value="<?php echo $user_obj['middle_name']; ?>">
                                                              </div>

                                                              <div class="form-group">
                                                                <input class="form-control"type="text" name="last_name" value="<?php echo $user_obj['last_name']; ?>">
                                                              </div>

                                                              <div class="form-group">
                                                                <select class="form-control" name="sex">
                                                                  <option value="MALE" <?php echo (($user_obj['sex'] == 'MALE') ? 'SELECTED': ''); ?>>Male</option>
                                                                  <option value="FEMALE" <?php echo (($user_obj['sex'] == 'FEMALE') ? 'SELECTED': ''); ?>>Female</option>
                                                                  <option value="NON BINARY" <?php echo (($user_obj['sex'] == 'NON BINARY') ? 'SELECTED': ''); ?>>Non binary lol</option>
                                                                </select>
                                                              </div>

                                                              <div class="form-group">
                                                                <input class="form-control"type="date" name="dob" value="<?php echo $user_obj['dob']; ?>">
                                                              </div>

                                                              <br>
                                                              <div class="d-flex">
                                                                <input class="btn btn-sm btn-primary mr-2"type="submit" name="edit_info" value="Confirm edit">
                                                                <button class="btn btn-sm btn-success" type="button" name="button" onclick='revert()'>Cancel</button>
                                                              </div>
                                                            </form>
                                                          </div>

                                                          <div id='basic_info'class="col-11">
                                                            <h6 class="card-subtitle mb-2"><?php echo $user_obj['last_name'].", ".$user_obj['first_name']." ".$user_obj['middle_name']; ?></h6>
                                                            <h6 class="card-subtitle mb-2">Bachelor of Science in <?php echo $user_obj['course_id']." " ?> Major in <?php echo $user_obj['major_id']; ?></h6>
                                                            <h6 class="card-subtitle mb-2" style="text-transform: capitalize;"><?php echo $user_obj['sex']; ?></h6>
                                                            <?php
                                                              $date = date_create($user_obj['dob']);
                                                              $date2 = date_format($date, "F d, Y");
                                                            ?>
                                                            <h6 class="card-subtitle mb-2"><?php echo $date2 ?></h6>
                                                          </div>

                                                          <?php if ($_SESSION['id_number'] == $user_obj['id_number']): ?>
                                                            <div>
                                                              <button id='edit_button'class='btn btn-md'type="button" name="button" onclick="transform()"><i class='fas fa-edit fa-sm fa-fw text-gray-500'></i></button>
                                                            </div>
                                                            <script type="text/javascript">
                                                              var basicInfo = document.getElementById('basic_info');
                                                              var editButton = document.getElementById('edit_button');
                                                              var editForm = document.getElementById('edit_form');

                                                              function transform() {
                                                                basicInfo.style.display = 'none';
                                                                editButton.style.display = 'none';
                                                                editForm.style.display = 'block';
                                                              }

                                                              function revert(){
                                                                basicInfo.style.display = 'block';
                                                                editButton.style.display = 'block';
                                                                editForm.style.display = 'none';
                                                              }
                                                            </script>
                                                          <?php endif; ?>
                                                          <!-- <a href="#" class="btn btn-info btn-icon-split">
                                                              <span class="icon text-white-50">
                                                                  <i class="fas fa-info-circle"></i>
                                                              </span>
                                                              <span class="text">Learn More</span>
                                                          </a> -->
                                                        </div>
                                                      </div>
                                                  </div>

                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="col-xl-7 col-lg-6">
                                     <div class="card shadow mb-4 border-bottom-dark">

                                         <div
                                             class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                             <h6 class="m-0 font-weight-bold text-primary">Tagged papers</h6>
                                         </div>

                                        <?php if (sizeof($tagged_papers) != 0): ?>
                                          <?php foreach ($tagged_papers as $paper): ?>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card" style="width: auto;">
                                                          <div class="card-body">
                                                            <h5 class="card-title"><?php echo $paper['title'] ?></h5>
                                                            <?php
                                                              $authors = $post->getPaperAuthors($paper['post_id']);
                                                              if (sizeof($authors) == 0) {
                                                                echo "<i> Authors on paper </i>";
                                                              }else{

                                                                for ($i=0; $i < sizeof($authors); $i++) {
                                                                  $author = $user->getSpecificUser($authors[$i]);
                                                                  echo $author['first_name']." ".$author['last_name'].", ";
                                                                }
                                                              }
                                                              echo $paper['year_publish'];
                                                             ?>

                                                            <br><br>
                                                            <a href="viewpap.php?post_id=<?php echo $paper['post_id']; ?>" class="btn btn-info btn-icon-split">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-info-circle"></i>
                                                                </span>
                                                                <span class="text">Go to post</span>
                                                            </a>
                                                          </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          <?php endforeach; ?>

                                        <?php else: ?>
                                          <i class="m-3">No tagged papers</i>
                                        <?php endif;?>
                                     </div>
                                 </div>

                                  <!--  -->
                                </div>
                            </div>

                            <div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Set your profile picture</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                          <div class="custom-file col-sm-12 mb-3 mb-sm-4">
                                            <!-- <input type="file" class="form-control" name="post_file" value=""> -->
                                            <input type="file" class="custom-file-input" id="post_file"
                                              aria-describedby="inputGroupFileAddon01" name="pic_file" onchange="loadFile(event)">
                                            <label class="custom-file-label" for="inputGroupFile01" id="file_label">
                                              File (jpg/png)
                                            </label>

                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <div id="thumbnail" style="text-align:center;display:none;">
                                            <img id="img_thumbnail" src="" alt="img here">
                                          </div>
                                        </div>

                                        <script type="text/javascript">

                                          var loadFile = function(event) {
                                            var file_name = document.getElementById('post_file').value;
                                            var split = file_name.split('\\');
                                            document.getElementById('file_label').innerHTML = split[split.length-1];
                                            document.getElementById('thumbnail').style.display = 'block';
                                            var output = document.getElementById('img_thumbnail');
                                            output.src = URL.createObjectURL(event.target.files[0]);
                                            output.onload = function() {
                                              URL.revokeObjectURL(output.src)
                                            }
                                          };

                                          function redirect(id) {
                                            window.location.href='profile.php?id='+id;
                                          }
                                        </script>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="redirect(<?php echo $user_obj['id']; ?>)">Close</button>
                                          <button type="submit" name="edit_pic" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                  </div>

                                </div>
                              </div>
                            </div>
                      </div>
                    </section>

                    <div class="container">
                            <!-- <div class="row">
                                <div class="col-xl-2 col-md-1"></div>
                                    <div class="col-xl-8 col-md-10 mb-4">
                                        <div class="font-weight-bold h3 text-gray-500" align="center">
                                            Your Post
                                        </div>
                                    </div>
                                <div class="col-xl-2 col-md-1">
                                </div>
                            </div> -->

                            <!-- <div class="row">
                                <div class="col-xl-2 col-md-1"></div>
                                <div class="col-xl-8 col-md-10 mb-5 ">
                                    <div class="font-weight-bold">Date posted:  <span class="font-weight-light"> January 01, 2020</span></div>
                                    <div class="font-weight-bold">Date of validity:  <span class="font-weight-light"> January 03, 2020</span></div>
                                    <div class="card border-bottom-danger">
                                        <div class="card-header bg-success">
                                            <div class="h6 text-gray-200 font-weight-bold text-center">Your post was approved by admin</div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">Header Title</h5>
                                            <h6 class="card-subtitle mb-4 text-muted">Juan B, Anneth gora, 2020</h6>
                                            <p class="card-text">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                                proidenin culpa qui officia deserunt mollit anim id est laborum.
                                            </p>
                                            <a href="#" class="btn btn-primary btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-arrow-right"></i>
                                                </span>
                                                <span class="text">View article</span>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span class="text">Update</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-1">
                                </div>
                            </div> -->


                            <!-- <div class="row">
                                <div class="col-xl-2 col-md-1"></div>
                                <div class="col-xl-8 col-md-10 mb-5">
                                    <div class="card border-bottom-danger">
                                        <div class="card-header bg-warning">
                                            <div class="font-weight-light h6 text-gray-700 text-center" >Waiting for approval</div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">Header Title</h5>
                                            <h6 class="card-subtitle mb-4 text-muted">Juan B, Anneth gora, 2020</h6>
                                            <p class="card-text">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                                proidenin culpa qui officia deserunt mollit anim id est laborum.
                                            </p>
                                            <a href="#" class="btn btn-light btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-arrow-right"></i>
                                                </span>
                                                <span class="text">View article</span>
                                            </a>
                                            <a href="#" class="btn btn-light btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span class="text">Update</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-1">
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
