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


if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = mysqli_real_escape_string($conn,$_SESSION['username']);

$studentQuery = "SELECT * FROM students WHERE username = '$username'";
$subjectQuery = "SELECT subcode, subname, theorymark, practicalmark, twmark, totalmark FROM subject WHERE username = '$username'";

$studentResult = $conn->query($studentQuery);
$subjectResult = $conn->query($subjectQuery);

if (isset($_POST['delete']) && isset($_POST['subcode'])) {
        
    $subcode = $_POST['subcode'];

   $deletesubject = "DELETE FROM subject WHERE subcode = '$subcode'";
   $deleteResult = $conn->query($deletesubject);
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
  <li ><a href="editprofile.php">Edit Profile</a></li>
  <li class="active"><a href="#subject.php">Subject</a></li>
  <li><a href="attendance.php">Attendance</a></li>
  <li><a href="logout.php">Logout</a></li>
</ul>

<ul>
  <li ><a href="addsub.php">Add Subject</a></li>
  <li ><a href="viewsub.php">View Subject</a></li>
</ul>

<h1>View Subject</h1>


<form action="" method="post" enctype="multipart/form-data">
<table >

<?php
if (mysqli_num_rows($studentResult) > 0) {
    while ($student = mysqli_fetch_assoc($studentResult)) {
        echo "<p><b>Username:</b> " . htmlspecialchars($student['username']) . "</p>";
        echo "<p><b>Name:</b> " . htmlspecialchars($student['name']) . "</p>";
        echo "<p><b>Course:</b> " . htmlspecialchars($student['course']) . "</p>";
        echo "<p><b>Semester:</b> " . htmlspecialchars($student['semester']) . "</p>";
    }
} else {
    echo "<p>No student information found.</p>";
}
echo   "<h2>Subject Details </h2>";


if (mysqli_num_rows($subjectResult) > 0) {
    while($row= mysqli_fetch_assoc($subjectResult)) {
    
?>

<thead>
        <tr style="background-color: black ; color:white;">
            <th>Subject Code</th>
            <th>Subject Name</th>
            <th>Theory Marks</th>
            <th>Practical Marks</th>
            <th>Term Work Marks</th>
            <th>Total Marks</th>
            <th><label> Double Click to Delete Subject</label></th>
      
        </tr>

    </thead>

    <tbody>
   <tr style="background-color: aqua;">
    <td><?php echo htmlspecialchars($row["subcode"]); ?></td>
     <td><?php echo htmlspecialchars($row["subname"]); ?></td>
       <td><?php echo htmlspecialchars($row["theorymark"]); ?></td>
     <td><?php echo htmlspecialchars($row["practicalmark"]); ?></td>
    <td><?php echo htmlspecialchars($row["twmark"]); ?></td>
     <td><?php echo htmlspecialchars($row["totalmark"]); ?></td><br>
     <td>
                <form action="#" method="post"> 
                    <input type="hidden" name="subcode" value="<?php echo htmlspecialchars($row['subcode']); ?>">
                    <input type="submit" name="delete" value="Delete">
                    <style>
                            input[type="submit"]
                            {
                            background-color: green;
                              color: white;
                             padding: 10px 70px;
	                          margin: 8px 8px;
                            cursor: pointer;
                             }
                            input:hover[type="submit"] 
		                     {
			                    background: red;
		                     }
                            
                	</style>
                </form>
            </td>
        </tr>
    
   
   </tr>
   </tbody>
   <?php } }?>




</table>

</form>
</body>
</html>