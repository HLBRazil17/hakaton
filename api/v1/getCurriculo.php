<?php

//DEFINE O CABEÇALHO EM JSON
header("Content-Type: application/json");

//CONECTA COMO BANCO DE DADOS
require('../../databaseManager/conectar.php');

$idUser = $_GET['idUser'];

//PREPARA A CONSULTA SQL
$sql = "SELECT dados.idUser as user_id, dados.nome, dados.ra, dados.email, curriculo.idCurriculo, curriculo.midia, curriculo.curso_id, curso.nomeCurso
        FROM dados
        LEFT JOIN curriculo ON dados.idUser = curriculo.user_id
        LEFT JOIN curso ON curso.idCurso = curriculo.curso_id
        WHERE dados.idUser = $idUser
        ORDER BY dados.nome";
        
//EXECUTA A CONSULTA
$result = $conn->query($sql);

$curriculos = [];

while ($row = $result->fetch_assoc()) {
    $curriculos[] = [
        'iduser'      => $row['user_id'],
        'nome'        => $row['nome'],
        'ra'          => $row['ra'],
        'email'       => $row['email'],
        'curriculo' => $row['idCurriculo'] ? [
            'idCurriculo' => $row['idCurriculo'],
            'midia'       => $row['midia'],
            'curso_id'    => $row['curso_id'],
            'nomeCurso'   => $row['nomeCurso'],
        ] : []
    ];
}

//CONVERTE A ARRAY PARA JSON
echo json_encode($curriculos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
