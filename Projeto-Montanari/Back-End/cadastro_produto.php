<?php
include("conexao.php");
session_start();

if (!isset($_SESSION["id"]) || $_SESSION["id"] == "") {
    header("Location: ../Paginas/entrada.php?mensagem='Usuário Não Encontrado'");
    mysqli_close($conexao);
    exit;
}

$id = $_SESSION["id"];
$codigo = $_POST["codigo"];
$nome_produto = $_POST["nome_produto"];
$categoria = $_POST["categoria"];
$quantidade = $_POST["quantidade"];
$estoque_minimo = $_POST["estoque_minimo"];
$preco = $_POST["preco"];

$busca = mysqli_query($conexao, "SELECT * FROM produtos WHERE codigo = '$codigo'");

if(mysqli_num_rows($busca) > 0){
    header("Location: ../Paginas/home.php?mensagem='Produto Ja Cadastrado'");
    mysqli_close($conexao);
    exit;
}

$insert = mysqli_query($conexao, "INSERT INTO produtos (codigo, usuario_id, nome, quantidade, preco, estoque_minimo, categoria) VALUES ('$codigo', '$id', '$nome_produto', '$quantidade', '$preco', '$estoque_minimo', '$categoria')");
if (!$insert) {
    header("Location: ../Paginas/home.php?mensagem='Erro ao Cadastrar Produto'");
    mysqli_close($conexao);
    exit;
}

header("Location: ../Paginas/home.php?mensagem=Produto Cadastrado com sucesso & tipo=success");
mysqli_close($conexao);
exit;
?>