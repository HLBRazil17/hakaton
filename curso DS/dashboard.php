<?php require('check.php');?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard</title>
</head>
<body>
    <div>
        <p>Olá <?php echo $_SESSION['usuario']; ?>!</p>
        <p>Seu último login foi <?php echo $_SESSION['acesso']; ?></p>
        <a href="pagina2.php">Página 2</a>
        <a href="logout.php"><button>Deslogar</button></a>
    </div>
</body>
</html>