<?php
session_start();
include 'db.php';

if ($_POST) {
  $username = mysqli_real_escape_string($conn, $_POST['uname']);
  $password = mysqli_real_escape_string($conn, $_POST['psw']);

  $sql = "SELECT * FROM students WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 1) {
      $user = mysqli_fetch_assoc( $result);
      $_SESSION['id'] =$user['id'];
      $_SESSION['username'] =$user['username'];
      header('location: dashboard.php');              
      echo "<script>alert('Welcome to $username')</script>";
      echo "<script>window.open('dashboard.php','_self')</script>";
    
  }  else{
      echo "<script>alert('Check Username Or Password')</script>";   
  }  
 }
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0">	
        <link rel="stylesheet" href="style/style.css">
    </head>

<body>

<center>
      
<h1> Student Login </h1>
<form action="#" method="post">
 
  <div class="container">
   
    <input type="text" placeholder="Enter Username" name="uname" required><br>
       
    <input type="password" placeholder="Enter Password" name="psw" required><br>

    <button type="submit">Login</button>
  
  </div>

  <div class="container" >
      <a href="forgot.php">Forgot password?</a></span><br>
     <a href="new.php">New Student Account</a></span>
  </div>
</form>
</center>
</body>
</html>
