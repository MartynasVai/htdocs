<?php 
  session_start(); 


  
  if (isset($_GET['logout'])) {
  	session_destroy();
	  unset($_SESSION['username']);
	  unset($_SESSION['user_id']);
  	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link  href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</head>
<body>

<div class="header">
	<h2>Home Page</h2>
</div>
<div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
		<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
		<p> <a href="feed.php" style="color: blue;">Feed</a> </p>
		<p> <a href="profile.php" style="color: blue;">Profile</a> </p>
		<p> <a href="groups.php" style="color: blue;">Groups</a> </p>
		<p> <a href="createpost.php" style="color: blue;">Create post</a> </p>
		<p> <a href="creategroup.php" style="color: blue;">Create group</a> </p>
    	<p> <a href="index.php?logout='1'" style="color: red;">Logout</a> </p>
	<?php endif ?>
	<?php  if (!isset($_SESSION['username'])) : ?>
		<p> <a href="login.php" style="color: blue;">Log in</a> </p>
		<p> <a href="feed.php" style="color: blue;">Feed</a> </p>

		<?php endif ?>
</div>
		
</body>
</html>


