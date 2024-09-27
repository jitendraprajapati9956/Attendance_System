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
    $theory_mark = intval($_POST['tmark']);
    $practical_mark = intval($_POST['pmark']);
    $termwork_mark = intval($_POST['twmark']);
    $total_mark = $theory_mark + $practical_mark + $termwork_mark;

    $checkQuery = "SELECT * FROM subject WHERE username = '$username' AND subcode = '$subject_code'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        $updateQuery = "UPDATE subject SET subname = '$subject_name', theorymark = '$theory_mark', practicalmark = '$practical_mark', twmark = '$termwork_mark', totalmark = '$total_mark' WHERE username = '$username' AND subcode = '$subject_code'";
        if (mysqli_query($conn, $updateQuery)) {
            echo "<script>alert('Subject updated successfully.')</script>";
            echo "<script>window.open('viewsub.php','_self')</script>";

        } else {
            echo "<script>alert('Error updating subject: " . mysqli_error($conn) . "')</script>";
        }
    } else {
        $insertQuery = "INSERT INTO subject (username, subcode, subname, theorymark, practicalmark, twmark, totalmark) VALUES ('$username', '$subject_code', '$subject_name', '$theory_mark', '$practical_mark', '$termwork_mark', '$total_mark')";
        if (mysqli_query($conn, $insertQuery)) {
            echo "<script>alert('New subject added successfully.')</script>";
            echo "<script>window.open('viewsub.php','_self')</script>";


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
  <li class="active"><a href="#subject.php">Subject</a></li>
  <li><a href="attendance.php">Attendance</a></li>
  <li><a href="logout.php">Logout</a></li>
</ul>

<ul>
  <li class="active"><a href="#addsub.php">Add Subject</a></li>
  <li><a href="viewsub.php">View Subject</a></li>
</ul>

<h1>Add Subject</h1>

<form action="#" method="post" enctype="multipart/form-data">
       
          <label for="subc">Subject Code:</label>
          <input type="text" id="username" name="subc" placeholder="Enter Subject Code" ><br>
     
          <label for="subn">Subject Name:</label>
          <input type="text" id="username" name="subn" placeholder="Enter Subject Name" ><br>

          <label for="tmark">Theory Marks:</label>
          <input type="number" id="username" name="tmark" placeholder="Enter Theory Marks" min="1" max="100"><br>
        
          <label for="pmark">Practical Marks:</label>
          <input type="number" id="username" name="pmark" placeholder="Enter Practical Marks" min="0" max="100" ><br>
        
          <label for="twmark">Term work Marks:</label>
          <input type="number" id="username" name="twmark" placeholder="Enter Term work Marks" min="0" max="100" ><br>
       
          
         
          <button type="submit" name="addsubject">Add Subject</button><br>

</form>

</body>
</html>