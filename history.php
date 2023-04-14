<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Redirect to login page
    header("location: index.php");
    exit;
}

// Create connection
$conn = mysqli_connect("localhost", "root", "", "project");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data
$sql = "SELECT id, Patient_Id, Med_history FROM patient_history WHERE Patient_Id = ".$_SESSION['patient_id']." ORDER BY id ASC";
$stmt = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Medical History</title>
</head>
<body>
    <h1>Medical History</h1>
    <p>Patient ID: <?php echo $_SESSION['patient_id']; ?></p>
<ul>
    <?php
    if(mysqli_num_rows($stmt)){
        while($patientData = mysqli_fetch_assoc($stmt)){
            ?>
            <li><?php echo $patientData['Med_history']; ?></li>
            <?php
        }
    } else {
        echo "<li>The history of this patient is not found.</li>";
    }
    ?>
    </ul>
</body>
</html>


