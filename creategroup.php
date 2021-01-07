<?php include('server.php') ?>
<?php
  if(session_id() == '') {
    session_start();
}

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }



  $id  = $_SESSION['user_id'];

?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<link  href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>


<style>
  div{
  word-wrap: break-word;
}
.btn{
  border: 1px solid  rgb(0, 0, 0);
}
</style>

</head>
<body>
  <div class="header">
  	<h2>Create group</h2>
  </div>
	
  <form method="post" action="creategroup.php" enctype="multipart/form-data">
  <p> <a href="index.php" style="color: blue;">index</a> </p>
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <h2>Group name</h2>
  	  <input type="text" name="groupname" >
  	</div>
  	<div class="input-group">
      <h2>Group picture</h2>
<input type="file" accept="image/*" name="groupphoto" value="<?php echo $groupphoto; ?>">
    </div>
    <div>
    <h2>Group bio</h2>
<textarea name="groupbio" rows="5" cols="50" maxlength="255" value="<?php echo $groupbio; ?>">
</textarea>
</div>

  	<div>
    <label for="private">Private </label> 
      <input type="checkbox" name="private"value="<?php echo $private; ?>">
  <br>

  	  <button type="submit" class="btn" name="create_grp">Create group</button>
  	</div>

  </form>
</body>
</html>