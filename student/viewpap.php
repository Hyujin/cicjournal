<?php
  require '../database/db_connect.php';
  require '../database/db.php';
  require '../controllers/posts_controller.php';
  require '../controllers/user_dashboard_controller.php';
  session_start();

  if(!isset($_SESSION['id_number']) || $_SESSION['user_type'] != "STUDENT"){
    header("location: ../");
  }

  if ($_SESSION['status'] == 'DISABLED') {
    header("location: disabled.php");
  }

  if (!isset($_GET['post_id'])) {
    header("location: index.php");
  }

  $user = new UserDashboard($_SESSION['id_number'],$_SESSION['user_type']);
  $post = new Posts($_SESSION['id_number'],$_SESSION['user_type']);
  $user_obj = $user->getSpecificUser($_SESSION['id_number']);
  $view_post = $post->getSpecificPaper($_GET['post_id']);
  $likes = $post->getReactionCount($_GET['post_id'], "LIKE");
  $unlikes = $post->getReactionCount($_GET['post_id'], "UNLIKE");
  $comments = $post->getComments($_GET['post_id']);

  if (empty($view_post)) {
    header("location:index.php");
  }

  if ($view_post['status'] == 'INACTIVE') {
    header('location:index.php');
  }

  if (isset($_POST['like'])) {
    array_pop($_POST);
    $_POST['react_type'] = "LIKE";
    if ($post->setReaction($_POST)) {
      $likes = $post->getReactionCount($_GET['post_id'], "LIKE");
      $unlikes = $post->getReactionCount($_GET['post_id'], "UNLIKE");
      header("location: viewpap.php?post_id=$_GET[post_id]#react_section");
    }

  }elseif(isset($_POST['unlike'])){
    array_pop($_POST);
    $_POST['react_type'] = "UNLIKE";
    if ($post->setReaction($_POST)) {
      $likes = $post->getReactionCount($_GET['post_id'], "LIKE");
      $unlikes = $post->getReactionCount($_GET['post_id'], "UNLIKE");
      header("location: viewpap.php?post_id=$_GET[post_id]#react_section");
    }
  }elseif (isset($_POST['comment'])) {
    array_pop($_POST);
    if ($post->setComment($_POST)) {
      $comments = $post->getComments($_GET['post_id']);
      header("location: viewpap.php?post_id=$_GET[post_id]#comment_section");
    }
  }elseif (isset($_POST['edit_comment'])) {
    array_pop($_POST);
    if ($post->editComment($_POST)) {
      header("location: viewpap.php?post_id=$_GET[post_id]#comment_section");
    }
  }elseif (isset($_POST['delete_comment'])) {
    array_pop($_POST);
    if ($post->deleteComment($_POST['comment_id'])) {
      header("location: viewpap.php?post_id=$_GET[post_id]#comment_section");
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

    <title>View Paper</title>

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

                <!-- Top bar -->
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
                                <form class="form-inline mr-auto w-100 navbar-search" method="get">
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
                <div class="container-fluid">
                    <div class="" style="margin-left: 10%;">
                        <div class="text-info">
                            <p class="small mb-2">
                              <?php
                                $date = date_create($view_post['date_posted']);
                                $date2 = date_format($date, "jS F, Y i:sa ");
                                echo $date2;
                              ?>
                                <!-- 28th January, 3:48pm -->
                            </p>
                             <h1 class="h3 mb-2"><?php echo $view_post['title']; ?></h1>

                        </div>
                        <div class="mb-2">
                            <code>Author/s</code>
                        </div>
                        <div class="row">
                          <?php $authors = $post->getPaperAuthors($view_post['post_id']); ?>
                           <?php if (!empty($authors)): ?>
                             <?php foreach ($authors as $value): ?>
                               <?php
                                $author = $user->getSpecificUser($value);
                                $default_avatar = ($author['sex'] == 'MALE'? 'male_default.jpg' : 'female_default.jpg' );
                                $author['prof_pic'] = ($author['prof_pic'] != null ? $author['prof_pic'] : $default_avatar);
                               ?>
                               <a class="d-flex align-items-center mr-4 mb-4" href="profile.php?id=<?php echo $author['id']; ?>">
                                   <div class="mr-2">
                                       <img class="icon_img rounded-circle" src="../profile_pictures/<?php echo $author['prof_pic']; ?>" alt="" width="40px">
                                   </div>
                                   <div class="font-weight-bold">
                                       <div class=""><?php echo $author['last_name'].", ".$author['first_name'] ?></div>
                                   </div>
                               </a>
                             <?php endforeach; ?>
                           <?php else: ?>
                             <i>Authors on paper</i>
                           <?php endif; ?>

                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 p-3">
                              <div class="d-sm-flex align-items-center justify-content-end">
                                  <!-- <br> -->
                                  <a href="../viewfile.php?file_name=<?php echo $view_post['file_name']; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="margin-right:10px;" target="_blank"><i class="fas fa-eye fa-sm text-white-50"></i> View File</a>
                                  <a href="../file_uploads/<?php echo $view_post['file_name']; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Download File</a>
                              </div>
                                <hr>
                                <h3 class="mb-4">Synopsis</h3>
                                <p class="">
                                    <?php echo $view_post['synopsis']; ?>
                                </p>
                                <hr>

                                <div>

                                  <form method="post" id="react_section" >
                                    <input type="hidden" name="post_id" value="<?php echo $_GET['post_id']; ?>">
                                    <input type="hidden" name="id_number" value="<?php echo $_SESSION['id_number']; ?>">
                                    <ul class="navbar nav">
                                      <li class="nav-item">
                                        <?php if(!$post->reactionExist($_GET['post_id'],$_SESSION['id_number'])): ?>
                                        <button type="submit" name="like" class="btn"id='like'style="width:80px;">
                                          <i class="fas fa-thumbs-up"  style="margin: 1%;">
                                            <span style="color:grey;">(<?php echo $likes; ?>)</span>
                                          </i>
                                        </button>

                                        <button class="btn"id='unlike'type="submit" name="unlike" style="width:80px;">
                                          <i class="fas fa-thumbs-down" id='unlike' style="margin:1%;">
                                            <span style="color:grey;">(<?php echo $unlikes; ?>)</span>
                                          </i>
                                        </button>
                                      <?php else: ?>
                                        <?php
                                          $color1 = ($post->likeExist($_GET['post_id'],$_SESSION['id_number']) ? 'blue': 'grey');
                                          $color2 = (!$post->likeExist($_GET['post_id'],$_SESSION['id_number']) ? 'blue': 'grey');
                                        ?>
                                        <button type="submit" name="like" class="btn"id='like'style="width:80px;">
                                          <i class="fas fa-thumbs-up"  style="color: <?php echo $color1; ?>;margin: 1%;">
                                            <span style="color:grey;">(<?php echo $likes; ?>)</span>
                                          </i>
                                        </button>

                                        <button class="btn"id='unlike'type="submit" name="unlike" style="width:80px;">
                                          <i class="fas fa-thumbs-down" id='unlike' style="color:<?php echo $color2; ?>;margin:1%;">
                                            <span style="color:grey;">(<?php echo $unlikes; ?>)</span>
                                          </i>
                                        </button>

                                      <?php endif; ?>

                                      </li>
                                    </ul>
                                  </form>

                                </div>
                                <hr>
                                <div id="comment_section" style="margin:1%;">
                                  <?php if (!empty($comments)): ?>
                                    <?php foreach ($comments as $comment): ?>
                                      <?php
                                        $keyboard_warrior = $user->getSpecificUser($comment['id_number']);
                                        $default_avatar = ($keyboard_warrior['sex'] == 'MALE'? 'male_default.jpg' : 'female_default.jpg' );
                                        $keyboard_warrior['prof_pic'] = ($keyboard_warrior['prof_pic'] != null ? $keyboard_warrior['prof_pic'] : $default_avatar);
                                      ?>
                                    <div class="card p-2">
                                      <div class="d-flex mr-4 mb-4 ">
                                        <form method="post" id='<?php echo $comment['id']; ?>' style="display:none;">
                                          <div class="d-flex">
                                            <div class="mr-2">
                                                <a href="#"><img class="icon_img rounded-circle" src="../profile_pictures/<?php echo $keyboard_warrior['prof_pic']; ?>" alt="" width="40px"></a>
                                            </div>
                                            <div class="font-weight-bold">

                                              <a href="#"><div class=""><?php echo $keyboard_warrior['first_name']." ".$keyboard_warrior['last_name']; ?></div></a>
                                              <textarea class="form-control form-control-sm" name="user_comment" rows="3" cols="80"><?php echo stripslashes($comment['comment']); ?></textarea> <br>
                                              <div class="d-flex">
                                                <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">
                                                <input class="btn btn-sm btn-primary mr-2"type="submit" name="edit_comment" value="Confirm edit">
                                                <button class="btn btn-sm btn-success" type="button" name="button" onclick='revert(<?php echo $comment['id']; ?>)'>Cancel</button>
                                              </div>
                                            </div>
                                          </div>

                                        </form>
                                        <div class="d-flex" id='user_comment_<?php echo $comment['id']; ?>'>
                                          <div class="mr-2">
                                              <a href="profile.php?id=<?php echo $keyboard_warrior['id']; ?>"><img class="icon_img rounded-circle" src="../profile_pictures/<?php echo $keyboard_warrior['prof_pic']; ?>" alt="" width="40px"></a>
                                          </div>
                                          <div class="font-weight-bold">
                                            <?php //$keyboard_warrior = $user->getSpecificUser($comment['id_number']); ?>
                                              <a href="profile.php?id=<?php echo $keyboard_warrior['id']; ?>"><div class=""><?php echo $keyboard_warrior['first_name']." ".$keyboard_warrior['last_name']; ?></div></a>
                                              <?php echo stripslashes($comment['comment']); ?>
                                          </div>
                                        </div>
                                        <?php if ($keyboard_warrior['id_number'] == $_SESSION['id_number']): ?>

                                          <div id='setting_<?php echo $comment['id']; ?>'style="margin-left:auto;">
                                            <div class='dropdown no-arrow' >
                                                <a class='dropdown-toggle' href='#' role='button' id='dropdownMenuLink'
                                                    data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                    <i class='fas fa-ellipsis-v fa-md fa-fw text-gray-500'></i>
                                                </a>
                                                <div class='dropdown-menu dropdown-menu-right shadow animated--fade-in '
                                                    aria-labelledby='dropdownMenuLink'>
                                                    <div class='dropdown-header'>Actions:</div>
                                                    <form method="post">
                                                      <input type='hidden' name='comment_id' value="<?php echo $comment['id'] ?>">
                                                      <button id='edit_button'class="dropdown-item"type="button" name="button"style='color:rgb(44, 155, 209);' onclick="transform(<?php echo $comment['id']; ?>)">Edit</button>
                                                      <!-- <a class='dropdown-item' href='editpap.php?post_id=' style='color:rgb(44, 155, 209);'>Edit</a> -->
                                                      <input class='dropdown-item' type='submit' name='delete_comment' value='Delete' style='color:rgb(219, 49, 44);'>
                                                    </form>
                                                </div>
                                            </div>
                                          </div>
                                        <?php endif; ?>

                                      </div>
                                      <div id='comment_date_<?php echo $comment['id']; ?>'>
                                        <small><i><?php echo $comment['comment_date']; ?></i></small>
                                      </div>

                                      <script type="text/javascript">
                                        var editButton = document.getElementById('edit_button');
                                        var editForm = document.getElementById('hidden_form');
                                        var userComment = document.getElementById('user_comment');
                                        var setting = document.getElementById('setting');
                                        var commentDate = document.getElementById('comment_date');

                                        function transform(x) {
                                          // edit
                                          var editForm = document.getElementById(x);
                                          var userComment = document.getElementById('user_comment_'+x);
                                          var setting = document.getElementById('setting_'+x);
                                          var commentDate = document.getElementById('comment_date_'+x);
                                          userComment.style.visibility = 'hidden';
                                          setting.style.visibility = 'hidden';
                                          commentDate.style.visibility = 'hidden';
                                          editForm.style.display = 'block';
                                        }

                                        function revert(x) {
                                          var editForm = document.getElementById(x);
                                          var userComment = document.getElementById('user_comment_'+x);
                                          var setting = document.getElementById('setting_'+x);
                                          var commentDate = document.getElementById('comment_date_'+x);
                                          userComment.style.visibility = 'visible';
                                          setting.style.visibility = 'visible';
                                          commentDate.style.visibility = 'visible';
                                          editForm.style.display = 'none';
                                        }

                                      </script>
                                    </div>
                                    <br>
                                  <?php endforeach; ?>
                                  <?php else: ?>
                                    <i>No comments</i>
                                  <?php endif; ?>
                                </div>
                                <hr>
                                <div id="write_comment_section"style="margin:1%;">
                                  <form method="post">
                                    <input type="hidden" name="post_id" value="<?php echo $_GET['post_id']; ?>">
                                    <input type="hidden" name="id_number" value="<?php echo $_SESSION['id_number']; ?>">
                                    <div class="form-group">
                                      <input class="form-control form-control-sm" type="text" name="comment_str" placeholder="Write a comment">
                                      <input type="submit" id="to_enter"name="comment" value="comment" hidden>
                                      <script type="text/javascript">
                                        var to_enter = document.getElementById('to_enter');

                                        to_enter.addEventListener(function (event) {
                                          if (event.keyCode == 13) {
                                            event.prevenDefault();
                                            to_enter.click();
                                          }
                                        })
                                      </script>
                                    </div>
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
