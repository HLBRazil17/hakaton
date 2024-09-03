<?php

//OBTÉM A ROTA DA URL
function obterRota()
{
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $rota = explode("/", trim($url, '/'));

    //DEFINE A ROTA PADRÃO CASO ESTIVER VAZIA
    if (empty($rota[0])) {
        $rota[0] = 'home';
    }

    //RETORNA A ROTA
    return $rota[0];
}

//INCLUI AS PÁGINAS RETORNADAS PELO OBTERROTA()
function incluirPagina($pagina)
{

    //DEFINE O CAMINHO DO ARQUIVO DA PÁGINA A SER RENDERIZADA
    $arquivoPagina = "components/pages/{$pagina}.php";

    //VERIFICA SE O ARQUIVO DA PÁGINA NÃO EXISTE
    if (!file_exists($arquivoPagina)) {
        echo "Página não encontrada.";
        return;
    }

    //RENDERIZA A PÁGINA
    include $arquivoPagina;
}

//EXECUTA A FUNÇÃO OBTERROTA()
$rota = obterRota();

//DEFINE O TITULO DA PÁGINA
$tituloPagina = ucfirst(str_replace('-', ' ', $rota));

// Define as classes ativas para os links de navegação
function getActiveClass($page) {
    global $rota;
    return $rota === $page ? 'text-primary' : 'text-white';
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($tituloPagina); ?></title>
    <link rel="shortcut icon" href="components/assets/icon.jpeg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="components/css/estilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <?php 
    
    //INCLUI O COMPONENTE DO CABEÇALHO
    include("components/header.php");
    ?>

    <main style="flex: 1;">
        <?php
        //INCLUI AS PÁGINAS RETORNADAS PELO OBTER ROTA()
        incluirPagina($rota);
        ?>
    </main>

    <?php
    //INCLUI O COMPONENTE DO FOOTER
    include("components/footer.php");
    ?>

    <script>
        //METODO PARA ABRIR E FECHAR O MENU LATERAL
        function toggleNav() {
            const navegacao = document.querySelector('.navegacao');
            navegacao.classList.toggle('open');
        }

        //FUNÇÃO QUE EXIBE UM AVISO PARA O USUÁRIO
        function mostrarAviso(mensagem, tipo = 'info') {
            const mensagensAviso = document.querySelector('#mensagensAviso');
            mensagensAviso.innerHTML = `<div class="aviso ${tipo}">${mensagem}</div>`;
            setTimeout(() => {
                mensagensAviso.innerHTML = ``;
            }, 15000);
        }
    </script>
</body>

</html>
