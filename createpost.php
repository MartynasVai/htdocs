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
  $_SESSION['private'] =false;
  $_SESSION['grouppost']=false;
?>

<head>
<link rel="stylesheet" type="text/css" href="style.css">
<link  href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <title>Create post</title>
  


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
	
  <form method="post" action="createpost.php" enctype="multipart/form-data">
    <?php include('errors.php'); ?>
    <p> <a href="index.php" style="color: blue;">Index</a> </p>
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



