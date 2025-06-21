<?php
// Conexão com o banco
$conn = new mysqli('db', 'user', 'userpass', 'movies_db');

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Busca todos os filmes
$sql = "SELECT * FROM movies ORDER BY title ASC"; // Ordenando por título para melhor visualização
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineVerse - Catálogo de Filmes</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="page-index">
    <header class="app-header">
        <div class="header-content">
            <img src="logo.svg" alt="Logo CineVerse" class="app-logo" />
            <h1 class="app-title">CineVerse</h1>
        </div>
        <nav class="main-nav">
            <a href="create.php" class="nav-link button button-primary">Adicionar Novo Filme</a>
        </nav>
    </header>

    <main class="main-content">
        <section class="movie-list-section card">
            <h2 class="section-title">Catálogo de Filmes</h2>
            <?php if ($result->num_rows > 0) : ?>
                <div class="table-responsive">
                    <table class="movie-table">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Diretor</th>
                                <th>Ano</th>
                                <th>Gênero</th>
                                <th class="actions-column">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr class="movie-item">
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= htmlspecialchars($row['director']) ?></td>
                                <td><?= htmlspecialchars($row['year']) ?></td>
                                <td><?= htmlspecialchars($row['genre']) ?></td>
                                <td class="actions-column">
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="button button-secondary button-small">Editar</a>
                                    <a href="delete.php?id=<?= $row['id'] ?>" class="button button-danger button-small" onclick="return confirm('Tem certeza que deseja excluir este filme? Esta ação não pode ser desfeita.')">Excluir</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="message message-info">Nenhum filme cadastrado ainda. <a href="create.php">Adicione um novo filme!</a></p>
            <?php endif; ?>
        </section>
    </main>

    <footer class="app-footer">
        <p>&copy; 2025 CineVerse - Todos os direitos reservados</p>
    </footer>
</body>
</html>

<?php $conn->close(); ?>