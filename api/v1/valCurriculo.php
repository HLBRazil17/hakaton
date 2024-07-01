<?php

//VERIFICA SE A REQUEST É UM (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $url = $_SERVER['HTTP_HOST'];

    //DEFINE O CABEÇALHO EM JSON
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: $url");
    header("Access-Control-Allow-Credentials: true");

    //CONECTA COMO BANCO DE DADOS
    require ('../../databaseManager/conectar.php');

    //PREPARA AS VARIÁVEIS COM O VALOR PASSADO PELOS PARÂMETROS
    $ra = $_POST['ra'];
    $dataNasc = $_POST['dataNasc'];
    $curso_id = $_POST['cursoNome'];

    //PREPARA A CONSULTA SQL PARA VERIFICAR SE O USUÁRIO EXISTE
    $validacaoAl = "SELECT * FROM dados WHERE ra LIKE '$ra' AND dataNasc LIKE '$dataNasc'";

    //EXECUTA A CONSULTA
    $result = $conn->query($validacaoAl);

    //VERIFICA SE O ALUNO EXISTE
    if($result->num_rows <= 0){
        http_response_code(404);
        echo json_encode(['error' => 'Esse usuário não existe '], JSON_UNESCAPED_UNICODE);
        exit;
    }

    //OBTÉM O RESULTADO DA CONSULTA
    $row = $result->fetch_assoc();

    //OBTÉM AS VARIÁVEIS DO RESULTADO DA CONSULTA 
    $user_id = $row['idUser'];

    // CONSULTA SQL PARA CONTAR OS CURRÍCULOS DO USUÁRIO NO CURSO
    $curriculos = "SELECT COUNT(*) AS num_curriculos FROM curriculo WHERE user_id = $user_id AND curso_id = $curso_id";

    // EXECUTA A CONSULTA DE CONTAGEM
    $resultCount = $conn->query($curriculos);

    //VERIFICA SE A PREPARAÇÃO DA CONSULTA FOI BEM-SUCEDIDA
    if (!$resultCount) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro na preparação da consulta: '], JSON_UNESCAPED_UNICODE);
        exit;
    }

    //OBTÉM O NÚMERO DE CURRÍCULOS ASSOCIADOS
    $rowCount = $resultCount->fetch_assoc();
    $numCurriculos = $rowCount['num_curriculos'];

    // VERIFICA SE JÁ EXISTEM 2 CURRÍCULOS ASSOCIADOS AO USUÁRIO E CURSO
    if ($numCurriculos >= 2) {
        http_response_code(400);
        echo json_encode(['error' => 'O usuário já possui 2 currículos registrados para este curso'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    //VALIDA SE O ARQUIVO É UM PDF
    if ($_FILES['arquivoCurriculo']['type'] != 'application/pdf') {
        http_response_code(400);
        echo json_encode(['error' => 'Envie um arquivo PDF válido.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    //DEFINE O TAMANHO MÁXIMO DO ARQUIVO (5 MB)
    $tamanhoMaximo = 5 * 1024 * 1024;

    //VERIFICA O TAMANHO DO ARQUIVO
    if ($_FILES['arquivoCurriculo']['size'] > $tamanhoMaximo) {
        http_response_code(400);
        echo json_encode(['error' => 'O arquivo PDF deve ter no máximo 5 MB.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // GERA UM NOME ÚNICO PARA O ARQUIVO
    $extensao = pathinfo($_FILES['arquivoCurriculo']['name'], PATHINFO_EXTENSION);
    $nomeArquivo = uniqid('', true) . '.' . $extensao;
    $destino = __DIR__ . '/../../upload/' . $nomeArquivo;

    //MOVE O ARQUIVO PARA O DESTINO
    if (!move_uploaded_file($_FILES['arquivoCurriculo']['tmp_name'], $destino)) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao enviar o arquivo.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    //OBTÉM O FUSO HORÁRIO 
    $fusoHorario = new DateTimeZone('America/Sao_Paulo');

    //OBTÉM A HORA E DATA ATUAL EM 'America/Sao_Paulo'
    $dataHoraAtual = new DateTime('now', $fusoHorario);

    //FORMATA A DATA E HORA 
    $tempoFormatado = $dataHoraAtual->format('Y-m-d H:i:s');

    //separar o link dos arquivos em , igual o midia
    $midia = $nomeArquivo;
    $dataEnv = $tempoFormatado;    ;

    //INSERE AS INFORMACOES DO CURRICULO AO BANCO DE DADOS
    $cadCurriculo = "INSERT INTO curriculo (midia, dataEnv, user_id, curso_id) VALUES (?,?,?,?)";
    $cadastro = $conn->prepare($cadCurriculo);

    //VERIFICA A PREPARAÇÃO DO CADASTRO
    if (!$cadastro) {
        http_response_code(500);
        json_encode(['error' => 'Erro na preparação da consulta: '], JSON_UNESCAPED_UNICODE);
        exit;
    }

    //LIGA OS PARÂMETROS À CONSULTA SQL
    $cadastro->bind_param("ssii", $midia, $dataEnv, $user_id, $curso_id);

    //VERIFICA A EFETUAÇÃO DO CADASTRO DE CURRICULO
    if (!$cadastro->execute()) {
        http_response_code(500);
        echo json_encode(['Error' => 'Erro ao cadastrar'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    //ARQUIVO ENVIADO COM SUCESSO
    echo json_encode(['success' => 'Arquivo PDF enviado com sucesso.'], JSON_UNESCAPED_UNICODE);
    
}