<?php
$pdo = new PDO('mysql:host=localhost;dbname=TP', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $date_creation = $_POST['date_creation'];
    $stmt = $pdo->prepare("UPDATE exercice SET titre = ?, auteur = ?, date_creation = ? WHERE id = ?");
    $success = $stmt->execute([$titre, $auteur, $date_creation, $id]);
    header("Location: index.php?msg=" . ($success ? "success" : "failure"));
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM exercice WHERE id = ?");
$stmt->execute([$id]);
$exercice = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier Exercice</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<h1>Modifier l'Exercice</h1>
<form method="POST" action="">
    <input type="hidden" name="id" value="<?= $exercice['id'] ?>">
    Titre: <input type="text" name="titre" value="<?= $exercice['titre'] ?>" required><br>
    Auteur: <input type="text" name="auteur" value="<?= $exercice['auteur'] ?>" required><br>
    Date de création: <input type="date" name="date_creation" value="<?= $exercice['date_creation'] ?>" required><br><br>
    <button type="submit">Modifier</button>
</form>
</body>
</html>
