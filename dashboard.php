<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");  // Redirect to login page if not logged in
    exit();
}

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

// Get the username from session
$user = $_SESSION['username'];

// Query to fetch user data
$query = "SELECT * FROM `patientlist` WHERE `username` = '$user'";
$result = mysqli_query($con, $query);

// Check if the user data exists
if (mysqli_num_rows($result) > 0) {
    // Fetch the user data
    $row = mysqli_fetch_assoc($result);
} else {
    echo "No data found for this user.";
    exit();
}

// Handle edit data request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    // Get new data from the form
    $newUsername = $_POST['username'];
    $newPassword = $_POST['password'];
    $newGender = $_POST['gender'];
    $newDisease = $_POST['disease'];
    $newCheckupTime = $_POST['checkuptime'];
    $newEmail = $_POST['email'];
    $newContact = $_POST['contact'];

    // Update query to edit the user data
    $editQuery = "UPDATE `patientlist` SET 
        `username` = '$newUsername', 
        `password` = '$newPassword',
        `gender` = '$newGender', 
        `disease` = '$newDisease', 
        `checkuptime` = '$newCheckupTime',
        `email` = '$newEmail',
        `contact` = '$newContact'
        WHERE `username` = '$user'";

    if (mysqli_query($con, $editQuery)) {
        // Update session variable and redirect
        $_SESSION['username'] = $newUsername;
        header("Location: dashboard.php");
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}

// Handle delete account request
if (isset($_POST['delete'])) {
    // Delete query to remove the user from the database
    $deleteQuery = "DELETE FROM `patientlist` WHERE `username` = '$user'";

    if (mysqli_query($con, $deleteQuery)) {
        // End session and redirect to login page after deletion
        session_unset();
        session_destroy();
        header("Location: login.html");
    } else {
        echo "Error deleting account: " . mysqli_error($con);
    }
}

// Close connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Dashboard</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <p>This is your dashboard. Below is your profile data:</p>
    
    <table border="1">
        <tr>
            <th>Username</th>
            <td><?php echo $row['username']; ?></td>
        </tr>
        <tr>
            <th>Password</th>
            <td><?php echo $row['password']; ?></td>
        </tr>
        <tr>
            <th>Gender</th>
            <td><?php echo $row['gender']; ?></td>
        </tr>
        <tr>
            <th>Disease</th>
            <td><?php echo $row['disease']; ?></td>
        </tr>
        <tr>
            <th>Checkup Time</th>
            <td><?php echo $row['checkuptime']; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo $row['email']; ?></td>
        </tr>
        <tr>
            <th>Contact</th>
            <td><?php echo $row['contact']; ?></td>
        </tr>
    </table>

    <h3>Edit My Data</h3>
    <form action="dashboard.php" method="POST">
        <label for="username">New Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $row['username']; ?>" required><br><br>

        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" value="<?php echo $row['password']; ?>" required><br><br>

        <label>Gender:</label>
        <input type="radio" name="gender" value="male" <?php echo $row['gender'] == 'male' ? 'checked' : ''; ?> required> Male
        <input type="radio" name="gender" value="female" <?php echo $row['gender'] == 'female' ? 'checked' : ''; ?> required> Female
        <input type="radio" name="gender" value="other" <?php echo $row['gender'] == 'other' ? 'checked' : ''; ?> required> Other
        <br><br>

        <label for="disease">Disease:</label>
        <select id="disease" name="disease" required>
            <option value="heart" <?php echo $row['disease'] == 'heart' ? 'selected' : ''; ?>>Heart</option>
            <option value="brain" <?php echo $row['disease'] == 'brain' ? 'selected' : ''; ?>>Brain</option>
            <option value="kidney" <?php echo $row['disease'] == 'kidney' ? 'selected' : ''; ?>>Kidney</option>
        </select>
        <br><br>

        <label for="checkuptime">Check Up Time:</label>
        <select id="checkuptime" name="checkuptime" required>
            <option value="morning" <?php echo $row['checkuptime'] == 'morning' ? 'selected' : ''; ?>>Morning</option>
            <option value="noon" <?php echo $row['checkuptime'] == 'noon' ? 'selected' : ''; ?>>Noon</option>
            <option value="evening" <?php echo $row['checkuptime'] == 'evening' ? 'selected' : ''; ?>>Evening</option>
        </select>
        <br><br>

        <label for="email">New Email Address:</label>
        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required><br><br>

        <label for="contact">New Contact Number:</label>
        <input type="tel" id="contact" name="contact" pattern="[0-9]{10}" value="<?php echo $row['contact']; ?>" required><br><br>

        <input type="submit" name="edit" value="Update My Data">
    </form>

    <h3>Delete My Account</h3>
    <form action="dashboard.php" method="POST">
        <input type="submit" name="delete" value="Delete My Account" onclick="return confirm('Are you sure you want to delete your account?');">
    </form>
    
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>
