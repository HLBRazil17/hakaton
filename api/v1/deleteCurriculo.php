<?php

//VERIFICA SE A REQUEST É UM (DELETE)
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

    $url = $_SERVER['HTTP_HOST'];

    //DEFINE O CABEÇALHO EM JSON
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: $url");
    header("Access-Control-Allow-Credentials: true");

    //CONECTA COMO BANCO DE DADOS
    require('../../databaseManager/conectar.php');

    //PREPARA AS VARIÁVEIS COM O VALOR PASSADO PELOS PARÂMETROS
    $idCurriculo = $_GET['idCurriculo'];
    $nomeArquivo = $_GET['nomeArquivo'];

    // ID do aluno a ser deletado (sanitize para evitar SQL Injection)
    if (!isset($idCurriculo)) {
        http_response_code(500);
        echo json_encode(['error' => 'ID do curriculo não especificado'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    //PREPARA A CONSULTA SQL DELETAR O CURRICULO ATAV
    $sql = "DELETE FROM curriculo WHERE idCurriculo = $idCurriculo";

    //VERIFICA SE A CONSULTA FOI BEM-SUCEDIDA
    if (!$conn->query($sql)) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao deletar o curriculo:'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    //CAMINHO DO ARQUIVO NO DIRETÓRIO DE UPLOADS
    $caminhoArquivo = __DIR__. '/../../upload/'. $nomeArquivo;

    //VERIFICA SE O ARQUIVO FOI REMOVIDO COM SUCESSO
    if (!unlink($caminhoArquivo)) {
        echo json_encode(['success' => 'Arquivo PDF excluído com sucesso.'], JSON_UNESCAPED_UNICODE);
    } 

    //CURRICULO DELETADO COM SUCESSO
    echo json_encode(['success' => 'Curriculo deketado com sucesso.'], JSON_UNESCAPED_UNICODE);
}
