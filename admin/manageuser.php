<?php
  require '../database/db_connect.php';
  require '../database/db.php';
  require '../controllers/settings_controller.php';
  require '../controllers/user_dashboard_controller.php';
  require '../controllers/posts_controller.php';
  require '../controllers/pagintation.php';
  session_start();

  if(!isset($_SESSION['id_number']) || $_SESSION['user_type'] != "SUPER"){
    header("location: ../");
  }

  if (isset($_SESSION['to_delete'])) {
    unset($_SESSION['to_delete']);
  }

  $setting = new Settings();
  $user = new UserDashboard($_SESSION['id_number'],$_SESSION['user_type']);
  $post = new Posts($_SESSION['id_number'],$_SESSION['user_type']);
  $paginate = new Paginate(10);
  $number_per_page = $paginate->getNumberPerPage();
  $current_page_num = (isset($_GET['page']) ? $_GET['page'] : 1);
  $number_of_result = mysqli_num_rows($paginate->getNumberOfResult("SELECT * FROM manage_user_view"));
  $total_pages = $paginate->getTotalPages();
  $starting_limit = ($current_page_num - 1) * $number_per_page;
  $posts_per_page = $paginate->getPostsPerPage("SELECT * FROM manage_user_view LIMIT $starting_limit,$number_per_page");

  if (isset($_GET['user_search'])) {
    $_GET['user_search'] = $paginate->sanitize($_GET['user_search']);
    $number_of_result = mysqli_num_rows($paginate->getNumberOfResult
    ("SELECT * FROM manage_user_view WHERE id_number LIKE '%$_GET[user_search]%' OR full_name LIKE '%$_GET[user_search]%'"));
    $total_pages = $paginate->getTotalPages();
    $starting_limit = ($current_page_num - 1) * $number_per_page;
    $posts_per_page = $paginate->getPostsPerPage
    ("SELECT * FROM manage_user_view WHERE id_number LIKE '%$_GET[user_search]%' OR full_name LIKE '%$_GET[user_search]%' LIMIT $starting_limit,$number_per_page");
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

    <title>User Management</title>

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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['user_name']; ?></span>
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
                    <nav aria-label="Page navigation example"style="display:flex;justify-content: space-between;align-items:flex-end;">
                     <ul class="pagination pg-blue" >
                       <?php
                         if ($current_page_num == 1){
                           echo "
                           <li class='page-item disabled'>
                             <a class='page-link' tabindex='-1'>Previous</a>
                           </li>";
                         }else{

                           $href = ( isset($_GET['user_search']) ? "manageuser.php?user_search=". $_GET['user_search']. "&page=". ($current_page_num-1) : "manageuser.php?page=".($current_page_num-1));

                           echo "
                           <li class='page-item '>
                             <a class='page-link' tabindex='-1' href='$href'>Previous</a>
                           </li>";
                         }
                       ?>

                       <?php
                         for ($i=0; $i < $total_pages; $i++) {
                           $href = ( isset($_GET['user_search']) ? "manageuser.php?user_search=". $_GET['user_search']. "&page=". ($i+1) : "manageuser.php?page=".($i+1));
                           if($current_page_num == $i+1){
                         ?>
                             <li class="page-item active">
                               <a class="page-link" href-'<?php echo $href; ?>'><?php echo $i+1 ?></a>
                             </li>
                         <?php
                           }else{
                          ?>
                            <li class="page-item ">
                              <a class="page-link" href='<?php echo $href; ?>'><?php echo $i+1 ?></a>
                            </li>
                           <?php
                           }
                         }
                         if ($current_page_num == $total_pages || $total_pages == 0){
                           echo "
                           <li class='page-item disabled'>
                             <a class='page-link' tabindex='-1'>Next</a>
                           </li>";
                         }else{
                           $href = ( isset($_GET['user_search']) ? "manageuser.php?user_search=". $_GET['user_search']. "&page=". ($current_page_num+1) : "manageuser.php?page=".($current_page_num+1));
                           echo "
                           <li class='page-item '>
                             <a class='page-link' tabindex='-1'  href='".$href."'>Next</a>
                           </li>";
                         }
                        ?>

                     </ul>
                     <div style='float:right;'>
                        Showing <?php echo mysqli_num_rows($posts_per_page)." out of ".$number_of_result." results"; ?>
                     </div>
                   </nav>


                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4 border-bottom-danger">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                                  <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
                                        method='GET'
                                        action='manageuser.php'>

                                      <div class="input-group">
                                          <input type="text" class="form-control bg-light border-dark small" placeholder="Search users"
                                              aria-label="Search" aria-describedby="basic-addon2" name='user_search' required>
                                          <div class="input-group-append">
                                            <button type='submit' class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                          </div>
                                      </div>

                                  </form>

                                  <a class="btn btn-success" href="adduser.php" style="margin-right:5px;">+ Add New User</a>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                  <table class="table table-hover">
                                    <thead>
                                      <tr>
                                        <th scope="col">ID NUMBER</th>
                                        <th scope="col">FULL NAME</th>
                                        <th scope="col">USER TYPE</th>
                                        <th scope="col">STATUS</th>
                                        <th scope="col">SETTINGS</th>
                                      </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                  <?php
                                    while ($obj = mysqli_fetch_assoc($posts_per_page)) {
                                      echo "<tr>";
                                      echo "<th scope='row'>$obj[id_number]</th>";
                                      echo "<td>$obj[full_name]</td>";
                                      echo "<td>$obj[user_type]</td>";
                                      echo ($obj['status'] == 'ENABLED' ? "<td style='color:green;'>$obj[status]</td>" : "<td style='color:red;'>$obj[status]</td>");
                                      echo "<td><form method='post'>
                                              <div class='dropdown no-arrow'style='float:right;' >
                                                  <a class='btn btn-sm btn-primary dropdown-toggle' href='#' role='button' id='dropdownMenuLink'
                                                      data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                      ACTIONS
                                                  </a>
                                                  <div class='dropdown-menu dropdown-menu-right shadow animated--fade-in'
                                                      aria-labelledby='dropdownMenuLink'>
                                                      <div class='dropdown-header'>Actions:</div>
                                                      <input type='hidden' name='id_number' value='".$obj['id_number']."'>
                                                      <a class='dropdown-item' href='edituser.php?id_number=".$obj['id_number']."' style='color:rgb(44, 155, 209);'>Edit</a>
                                                      ";
                                                      if ($obj['user_type'] != 'SUPER') {
                                                        echo "<input class='dropdown-item' type='submit' name='delete_user' value='Delete' style='color:rgb(219, 49, 44);'>";
                                                      }
                                                      echo "
                                                      <div class='dropdown-divider'></div>
                                                      <div class='dropdown-header'>Visibility:</div>
                                                      <input class='dropdown-item' type='submit' name='disable_acc' value='Disable account'>
                                                      <input class='dropdown-item' type='submit' name='enable_acc' value='Enable account'>
                                                  </div>
                                              </div>

                                            </form></td>";
                                      echo "</tr>";
                                    }

                                   ?>
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
                    <a class="btn btn-primary" href="../logout.php">Logout</a>
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
  if (isset($_POST['disable_acc'])) {
    require '../modal.php';
    if ($user->checkStatus($_POST['id_number'])) {
      if ($user->setAccountStatus(array("DISABLED",$_POST['id_number']))) {
        echo "<script>
          $(document).ready(function(){
            $('.modal-header').css({
              backgroundColor : '#800000',
              color : 'white',
              textAlign: 'center'
            });
            $('.modal-title').text('CICjournal');
            $('.modal-body').text('This user account is now disabled');
            $('#modal-success-save').text('Cancel');
            $('#modal-success-close').text('Delete');
            $('#modal-success-save').hide();
            $('#modal-success-close').hide();
            $('#successModal').modal('show');
            setTimeout(function(){
              $('#successModal').modal('hide');
              window.location.href = 'manageuser.php';
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
          $('.modal-body').text('This user account is already disabled');
          $('#modal-success-save').text('Cancel');
          $('#modal-success-close').text('Delete');
          $('#modal-success-save').hide();
          $('#modal-success-close').hide();
          $('#successModal').modal('show');
          setTimeout(function(){
            $('#successModal').modal('hide');
            window.location.href = 'manageuser.php';
          }, 2000);
        });
      </script>";
    }
  }elseif (isset($_POST['enable_acc'])){
    require '../modal.php';
    if (!$user->checkStatus($_POST['id_number'])) {
      if ($user->setAccountStatus(array("ENABLED",$_POST['id_number']))) {
        echo "<script>
          $(document).ready(function(){
            $('.modal-header').css({
              backgroundColor : '#800000',
              color : 'white',
              textAlign: 'center'
            });
            $('.modal-title').text('CICjournal');
            $('.modal-body').text('This user account is now enabled');
            $('#modal-success-save').text('Cancel');
            $('#modal-success-close').text('Delete');
            $('#modal-success-save').hide();
            $('#modal-success-close').hide();
            $('#successModal').modal('show');
            setTimeout(function(){
              $('#successModal').modal('hide');
              window.location.href = 'manageuser.php';
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
          $('.modal-body').text('This user account is already enabled');
          $('#modal-success-save').text('Cancel');
          $('#modal-success-close').text('Delete');
          $('#modal-success-save').hide();
          $('#modal-success-close').hide();
          $('#successModal').modal('show');
          setTimeout(function(){
            $('#successModal').modal('hide');
            window.location.href = 'manageuser.php';
          }, 2000);
        });
      </script>";
    }

  }elseif (isset($_POST['delete_user'])){
    array_pop($_POST);
    $_SESSION['to_delete'] = $_POST['id_number'];
    require '../modal.php';
    echo "<script>
      $(document).ready(function(){
        $('#successModal').modal({
            backdrop: 'static'
        });

        $('.modal-header').css({
          backgroundColor : '#800000',
          color : 'white',
          textAlign: 'center'
        });
        $('.modal-title').text('CICjournal');
        $('.modal-body').text('Are you sure you want to delete this user?');
        $('#modal-success-save').text('Cancel');
        $('#modal-success-close').text('Delete');
        // $('#modal-success-save').hide();
        // $('#modal-success-close').hide();
        $('#successModal').modal('show');

        $('#modal-success-close').on('click', function(event){
          window.location.href = 'deleteuser.php';
        });

        $('#modal-success-save').on('click', function(event){
          window.location.href = 'manageuser.php';
        });

        $('.close').on('click', function(event){
          window.location.href = 'manageuser.php';
        });

      });
    </script>";

  }
 ?>
