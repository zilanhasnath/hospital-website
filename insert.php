<?php
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
    $gender = $_POST['gender']; 
    $disease = $_POST['disease']; 
    $checkuptime = $_POST['checkuptime']; 
    $email = $_POST['email']; 
    $contact = $_POST['contact']; 

    // Create a prepared statement to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO `patientlist` (`username`, `password`, `gender`, `disease`, `checkuptime`, `email`, `contact`) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $username, $password, $gender, $disease, $checkuptime, $email, $contact);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Record inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Close connection
mysqli_close($con);
?>
