<?php include('server.php')?> 
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
  $sql = "SELECT * FROM users WHERE user_id=$id";
$sth = $db->query($sql);
$result=mysqli_fetch_array($sth);
$bio=$result['bio'];
$pic='<img src="data:image/jpeg;base64,'.( $result['profilepic'] ).'"width=40%"/>';
?>

<!DOCTYPE html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<link  href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<style>
	.btn{
	border: 1px solid  rgb(0, 0, 0);
}
</style>



</head>
<body>
<div class="header">
	<h2>Profile</h2>
</div>

<form method="post" action="profile.php" enctype="multipart/form-data">
<p> <a href="index.php" style="color: blue;">Index</a> </p>
<div>
<h4>Profile picture</h4>
</div>
<div class="input-group">
<?php echo $pic?>
</div>
<div>
<h4>New profile picture</h4>
<input type="file" accept="image/*" name="newprofilepic" value="<?php echo $newprofilepic; ?>">
</div>
      <div class="input-group">
  	  <button type="submit" class="btn" name="edit_pfp">Change picture</button>
  	</div>
<div>
<h4>Bio</h4>
<textarea name="bio" rows="5" cols="50" maxlength="255">
<?php echo $bio ?>
</textarea>

</div>
</div>
      <div class="input-group">
  	  <button type="submit" class="btn" name="edit_bio">Change bio</button>
  	</div>

</div>
  	<?php include('errors.php'); ?>
  	<div class="input-group">
	  <h4>Username : <strong><?php echo $_SESSION['username']; ?></strong></h4>
</div>
<div>
      <h4>New Username</h4>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
      <div class="input-group">
  	  <button type="submit" class="btn" name="edit_un">Change username</button>
  	</div>
  	<div class="input-group">
  	  <h4>New email</h4>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
      <button type="submit" class="btn" name="edit_em">Change email</button>
  	<div class="input-group">
  	  <h4>New Password</h4>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <h4>Confirm password</h4>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="edit_pas">Change password</button>
  	</div>

  	<button type="submit" class="btn" name="delete_acc">Delete account</button>

  </form>



</body>