<?php
session_start();

// Check if the login form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if fields are empty
    if (empty($_POST['email']) || empty($_POST['pass'])) {
        $_SESSION['error'] = "Email and password are required";
        header("Location: login.php");
        return;
    }

    // Check if email has a valid format
    if (strpos($_POST['email'], '@') === false) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    }

    // Check the password
    $salt = 'XyZzy12*_';
    $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; // Password is php123
    $check = hash('md5', $salt.$_POST['pass']);
    if ($check == $stored_hash) {
        // Successful authentication, save the user in the session
        $_SESSION['name'] = $_POST['email'];
        error_log("Login success: ".$_POST['email']);
        header("Location: index.php");
        return;
    } else {
        // Incorrect password
        error_log("Login fail: ".$_POST['email']." $check");
        $_SESSION['error'] = "Incorrect password";
        header("Location: login.php");
        return;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Asmaa Chouai - Login Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Please Log In</h1>
    <?php
    // Display errors if any
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger">'.$_SESSION['error']."</div>\n";
        unset($_SESSION['error']);
    }
    ?>
    <form method="post">
        <div class="form-group">
            <label for="email">User Name:</label>
            <input type="text" class="form-control" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="pass">Password:</label>
            <input type="password" class="form-control" name="pass" id="pass" required>
        </div>
        <button type="submit" class="btn btn-primary" name="login">Log In</button>
        <a href="welcome.php" class="btn btn-secondary" role="button">Cancel</a>
    </form>

</div>
<!-- Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


