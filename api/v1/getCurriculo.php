<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //DEFINE O CABEÇALHO EM JSON
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: http://127.0.0.1:5173");
    header("Access-Control-Allow-Credentials: true");

    //CONECTA COMO BANCO DE DADOS
    require('../../databaseManager/conectar.php');

    $idUser = $_GET['idUser'];

    //PREPARA A CONSULTA SQL
    $sql = "SELECT dados.idUser as user_id, dados.nome, dados.estado, dados.ra, dados.telefone, dados.email, curriculo.idCurriculo, curriculo.midia, curriculo.curso_id, curso.nomeCurso
            FROM dados
            LEFT JOIN curriculo ON dados.idUser = curriculo.user_id
            LEFT JOIN curso ON curso.idCurso = curriculo.curso_id
            WHERE dados.idUser = $idUser
            ORDER BY dados.nome";

    //EXECUTA A CONSULTA
    $result = $conn->query($sql);

    //ARRAY QUE ARMAZENAM O RESULTADO DA CONSULTA
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $iduser = $row['user_id'];

        //ARMAZENA AS INFORMAÇÕES DO USUÁRIO

            $data = [
                'iduser'      => $iduser,
                'nome'        => $row['nome'],
                'estado'      => $row['estado'],
                'ra'          => $row['ra'],
                'email'       => $row['email'],
                'telefone'    => $row['telefone'],
                'curriculos'  => [],
            ] ?? [];
        

        //ARMAZENA AS INFORMAÇÕES DO CURRCULO
        if (!empty($row['idCurriculo'])) {
            $data[$iduser]['curriculos'][] = [
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