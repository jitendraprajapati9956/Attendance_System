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
$username = mysqli_real_escape_string($conn,$_SESSION['username']);

$studentQuery = "SELECT * FROM students WHERE username = '$username'";
$subjectQuery = "SELECT subcode, subname, theoryattend, theorytotal, practicalattend, practicaltotal FROM subject WHERE username = '$username'";

$studentResult = mysqli_query($conn,$studentQuery);
$subjectResult = mysqli_query($conn,$subjectQuery);

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
  <li ><a href="addattendance.php">Add Attendance</a></li>
  <li class="active"><a href="viewattend.php">View Attendance</a></li>
</ul>
<h1> View Attending  Lecture Subject</h1>


<form action="" method="post" enctype="multipart/form-data">
<table>

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
     echo   "<h2>Attendance Record </h2>";
      
if (mysqli_num_rows($subjectResult) > 0) {
    while($row= mysqli_fetch_assoc($subjectResult)) {
    
?>
 <thead>
        <tr style="background-color: black ; color:white;">
             <th>Subject Code</th>
            <th>Subject Name</th>
            <th>Theory Attending Lecture</th>
            <th>Theory Total Lecture</th>
            <th>Practical Attending Lecture</th>
            <th>Practical Total Lecture</th>
            <th><label> Double Click to Delete Attendance</label></th>
      
        </tr>

 </thead>

    <tbody>
   <tr style="background-color: aqua;">
    <td><?php echo htmlspecialchars($row["subcode"]); ?></td>
     <td><?php echo htmlspecialchars($row["subname"]); ?></td>
       <td><?php echo htmlspecialchars($row["theoryattend"]); ?></td>
     <td><?php echo htmlspecialchars($row["theorytotal"]); ?></td>
    <td><?php echo htmlspecialchars($row["practicalattend"]); ?></td>
     <td><?php echo htmlspecialchars($row["practicaltotal"]); ?></td><br>
     <td>
                <form action="#" method="post"> 
                    <input type="hidden" name="subcode" value="<?php echo htmlspecialchars($row['subcode']); ?>">
                    <input type="submit" name="delete" value="Delete"><label style="color:whitesmoke;">
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
   </tbody>
   <?php } }?>
</table>

<?php
$subjectQuery = "SELECT subcode, subname, theoryattend, theorytotal, practicalattend, practicaltotal FROM subject WHERE username = '$username'";
$subjectResult = mysqli_query($conn,$subjectQuery);


$totalTheoryAttended = '0';
$totalTheoryPossible = '0';
$totalPracticalAttended = '0';
$totalPracticalPossible = '0';

if (mysqli_num_rows($subjectResult) > 0) {
    while($row = mysqli_fetch_assoc($subjectResult)) {
        $totalTheoryAttended += $row["theoryattend"];
        $totalTheoryPossible += $row["theorytotal"];
        $totalPracticalAttended += $row["practicalattend"];
        $totalPracticalPossible += $row["practicaltotal"];
    }
}

$totalAttended = $totalTheoryAttended + $totalPracticalAttended ;
$totalPossible = $totalTheoryPossible + $totalPracticalPossible; 
$cumulativePercentage = ($totalPossible > 0) ? ($totalAttended / $totalPossible) * 100  : 0 ;

$detentionStatus = ($cumulativePercentage < 75) ? "Student is likely to be detained." : "Student is not at risk of detention.";


?>
<h2>Attendance Summary </h2>

<p><b>Lecture Attendance:</b> <?php echo htmlspecialchars($totalTheoryAttended); ?></p>
<p><b>Practical Attendance:</b> <?php echo htmlspecialchars($totalPracticalAttended); ?></p>
<p><b>Total Attend:</b> <?php echo htmlspecialchars($totalAttended); ?></p>
<p><b>Total Lecture:</b> <?php echo htmlspecialchars($totalPossible); ?></p>
<p><b>Cumulative Overall Attendance in Percentage:</b> <?php echo htmlspecialchars(number_format($cumulativePercentage, 2)); ?>%</p>
<p><b>Detention Status:</b> <?php echo $detentionStatus; ?></p>

</form>
</body>
</html>