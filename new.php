<?php
session_start();

$db_host = 'localhost';  
$db_user = 'root';       
$db_pass = '';           
$db_name = 'attendance';  

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die('Connection failed: ');
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $email = $_POST['email'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $education = $_POST['education'];

  

    if (isset($_FILES['profilephoto']) && $_FILES['profilephoto']['error'] == 0) {
        $allowed = ['jpg' => 'image/jpg', 'jpeg' => 'image/jpeg', 'gif' => 'image/gif', 'png' => 'image/png'];
        $filename = $_FILES['profilephoto']['name'];
        $filetype = $_FILES['profilephoto']['type'];
        $filesize = $_FILES['profilephoto']['size'];
        
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            die(" Please select a valid file format.");
        }

        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) {
            die(" File size is larger than the allowed limit.");
        }

        if (in_array($filetype, $allowed)) {
            $newfilename = md5(time() . $filename) . ".$ext";  
            $filepath = "image/" . $newfilename;
            if (move_uploaded_file($_FILES["profilephoto"]["tmp_name"], $filepath)) {
                echo "Your file was uploaded successfully.";
            } 

 
 
 
    $sql = "INSERT INTO students (username, password, email, name, address, contact, course, semester, gender, dob, image, education) VALUES ('$username', '$password', '$email', '$name', '$address', '$mobile', '$course', '$semester', '$gender', '$birthdate', '$filename', '$education')";

    if (mysqli_query($conn,$sql) === TRUE) {
        
    echo "<script>alert('New Student Account Create successfully.')</script>";  
    echo "<script>window.open('login.php','_self')</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
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
        <link rel="stylesheet" href="style/register.css">
    </head>

<body>

<h1>Registration Form</h1>
    <form action="#" method="post" enctype="multipart/form-data">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter Username" minlength="5"><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter Password" required minlength="8"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter Email Address" required><br><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter Full Name" required><br><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" placeholder="Enter Address" required><br><br>

        <label for="mobile">Mobile:</label>
        <input type="tel" id="mobile" name="mobile" pattern="[0-9]{10}" placeholder="Enter Mobile No." required title="Ten digits code"><br><br>

        <label for="course">Course:</label>
        <input type="text" id="course" name="course" placeholder="Enter Course Name" required><br><br>

        <label for="semester">Semester:</label>
        <input type="number" id="semester" name="semester" min="1" max="8" placeholder="Enter Semester" required><br><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
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
        <input type="text" id="education" name="education" placeholder="Enter Last Education" required><br><br>

        <button type="submit">Register</button><br>

        <a href="login.php">Back to login</a></span>

    </form>
</body>
</html>
