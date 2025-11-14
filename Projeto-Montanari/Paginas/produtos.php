<?php
include("../Back-End/conexao.php");
session_start();

if(isset($_SESSION["id"]) || $_SESSION["id"] == "") {
    die("Usuario Não Encontrado");
}

$id = $_SESSION["id"];
$busca = mysqli_query($conexao, "SELECT * FROM a WHERE id = '$id'");

if(mysqli_num_rows($busca) == 0) {
    die("Usuario Não Encontrado (2)");
}

$informacoes = mysqli_fetch_assoc($busca);
$nome_empresa = $informacoes["nome"];

$produtos = mysqli_query($conexao,"SELECT * FROM produtos WHERE id_empresa = '$id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>PREÇO</th>
                <th>QUANTIDADE</th>
            </tr>
        </thead>
        <?php
        while($linha = mysqli_fetch_assoc($produtos)) {
            printf($linha);
        }
        ?>
        <tbody>
        </tbody>
    </table>
</body>
</html>