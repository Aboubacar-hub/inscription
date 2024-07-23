<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $numero = $_POST['numero'];

    try {
        include "config.php"; //inclure la connexion a la base de donné

        $stmt = $conn->prepare("INSERT INTO  utilisateurs (nom, prenom, email, password, numero) VALUES (:nom, :prenom, :email, :password, :numero)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':numero', $numero);

        if ($stmt->execute()) { // si l'inscription a bien été effectuer  enregistrement dans la base de donné
            // Envoi de l'email de confirmation
            $to = $email;  // email de l'utilisateur qui recoit le mail 
            $subject = "Confirmation d'inscription";
            $message = "Merci de vous être inscrit, $prenom $nom!\n\nVotre numéro: $numero";
            $headers = "From: ton-email@example.com"; // Remplace avec ton adresse e-mail

            if (mail($to, $subject, $message, $headers)) {
                echo " l'inscription nickel et  L'email de confirmation a été envoyé. ";
            } else {
                echo "Erreur lors de l'envoi de l'email de confirmation.";
            }
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
