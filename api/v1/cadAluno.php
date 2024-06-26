<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //CONECTA COMO BANCO DE DADOS
    require ('../../databaseManager/conectar.php');

    //PREPARA AS VARIÁVEIS COM O VALOR PASSADO PELOS PARÂMETROS
    $nome = $_POST['nome'];
    $curso = $_POST['nomeCurso'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $dataNasc = $_POST['dataNasc'];
    $ra = $_POST['ra'];

    // Inserindo os dados no banco de dados usando prepared statements para evitar SQL Injection
    $sql = "INSERT INTO dados (nome, telefone, email, dataNasc, ra, cursoNome) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        http_response_code(500);
        json_decode(json_encode(array('error' => 'Erro na preparação da consulta: ')));
    }

    $stmt->bind_param("ssssss", $nome, $telefone, $email, $dataNasc, $ra, $curso);

    if (!$stmt->execute()) {
        echo "Erro ao cadastrar";
        exit;
    }

    echo "Cadastro realizado com sucesso!";

}
?>