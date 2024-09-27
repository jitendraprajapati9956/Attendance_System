<?php
session_start();

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'attendance';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " );
}

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = mysqli_real_escape_string($conn,$_SESSION['username']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_code = mysqli_real_escape_string($conn,$_POST['subc']);
    $subject_name = mysqli_real_escape_string($conn,$_POST['subn']);
    $theory_attend = intval($_POST['tal']);
    $theory_total = intval($_POST['ttl']);
    $practical_attend = intval($_POST['pal']);
    $practical_total = intval($_POST['ptl']);
    
    $theory= $theory_attend / $theory_total;

    $practical = $practical_attend / $practical_total; 

    $checkQuery = "SELECT * FROM subject WHERE username = '$username' AND subcode = '$subject_code'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        $updateQuery = "UPDATE subject SET subname = '$subject_name', theoryattend = '$theory_attend', theorytotal = '$theory_total', practicalattend = '$practical_attend', practicaltotal = '$practical_total'   WHERE username = '$username' AND subcode = '$subject_code'";
        if (mysqli_query($conn, $updateQuery)) {
            echo "<script>alert('Subject updated successfully.')</script>";
            echo "<script>window.open('viewattend.php','_self')</script>";
            
        } else {
            echo "<script>alert('Error updating subject: " . mysqli_error($conn) . "')</script>";
        }
    } else {
        $insertQuery = "INSERT INTO subject (username, subcode, subname, theoryattend, theorytotal, practicalattend, practicaltotal) VALUES ('$username', '$subject_code', '$subject_name', '$theory_attend', '$theory_total', '$practical_attend', '$practical_total')";
        if (mysqli_query($conn, $insertQuery)) {
            echo "<script>alert('New subject added successfully.')</script>";
            echo "<script>window.open('viewattend.php','_self')</script>";

        } else {
            echo "<script>alert('Error adding subject: " . mysqli_error($conn) . "')</script>";
        }
    }
}

mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0">	
        <link rel="stylesheet" href="style/profile.css">
        <link rel="stylesheet" href="style/register.css">
  
    </head>

<body>
<ul>
  <li ><a href="dashboard.php">Student Profile</a></li>
  <li ><a href="editprofile.php">Edit Profile</a></li>
  <li ><a href="subject.php">Subject</a></li>
  <li class="active"><a href="#attendance.php">Attendance</a></li>
  <li><a href="logout.php">Logout</a></li>
</ul>

<ul>
  <li class="active"><a href="#addattendance.php">Add Attendance</a></li>
  <li ><a href="viewattend.php">View Attendance</a></li>
</ul>


<h1>Attending Lecture Subject</h1>

<form action="" method="post">
        
          <label for="subc">Subject Code:</label>
          <input type="text" id="username" name="subc" placeholder="Enter Subject Code" ><br>
     
          <label for="subn">Subject Name:</label>
          <input type="text" id="username" name="subn" placeholder="Enter Subject Name" ><br>

          <label for="tal">Theory Attending Lecture</label>
          <input type="number" id="username" name="tal" placeholder="Enter Theory Attending Lecture" min="0" max="100"><br>
        
          <label for="ttl">Theory Total Lecture:</label>
          <input type="number" id="username" name="ttl" placeholder="Enter Theory Total Lecture" min="0" max="500"><br>
        
          <label for="pal">Practical Attending Lecture:</label>
          <input type="number" id="username" name="pal" placeholder="Enter Practical Attending Lecture" min="0" max="100" ><br>
        
          <label for="ptl">Practical Total Lecture:</label>
          <input type="number" id="username" name="ptl" placeholder="Enter Practical Total Lecture" min="0" max="500" ><br>
        
         
          <button type="submit" name="attending">Attending </button><br>

</form>
</body>
</html>