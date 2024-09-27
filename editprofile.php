<?php
session_start();

$db_host = 'localhost';  
$db_user = 'root';       
$db_pass = '';           
$db_name = 'attendance';  

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $address = mysqli_real_escape_string($conn, trim($_POST['address']));
    $mobile = mysqli_real_escape_string($conn, trim($_POST['mobile']));
    $course = mysqli_real_escape_string($conn, trim($_POST['course']));
    $semester = mysqli_real_escape_string($conn, trim($_POST['semester']));
    $gender = mysqli_real_escape_string($conn, trim($_POST['gender']));
    $birthdate = mysqli_real_escape_string($conn, trim($_POST['birthdate']));
    $education = mysqli_real_escape_string($conn, trim($_POST['education']));

    $user = $_SESSION['username'];

    $target_dir = "image/";
    $target_file = $target_dir . basename($_FILES["profilephoto"]["name"]);
    if (move_uploaded_file($_FILES["profilephoto"]["tmp_name"], $target_file)) {
        $sql = "UPDATE students SET username='$username', email='$email', name='$name', address='$address', contact='$mobile', course='$course', semester='$semester', gender='$gender', dob='$birthdate', image='$target_file', education='$education' WHERE username='$username'";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Profile updated successfully.')</script>";  
            echo "<script>window.open('login.php','_self')</script>";

        } 
      }
}

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
  <li class="active"><a href="#editprofile.php">Edit Profile</a></li>
  <li><a href="subject.php">Subject</a></li>
  <li><a href="attendance.php">Attendance</a></li>
  <li><a href="logout.php">Logout</a></li>
</ul>
<h1>Edit Profile</h1>
<form action="#" method="post" enctype="multipart/form-data">

  <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Edit Username"  minlength="5"><br><br>

        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Edit Email Address"  required><br><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Edit Full Name"  required><br><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" placeholder="Edit Address"   required><br><br>

        <label for="mobile">Mobile:</label>
        <input type="tel" id="mobile" name="mobile" pattern="[0-9]{10}" placeholder="Edit Mobile No."  required title="Ten digits code"><br><br>

        <label for="course">Course:</label>
        <input type="text" id="course" name="course" placeholder="Edit Course Name"  required><br><br>

        <label for="semester">Semester:</label>
        <input type="number" id="semester" name="semester" min="1" max="8" placeholder="Edit Semester"  required><br><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender"  required>
            <option value="">Choose Gender..</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select><br><br>

        <label for="birthdate">Birthdate:</label>
        <input type="date" id="birthdate" name="birthdate"  required><br><br>

        <label for="profilephoto">Profile Photo:</label>
        <input type="file" id="profilephoto" name="profilephoto" accept="image/*" required><br><br>

        <label for="education">Education:</label>
        <input type="text" id="education" name="education" placeholder="Edit Last Education"   required><br><br>

        <button type="submit" name="update">Update Profile</button><br>
</body>
</html>