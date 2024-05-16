<?php
session_start();

// Include pdo.php to access the database connection
require_once 'pdo.php';

// Check if the 'autos_id' parameter is set in the URL
if (!isset($_GET['autos_id']) || !is_numeric($_GET['autos_id'])) {
    $_SESSION['error'] = "Invalid request";
    header("Location: index.php");
    return;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm']) && $_POST['confirm'] == 'Delete') {
    // Prepare SQL statement to delete the record
    $stmt = $pdo->prepare("DELETE FROM autos WHERE autos_id = :autos_id");
    $stmt->execute(['autos_id' => $_GET['autos_id']]);

    // Redirect to index.php with a success message
    header("Location: index.php?success=delete");
    return;
}

// Fetch the automobile details to display in the confirmation message
$stmt = $pdo->prepare("SELECT make, model FROM autos WHERE autos_id = :autos_id");
$stmt->execute(['autos_id' => $_GET['autos_id']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    $_SESSION['error'] = "Record not found";
    header("Location: index.php");
    return;
}

$make = $row['make'];
$model = $row['model'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Asmaa CHOUAI's Delete Automobile</title>
</head>
<body>
<h2>Delete Automobile</h2>
<p>Are you sure you want to delete the automobile with make: "<?php echo htmlentities($make); ?>" and model: "<?php echo htmlentities($model); ?>"?</p>
<form method="post">
    <input type="submit" name="confirm" value="Delete">
    <a href="index.php">Cancel</a>
</form>
</body>
</html>
