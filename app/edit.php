<?php
$conn = new mysqli('db', 'user', 'userpass', 'movies_db');

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $director = $_POST['director'] ?? '';
    $year = $_POST['year'] ?? '';
    $genre = $_POST['genre'] ?? '';

    $stmt = $conn->prepare("UPDATE movies SET title=?, director=?, year=?, genre=? WHERE id=?");
    $stmt->bind_param("ssisi", $title, $director, $year, $genre, $id);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Erro ao atualizar filme.";
    }
} else {
    // Busca dados do filme
    $stmt = $conn->prepare("SELECT * FROM movies WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $movie = $result->fetch_assoc();
    if (!$movie) {
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>CineVerse - Editar Filme</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<header>
    <img src="logo.svg" alt="Logo CineVerse" />
    <h1>CineVerse</h1>
</header>
<nav>
    <a href="index.php">Voltar à lista</a>
</nav>

<section class="container">
    <h2>Editar Filme</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post" action="edit.php?id=<?= $id ?>">
        <label for="title">Título:</label>
        <input type="text" name="title" id="title" required value="<?= htmlspecialchars($movie['title']) ?>" />

        <label for="director">Diretor:</label>
        <input type="text" name="director" id="director" required value="<?= htmlspecialchars($movie['director']) ?>" />

        <label for="year">Ano:</label>
        <input type="number" name="year" id="year" required min="1900" max="<?= date('Y') ?>" value="<?= htmlspecialchars($movie['year']) ?>" />

        <label for="genre">Gênero:</label>
        <input type="text" name="genre" id="genre" required value="<?= htmlspecialchars($movie['genre']) ?>" />

        <button type="submit">Atualizar</button>
    </form>
</section>

<footer>
    <p>&copy; 2025 CineVerse - Todos os direitos reservados</p>
</footer>
</body>
</html>

<?php $conn->close(); ?>
