<?php

//VERIFICA SE A REQUEST É UM (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //
    header("Content-Type: application/json");

    //CONECTA COMO BANCO DE DADOS
    require ('../../databaseManager/conectar.php');

    //PREPARA AS VARIÁVEIS COM O VALOR PASSADO PELOS PARÂMETROS
    $ra = $_POST['ra'];
    $dataNasc = $_POST['dataNasc'];

    // PREPARA A CONSULTA SQL PARA VERIFICAR SE O USUÁRIO EXISTE
    $validacaoAl = "SELECT * FROM dados WHERE ra LIKE '$ra' AND dataNasc LIKE '$dataNasc'";

    //EXECUTA A CONSULTA
    $result = $conn->query($validacaoAl);

    //VERIFICA SE O ALUNO EXISTE
    if($result->num_rows <= 0){
        throw new \Exception("Esse usuário não existe", 404);
    }

    //VALIDA SE O ARQUIVO É UM PDF
    if ($_FILES['arquivoCurriculo']['type'] != 'application/pdf') {
        http_response_code(400);
        echo json_encode(['error' => 'Envie um arquivo PDF válido.']);
        exit;
    }

    //DEFINE O TAMANHO MÁXIMO DO ARQUIVO (5 MB)
    $tamanhoMaximo = 5 * 1024 * 1024;

    //VERIFICA O TAMANHO DO ARQUIVO
    if ($_FILES['arquivoCurriculo']['size'] > $tamanhoMaximo) {
        http_response_code(400);
        echo json_encode(['error' => 'O arquivo PDF deve ter no máximo 5 MB.']);
        exit;
    }

    // GERA UM NOME ÚNICO PARA O ARQUIVO
    $extensao = pathinfo($_FILES['arquivoCurriculo']['name'], PATHINFO_EXTENSION);
    $nomeArquivo = uniqid('', true) . '.' . $extensao;
    $destino = __DIR__ . '/../../upload/' . $nomeArquivo;

    //MOVE O ARQUIVO PARA O DESTINO
    if (!move_uploaded_file($_FILES['arquivoCurriculo']['tmp_name'], $destino)) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao enviar o arquivo.']);
        exit;
    }

    //
    $row = $result->fetch_assoc();

    //OBTÉM O FUSO HORÁRIO 
    $fusoHorario = new DateTimeZone('America/Sao_Paulo');

    //OBTÉM A HORA E DATA ATUAL EM 'America/Sao_Paulo'
    $dataHoraAtual = new DateTime('now', $fusoHorario);

    //FORMATA A DATA E HORA 
    $tempoFormatado = $dataHoraAtual->format('Y-m-d H:i:s');

    //separar o link dos arquivos em , igual o midia
    $midia = $nomeArquivo;
    $dataEnv = $tempoFormatado;    ;
    $user_id = $row['idUser'];
    $curso_id = $_POST['curso_id'];

    //INSERE AS INFORMACOES DO CURRICULO AO BANCO DE DADOS
    $cadCurriculo = "INSERT INTO curriculo (midia, dataEnv, user_id, curso_id) VALUES (?,?,?,?)";
    $cadastro = $conn->prepare($cadCurriculo);

    if (!$cadastro) {
        http_response_code(500);
        json_decode(json_encode(array('error' => 'Erro na preparação da consulta: ')));
        exit;
    }

    $cadastro->bind_param("ssssss", $midia, $dataEnv, $user_id, $curso_id);

    if (!$stmt->execute()) {
        http_response_code(500);
        json_decode(json_encode(array('error' => 'Erro ao cadastrar: ')));
        exit;
    }
    
    //ARQUIVO ENVIADO COM SUCESSO
    echo json_encode(['success' => 'Arquivo PDF enviado com sucesso.', 'nome_arquivo' => $nomeArquivo, 'teste' => 'http://'.$_SERVER['HTTP_HOST'].'/upload/'.$nomeArquivo]);
    
}