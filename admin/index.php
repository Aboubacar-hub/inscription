<?php
session_start();
include "../config.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ../connexion.php'); // Redirection vers la page de connexion si il n'est pas  connecté
    exit;
}

// Récupérer les informations de l'utilisateur connecté
$stmt = $conn->prepare('SELECT * FROM utilisateurs WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Tableau de bord</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>Bienvenue, <?php echo htmlspecialchars($user['email']); ?>!</h1>
    <p>ID Utilisateur: <?php echo htmlspecialchars($user['id']); ?></p>
    <p>Nom: <?php echo htmlspecialchars($user['nom']); ?></p>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    <a href="deconnexion.php">Déconnexion</a>
</body>
</html>
