<?php
// Função para obter a rota da URL
function obterRota() {
    $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $rota = explode("/", trim($urlPath, '/'));

    // Define a rota 'home' se estiver vazia
    if (empty($rota[0])) {
        $rota[0] = 'home';
    }

    return $rota[0];
}

// Função para incluir a página correspondente
function incluirPagina($pagina) {
    $arquivoPagina = "pages/{$pagina}.html";

    // Verifica se o arquivo da página existe
    if (file_exists($arquivoPagina)) {
        include $arquivoPagina;
    } else {
        // Exibe uma mensagem de erro se a página não for encontrada
        echo "Página não encontrada.";
    }
}

// Execução principal
$rota = obterRota();
$tituloPagina = ucfirst(str_replace('-', ' ', $rota)); // Define o título da página
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($tituloPagina); ?></title>
</head>

<body>
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/sobre-nos">Sobre nós</a></li>
            <li><a href="/sobre-nos">Sobre nós</a></li>
            
        </ul>
    </nav>

    <main>
        <?php incluirPagina($rota); ?>
    </main>
    <footer>
        footer
    </footer>
</body>

</html>


