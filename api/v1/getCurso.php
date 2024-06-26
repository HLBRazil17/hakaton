<?php
//VERIFICA SE A REQUEST É UM (POST)
// if ($_SERVER["REQUEST_METHOD"] == "GET") {

    header("Content-Type: application/json");

    //CONECTA COMO BANCO DE DADOS
    require ('../../databaseManager/conectar.php');

    //
    $getCursos =  "SELECT * FROM curso";

    //
    $result = $conn->query($getCursos);

    //VERIFICA SE A TABELA CONTÉM ALUNO
    if($result->num_rows <= 0){
        throw new \Exception("A tabela não contém cursos cadastrados", 404);
    }

    $array = [];

    while ($row = $result->fetch_assoc()) {
        if($row['estado'] == 'a'){
            $array[] = [
                'idCurso' => $row['idCurso'],
                'nomeCurso' => $row['nomeCurso'],
            ];
        }
    }

    echo json_encode($array);

// }
?>