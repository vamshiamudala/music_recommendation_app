<?php
session_start();

// Database credentials
$host = "localhost";
$user = "root";
$password = "";
$database = "music";

// Create a database connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle login form submission
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database for the user with the given username and password
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful and if the user exists
    if (mysqli_num_rows($result) > 0) {
        // User exists, set session variables and redirect to welcome page
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: welcome.php");
        exit();
    } else {
        // User doesn't exist, display error message
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Music</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <img src="logo.png" alt="logo">
        </nav>
        
        <div class="container">
            <?php if (isset($error)): ?>
                <p><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST" action="index.php">
            <form method="POST" action="index.php">
            <h1>Welcome to Music app</h1>
            <h2>Get your music options based on your mood</h2>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="" required>
                <input type="submit" name="submit" value="Log In">
            </form>
            </form>
        </div>
    </header>
</body>
</html>
