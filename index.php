<?php

//OBTÉM A ROTA DA URL
function obterRota()
{
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $rota = explode("/", trim($url, '/'));

    //DEFINE A ROTA PADRÃO CASO ESTIVER VAZIA
    if (empty($rota[0])) {
        $rota[0] = 'gerenciamento-alunos';
    }

    return $rota[0];
}

//INCLUI AS PÁGINAS RETORNADAS PELO OBTERROTA()
function incluirPagina($pagina)
{
    $arquivoPagina = "pages/{$pagina}.html";

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
    <link rel="stylesheet" href="/pages/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body>
    <nav>
        <ul>
            <li class="cadastro">
                <a href="/cadastro-aluno">
                    Cadastrar de Aluno
                    <span class="material-symbols-outlined">
                        add
                    </span>
                </a>
            </li>
            <li><a href="/">Gerenciamento de Alunos</a></li>
            <li><a href="/envio-curriculo">Envio Curriculo</a></li>
        </ul>
    </nav>

    <main>
        <?php
        incluirPagina($rota);
        ?>
    </main>
<!-- 
    <footer>
        footer
    </footer> -->
</body>

</html>