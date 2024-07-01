<?php

//VERIFICA SE A REQUEST É UM (GET)
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $url = $_SERVER['HTTP_HOST'];
    
    //DEFINE O CABEÇALHO EM JSON
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: $url");
    header("Access-Control-Allow-Credentials: true");

    //CONECTA COMO BANCO DE DADOS
    require('../../databaseManager/conectar.php');

    //PEGA O PARÂMETROS DA URL
    $idUser = $_GET['idUser'];
    $busca = $_GET['busca'] ?? null;

    //PREPARA A CONSULTA SQL
    $sqlUsuario = "SELECT dados.idUser as user_id, dados.nome, dados.dataNasc, dados.estado, dados.ra, dados.telefone, dados.email
                   FROM dados
                   WHERE dados.idUser = $idUser";

    //EXECUTA AS CONSULTAS DO ALUNO
    $resultAluno = $conn->query($sqlUsuario);

    //ARRAY QUE ARMAZENAM O RESULTADO DA CONSULTA
    $data = [];

    //RENDERIZA OS RESULTADOS DA CONSULTA
    while ($row = $resultAluno->fetch_assoc()) {
        //ARMAZENA AS INFORMAÇÕES DO USUÁRIO
            $data = [
                'iduser'      => $row['user_id'],
                'nome'        => $row['nome'],
                'estado'      => $row['estado'],
                'dataNasc'    => $row['dataNasc'],
                'ra'          => $row['ra'],
                'email'       => $row['email'],
                'telefone'    => $row['telefone'],
                'curriculos'  => [],
            ] ?? [];
    }

    //PREPARA A CONSULTA SQL
    $sqlCurriculos = "SELECT curriculo.idCurriculo, curriculo.midia, curriculo.curso_id, curso.nomeCurso
                      FROM curriculo
                      LEFT JOIN curso ON curso.idCurso = curriculo.curso_id
                      WHERE curriculo.user_id = $idUser";

    //ADICIONA CONDIÇÃO DE ESTADO SE FOR FORNECIDA
    if (!empty($busca)) {
        //RETORNA AS INFOMAÇÕES DE CURRICULO DE ACORDO COM O NOME DO CURSO
        $sqlCurriculos .= " AND curso.nomeCurso LIKE '%$busca%'";
    }

    //EXECUTA AS CONSULTAS DO CURRICULO
    $resultCurriculo = $conn->query($sqlCurriculos);

    //RENDERIZA OS RESULTADOS DA CONSULTA
    while ($row = $resultCurriculo->fetch_assoc()) {
        //ARMAZENA AS INFORMAÇÕES DO USUÁRIO
        if (!empty($row['idCurriculo'])) {
            $data['curriculos'][] = [
                'idCurriculo' => $row['idCurriculo'],
                'midia'       => $row['midia'],
                'curso_id'    => $row['curso_id'],
                'nomeCurso'   => $row['nomeCurso'],
            ];
        }
    }

    //CONVERTE A ARRAY PARA JSON
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
?>