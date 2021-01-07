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






  ?>
  <!DOCTYPE html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<link  href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>




</head>
<body>

<div class="header">
	<h2>Groups</h2>
</div>
<div class="content">
<p> <a href="index.php" style="color: gray;">Index</a> </p>
<?php 

$query = "SELECT * FROM group_membership WHERE user_id='$id'";


 $result = $db->query($query);

 $count = mysqli_num_rows($result);
 
  

//TODO design for page and display group users
foreach($result as $row) {

$findid=$row['group_id'];

$group_check_query = "SELECT * FROM groups where group_id=$findid";

$rez = mysqli_query($db, $group_check_query);
$groupfound = mysqli_fetch_assoc($rez); 
/** 
TODO ADD LINKS TO GROUPS
 
*/


  echo ("<br>");
    echo "<a href= ";//VIEWPOST
      echo("viewgroup.php?name=");
      echo($groupfound['groupname']);
      echo ">";
      echo ($groupfound['groupname']);
      echo"</a> <br>";



}

?>
</div>




</body>