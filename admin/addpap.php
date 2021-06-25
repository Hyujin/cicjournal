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

    <title>Add Papers</title>

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

                        <!-- Nav Item - Alerts -->

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
                            <h6 class="m-0 font-weight-bold text-primary">Add Research Paper</h6>
                          </div>

                          <div class="card-body">
                            <form class="user" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="" placeholder="Title of the paper" name="title" required>
                                </div>
                                <div class="form-group">
                                  <textarea class="form-control" rows="8" cols="80" placeholder="Synopsis/description" name="synopsis" required></textarea>
                                    <!-- <input type="text" class="form-control" id="" placeholder="Title of the paper" name="title"> -->
                                </div>
                                <div class="form-group">
                                  <input class="form-control"type="number" min="1997" max="2021" step="1" value="1997" name="year">
                                </div>
                                <div class="form-group">
                                  <select id="inputState" class="form-control" name="category" required>

                                    <?php
                                      $categories = $setting->getAllCategory();
                                      $counter = 0;
                                      foreach ($categories as $category) {
                                        if ($counter == 0) {
                                          ?>
                                          <option selected hidden value='<?php echo $category['category_id']; ?>'>Category</option>
                                          <?php
                                        }
                                        $counter ++;
                                        echo "<option value='".$category['category_id']."'>".$category['name']."</option>";
                                      }
                                     ?>
                                  </select>
                                </div>
                                <div class="form-group" id="datalistgroup">
                                    <input type="text" class="form-control" id="datalistinput"list="datalistOptions" placeholder="Add/tag authors" onchange="getEmail()" value="">
                                    <datalist id="datalistOptions" style="overflow-y: auto;max-height: 500px;">

                                      <?php
                                        $student_info = $user->getAllStudents();

                                        if (sizeof($student_info) != 0) {
                                          for ($i=0; $i < sizeof($student_info); $i++) {
                                            echo "<option class='emails'value=".$student_info[$i]['id_number']."><option>";
                                          }
                                        }
                                       ?>
                                    </datalist>

                                     <script type="text/javascript">
                                       var klazz = document.getElementsByClassName('klazz');
                                        function getEmail() {
                                          var parentNode = document.getElementById('datalistgroup');
                                          var datalist = document.getElementById('datalistinput');
                                          var hiddenField = document.createElement("input");
                                          var emails = document.getElementsByClassName('emails');
                                          var check_list = false;
                                          var flag = true;

                                          for (var i = 0; i < emails.length; i++) {
                                              if (emails[i].value == datalist.value) {
                                                check_list = true;
                                              }
                                          }

                                          // //Check duplicate
                                          for (var i = 0; i < klazz.length; i++) {
                                            if(klazz[i].value == datalist.value){
                                              flag = false;
                                            }
                                          }


                                          if (check_list && flag && datalist.value != "") {
                                            // console.log('debb');
                                            hiddenField.setAttribute("type","hidden");
                                            hiddenField.setAttribute("class",datalist.value+" klazz");
                                            hiddenField.setAttribute("name","authors[]");
                                            hiddenField.setAttribute("value",datalist.value);
                                            document.getElementById('datalistgroup').appendChild(hiddenField);
                                            var spanWrapper = document.createElement("span");
                                            var h6 = document.createElement("h6");
                                            var closeButton = document.createElement("button");
                                            //Span element
                                            spanWrapper.setAttribute("class", "badge bg-primary rounded-pill "+ datalist.value);
                                            spanWrapper.setAttribute("style", "margin-right:2px;");
                                            document.getElementById("appendPill").appendChild(spanWrapper);
                                            //h6
                                            closeButton.setAttribute("class","btn btn-link btn-sm");
                                            closeButton.setAttribute("type","button");
                                            closeButton.setAttribute("style","color:white;text-decoration:none;");
                                            closeButton.setAttribute("id", datalist.value);
                                            closeButton.setAttribute("onclick", "removeSelected(this.id)");
                                            closeButton.innerHTML = "x";
                                            h6.innerHTML = "&nbsp;&nbsp;"+ datalist.value;
                                            spanWrapper.appendChild(h6);
                                            h6.appendChild(closeButton);
                                          }
                                          datalist.value = "";
                                        }

                                        function removeSelected(emailRemove) {
                                          console.log("class: "+emailRemove);
                                          for (var i = 0; i < klazz.length; i++) {
                                            // console.log("klazz: "+klazz.value);
                                            if(klazz[i].value == emailRemove){
                                              klazz[i].remove();
                                            }
                                          }
                                          var toRemove = document.getElementsByClassName(emailRemove);
                                          for (var i = 0; i < toRemove.length; i++) {
                                            toRemove[i].remove();
                                          }
                                        }
                                     </script>
                                    <ul class="list-group">

                                      <li id="appendPill" class="list-group-item d-flex-wrap align-items-center"style="color:white;">
                                        <!-- <span class="badge bg-primary rounded-pill">
                                          <h6>&nbsp;&nbsp;email@gmail.com <button class="btn btn-link btn-sm"type="button" name="button"style="color:white;text-decoration:none;">x</button></h6>
                                        </span> -->
                                      </li>
                                    </ul>

                                </div>
                                <div class="form-group">
                                  <div class="custom-file col-sm-12 mb-3 mb-sm-4">
                                    <!-- <input type="file" class="form-control" name="post_file" value=""> -->
                                    <input type="file" class="custom-file-input" id="post_file"
                                      aria-describedby="inputGroupFileAddon01" name="post_file" onchange="invoke()">
                                    <label class="custom-file-label" for="inputGroupFile01" id="file_label">
                                      File
                                      <script type="text/javascript">
                                        function invoke() {
                                          var file_name = document.getElementById('post_file').value;
                                          var split = file_name.split('\\');
                                          console.log(split[split.length-1]);
                                          document.getElementById('file_label').innerHTML = split[split.length-1];
                                        }
                                      </script>
                                    </label>
                                  </div>
                                </div>

                                <div align="center">
                                  <input type="submit"class="btn btn-primary btn-block" name="add_post" value="Submit">
                                </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

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
if (isset($_POST['add_post'])) {
  array_pop($_POST);
  if ($post->newPost($_POST,$_FILES)) {
    require '../modal.php';
    echo "<script>
      $(document).ready(function(){
        $('.modal-header').css({
          backgroundColor : '#800000',
          color : 'white',
          textAlign: 'center'
        });
        $('.modal-title').text('CICjournal');
        $('.modal-body').text('Successfuly added paper');
        $('#modal-success-save').hide();
        $('#modal-success-close').hide();
        $('#successModal').modal('show');
        setTimeout(function(){
          $('#successModal').modal('hide');
          window.location.href='managepap.php';
        }, 2000);
      });
    </script>";
  }else{
    require '../modal.php';
    echo "<script>
      $(document).ready(function(){
        $('.modal-header').css({
          backgroundColor : '#800000',
          color : 'white',
          textAlign: 'center'
        });
        $('.modal-title').text('CICjournal');
        $('.modal-body').text('Something went wrong. Please try refreshing the page.');
        $('#modal-success-save').hide();
        $('#modal-success-close').hide();
        $('#successModal').modal('show');
        setTimeout(function(){
          $('#successModal').modal('hide');
          window.location.href='managepap.php';
        }, 2000);
      });
    </script>";
  }

}

 ?>
