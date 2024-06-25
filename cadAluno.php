<?php
require('databaseManager/conectar.php'); // Arquivo que contém a conexão com o banco de dados

// Recebendo e sanitizando os dados do formulário
$nome = $_POST['nome'];
$curso = $_POST['nomeCurso'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$data_nascimento = $_POST['dataNasc'];

// Inserindo os dados no banco de dados usando prepared statements para evitar SQL Injection
$sql = "INSERT INTO dados (nome, nomeCurso, telefone, email, dataNasc) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sisss", $nome, $curso, $telefone, $email, $data_nascimento);

    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro ao cadastrar aluno: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Erro na preparação da consulta: " . $conn->error;
}

$conn->close();
?>