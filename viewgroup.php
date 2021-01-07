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

$user_id=$_SESSION['user_id'];

$db = mysqli_connect("localhost", "root", "", "svetaine");

//echo 'Hello ' . ($_GET["name"]) . '!';

$groupname=$_GET["name"];

$sql = "SELECT * FROM groups WHERE groupname='$groupname'";
$sth = $db->query($sql);
$result=mysqli_fetch_array($sth);

if($result){


  $admin=$result['group_admin'];
  $pic='<img src="data:image/jpeg;base64,'.( $result['group_photo'] ).'"width="50%"/>';
  //echo $pic;

  $bio=$result['group_bio'];

    //echo $groupname;

   // echo $bio;

    $id=$result['group_id'];

    $_SESSION['group_id']=$id;




/*/////////////////////////////////////////////////////////////////VIEW USERS
$query = "SELECT * FROM group_membership WHERE group_id='$id'";


 $result = $db->query($query);

 //$count = mysqli_num_rows($result);
 
  


foreach($result as $row) {
  echo ("<br>");
    echo $row['user_id'];
}
*/

}else
echo "group doesn't exist";
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
  div{
  word-wrap: break-word;
}

</style>



</head>
<body>
<div>



<div class="header">
  <h2>Group</h2>
</div>

<form method="post" action="index.php" >
<?php include('errors.php'); ?>
<p> <a href="index.php" style="color: blue;">Index</a> </p>
<div>
  <div>
<h4>Group picture</h4>
</div>

<?php echo $pic?>

<br>
<h4>bio: <?php echo $bio ?></h4>
</div>
  	<div class="input-group">
      <p>Group name : <strong><?php echo $groupname; ?></strong></p>
  	</div>
  	<div class="input-group">
    <button type="submit" class="btn" name="delete_group">DELETE GROUP</button>
  	</div>

  </form>
</div>




</body>
