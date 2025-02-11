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
            <li><a href="accueil.php">Accueil</a></li>
            <li><a href="">Catalogue</a></li>
            <li><a href="connexion.php">Se connecter</a></li>
            <li><a href="inscription.php">S'inscrire</a></li>
        </ul>
    </nav>
</header>

<main>
    <!-- Formulaire de connexion -->
    <div class="container">
        <div class="formulaire">
            <h1>Connexion</h1>
                <form method="POST" action="">
                    <label for="email">Votre e-mail</label>
                    <input type="text" id="email" name="email" placeholder="Entrez votre e-mail..." required><br />
                    <br />
                    <label for="password">Votre mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe..."
                        required><br />
                    <br />
                    <input type="submit" value="Se connecter" name="connexion">
                    <a href="inscription.php">Inscription</a>
                </form>
            </div>
        </div>
    </main>

<footer>
    <nav>
        <ul>
        <li><a href="accueil.php">Accueil</a></li>
            <li><a href="">Catalogue</a></li>
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