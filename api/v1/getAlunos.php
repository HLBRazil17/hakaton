<?php
//VERIFICA SE A REQUEST É UM (POST)
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    //DEFINE O CABEÇALHO EM JSON
    header("Content-Type: application/json");

    //CONECTA COMO BANCO DE DADOS
    require ('../../databaseManager/conectar.php');

    //PREPARA A CONSULTA SQL
    $getAlunos =  "SELECT * FROM dados";

    //EXECUTA A CONSULTA
    $result = $conn->query($getAlunos);

    //VERIFICA SE A TABELA CONTÉM ALUNO
    if($result->num_rows <= 0){
        throw new \Exception("Esse usuário não existe", 404);
    }

    //ARRAY $ALUNOS
    $alunos = [];

    //RENDERIZA OS RESULTADOS DA CONSULTA
    while ($row = $result->fetch_assoc()) {
        //RETORNA OS DETALHES DE ALUNOS SE FOREM 'ATIVOS'
        if($row['estado'] == 'a'){
            $alunos[] = [
                'iduser' => $row['idUser'],
                'nome'   => $row['nome'],
                'ra'     => $row['ra'],
                'email'  => $row['email'],
            ];
        }
    }

    //CONVERTE A ARRAY PARA JSON
    echo json_encode($alunos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

}
?>