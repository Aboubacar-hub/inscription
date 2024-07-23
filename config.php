<!-- Ouverture de la balise php  -->
 <?php
  // Connexion à la base de données
  $servername = "localhost";
  $username = "root";
  $password_db = "";
  $dbname = "inscription";
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  ?>