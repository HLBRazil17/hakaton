<?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //DEFINE O CABEÇALHO EM JSON
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: http://192.168.0.106:8080");
    header("Access-Control-Allow-Credentials: true");

    //CONECTA COMO BANCO DE DADOS
    require ('../../databaseManager/conectar.php');

    //PREPARA AS VARIÁVEIS COM O VALOR PASSADO PELOS PARÂMETROS
    $idUser = $_GET['idUser'];

    //PREPARA A CONSULTA SQL
    $getAluno = "SELECT * FROM dados WHERE idUser LIKE '$idUser'";

    //EXECUTA A CONSULTA
    $result = $conn->query($getAluno);

    //VERIFICA SE A TABELA CONTÉM ALUNO
    if ($result->num_rows <= 0) {
        throw new \Exception("Esse usuário não existe", 404);
    }

    //ARRAY $ALUNO
    $aluno = [];

    //RENDERIZA OS RESULTADOS DA CONSULTA
    while ($row = $result->fetch_assoc()) {
        //RETORNA OS DETALHES DE ALUNOS SE FOREM 'ATIVOS'
        if ($row['estado'] == 'a') {
            $aluno[] = [
                'iduser' => $row['idUser'],
                'nome' => $row['nome'],
                'ra' => $row['ra'],
                'email' => $row['email'],
            ];
        }
    }

    //CONVERTE A ARRAY PARA JSON
    echo json_encode($aluno, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
?>