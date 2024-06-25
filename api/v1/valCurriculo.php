<?php

//VERIFICA SE A REQUEST É UM (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //CONECTA COMO BANCO DE DADOS
    require ('databaseManager/conectar.php');

    //RECEBE OS VALORES PASSADOS DO PARAMETRO
    $nome = $_POST['nome'];
    $dataNasc = $_POST['dataNasc'];

    // PREPARA A CONSULTA SQL PARA VERIFICAR SE O USUÁRIO EXISTE
    $sql = "SELECT * FROM teste WHERE nome LIKE '$nome' AND teste LIKE '$dataNasc'";
    $result = $conn->query($sql);

    //VERIFICA SE O ALUNO EXISTE
    if($result->num_rows <= 0){
        throw new \Exception("Esse usuário não existe", 404);
    }

    //VERIFICA SE O ARQUIVO FOI ENVIADO
    if (!isset($_FILES['pdfFile'])) {
        throw new \Exception("Envie um arquivo PDF", 404);
    }

    //VALIDA SE O ARQUIVO É UM PDF
    if ($_FILES['pdfFile']['type'] != 'application/pdf') {
        throw new \Exception("Envie um arquivo PDF válido", 400);
    }

    //DEFINE O TAMANHO MÁXIMO DO ARQUIVO(5 MB)
    $tamanhoMaximo = 5 * 1024 * 1024;

    //VERIFICA O TAMANHO DO ARQUIVO
    if ($_FILES['pdfFile']['size'] > $tamanhoMaximo) {
        throw new \Exception("O arquivo PDF deve ter no máximo 5 MB", 400);
    }

    //GERA UM NOME ÚNICO PARA O ARQUIVO
    $extensao = pathinfo($_FILES['pdfFile']['name'], PATHINFO_EXTENSION);
    $nomeArquivo = str_replace('.', '', uniqid('', true)) . '.' . $extensao;
    $destino = 'upload/' . $nomeArquivo;

    //VALIDA SE O ENVIO FOI BEM SUCEDIDO
    if (!move_uploaded_file($_FILES['pdfFile']['tmp_name'], $destino)) {
        throw new \Exception("Erro ao enviar o arquivo", 501);
    }

}
?>