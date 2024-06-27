<?php
//VERIFICA SE A REQUEST É UM (POST)
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    //DEFINE O CABEÇALHO EM JSON
    header("Content-Type: application/json");

    //CONECTA COMO BANCO DE DADOS
    require ('../../databaseManager/conectar.php');

    //PREPARA A CONSULTA SQL
    $getCursos =  "SELECT * FROM curso";

    //EXECUTA A CONSULTA
    $result = $conn->query($getCursos);

    //VERIFICA SE A TABELA CONTÉM ALUNO
    if($result->num_rows <= 0){
        throw new \Exception("A tabela não contém cursos cadastrados", 404);
    }

    //ARRAY $CURSOS
    $cursos = [];

    //RENDERIZA OS RESULTADOS DA CONSULTA
    while ($row = $result->fetch_assoc()) {
        //RETORNA OS DETALHES DE CURSOS SE FOREM 'ATIVOS'
        if($row['estado'] == 'a'){
            $cursos[] = [
                'idCurso'   => $row['idCurso'],
                'nomeCurso' => $row['nomeCurso'],
            ];
        }
    }

    //CONVERTE A ARRAY PARA JSON
    echo json_encode($cursos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

}
?>