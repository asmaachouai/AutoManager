<?php
require_once "pdo.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION['name'])) {
    die('Not logged in');
}
// Check if there's a success message in the session
$successMessage = '';
if (isset($_SESSION['success'])) {
    $successMessage = $_SESSION['success'];
    unset($_SESSION['success']); // Clear the session variable
}
// Fetch all automobiles data from the database
$stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asmaa CHOUAI - List of Automobiles</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php

// Check if success parameter is set for record addition
if (isset($_GET['success']) && $_GET['success'] == 'add') {
    echo '<div style="background-color: green; color: white; padding: 10px;">Record added</div>';
}

// Check if success parameter is set for record edit
if (isset($_GET['success']) && $_GET['success'] == 'edit') {
    echo '<div style="background-color: green; color: greenyellow; padding: 10px;">Record edited</div>';
}

if (isset($_GET['success']) && $_GET['success'] == 'delete') {
    echo '<div style="background-color: green; color: darkgreen; padding: 10px;">Record deleted</div>';
}


?>
<div class="container mt-5">
    <h1>Welcome to the Automobiles Database</h1></div>
<div class="container mt-5">
    <!-- List of automobiles -->
    <?php if ($rows && count($rows) > 0): ?>
        <table class="table">
            <thead>
            <tr>
                <th>Make</th>
                <th>Model</th>
                <th>Year</th>
                <th>Mileage</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?php echo htmlentities($row['make']); ?></td>
                    <td><?php echo htmlentities($row['model']); ?></td>
                    <td><?php echo $row['year']; ?></td>
                    <td><?php echo $row['mileage']; ?></td>
                    <td>
                        <a href="edit.php?autos_id=<?php echo htmlentities($row['autos_id']); ?>" class="btn btn-primary">Edit</a>
                        <a href="delete.php?autos_id=<?php echo htmlentities($row['autos_id']); ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No automobiles found.</p>
    <?php endif; ?>
</div>
<div class="container mt-3">
    <a href="add.php" class="btn btn-primary">Add New Entry</a>
    <a href="logout.php" class="btn btn-primary">Logout</a>
</div>
</body>
</html>
