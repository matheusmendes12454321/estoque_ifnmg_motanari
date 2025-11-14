<?php
session_start();
if (isset($_SESSION["id"])){
    header("Location: ./inicio.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Estoque</title>
</head>
<body>
    <h1>Bem vindo ao nosso sistema de estoque</h1>
    <a href="./Paginas/cadastro.html">Cadastre sua empresa</a>
    <a href="./Paginas/entrar.html">Entre Aqui</a>
</body>
</html>