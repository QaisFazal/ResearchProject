<?php
session_start();
if (isset($_GET['id'])) {
	// Connect to the MySQL database  
    include "db.php";
	$id = preg_replace('#[^0-9]#i', '', $_GET['id']); 
	// Use this var to check to see if this ID exists, if yes then get the product 
	// details, if no then exit this script and give message why
	$sql = mysqli_query($con,"SELECT * FROM products WHERE product_id='$id' LIMIT 1");
	$productCount = mysqli_num_rows($sql); // count the output amount
    if ($productCount > 0) {
		// get all the product details
		while($row = mysqli_fetch_array($sql)){ 
			$pro_id    = $row['product_id'];
			$pro_cat   = $row['product_cat'];
			$pro_brand = $row['product_brand'];
			$pro_title = $row['product_title'];
			$pro_price = $row['product_price'];
      $pro_image = $row['product_image'];
      $pro_desc = $row['product_desc'];
         }
		 
	} else {
		echo "That item does not exist.";
	    exit();
	}
		
}
else {
	echo "Data to render this page is missing.";
	exit();
}

  if(isset($_POST['submitComment'])) {
    $uid=$_SESSION['uid'];
    $pid=$pro_id;
    $date=date("Y/m/d");
    $comment=$_POST['comment'];

    $sql="INSERT INTO comments (uid,pid,time,comment) VALUES ('$uid','$pid','$date','$comment')";
    $result= $con->query($sql);




}
 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>TripMate</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<script src="js/jquery2.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="main.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css"/>

	</head>
<body style="padding-top:56px;">


	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">	
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse" aria-expanded="false">
					<span class="sr-only">navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="index.php" class="navbar-brand">TripMate</a>
			</div>
		<div class="collapse navbar-collapse" id="collapse">
			<ul class="nav navbar-nav">
				<li><a href="index.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
				<li><a href="index.php"><span class="glyphicon glyphicon-modal-window"></span>Product</a></li>
			</ul>
		</div>
	</div>
	</div>
  </div>
  

  <div class=container>
  <div class="row">
  <div class="col-lg-9">
  <div class="card mt-5">
          <img class="card-img-top img-fluid" src="<?php echo 'product_images/'.$pro_image ?>" alt="">
          <div class="card-body">
            <h3 class="card-title"><?php echo $pro_title ?></h3>
            <h4><?php echo '$ '.$pro_price ?></h4>
            <p class="card-text"><?php echo $pro_desc ?></p>
            <span class="text-warning">&#9733; &#9733; &#9733; &#9733; &#9734;</span>
            4.0 stars
          </div>
        </div>

        <div class="card card-outline-secondary my-4">
          <div class="card-header">
            Product Reviews
          </div>
          <div class="card-body">
          <?php
          $sql="SELECT * from comments where pid='$pro_id'";
          $query = mysqli_query($con,$sql);
          
          if (mysqli_num_rows($query) > 0) {
            while($row = mysqli_fetch_assoc($query)) {

            echo "<p>".$row['comment']."</p>";
            echo "<small class='text-muted'>Posted by ". $_SESSION['name']. " on ".$row['time']."</small>";
            echo "<hr>";
          }
        }
            ?>
            
            
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
  Write a Comment!
</button>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Write A Comment!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="">
      <textarea class="form-control" id="exampleFormControlTextarea1" name="comment" rows="3"></textarea>
      <button  type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button  type="submit" class="btn btn-primary" name="submitComment">Submit!</button>
      </form>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
          </div>
        </div>
       

      </div>
      </div>
      </body>
      </html>
      


