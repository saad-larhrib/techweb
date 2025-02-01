<?php
// Establish database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=tp', 'root', ''); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Ajouter un nouvel exercice
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['titre'], $_POST['auteur'], $_POST['date_creation'])) {
        $titre = $_POST['titre'];
        $auteur = $_POST['auteur'];
        $date_creation = $_POST['date_creation'];

        try {
            $stmt = $pdo->prepare("INSERT INTO exercice (titre, auteur, date_creation) VALUES (?, ?, ?)");
            $stmt->execute([$titre, $auteur, $date_creation]);
            echo "<p style='color: green;'>Exercice ajouté avec succès.</p>";
        } catch (PDOException $e) {
            echo "<p style='color: red;'>Erreur lors de l'ajout : " . $e->getMessage() . "</p>";
        }
    }
}

// Récupérer la liste des exercices
try {
    $stmt = $pdo->query("SELECT * FROM exercice");
    $exercices = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des exercices : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Exercices</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body> 
<h1>Ajouter un Exercice</h1>
<form method="POST" action="">
    <label for="titre">Titre:</label><br>
    <input type="text" name="titre" id="titre" required><br>
    <label for="auteur">Auteur:</label><br>
    <input type="text" name="auteur" id="auteur" required><br>
    <label for="date_creation">Date de création:</label><br>
    <input type="date" name="date_creation" id="date_creation" required><br><br>
    <button type="submit">Ajouter</button>
</form>

<h1>Liste des Exercices</h1>
<?php if (!empty($exercices)): ?>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>Auteur</th>
        <th>Date de Création</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($exercices as $exercice): ?>
        <tr>
            <td><?= htmlspecialchars($exercice['id']) ?></td>
            <td><?= htmlspecialchars($exercice['titre']) ?></td>
            <td><?= htmlspecialchars($exercice['auteur']) ?></td>
            <td><?= htmlspecialchars($exercice['date_creation']) ?></td>
            <td>
                <a href="modifier.php?id=<?= htmlspecialchars($exercice['id']) ?>">Modifier</a> |
                <a href="supprimer.php?id=<?= htmlspecialchars($exercice['id']) ?>" onclick="return confirm('Voulez-vous vraiment supprimer cet exercice ?')">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
    <p>Aucun exercice trouvé.</p>
<?php endif; ?>
</body>
</html>
