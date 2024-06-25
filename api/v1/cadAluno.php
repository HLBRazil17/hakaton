<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require ('../../databaseManager/conectar.php');

    // Recebendo e sanitizando os dados do formulário
    $nome = $_POST['nome'];
    $curso = $_POST['nomeCurso'];
    $telefone = $_POST['telefone'];
    echo $telefone;
    $email = $_POST['email'];
    $dataNasc = $_POST['dataNasc'];
    $ra = $_POST['ra'];

    // Inserindo os dados no banco de dados usando prepared statements para evitar SQL Injection
    $sql = "INSERT INTO dados (nome, telefone, email, dataNasc, ra, cursoNome) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssss", $nome, $telefone, $email, $dataNasc, $ra, $curso);

            if ($stmt->execute()) {
                echo "Cadastro realizado com sucesso!";
                exit;
            }

            if (!$stmt->execute()) {
                echo "Erro ao cadastrar";
            }

        $stmt->close();
    } else {
        echo "Erro na preparação da consulta: " . $conn->error;
    }

    $conn->close();

}
?>