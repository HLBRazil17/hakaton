<?php
// Variaveis para conectar ao banco de dados
$servername = "localhost:3308";
$username = "root";
$password = "etec2023";
$dbname = "curriculo";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi estabelecida corretamente
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>