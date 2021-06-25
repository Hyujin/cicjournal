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

  if (!isset($_GET['post_id'])) {
    header("location:index.php");
  }

  $user = new UserDashboard($_SESSION['id_number'],$_SESSION['user_type']);
  $post = new Posts($_SESSION['id_number'],$_SESSION['user_type']);
  $setting = new Settings();
  $check_to_edit = $post->getSpecificPaper($_GET['post_id'])['post_id'];

  if (empty($check_to_edit)) {
    // echo "<script> window.location.href = 'managepap.php'; </script>";
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

    <title>Edit Paper</title>

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

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

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
                <div class="container">
                    <!-- Page Heading -->
                    <!-- BODY::: MUCH BETTER IF BOOTSTRAP FORM INYO I INSERT DRE -->
                    <div class="card o-hidden border-bottom-danger shadow-lg p-3 my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-5">Edit Paper</h1>
                                        </div>
                                        <form class="user" method="post" enctype="multipart/form-data">
                                          <?php
                                            $to_edit = $post->getSpecificPaper($_GET['post_id']);
                                           ?>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="" placeholder="Title of the paper" value="<?php echo stripslashes($to_edit['title']); ?>"name="title" required>
                                            </div>
                                            <div class="form-group">
                                              <textarea class="form-control" rows="8" cols="80" placeholder="Synopsis/description" name="synopsis" required><?php echo stripslashes($to_edit['synopsis']); ?></textarea>
                                                <!-- <input type="text" class="form-control" id="" placeholder="Title of the paper" name="title"> -->
                                            </div>
                                            <div class="form-group">
                                              <input class="form-control"type="number" min="1997" max="2021" step="1" value="<?php echo $to_edit['year_publish'] ?>" name="year"required>
                                            </div>
                                            <div class="form-group">
                                              <select id="inputState" class="form-control" name="category" required>
                                                <option selected disabled hidden>Category</option>
                                                <?php
                                                  $categories = $setting->getAllCategory();
                                                  foreach ($categories as $category) {
                                                    if ($category['category_id'] == $to_edit['category_id']) {
                                                      echo "<option value='".$category['category_id']."' selected>".$category['name']."</option>";
                                                      continue;
                                                    }
                                                    echo "<option value='".$category['category_id']."'>".$category['name']."</option>";
                                                  }
                                                 ?>
                                              </select>
                                            </div>
                                            <div class="form-group" id="datalistgroup">
                                                <input type="text" class="form-control" id="datalistinput" list="datalistOptions" placeholder="Add/tag authors" onchange="getEmail()" value="">
                                                <datalist id="datalistOptions">
                                                  <?php
                                                    $student_info = $user->getAllStudents();
                                                    $paper_author = $post->getPaperAuthors($_GET['post_id']);

                                                    for ($i=0; $i < sizeof($student_info); $i++) {
                                                      echo "<option class='emails' value='".$student_info[$i]['id_number']."'><option>";
                                                    }

                                                   ?>
                                                </datalist>
                                                <ul class="list-group">
                                                  <li id="appendPill" class="list-group-item d-flex-wrap align-items-center"style="color:white;">
                                                    <!-- <span class="badge bg-primary rounded-pill">
                                                      <h6>&nbsp;&nbsp;email@gmail.com <button class="btn btn-link btn-sm"type="button" name="button"style="color:white;text-decoration:none;">x</button></h6>
                                                    </span> -->
                                                  </li>
                                                </ul>
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
                                                        // console.log(emails[i].value);
                                                          if (emails[i].value == datalist.value) {
                                                            check_list = true;
                                                          }
                                                      }

                                                      // //Check duplicate
                                                      for (var i = 0; i < klazz.length; i++) {
                                                        console.log(klazz[i].value);
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
                                                        closeButton.setAttribute("class","btn btn-link btn-sm x");
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

                                                    function toEditPill(data) {
                                                      var hiddenField = document.createElement("input");

                                                      hiddenField.setAttribute("type","hidden");
                                                      hiddenField.setAttribute("class",data+" klazz");
                                                      hiddenField.setAttribute("name","authors[]");
                                                      hiddenField.setAttribute("value",data);
                                                      document.getElementById('datalistgroup').appendChild(hiddenField);

                                                      var spanWrapper = document.createElement("span");
                                                      var h6 = document.createElement("h6");
                                                      var closeButton = document.createElement("button");
                                                      //Span element
                                                      spanWrapper.setAttribute("class", "badge bg-primary rounded-pill "+ data);
                                                      spanWrapper.setAttribute("style", "margin-right:2px;");
                                                      document.getElementById("appendPill").appendChild(spanWrapper);
                                                      //h6
                                                      closeButton.setAttribute("class","btn btn-link btn-sm");
                                                      closeButton.setAttribute("type","button");
                                                      closeButton.setAttribute("style","color:white;text-decoration:none;");
                                                      closeButton.setAttribute("id", data);
                                                      closeButton.setAttribute("onclick", "removeSelected(this.id)");
                                                      closeButton.innerHTML = "x";
                                                      h6.innerHTML = "&nbsp;&nbsp;"+ data;
                                                      spanWrapper.appendChild(h6);
                                                      h6.appendChild(closeButton);

                                                      // datalist.value = "";
                                                    }

                                                    function removeSelected(emailRemove) {
                                                      console.log("class: "+emailRemove);
                                                      var klazz = document.getElementsByClassName('klazz');
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

                                                    var authors = <?php echo json_encode($paper_author); ?>

                                                    for (var i = 0; i < authors.length; i++) {
                                                      console.log(authors[i]);
                                                      toEditPill(authors[i]);
                                                    }
                                                 </script>


                                            </div>
                                            <div class="form-group">
                                              <div class="custom-file col-sm-12 mb-3 mb-sm-4">
                                                <!-- <input type="file" class="form-control" name="post_file" value=""> -->
                                                <input type="file" class="custom-file-input" id="post_file"
                                                  aria-describedby="inputGroupFileAddon01" name="post_file" onchange="invoke()">
                                                <label class="custom-file-label" for="inputGroupFile01" id="file_label">
                                                  File
                                                  <script type="text/javascript">
                                                    setFileName(<?php echo json_encode($to_edit['file_name']); ?>);
                                                    function invoke() {
                                                      var file_name = document.getElementById('post_file').value;
                                                      var split = file_name.split('\\');
                                                      console.log(split[split.length-1]);
                                                      document.getElementById('file_label').innerHTML = split[split.length-1];
                                                    }

                                                    function setFileName(fileName) {
                                                      document.getElementById('file_label').innerHTML = fileName;
                                                    }
                                                  </script>
                                                </label>
                                              </div>
                                            </div>
                                            <input type="hidden" name="to_unlink" value="<?php echo "../file_uploads/".$to_edit['file_name'];?>">
                                            <input type="hidden" name="post_id" value="<?php echo $_GET['post_id']; ?>">
                                            <div align="center">
                                              <input type="submit"class="btn btn-primary btn-block" name="edit_post" value="Submit">
                                            </div>
                                        </form>
                                        <?php
                                          if (!empty($check_to_edit)) {
                                            if (isset($_POST['edit_post'])) {
                                              require '../modal.php';
                                              array_pop($_POST);
                                              $to_edit_id = array_pop($_POST);
                                              if ($setting->addNewActivity(array($_SESSION['id_number'],"EDIT PAPER POST_ID(".$to_edit_id.")"), $_SESSION['user_type'])) {
                                                $check_to_edit = $post->getSpecificPaper($to_edit_id)['post_id'];


                                                  if ($post->editPaper($_POST,$_FILES,$to_edit_id)) {
                                                    echo "<script>
                                                      $(document).ready(function(){
                                                        $('.modal-header').css({
                                                          backgroundColor : '#800000',
                                                          color : 'white',
                                                          textAlign: 'center'
                                                        });
                                                        $('.modal-title').text('CICjournal');
                                                        $('.modal-body').text('Successfuly edited paper');
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
                                                $('.modal-body').text('Unable to fetch this id');
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

                                         ?>
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



    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

</body>

</html>
