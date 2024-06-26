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

    //PREPARA A CONSULTA SQL
    $getCursos =  "SELECT * FROM curso";

    //EXECUTA A CONSULTA
    $result = $conn->query($getCursos);

    //VERIFICA SE A TABELA CONTÉM ALUNO
    if($result->num_rows <= 0){
        throw new \Exception("A tabela não contém cursos cadastrados", 404);
    }

    //ARRAY QUE ARMAZENAM O RESULTADO DA CONSULTA
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