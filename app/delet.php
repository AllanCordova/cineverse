<?php
$conn = new mysqli('db', 'user', 'userpass', 'movies_db');

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM movies WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        // Redireciona com mensagem de erro, se necessário
        header("Location: index.php?error=delete_failed");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

$conn->close();
?>