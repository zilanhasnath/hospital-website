<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "patientlist";

// Create connection
$con = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username']; 
    $password = $_POST['password']; 

    // Query to check if username and password match in the database
    $query = "SELECT * FROM `patientlist` WHERE `username` = '$username' AND `password` = '$password'";

    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // User found, redirect to a protected page (for example, user dashboard)
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");  // You can change this to any page after login
    } else {
        echo "Invalid username or password.";
    }
}

// Close connection
mysqli_close($con);
?>
