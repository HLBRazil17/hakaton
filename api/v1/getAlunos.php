<?php
//VERIFICA SE A REQUEST É UM (POST)
// if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Content-Type: application/json");

    //CONECTA COMO BANCO DE DADOS
    require ('../../databaseManager/conectar.php');

    //
    $getAlunos =  "SELECT * FROM dados";

    //
    $result = $conn->query($getAlunos);

    //VERIFICA SE A TABELA CONTÉM ALUNO
    if($result->num_rows <= 0){
        throw new \Exception("Esse usuário não existe", 404);
    }

    $array = [];

    while ($row = $result->fetch_assoc()) {
        $array[] = [
            'iduser' => $row['idUser'],
            'nome' => $row['nome'],
            'midia' => [$row['nome']],
        ];
    }

    echo json_encode($array);

// }
?>