<?php

//VERIFICA SE A REQUEST É UM (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $url = $_SERVER['HTTP_HOST'];

    //DEFINE O CABEÇALHO EM JSON
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: $url");
    header("Access-Control-Allow-Credentials: true");

    //CONECTA COMO BANCO DE DADOS
    require('../../databaseManager/conectar.php');

    //PREPARA AS VARIÁVEIS COM O VALOR PASSADO PELOS PARÂMETROS
    $alunoId = $_GET['idUser'];
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $dataNasc = $_POST['dataNasc'];
    $ra = $_POST['ra'];
    $estado = $_POST['estado'];

    //PREPARA A CONSULTA SQL PARA ATUALIZAR OS DADOS DO ALUNO
    $sql = "UPDATE dados SET nome=?, telefone=?, email=?, dataNasc=?, ra=?, estado=? WHERE idUser=?";
    $stmt = $conn->prepare($sql);

    //VERIFICA A PREPARAÇÃO DA CONSULTA
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro na preparação da consulta: ' . $conn->error]);
        exit;
    }

    //LIGA OS PARÂMETROS À CONSULTA SQL
    $stmt->bind_param("ssssssi", $nome, $telefone, $email, $dataNasc, $ra, $estado, $alunoId);

    //VERIFICA SE A CONSULTA FOI BEM SUCEDIDA
    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao atualizar dados do aluno: ' . $stmt->error]);
        exit;
    }

    //ATUALIZAÇÃO REALIZADA COM SUCESSO
    echo json_encode(['success' => 'Dados do aluno atualizados com sucesso.']);
    exit;
}
