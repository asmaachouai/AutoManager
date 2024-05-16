<?php
require_once "pdo.php";
session_start();

if (!isset($_SESSION['name'])) {
    die("ACCESS DENIED");
}

if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    if (empty($_POST['make']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['mileage'])) {
        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        return;
    } elseif (!is_numeric($_POST['year'])) {
        $_SESSION['error'] = "Year must be an integer";
        header("Location: add.php");
        return;
    } elseif (!is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = "Mileage must be an integer";
        header("Location: add.php");
        return;
    } else {
        $stmt = $pdo->prepare('INSERT INTO autos (make, model, year, mileage) VALUES (:mk, :md, :yr, :mi)');
        $stmt->execute(array(
                ':mk' => $_POST['make'],
                ':md' => $_POST['model'],
                ':yr' => $_POST['year'],
                ':mi' => $_POST['mileage'])
        );
        header("Location: index.php?success=add");
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
    <title>Asmaa CHOUAI - Add Automobile</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Add Automobile</h1>

    <!-- Display error message if present -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlentities($_SESSION['error']); ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Display success message if present -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success" role="alert">
            <?php echo htmlentities($_SESSION['success']); ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Add automobile form -->
    <form method="post">
        <div class="form-group">
            <label for="make">Make:</label>
            <input type="text" class="form-control" id="make" name="make" required>
        </div>
        <div class="form-group">
            <label for="model">Model:</label>
            <input type="text" class="form-control" id="model" name="model" required>
        </div>
        <div class="form-group">
            <label for="year">Year:</label>
            <input type="number" class="form-control" id="year" name="year" required>
        </div>
        <div class="form-group">
            <label for="mileage">Mileage:</label>
            <input type="number" class="form-control" id="mileage" name="mileage" required>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
        <a href="index.php" class="btn btn-secondary" role="button">Cancel</a>
    </form>
</div>
</body>
</html>







