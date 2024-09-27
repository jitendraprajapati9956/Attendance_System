<?php
session_start();


$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'attendance';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: ");
}

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}




$username = mysqli_real_escape_string($conn, $_SESSION['username']);

$sql = "SELECT image, name, email, address, contact, course, semester, gender, dob, education FROM students WHERE username='$username'";
$result = mysqli_query($conn, $sql);

$student = array();


if ($result && mysqli_num_rows($result) > 0) {
    $student = mysqli_fetch_assoc($result);
    
  } 
 
  if (!$student) {
    echo "<script>alert('No profile found for the specified username')</script>";
          echo "<script>window.open('login.php','_self')</script>";

}

if (isset($_POST['deleteusername'])) {
        
    $username = $_SESSION['username'];

   $deletesubject = "DELETE FROM students WHERE username = '$username'";
   $deleteResult = mysqli_query($conn,$deletesubject);
    
   header('login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/profile.css">
  
</head>
<body>
<ul>
    <li class="active"><a href="dashboard.php">Student Profile</a></li>
    <li><a href="editprofile.php">Edit Profile</a></li>
    <li><a href="subject.php">Subject</a></li>
    <li><a href="attendance.php">Attendance</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>

<h1>Student Profile</h1>
<form action="" method="post" enctype="multipart/form-data">
<table  style="width:100%">
    <thead>
        <b>Student Profile Photo</b>
 
        <tr><td><img src="image/<?php echo  htmlspecialchars($student['image']); ?>" style='width: 150px; height: 150px; '></td></tr>
        <tr style="background-color: lightblue;"><th>Name:</th><td><?php echo htmlspecialchars($student['name']); ?></td></tr>
        <tr><th>Email:</th><td><?php echo htmlspecialchars($student['email']); ?></td></tr>
        <tr style="background-color: lightblue;"><th>Address:</th><td><?php echo htmlspecialchars($student['address']); ?></td></tr>
        <tr><th>Mobile No:</th><td><?php echo htmlspecialchars($student['contact']); ?></td></tr>
        <tr style="background-color: lightblue;"><th>Course:</th><td><?php echo htmlspecialchars($student['course']); ?></td></tr>
        <tr><th>Semester:</th><td><?php echo htmlspecialchars($student['semester']); ?></td></tr>
        <tr style="background-color: lightblue;"><th>Gender:</th><td><?php echo htmlspecialchars($student['gender']); ?></td></tr>
        <tr><th>Birthdate:</th><td><?php echo htmlspecialchars($student['dob']); ?></td></tr>
        <tr style="background-color: lightblue;"><th>Education:</th><td><?php echo htmlspecialchars($student['education']); ?></td></tr>
        <tr>
            <th> 
            <td colspan="2">
                <input type="submit" name="deleteusername" value="Delete Account" style="background-color: green; color: white; padding: 10px 70px; margin: 8px 8px; cursor: pointer;">
                <style>
                    input[type="submit"]:hover { background: red; }
                </style>
            </td>

            </th>
        </tr>
    </thead>
    
</table>
</form>
</body>
</html>
