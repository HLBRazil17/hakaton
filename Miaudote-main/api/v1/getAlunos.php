<?php

//VERIFICA SE A REQUEST É UM (GET)
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $url = $_SERVER['HTTP_HOST'];

    //DEFINE O CABEÇALHO EM JSON
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: $url");
    header("Access-Control-Allow-Credentials: true");

    //CONECTA COMO BANCO DE DADOS
    require ('../../databaseManager/conectar.php');

    //PEGA O PARÂMETRO DE BUSCA SE EXISTIR
    $busca = $_GET['busca'] ?? null;
    $estadoAluno = $_GET['estado'] ?? null;

    //PREPARA A CONSULTA SQL
    $getAlunos =  "SELECT * FROM dados WHERE nome LIKE '%$busca%'";

    // ADICIONA CONDIÇÃO DE ESTADO SE FOR FORNECIDA
    if ($estadoAluno !== null) {
        //RETORNA OS DETALHES DE ALUNOS DE ACORDO COM SEU ESTADO
        $getAlunos .= " AND estado = '$estadoAluno'";
    }

    //EXECUTA A CONSULTA
    $result = $conn->query($getAlunos);

    //VERIFICA SE A TABELA CONTÉM ALUNO
    // if($result->num_rows <= 0){
    //     throw new \Exception("Esse usuário não existe", 404);
    // }

    //ARRAY QUE ARMAZENAM O RESULTADO DA CONSULTA
    $alunos = [];

    //RENDERIZA OS RESULTADOS DA CONSULTA
    while ($row = $result->fetch_assoc()) {
        $alunos[] = [
            'iduser' => $row['idUser'],
            'nome'   => $row['nome'],
            'ra'     => $row['ra'],
            'email'  => $row['email'],
            'estado' => $row['estado'],
        ];
    }

    //CONVERTE A ARRAY PARA JSON
    echo json_encode($alunos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

}
?>