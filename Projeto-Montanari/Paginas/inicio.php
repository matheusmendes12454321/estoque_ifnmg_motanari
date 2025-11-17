<?php
include("../Back-End/conexao.php");
session_start();

if(!isset($_SESSION["id"]) || $_SESSION["id"] == "") {
    die("Usuario Não Encontrado");
}

$id = $_SESSION["id"];
$busca = mysqli_query($conexao, "SELECT * FROM a WHERE id = '$id'");

if(mysqli_num_rows($busca) == 0) {
    die("Usuario Não Encontrado (2)");
}

$informacoes = mysqli_fetch_assoc($busca);
$nome_empresa = $informacoes["nome"];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <div id="Saida">
        
    </div>
</body>
</html>