<?php
// Conectar ao banco de dados
$servername = "localhost:3308";
$username = "root";
$password = "etec2024";
$database = "site_adocao";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
