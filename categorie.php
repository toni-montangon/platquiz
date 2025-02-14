<?php
$pdo = new PDO('mysql:host=localhost;dbname=quizz', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Création d'une catégorie
if (isset($_POST['ajouter_categorie'])) {
    if (!empty($_POST['categories'])) {
        $categories = htmlspecialchars($_POST['categories']);
        $recup_categorie = $pdo->prepare('SELECT * FROM categories WHERE categories = ?');
        $recup_categorie->execute([$categories]);

        if ($recup_categorie->rowCount() == 0) {
            $insert_categorie = $pdo->prepare('INSERT INTO categories (categories) VALUES (?)');
            $insert_categorie->execute([$categories]);
        }
    }
}

// Suppression d'une catégorie
if (isset($_POST['supprimer_categorie'])) {
    if (!empty($_POST['categories'])) {
        $categories = htmlspecialchars($_POST['categories']);
        $delete_categorie = $pdo->prepare('DELETE FROM categories WHERE categories = ?');
        $delete_categorie->execute([$categories]);
    }
}

// Ajout d'un quiz
if (isset($_POST['ajouter_quiz'])) {
    if (!empty($_POST['nom_quiz']) && !empty($_POST['description_quiz']) && !empty($_POST['categories'])) {
        $nom_quiz = htmlspecialchars($_POST['nom_quiz']);
        $description_quiz = htmlspecialchars($_POST['description_quiz']);
        $categories = $_POST['categories'];
        
        $stmt_categorie = $pdo->prepare("SELECT id FROM categories WHERE categories = ?");
        $stmt_categorie->execute([$categories]);
        $categorie_data = $stmt_categorie->fetch(PDO::FETCH_ASSOC);

        if ($categorie_data) {
            $categorie_id = $categorie_data['id'];
            $insert_quiz = $pdo->prepare("INSERT INTO quiz (nom_quiz, description_quiz, id_categorie) VALUES (?, ?, ?)");
            $insert_quiz->execute([$nom_quiz, $description_quiz, $categorie_id]);
        }
    }
}

// Récupérer toutes les catégories
$query_categories = $pdo->query("SELECT * FROM categories");
$categories = $query_categories->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="categorie.css">
    <title>Gestion des Quiz</title>
</head>
<body>
<header>
    <nav>
        <div class="logo">
            <img src="https://media.discordapp.net/attachments/1326120582391009332/1338513885941993492/Nomad.png?ex=67ab5bb2&is=67aa0a32&hm=d8f77555750424b8b35b48f2f8a1192c306d75ea226a32d6b0defd5f132ea241&=&format=webp&quality=lossless&width=625&height=625" alt="Logo quiz">
        </div>
        <ul>
            <li><a href="accueil.php">Accueil</a></li>
            <li><a href="categories.php">Catalogue</a></li>
            <li><a href="connexion.php">Se connecter</a></li>
            <li><a href="inscription.php">S'inscrire</a></li>
        </ul>
    </nav>
</header>
    <h1>Gestion des Catégories et Quiz</h1>

    <!-- Ajouter une catégorie -->
    <form method="post">
        <h2>Nouvelle Catégorie</h2>
        <input type="text" name="categories" placeholder="Nom de la catégorie" required>
        <button type="submit" name="ajouter_categorie">Ajouter</button>
    </form>

    <!-- Supprimer une catégorie -->
    <form method="post">
        <h2>Supprimer une Catégorie</h2>
        <select name="categories" required>
            <option value="">Sélectionner une catégorie</option>
            <?php foreach ($categories as $categories) { ?>
                <option value="<?= htmlspecialchars($categories['categories']) ?>">
                    <?= htmlspecialchars($categories['categories']) ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit" name="supprimer_categorie">Supprimer</button>
    </form>

    <!-- Ajouter un Quiz -->
    <form method="post">
        <h2>Ajouter un Quiz</h2>
        <input type="text" name="nom_quiz" placeholder="Nom du quiz" required>
        <textarea name="description_quiz" placeholder="Description du quiz" required></textarea>
        <select name="categories" required>
            <option value="">Sélectionner une catégorie</option>
            <?php foreach ($categories as $categories) { ?>
                <option value="<?= htmlspecialchars($categories['categories']) ?>">
                    <?= htmlspecialchars($categories['categories']) ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit" name="ajouter_quiz">Ajouter</button>
    </form>
</body>
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
</html>
