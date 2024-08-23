<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header('Location: index.php');
    exit;
}
?>