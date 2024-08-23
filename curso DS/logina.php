<?php
session_start();
//coloque o arquivo do banco de dados quando necessário

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeUsuario = $_POST['nomeUsuario'];
    $senhaUsuario = md5($_POST['senhaUsuario']); //Criptografa a senha usando md5

    if($nomeUsuario=='Teste'&& $senhaUsuario==md5('senha')){
        //inicia a sessão
        $_SESSION['idUsuario'] = 1;//substituir com os dados do banco quando necessario
        $_SESSION['nivelAcesso'] = 'vendedor';
        $_SESSION['usuario'] = $nomeUsuario;
        date_default_timezone_set('America/Sao Paulo');
        $_SESSION['acesso']=date('d/m/Y H:i:s');

        header('Location:dashboard.php'); //Redireciona para a pagina de dashboard 
        exit;
    } else {
        echo "<script>
        alert('Usuário ou senhas incorretos!');
        window.location.href = 'index.php';
        </script>";
        exit();
    }
}