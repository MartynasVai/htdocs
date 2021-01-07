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


$post_id=$_GET["id"];



$sql = "SELECT * FROM posts WHERE post_id='$post_id'";//FIND POST
$sth = $db->query($sql);
$result=mysqli_fetch_array($sth);
$profileid=$result['user_id'];
$grouppost=$result['group_post'];

$sql2 = "SELECT * FROM users WHERE user_id='$profileid'";//FIND USER
$sth2 = $db->query($sql2);
$result2=mysqli_fetch_array($sth2);
$profilename=$result2['username'];

if($grouppost==1){$group_id=$result['group_id'];

    $sql3 = "SELECT * FROM groups WHERE group_id='$group_id'";//FIND GROUP
    $sth3 = $db->query($sql3);
    $result3=mysqli_fetch_array($sth3);
    $groupname=$result3['groupname'];



}

if($result){

    $title=$result['title'];
    $posttype=$result['post_type'];

    if($posttype==1){

    $pic='<img src="data:image/jpeg;base64,'.( $result['image'] ).'"width="25%" >';
}else{
    $text=$result['text'];

}
}else{
echo "post doesn't exist";
//TODO link to 404
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
<h2>View post</h2>
</div>

<div class="content">
<p> <a href="index.php" style="color: gray;">Index</a> </p>
<p> <a href="feed.php" style="color: gray;">Feed</a> </p>
      <?php 
        echo "<a href= ";//VIEWPROFILE
        echo("viewprofile.php?id=");
        echo($profileid);
        echo ">";
        echo ($profilename);
        echo"</a> <br>";

if($grouppost==1){
    echo "<a href= ";//VIEWGROUP
    echo("viewprofile.php?id=");
    echo($group_id);
    echo ">";
    echo ($groupname);
    echo"</a> <br>";

}



      echo ($title);
      echo("<br>");
      if($posttype == 1){
        echo $pic;


      }else{
          echo"<p>";
        echo $text;
        echo"</p>";


      }
      
      ?>






</body>