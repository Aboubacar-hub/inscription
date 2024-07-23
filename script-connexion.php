<!-- Ouverture de la balise php  -->
<?php
session_start();

include  "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Requête pour vérifier l'utilisateur
      $stmt = $conn->prepare('SELECT * FROM utilisateurs WHERE email = ?');
      $stmt->execute([$email]);
      $user = $stmt->fetch();
  

      if ($user && password_verify($password, $user['password'])) {
          // Connexion réussie
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['email'] = $user['email'];
          echo "vous etes connecte! , " . htmlspecialchars($user['email']) . ".";
      } else {
          // Connexion échouée
          echo "connexion echoué.";
      }

}
  ?>