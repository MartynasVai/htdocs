<?php 
$db = mysqli_connect("localhost", "root", "", "svetaine");

//echo 'Hello ' . ($_GET["id"]) . '!';

$profile_id=$_GET["id"];

$sql = "SELECT * FROM users WHERE user_id='$profile_id'";
$sth = $db->query($sql);
$result=mysqli_fetch_array($sth);

if($result){


  
  $pic='<img src="data:image/jpeg;base64,'.( $result['profilepic'] ).'"width="50%"/>';


  $profile_name=$result['username'];

  $bio=$result['bio'];

}else{
echo "user doesn't exist";
header("location: index.php");
}
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
</style>

</head>
<body>

<div class="header">
<h2>View profile</h2>
</div>

<div class="content">
<p> <a href="index.php" style="color: gray;">Index</a> </p>
<p> <a href="feed.php" style="color: gray;">Feed</a> </p>
<h3>Profile picture</h3>
<?php 
echo $pic
?>
<h3>Profile name</h3>
<h3>
<?php 
echo $profile_name;
?>
</h3>
<p>
<?php 
echo $bio;
?>
</p>




</body>