<?php
require_once "pdo.php";
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['name'])) {
    die("ACCESS DENIED");
}

// Vérifie si auto_id est fourni dans l'URL
if (!isset($_GET['autos_id'])) {
    $_SESSION['error'] = "Missing automobile ID";
    header('Location: index.php');
    return;
}

// Récupère les données de l'automobile depuis la base de données
$stmt = $pdo->prepare("SELECT * FROM autos WHERE autos_id = :auto_id");
$stmt->execute(array(':auto_id' => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifie si l'automobile existe
if (!$row) {
    $_SESSION['error'] = "Automobile not found";
    header('Location: index.php');
    return;
}

// Gestion de la soumission du formulaire
if (isset($_POST['cancel'])) {
    // Redirige vers index.php si le bouton Annuler est cliqué
    header('Location: index.php');
    return;
}

if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    if (empty($_POST['make']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['mileage'])) {
        $_SESSION['error'] = "All fields are required";
        header("Location: edit.php?autos_id=" . $_GET['autos_id']);
        return;
    } elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = "Year and mileage must be numeric values";
        header("Location: edit.php?autos_id=" . $_GET['autos_id']);
        return;
    } else {
        $stmt = $pdo->prepare('UPDATE autos SET make = :mk, model = :md, year = :yr, mileage = :mi WHERE autos_id = :auto_id');
        $stmt->execute(array(
                ':mk' => $_POST['make'],
                ':md' => $_POST['model'],
                ':yr' => $_POST['year'],
                ':mi' => $_POST['mileage'],
                ':auto_id' => $_GET['autos_id'])
        );
        header("Location: index.php?success=edit");er("Location: index.php"); // Redirige vers index.php après la mise à jour réussie
        return;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asmaa CHOUAI - Edit Automobile</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Edit Automobile</h1>

    <!-- Affiche le message d'erreur s'il est présent -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlentities($_SESSION['error']); ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Formulaire d'édition de l'automobile -->
    <form method="post">
        <div class="form-group">
            <label for="make">Make:</label>
            <input type="text" class="form-control" id="make" name="make" value="<?php echo htmlentities($row['make']); ?>" required>
        </div>
        <div class="form-group">
            <label for="model">Model:</label>
            <input type="text" class="form-control" id="model" name="model" value="<?php echo htmlentities($row['model']); ?>" required>
        </div>
        <div class="form-group">
            <label for="year">Year:</label>
            <input type="number" class="form-control" id="year" name="year" value="<?php echo $row['year']; ?>" required>
        </div>
        <div class="form-group">
            <label for="mileage">Mileage:</label>
            <input type="number" class="form-control" id="mileage" name="mileage" value="<?php echo $row['mileage']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <button type="submit" class="btn btn-secondary" name="cancel">Cancel</button>
    </form>
</div>
</body>
</html>


