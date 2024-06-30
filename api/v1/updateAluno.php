<?php

// Verifica se o método de requisição é POST (após o formulário ser submetido)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // conectar.php deve estar incluso para estabelecer a conexão com o banco de dados
    require('../../databaseManager/conectar.php');
    
    // Define o cabeçalho como JSON
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: http://192.168.0.106:8080");
    header("Access-Control-Allow-Credentials: true");

    // Limpa e valida os dados recebidos
    $alunoId = $_GET['idUser'];
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $dataNasc = $_POST['dataNasc'];
    $ra = $_POST['ra'];
    $estado = $_POST['estado'];

    // Prepara a consulta SQL para atualizar dados do aluno
    $sql = "UPDATE dados SET nome=?, telefone=?, email=?, dataNasc=?, ra=?, estado=? WHERE idUser=?";
    $stmt = $conn->prepare($sql);

    // Verifica a preparação da consulta
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro na preparação da consulta: ' . $conn->error]);
        exit;
    }

    // Liga os parâmetros à consulta SQL
    $stmt->bind_param("ssssssi", $nome, $telefone, $email, $dataNasc, $ra, $estado, $alunoId);

    // Executa a consulta para atualizar dados do aluno
    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao atualizar dados do aluno: ' . $stmt->error]);
        exit;
    }

    // Atualização realizada com sucesso
    echo json_encode(['success' => 'Dados do aluno atualizados com sucesso.']);
    exit;
}
