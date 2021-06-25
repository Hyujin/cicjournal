<?php
  require 'database/db_connect.php';
  require 'database/db.php';
  require 'controllers/login_controller.php';
  session_start();
  /* NASA UBOS ANG CONDITIONING */
  if(isset($_SESSION['email']) && $_SESSION['user_type'] == "SUPER"){
    header("location: admin/");
  }elseif (isset($_SESSION['email']) && $_SESSION['user_type'] == "STUDENT") {
    header("location: student/");
  }
 ?>
 <!DOCTYPE html>
 <title>Signup</title>
 <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
 <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
 <!-- Include the above in your HEAD tag -->

 <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
 <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
 <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
  <!-- Include the above in your HEAD tag -->

 <style>
   @import url("//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css");
   .login-block{
     background: #DE6262;  /* fallback for old browsers */
     background: -webkit-linear-gradient(to bottom, gray, maroon);  /* Chrome 10-25, Safari 5.1-6 */
     background: linear-gradient(to bottom, gray, maroon); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
     float:left;
     width:100%;
     padding : 50px 0;
   }
   .banner-sec{background:url(https://static.pexels.com/photos/33972/pexels-photo.jpg)  no-repeat left bottom; background-size:cover; min-height:500px; border-radius: 0 10px 10px 0; padding:0;}
   .container{background:#fff; border-radius: 10px; box-shadow:15px 20px 0px rgba(0,0,0,0.1);}
   .carousel-inner{border-radius:0 10px 10px 0;}
   .carousel-caption{text-align:left; left:5%;}
   .login-sec{padding: 50px 30px; position:relative;}
   .login-sec .copy-text{position:absolute; width:80%; bottom:20px; font-size:13px; text-align:center;}
   .login-sec .copy-text i{color:#FEB58A;}
   .login-sec .copy-text a{color:#E36262;}
   .login-sec h2{margin-bottom:30px; font-weight:800; font-size:30px; color: #DE6262;}
   .login-sec h2:after{content:" "; width:100px; height:5px; background:#FEB58A; display:block; margin-top:20px; border-radius:3px; margin-left:auto;margin-right:auto}
   .btn-login{background: #DE6262; color:#fff; font-weight:600;}
   .banner-text{width:70%; position:absolute; bottom:40px; padding-left:20px;}
   .banner-text h2{color:#fff; font-weight:600;}
   .banner-text h2:after{content:" "; width:100px; height:5px; background:#FFF; display:block; margin-top:20px; border-radius:3px;}
   .banner-text p{color:#fff;}
 </style>

 <body>
   <section class="login-block">
     <div class="container">
     	<div class="row">
     		<div class="col-md-4 login-sec">
   		    <form class="login-form" method="post">

            <h2 class="text-uppercase text-center">Create an account</h2>

             <div class="form-group">
               <input type="email" class="form-control" placeholder="Email" name="email">
             </div>

             <div class="form-group">
               <input type="password" class="form-control" placeholder="Password" name="password">
             </div>

             <input type="hidden" name="user_type" value="STUDENT">

             <div class="form-group">
               <input type="password" class="form-control" placeholder="Confirm Passowrd" name="confirm">
             </div>


             <div class="form-check">
               <label class="form-check-label">
                 <input class="form-check-input btn btn-sm btn-login" type="submit" name="create_account" value="Create">
               </label>
             </div>
             <!-- <script type="text/javascript" src="../js/script.js"></script> -->

           </form>
           <div class="copy-text">Already have an account? <a href="index.php">Click Here</a></div>
     		</div>

 <!-- Separate this file into another php file -->
     		<div class="col-md-8 banner-sec">
           <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                 <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                 <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                 <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
               </ol>

               <div class="carousel-inner" role="listbox">
                 <div class="carousel-item active">
                   <img class="d-block img-fluid" src="https://static.pexels.com/photos/33972/pexels-photo.jpg" alt="First slide">
                   <div class="carousel-caption d-none d-md-block">
                     <div class="banner-text">
                         <h2>Welcome to CIC Journal</h2>
                         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
                     </div>
                   </div>
                 </div>

                 <div class="carousel-item">
                   <img class="d-block img-fluid" src="https://images.pexels.com/photos/7097/people-coffee-tea-meeting.jpg" alt="First slide">
                   <div class="carousel-caption d-none d-md-block">
                     <div class="banner-text">
                         <h2>Welcome to CIC Journal</h2>
                         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
                     </div>
                   </div>
                 </div>

                 <div class="carousel-item">
                   <img class="d-block img-fluid" src="https://images.pexels.com/photos/872957/pexels-photo-872957.jpeg" alt="First slide">
                   <div class="carousel-caption d-none d-md-block">
                     <div class="banner-text">
                         <h2>Welcome to CIC Journal</h2>
                         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
                     </div>
                   </div>
                 </div>

               </div>
         		</div>
         	</div>
       </div>
     </div>
   </section>
 </body>
 </html>
 <?php
   if(isset($_POST['create_account'])){
     //Remove unnecessary data
     for ($i=0; $i < 2; $i++) {
       array_pop($_POST);
     }

     $register = new Login();
     if($register->register($_POST)){
       require 'modal.php';
       echo "<script>
         $(document).ready(function(){
           $('.modal-header').css({
             backgroundColor : '#800000',
             color : 'white',
             textAlign: 'center'
           });
           $('.modal-title').text('Success');
           $('.modal-body').text('Please login to continue..');
           $('#modal-success-save').hide();
           $('#modal-success-close').hide();
           $('#successModal').modal('show');
           setTimeout(function(){
             $('#successModal').modal('hide');
             window.location.href='index.php';
           }, 5000);
         });
       </script>";
     }else{
       // $error = $register->getError();
       require 'modal.php';
       echo "<script>
         $(document).ready(function(){
           $('.modal-header').css({
             backgroundColor : '#800000',
             color : 'white',
             textAlign: 'center'
           });
           $('.modal-title').text('Something went wrong');
           // $('.modal-body').text('');
           $('#modal-success-save').hide();
           $('#modal-success-close').hide();
           $('#successModal').modal('show');
           setTimeout(function(){
             $('#successModal').modal('hide');
             window.location.href='signup.php';
           }, 5000);
         });
       </script>";
     }
   }

  ?>
