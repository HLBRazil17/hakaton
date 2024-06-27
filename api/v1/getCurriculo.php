<?php

//DEFINE O CABEÇALHO EM JSON
header("Content-Type: application/json");

//CONECTA COMO BANCO DE DADOS
require('../../databaseManager/conectar.php');

$idUser = $_GET['idUser'];

//PREPARA A CONSULTA SQL
$sql = "SELECT * FROM curriculo LEFT JOIN dados ON dados.idUser = curriculo.user_id LEFT JOIN curso ON curso.idCurso = curriculo.curso_id WHERE curriculo.user_id = $idUser ORDER BY dados.nome";

//EXECUTA A CONSULTA
$result = $conn->query($sql);

//VERIFICA SE A TABELA CONTÉM ALUNO
if ($result->num_rows <= 0) {
    throw new \Exception("Esse usuário não existe", 404);
}

$curriculos = [];

while ($row = $result->fetch_assoc()) {
    $curriculos[] = [
        'iduser'      => $row['user_id'],
        'nome'        => $row['nome'],
        'ra'          => $row['ra'],
        'email'       => $row['email'],
        'curriculo' =>[
            'idCurriculo' => $row['idCurriculo'],
            'midia'       => $row['midia'],
            'curso_id'    => $row['curso_id'],
            'nomeCurso'   => $row['nomeCurso'],
        ]

    ];
}

//CONVERTE A ARRAY PARA JSON
echo json_encode($curriculos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
