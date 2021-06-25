<?php
  require '../database/db_connect.php';
  require '../database/db.php';

  $db = new DBConnect();
  $con = $db->getConnection();

  $query = "SELECT COUNT(id) AS count_id FROM test_table";

  $number_per_page = 10;
  $current_page_num = (isset($_GET['page']) ? $_GET['page'] : 1);
  $number_of_result = mysqli_fetch_assoc(mysqli_query($con,$query))['count_id'];
  $total_pages = ceil($number_of_result / $number_per_page);
  $starting_limit = ($current_page_num - 1) * $number_per_page;

  $query2 = "SELECT * FROM test_table LIMIT $starting_limit,$number_per_page";
  $content = mysqli_query($con,$query2);

  echo "perpage: ".$number_per_page."<br>";
  echo "numofres: ".$number_of_result."<br>";
  echo "total_pages: ".$total_pages."<br>";
  echo "starting_lim: ".$starting_limit."<br>";
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
     <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
     <title>test</title>
   </head>
   <body> <br>
     <nav aria-label="Page navigation example">
      <ul class="pagination pg-blue">

        <?php
          if ($current_page_num == 1){
            echo "
            <li class='page-item disabled'>
              <a class='page-link' tabindex='-1'>Previous</a>
            </li>";
          }else{
            echo "
            <li class='page-item '>
              <a class='page-link' tabindex='-1' href='testfile.php?page=".($current_page_num-1)."'>Previous</a>
            </li>";
          }
        ?>


        <?php
          for ($i=0; $i < $total_pages; $i++) {
            if($current_page_num == $i+1){
          ?>
              <li class="page-item active">
                <a class="page-link" href-'testfile.php?page=<?php echo $i+1 ?>'><?php echo $i+1 ?></a>
              </li>
          <?php
            }else{
           ?>
             <li class="page-item ">
               <a class="page-link" href='testfile.php?page=<?php echo $i+1 ?>'><?php echo $i+1 ?></a>
             </li>
            <?php
            }
          }
          if ($current_page_num == $total_pages){
            echo "
            <li class='page-item disabled'>
              <a class='page-link' tabindex='-1'>Next</a>
            </li>";
          }else{
            echo "
            <li class='page-item '>
              <a class='page-link' tabindex='-1'  href='testfile.php?page=".($current_page_num+1)."'>Next</a>
            </li>";
          }
         ?>

      </ul>
    </nav>

    <div class="content">
      <?php
        $counter = $starting_limit+1;
        while ($obj = mysqli_fetch_assoc($content)) {
          echo $counter . ".) ".$obj['stringni']."<br>";
          $counter ++;
        }
       ?>
    </div>
   </body>
 </html>
