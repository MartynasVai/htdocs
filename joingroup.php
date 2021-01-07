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

$db = mysqli_connect("localhost", "root", "", "svetaine");


$group_id=$_GET["id"];

$_SESSION['groupid']=$group_id;


$sql = "SELECT * FROM groups WHERE group_id='$group_id'";
$sth = $db->query($sql);
$result=mysqli_fetch_array($sth);

if($result){

    $name=$result['groupname'];
    $pic='<img src="data:image/jpeg;base64,'.( $result['group_photo'] ).'"width="200" height="200"/>';
    $bio=$result['group_bio'];

}else{
echo "group doesn't exist";
//TODO link to 404
}
?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="style.css">
<link  href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>


<style>
  div{
  word-wrap: break-word;
}
</style>




</head>
<body>
<form method="post" action="groups.php" value="<?php echo $group_id; ?>">

<div class="input-group">
<p>Group picture</p>
<?php echo $pic?>
<br>
<p>bio: <?php echo $bio ?></p>
</div>
<?php include('errors.php'); ?>
  	<div class="input-group">
      <p>Group name : <strong><?php echo $name; ?></strong></p>
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="join_gr">Join group</button>
  	</div>

  </form>



</body>