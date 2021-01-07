<?php 
$db = mysqli_connect("localhost", "root", "", "svetaine");

//echo 'Hello ' . ($_GET["id"]) . '!';

$profile_id=$_GET["id"];

$sql = "SELECT * FROM users WHERE user_id='$profile_id'";
$sth = $db->query($sql);
$result=mysqli_fetch_array($sth);

if($result){


  
  $pic='<img src="data:image/jpeg;base64,'.( $result['profilepic'] ).'"width="200" height="200"/>';
  echo $pic;

  $profile_name=$result['username'];

  $bio=$result['bio'];

    echo $profile_name;

    echo $bio;
}else
echo "user doesn't exist";
?>