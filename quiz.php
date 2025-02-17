<?php
session_start();

// Récupérer les quiz
function getQuizzes($pdo) {
    $stmt = $pdo->query("SELECT * FROM categories");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer les questions d'un quiz
function getQuestions($pdo, $quiz_id) {
    $stmt = $pdo->prepare("SELECT * FROM quiz WHERE id_categorires = ?");
    $stmt->execute([$quiz_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Vérifier les réponses
function checkAnswers($pdo, $answers) {
    $score = 0;
    foreach ($answers as $question_id => $user_answer) {
        $stmt = $pdo->prepare("SELECT reponse FROM quiz WHERE id = ?");
        $stmt->execute([$question_id]);
        $correct_answer = $stmt->fetchColumn();
        if (trim($user_answer) == trim($correct_answer)) {
            $score++;
        }
    }
    return $score;
}

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=quizz;charset=utf8", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="categorie.css">
    <title>Quiz</title>

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
    <div class="container">
        <?php if (!isset($_GET['quiz'])): ?>
            <h1>Liste des Quiz</h1>
            <ul>
                <?php foreach (getQuizzes($pdo) as $quiz): ?>
                    <li><a href="?quiz=<?= $quiz['id'] ?>"><?= htmlspecialchars($quiz['nom_quiz']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <?php $quiz_id = (int) $_GET['quiz']; ?>
            <h1>Questions du Quiz</h1>
            <form method="post" action="">
                <?php foreach (getQuestions($pdo, $quiz_id) as $question): ?>
                    <div class="quiz-item">
                        <p><?= htmlspecialchars($question['question']) ?></p>
                        <?php
                        $propositions = explode("\r\n", $question['proposition_reponse']);
                        foreach ($propositions as $proposition): ?>
                            <label>
                                <input type="radio" name="answers[<?= $question['id'] ?>]" value="<?= htmlspecialchars($proposition) ?>" required>
                                <?= htmlspecialchars($proposition) ?>
                            </label><br>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                <input type="submit" value="Valider">
            </form>
        <?php endif; ?>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answers'])) {
            $score = checkAnswers($pdo, $_POST['answers']);
            echo "<h2>Votre score : $score</h2>";
        }
        ?>
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
