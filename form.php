<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title> 
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <h2>Registration Form</h2>
    <br>
    <form action="insert.php" method="POST">
        <!-- Username -->
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required><br><br>

        <!-- Password -->
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required><br><br>

        <!-- Gender -->
        <label>Gender:</label>
        <input type="radio" name="gender" value="male" required> Male
        <input type="radio" name="gender" value="female" required> Female
        <input type="radio" name="gender" value="other" required> Other
        <br><br>

        <!-- Disease -->
        <label for="disease">Disease:</label>
        <select id="disease" name="disease" required>
            <option value="heart">Heart</option>
            <option value="brain">Brain</option>
            <option value="kidney">Kidney</option>
        </select>
        <br><br>

        <!-- Checkup Time -->
        <label for="checkuptime">Check Up Time:</label>
        <select id="checkuptime" name="checkuptime" required>
            <option value="morning">Morning</option>
            <option value="noon">Noon</option>
            <option value="evening">Evening</option>
        </select>
        <br><br>

        <!-- Email -->
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required><br><br>

        <!-- Contact Number -->
        <label for="contact">Contact Number:</label>
        <input type="tel" id="contact" name="contact" pattern="[0-9]{10}" placeholder="Enter your 10-digit contact number" required><br><br>

        <!-- Submit -->
        <input type="submit" value="Submit">
    </form>

    <br>
    <!-- Link to Login Page -->
    <p>Already have an account? <a href="login.html">Login here</a></p>
</body>
</html>
