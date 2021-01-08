<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect("localhost", "root", "", "svetaine");
// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }


  // check if a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // register user if there are no errors in the form
  if (count($errors) == 0) {
      $password = password_hash($password_1, PASSWORD_DEFAULT);

    $profilepic =base64_encode( file_get_contents("Assets/nopic.jpg"));//---------------------------DEFAULT PROFILE PIC Assets/nopic.jpg

    
  	$query = "INSERT INTO users (username, email, password, profilepic) 
  			  VALUES('$username', '$email', '$password', '$profilepic')";
    mysqli_query($db, $query);

    $query = "SELECT * FROM users WHERE username='$username'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($result);

    $_SESSION['user_id']= $row['user_id'];//user id
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

// ... 
// LOGIN USER
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
   //     $password = md5($password);
        //$password = password_hash($password, PASSWORD_DEFAULT);
//password_verify ( string $password , string $hash ) : bool

       // $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";

        $query = "SELECT * FROM users WHERE username='$username'";

        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            $row = mysqli_fetch_assoc($results);
            if(password_verify($password, $row['password'])){
              session_start();
              

          $_SESSION['username'] = $username;
          $_SESSION['success'] = "You are now logged in";
          $_SESSION['user_id']= $row['user_id'];
          //$_SESSION['user_id'] = $userid;//--------------------USERID
          
          header('location: index.php');
        }else {
            array_push($errors, "Wrong username/password combination");
        }

        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
  }

  //----------------------------------------------------------------------------------EDIT PROFILE 
  
//edit username
if (isset($_POST['edit_un'])) {

  

  $username = mysqli_real_escape_string($db, $_POST['username']);

  $query = "SELECT * FROM users WHERE username='$username'";
  $result = mysqli_query($db, $query);

  if (empty($username)) { array_push($errors, "Username is required"); }
  $user_check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }}
    if (count($errors) == 0) {

  $id  = $_SESSION['user_id'];



  $query  = "UPDATE users SET username='$username' WHERE user_id=$id";
  mysqli_query($db, $query);

  $_SESSION['username'] = $username;


}
  

}
//EDIT EMAIL
if (isset($_POST['edit_em'])) {


  $email = mysqli_real_escape_string($db, $_POST['email']);

  $query = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($db, $query);

  if (empty($email)) { array_push($errors, "Email is required"); }
  $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['email'] === $email) {
      array_push($errors, "Email is taken");
    }}
    if (count($errors) == 0) {


  $id  = $_SESSION['user_id'];

  $query  = "UPDATE users SET email='$email' WHERE user_id=$id";
  mysqli_query($db, $query);

  $_SESSION['email'] = $email;


}
  

}
//EDIT PASSWORD
if (isset($_POST['edit_pas'])) {


  $id  = $_SESSION['user_id'];


  //mysqli_query($db, $query);

  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }
  if (count($errors) == 0) {
    // $password = md5($password_1);//encrypt the password before saving in the database-------------------------
     $password = password_hash($password_1, PASSWORD_DEFAULT);
     $query  = "UPDATE users SET password='$password' WHERE user_id=$id";
     mysqli_query($db, $query);
  }



}


  
//EDIT PROFILE PICTURE
if (isset($_POST['edit_pfp'])) {


  
  if(!file_exists($_FILES['newprofilepic']['tmp_name']) || !is_uploaded_file($_FILES['newprofilepic']['tmp_name'])) {array_push($errors, "Picture is required");}


  if (count($errors) == 0) {
  $image = addslashes(base64_encode(file_get_contents($_FILES['newprofilepic']['tmp_name'])));



  $id  = $_SESSION['user_id'];


  $query  = "UPDATE users SET profilepic='$image' WHERE user_id=$id";

  mysqli_query($db, $query);


}
  

}
if (isset($_POST['edit_bio'])) {


  $bio = mysqli_real_escape_string($db, $_POST['bio']);




  $id  = $_SESSION['user_id'];

  $query  = "UPDATE users SET bio='$bio' WHERE user_id=$id";
  mysqli_query($db, $query);



  

}
//-----------------------------------------------------------------------CREATE GROUP
if (isset($_POST['create_grp'])) {


  $bio = mysqli_real_escape_string($db, $_POST['groupbio']);




  $id  = $_SESSION['user_id'];


if (isset($_POST['private'])) {

  $private=true;
  // Checkbox is selected
} else {
$private=false;
 // Alternate code
}

if(!file_exists($_FILES['groupphoto']['tmp_name']) || !is_uploaded_file($_FILES['groupphoto']['tmp_name'])) {

  
  //$image = addslashes(base64_encode(file_get_contents($_FILES['newprofilepic']['tmp_name'])));
  
  
    $image =base64_encode( file_get_contents("Assets/nopic.jpg"));
  }else{
  $image = addslashes(base64_encode(file_get_contents($_FILES['groupphoto']['tmp_name'])));
}
  $groupname = mysqli_real_escape_string($db, $_POST['groupname']);


  $query = "SELECT * FROM groups WHERE groupname='$groupname'";
  $result = mysqli_query($db, $query);



  if (empty($groupname)) { array_push($errors, "Group name is required"); }
  $group_check_query = "SELECT * FROM groups WHERE groupname='$groupname' LIMIT 1";
  $result = mysqli_query($db, $group_check_query);
  $group = mysqli_fetch_assoc($result);
  

  if ($group) { // if group exists
    if ($group['groupname'] === $groupname) {
      array_push($errors, "Group name already exists");
    }}



    if (count($errors) == 0) {


	$query = "INSERT INTO groups (groupname, group_photo, group_admin, group_bio, private) 
  			  VALUES('$groupname', '$image', '$id', '$bio','$private')";
    mysqli_query($db, $query);


    $query = "SELECT * FROM groups WHERE groupname='$groupname'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);

    $groupid= $row['group_id'];


    $query = "INSERT INTO group_membership(user_id, group_id)
          VALUES('$id','$groupid')";
    mysqli_query($db, $query);

    }

}

//join_gr
if (isset($_POST['join_gr'])) {



  $id  = $_SESSION['user_id'];
  $group_id = $_SESSION['groupid'];
  unset($_SESSION['groupid']);

  $user_check_query = "SELECT * FROM group_membership WHERE user_id='$id' AND group_id='$group_id'  LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
      array_push($errors, "You are already a member");
    }
    if (count($errors) == 0) {

    $query = "INSERT INTO group_membership(user_id, group_id)
          VALUES('$id','$group_id')";
    mysqli_query($db, $query);

    }
}
//CREATE POST 
if (isset($_POST['create_post'])) {

  $posttype = $_POST['posttype'];
  unset($_SESSION['posttype']);
  
  $id  = $_SESSION['user_id'];


  $title =mysqli_real_escape_string($db, $_POST['title']);


  $private = $_SESSION['private'];
  unset($_SESSION['private']);

  $grouppost = $_SESSION['grouppost'];
  unset($_SESSION['grouppost']);

echo $private;
echo $grouppost;

  if($grouppost==1){

    $group_id= $_SESSION['groupid'];
    unset($_SESSION['groupid']);
  }else {$group_id=0;}




  if (empty($title)) { array_push($errors, "Title is required"); }//IF NO TITLE
  if (count($errors) == 0) {//IF NO ERRORS

    $post_check_query = "SELECT * FROM posts WHERE title='$title'LIMIT 1";
    $result = mysqli_query($db, $post_check_query);
    $posts = mysqli_fetch_assoc($result);
    
    if ($posts) { // if post title exists
      if ($posts['title'] === $title) {
        array_push($errors, "Title already exists");
      }}

  if($posttype == 1){//image post type

    if(!file_exists($_FILES['postimage']['tmp_name']) || !is_uploaded_file($_FILES['postimage']['tmp_name'])) {array_push($errors, "Picture is required");}

  

 

  if (count($errors) == 0) {//IF NO ERRORS

    $image = addslashes(base64_encode(file_get_contents($_FILES['postimage']['tmp_name'])));

  $query = "INSERT INTO posts (user_id, group_post, private_group, post_type, title, image, group_id) 
  VALUES('$id', '$grouppost','$private', '$posttype', '$title', '$image', $group_id)";
mysqli_query($db, $query);

  }



  }else {//text post type

  $text =mysqli_real_escape_string($db, $_POST['text']);
  

  if (empty($title)) { array_push($errors, "Title is required"); }//IF NO TEXT

  if (count($errors) == 0) {//IF NO ERRORS

  
    $query = "INSERT INTO posts (user_id, group_post, private_group, post_type, title, text, group_id) 
    VALUES('$id', '$grouppost','$private', '$posttype', '$title', '$text', $group_id)";
  mysqli_query($db, $query);



  }
  }
  }
  }
  //-----------------------------------------------------------------------DELETING
  if (isset($_POST['delete_group'])) {//DELETE GROUP


 

    $id  = $_SESSION['user_id'];
    $group_id = $_SESSION['group_id'];
    unset($_SESSION['group_id']);
    $_SESSION['admin']=$admin;
    $sql = "SELECT * FROM groups WHERE group_id='$group_id'";
    $sth = $db->query($sql);
    $result=mysqli_fetch_array($sth);
    $admin=$result['group_admin'];

    if($admin==$id){

      


//DELETE FROM `groups` WHERE `groups`.`group_id` = 7
//DELETE FROM `groups` WHERE `groups`.`group_id` = 6


     $del="DELETE FROM groups WHERE group_id ='$group_id'";


     mysqli_query($db, $del);
     //mysqli_close($db);

    // $db = mysqli_connect("localhost", "root", "", "svetaine");

     $del="DELETE FROM posts WHERE group_id ='$group_id'";
     mysqli_query($db, $del);

     $del="DELETE FROM group_membership WHERE group_id ='$group_id'";
     mysqli_query($db, $del);
 
     mysqli_close($db);





     header("location: groups.php");
    }else{array_push($errors, "You don't have the permission"); }





  }
  if (isset($_POST['delete_acc'])) {//DELETE GROUP


 

    $id  = $_SESSION['user_id'];




//DELETE FROM `groups` WHERE `groups`.`group_id` = 7
//DELETE FROM `groups` WHERE `groups`.`group_id` = 6
$user_check_query = "SELECT * FROM groups WHERE group_admin='$id' LIMIT 1";
$result = mysqli_query($db, $user_check_query);
$user = mysqli_fetch_assoc($result);

if($result){
    
$groupid=$user['group_id'];

     $del="DELETE FROM groups WHERE group_admin ='$id'";
     mysqli_query($db, $del);

     $del="DELETE FROM posts WHERE group_id ='$groupid'";
     mysqli_query($db, $del);

     $del="DELETE FROM group_membership WHERE group_id ='$groupid'";
     mysqli_query($db, $del);

}
     

     $del="DELETE FROM posts WHERE user_id ='$id'";
     mysqli_query($db, $del);

     $del="DELETE FROM users WHERE user_id='$id'";
     mysqli_query($db, $del);
 
     mysqli_close($db);


     session_destroy();
     header("location: index.php");
  }
  ?>
