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
  $group_id=$_GET["id"];
//creategrouppost?id=
$_SESSION['groupid']=$group_id;

$db = mysqli_connect("localhost", "root", "", "svetaine");//CONNECT TO DATABASE

$sql = "SELECT * FROM group_membership WHERE group_id='$group_id' AND user_id='$id'";//CHECK IF USER IS IN THE GROUP
$sth = $db->query($sql);
$result=mysqli_fetch_array($sth);
if($result){


$sql = "SELECT * FROM groups WHERE group_id='$group_id'";
$sth = $db->query($sql);
$result=mysqli_fetch_array($sth);

if($result){

$_SESSION['private'] =$result['private'];
$_SESSION['grouppost']=true;

}else{array_push($errors, "Error");}


}else{array_push($errors, "You are not a member");}




?>

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <title>Create post</title>
  <link rel="stylesheet" type="text/css" href="style.css">


  <script>
$(document).ready(function(){/// jei post type image parodyti image upload
  $("#1").click(function(){
    $("#text").hide();
    $("#image").show();
  });
  $("#2").click(function(){/// jei post type text parodyti text upload
     $("#text").show();
     $("#image").hide();
  });
});
</script>
</head>
<body>
  <div class="header">
  	<h2>Create post</h2>
  </div>
	
  <form method="post" action="creategrouppost.php?id=1" enctype="multipart/form-data">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>Title</label>
  	  <input type="text" name="title">
  	</div>
<div>
<input type="radio"  id="1" name="posttype" value="1" checked>
  <label for="1">image</label><br>
  <input type="radio"  id="2" name="posttype" value="2">
  <label for="2">text</label><br>  


</div>
<div id=text hidden>
<div>
<textarea name="text" rows="5" cols="50" maxlength="255">
</textarea>
</div>
</div>
<div id=image>
<div class="input-group">
<input type="file" accept="image/*" name="postimage" value="<?php echo $postimage; ?>">
    </div>
</div>


  	</div>



  	<div class="input-group">
  	  <button type="submit" class="btn" name="create_post">Post</button>
  	</div>
  </form>


</body>

</html>



