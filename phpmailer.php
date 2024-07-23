<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);   // hacher le mots de passe de pour des raison de securité
    $numero = $_POST['numero'];

    try {

        include "config.php"; //inclure la connexion a la base de donné
           // preparation de la requete
        $stmt = $conn->prepare("INSERT INTO  utilisateurs  (nom, prenom, email, password, numero) VALUES (:nom, :prenom, :email, :password, :numero)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':numero', $numero);

        if ($stmt->execute()) {   // si l'inscription a bien été effectuer  enregistrement dans la base de donné
            // Envoi de l'email de confirmation
            $mail = new PHPMailer(true);

            try {
                // Paramètres du serveur
                $mail->isSMTP();
                $mail->Host       = 'smtp.example.com'; // Remplace avec le serveur SMTP de ton choix
                $mail->SMTPAuth   = true;
                $mail->Username   = 'ton-email@example.com'; // Remplace avec ton adresse e-mail
                $mail->Password   = 'ton-mot-de-passe'; // Remplace avec ton mot de passe
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Destinataires
                $mail->setFrom('ton-email@example.com', 'Mailer'); // Remplace avec ton adresse e-mail
                $mail->addAddress($email, $prenom);  // email de l'utilisateur qui recoir le mail 

                // Contenu de l'email
                $mail->isHTML(true);
                $mail->Subject = 'Confirmation d\'inscription';
                $mail->Body    = 'Merci de vous être inscrit, ' . $prenom . ' ' . $nom . '!';

                $mail->send();
                echo 'L\'email de confirmation a été envoyé.';
                
            } catch (Exception $e) {
                echo "L'email n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
            }
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
