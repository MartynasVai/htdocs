
<!DOCTYPE html>
<html>
<head>
<title>Feed</title>

<link rel="stylesheet" type="text/css" href="style.css">
<link  href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</head>
<body>

<div class="header">
	<h2>Feed</h2>
</div>

<div class="content">
<p> <a href="index.php" style="color: gray;">Index</a> </p>
<?php 

$db = mysqli_connect("localhost", "root", "", "svetaine");

$false=false;
$query = "SELECT * FROM posts WHERE private_group='0'";
$result = $db->query($query);
//$result=mysqli_fetch_array($sth);

foreach($result as $row) {
    echo ("<br>");
      echo "<a href= ";//VIEWPOST
        echo("viewpost.php?id=");
        echo($row['post_id']);
        echo ">";
        echo ($row['title']);
        echo"</a> <br>";
  }



?>




</div>



</body>