<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlatQuiz</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
<header>
    <nav>
        <div class="logo">
            <img src="https://media.discordapp.net/attachments/1326120582391009332/1338513885941993492/Nomad.png?ex=67ab5bb2&is=67aa0a32&hm=d8f77555750424b8b35b48f2f8a1192c306d75ea226a32d6b0defd5f132ea241&=&format=webp&quality=lossless&width=625&height=625" alt="Logo quiz">
        </div>
        <ul>
            <li><a href="accueil">Accueil</a></li>
            <li><a href="categorie.php">Catalogue</a></li>
            <li><a href="connexion.php">Se connecter</a></li>
            <li><a href="inscription.php">S'inscrire</a></li>
        </ul>
    </nav>
</header>



<!-- Formulaire d'inscription -->
<div class="container">
    <div class="formulaire">
        <h1>Inscription</h1>
    <form method="POST" action="">
        <label for="nom">Votre nom</label>
        <input type="text" id="nom" name="nom" placeholder="Entrez votre nom..." required><br />
        <br />
        <label for="prenom">Votre prénom</label>
        <input type="text" id="prenom" name="prenom" placeholder="Entrez votre prenom..." required><br />
        <br />
        <label for="pseudo">Votre pseudo</label>
        <input type="text" id="pseudo" name="pseudo" placeholder="Entrez votre pseudo..." required><br />
        <br />
        <label for="email">Votre e-mail</label>
        <input type="text" id="email" name="email" placeholder="Entrez votre e-mail..." required><br />
        <br />
        <label for="password">Votre mot de passe</label>
        <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe..." required><br />
        <br />
        <input type="submit" value="M'inscrire" name="inscription">
    </form>
    </div>
</div>

<footer>
      <nav>
        <ul>
          <li><a href="accueil.php">Accueil</a></li>
          <li><a href="categorie.php">Catalogue</a></li>
          <li><a href="connexion.php">Se connecter</a></li>
          <li><a href="inscription.php">S'inscrire</a></li>
        </ul>
      </nav>
      <div class="socials">
        <a href="https://github.com/toni-montangon/platquiz"><img src="https://bitperfect.at/assets/blog-images/Headerbild-Was-ist-GitHub-v2.png" alt="Github"></a>
      </div>
      <p>&copy; 2025 LaPlatQuiz. Tous droits réservés.</p>
    </footer>

</body>
</html>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo '<pre>';
    print_r($_POST);  // affiche toutes les données envoyées dans le formulaire
    echo '</pre>';

    // récupérer les valeurs du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $mdp = $_POST['password'];

    // validation des champs
    if (empty($nom) || empty($prenom) || empty($pseudo) || empty($email) || empty($mdp)) {
        echo "Tous les champs sont obligatoires.";
        exit;
    }

    // Hashage du mot de passe avant insertion
    $hashed_mdp = password_hash($mdp, PASSWORD_DEFAULT);

    // connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "quizz";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prépare la requête d'insertion
        $stmt = $conn->prepare("INSERT INTO users (nom, prenom, pseudo, email, mdp) VALUES (?, ?, ?, ?, ?)");

        // lier les paramètres et exécuter la requête
        $stmt->execute([$nom, $prenom, $pseudo, $email, $hashed_mdp]);

        // Affichage de la réussite de l'inscription
        echo "Inscription réussie!";

        // Redirection vers la page connexion.php après une inscription réussie
        header("Location: accueil.php");
        exit(); // Stoppe l'exécution du script après la redirection

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

    // Fermer la connexion
    $conn = null;
}
?>