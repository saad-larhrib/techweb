<?php
$pdo = new PDO('mysql:host=localhost;dbname=TP', 'root', '');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM exercice WHERE id = ?");
    $success = $stmt->execute([$id]);
    header("Location: index.php?msg=" . ($success ? "deleted" : "failed"));
    exit();
}
?>
