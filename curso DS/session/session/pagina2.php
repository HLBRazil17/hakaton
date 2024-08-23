<?php require('check.php');?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina 2</title>
</head>
<body>
    <?php echo $_SESSION['idUsuario']; ?>
    <p>Essa é a pagina 2</p>
    <a href=dashboard.php>Voltar para a Dashboard</a>
</body>
</html>