<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //DEFINE O CABEÇALHO EM JSON
    header("Content-Type: application/json");

    //CONECTA COMO BANCO DE DADOS
    require ('../../databaseManager/conectar.php');

    //PREPARA AS VARIÁVEIS COM O VALOR PASSADO PELOS PARÂMETROS
    $nome = $_POST['nome'];
    $cursoNome = $_POST['cursoNome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $dataNasc = $_POST['dataNasc'];
    $ra = $_POST['ra'];

    //PREPARA A CONSULTA SQL
    $sql = "INSERT INTO dados (nome, telefone, email, dataNasc, ra) VALUES (?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    //VERIFICA A PREPARAÇÃO DO $SQL
    if (!$stmt) {
        http_response_code(500);
        json_decode(json_encode(array('error' => 'Erro na preparação da consulta: ')));
        exit;
    }

    //
    $stmt->bind_param("sssss", $nome, $telefone, $email, $dataNasc, $ra);

    //VERIFICA A EFETUAÇÃO DO CADASTRO
    if (!$stmt->execute()) {
        http_response_code(500);
        json_decode(json_encode(array('error' => 'Erro ao cadastrar ')));
        exit;
    }

    //PREPARA A CONSULTA SQL
    $getAlunos = "SELECT * FROM dados WHERE nome LIKE '$nome' AND dataNasc = '$dataNasc' LIMIT 1";

    //EXECUTA A CONSULTA
    $result = $conn->query($getAlunos);

    //
    $aluno = $result->fetch_assoc();

    //
    $sql = "INSERT INTO dados_has_curso(dados_idUser, curso_idCurso) VALUES (?, ?)";

    //
    $stmt = $conn->prepare($sql);

    //VERIFICA A PREPARAÇÃO DO $SQL
    if (!$stmt) {
        http_response_code(500);
        json_decode(json_encode(array('error' => 'Erro na preparação da consulta: ')));
        exit;
    }

    //
    $stmt->bind_param("ii", $aluno['idUser'], $cursoNome);

    //VERIFICA A EFETUAÇÃO DO CADASTRO
    if (!$stmt->execute()) {
        http_response_code(500);
        json_decode(json_encode(array('error' => 'Erro ao cadastrar ')));
        exit;
    }

    //CADASTRO ENVIADO COM SUCESSO
    echo json_encode(['success' => 'Cadastro realizado com sucesso.']);

}
?>