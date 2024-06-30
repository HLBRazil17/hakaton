<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //DEFINE O CABEÇALHO EM JSON
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: http://192.168.0.106:8080");
    header("Access-Control-Allow-Credentials: true");

    //CONECTA COMO BANCO DE DADOS
    require('../../databaseManager/conectar.php');

    $idUser = $_GET['idUser'];

    //PREPARA A CONSULTA SQL
    $sql = "SELECT dados.idUser as user_id, dados.nome,dados.dataNasc, dados.estado, dados.ra, dados.telefone, dados.email, curriculo.idCurriculo, curriculo.midia, curriculo.curso_id, curso.nomeCurso
            FROM dados
            LEFT JOIN curriculo ON dados.idUser = curriculo.user_id
            LEFT JOIN curso ON curso.idCurso = curriculo.curso_id
            WHERE dados.idUser = $idUser
            ORDER BY dados.nome";

    //EXECUTA AS CONSULTAS DO ALUNO E CURRICULO
    $resultAluno = $conn->query($sql);
    $resultCurriculo = $conn->query($sql);

    //ARRAY QUE ARMAZENAM O RESULTADO DA CONSULTA
    $data = [];

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