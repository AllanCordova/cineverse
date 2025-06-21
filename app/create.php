<?php
$conn = new mysqli('db', 'user', 'userpass', 'movies_db');

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Lógica para adicionar ou editar filme
// Esta parte do código PHP é a mesma que você já tinha, não precisa de alterações aqui para a estilização.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (basename($_SERVER['PHP_SELF']) === 'create.php') { // Lógica para create.php
        $title = $_POST['title'] ?? '';
        $director = $_POST['director'] ?? '';
        $year = $_POST['year'] ?? '';
        $genre = $_POST['genre'] ?? '';

        $stmt = $conn->prepare("INSERT INTO movies (title, director, year, genre) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $title, $director, $year, $genre);
        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Erro ao adicionar filme.";
        }
    } elseif (basename($_SERVER['PHP_SELF']) === 'edit.php') { // Lógica para edit.php
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php");
            exit();
        }
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
    }
} else {
    // Lógica para carregar dados do filme em edit.php
    if (basename($_SERVER['PHP_SELF']) === 'edit.php') {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php");
            exit();
        }
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
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineVerse - <?php echo (basename($_SERVER['PHP_SELF']) === 'create.php') ? 'Adicionar Filme' : 'Editar Filme'; ?></title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="page-form">
    <header class="app-header">
        <div class="header-content">
            <img src="logo.svg" alt="Logo CineVerse" class="app-logo" />
            <h1 class="app-title">CineVerse</h1>
        </div>
        <nav class="main-nav">
            <a href="index.php" class="nav-link">Voltar à lista</a>
        </nav>
    </header>

    <main class="main-content">
        <section class="form-section card">
            <h2 class="section-title"><?php echo (basename($_SERVER['PHP_SELF']) === 'create.php') ? 'Adicionar Novo Filme' : 'Editar Filme'; ?></h2>
            <?php if (!empty($error)) echo "<p class='message message-error'>$error</p>"; ?>
            <form method="post" action="<?php echo (basename($_SERVER['PHP_SELF']) === 'create.php') ? 'create.php' : 'edit.php?id=' . $id; ?>" class="movie-form">
                <div class="form-group">
                    <label for="title" class="form-label">Título:</label>
                    <input type="text" name="title" id="title" class="form-input" required value="<?= (basename($_SERVER['PHP_SELF']) === 'edit.php' && isset($movie['title'])) ? htmlspecialchars($movie['title']) : '' ?>" />
                </div>

                <div class="form-group">
                    <label for="director" class="form-label">Diretor:</label>
                    <input type="text" name="director" id="director" class="form-input" required value="<?= (basename($_SERVER['PHP_SELF']) === 'edit.php' && isset($movie['director'])) ? htmlspecialchars($movie['director']) : '' ?>" />
                </div>

                <div class="form-group">
                    <label for="year" class="form-label">Ano:</label>
                    <input type="number" name="year" id="year" class="form-input" required min="1900" max="<?= date('Y') ?>" value="<?= (basename($_SERVER['PHP_SELF']) === 'edit.php' && isset($movie['year'])) ? htmlspecialchars($movie['year']) : '' ?>" />
                </div>

                <div class="form-group">
                    <label for="genre" class="form-label">Gênero:</label>
                    <input type="text" name="genre" id="genre" class="form-input" required value="<?= (basename($_SERVER['PHP_SELF']) === 'edit.php' && isset($movie['genre'])) ? htmlspecialchars($movie['genre']) : '' ?>" />
                </div>

                <button type="submit" class="button button-primary"><?php echo (basename($_SERVER['PHP_SELF']) === 'create.php') ? 'Adicionar Filme' : 'Atualizar Filme'; ?></button>
            </form>
        </section>
    </main>

    <footer class="app-footer">
        <p>&copy; 2025 CineVerse - Todos os direitos reservados</p>
    </footer>
</body>
</html>

<?php $conn->close(); ?>