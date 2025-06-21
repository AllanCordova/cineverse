<?php
// index.php

// Carrega variáveis de ambiente (definidas no docker-compose)
$host    = getenv('DB_HOST')     ?: 'db';
$db      = getenv('DB_DATABASE') ?: 'movies_db';
$user    = getenv('DB_USER')     ?: 'user';
$pass    = getenv('DB_PASSWORD') ?: 'userpass';

// Abre conexão
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
    die('Erro de conexão: ' . $mysqli->connect_error);
}

// Se quiser exibir algo rápido:
echo "Conectado com sucesso ao banco “{$db}”!";

// Você pode a partir daqui executar consultas, por exemplo:
// $result = $mysqli->query("SELECT * FROM movies");
// ...
