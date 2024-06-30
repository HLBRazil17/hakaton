<?php

header("Access-Control-Allow-Origin: *");

//OBTÉM A ROTA DA URL
function obterRota(){
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $rota = explode("/", trim($url, '/'));

    //DEFINE A ROTA PADRÃO CASO ESTIVER VAZIA
    if (empty($rota[0])) {
        $rota[0] = 'gerenciamento-alunos';
    }

    return $rota[0];
}

//INCLUI AS PÁGINAS RETORNADAS PELO OBTERROTA()
function incluirPagina($pagina){
    //
    $arquivoPagina = "components/pages/{$pagina}.php";

    //VERIFICA SE O ARQUIVO DA PÁGINA NÃO EXISTE
    if (!file_exists($arquivoPagina)) {
        echo "Página não encontrada.";
        return;
    }

    include $arquivoPagina;
}

//EXECUTA A FUNÇÃO OBTERROTA()
$rota = obterRota();

//DEFINE O TITULO DA PÁGINA
$tituloPagina = ucfirst(str_replace('-', ' ', $rota));
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($tituloPagina); ?></title>
    <link rel="stylesheet" href="components/css/style.css">
    <link rel="shortcut icon" href="components/assets/icon.jpeg" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body>

    <?php
        //INCLUI O COMPONETE DO CABEÇALHO
        include("components/header.php");
    ?>

    <?php
        //INCLUI O COMPONETE DE NAVEGAÇÃO
        include("components/navigation.php");
    ?>

    <main>
        <?php
        //INCLUI AS PÁGINAS RETORNADAS PELO OBTERROTA()
        incluirPagina($rota);
        ?>
    </main>

    <script>
        //METODO PARA ABRIR E FECHAR O MENU LATERAL
        function toggleNav(){
            const navegacao =document.querySelector('.navegacao');
            navegacao.classList.toggle('open');
        }
    </script>
</body>

</html>