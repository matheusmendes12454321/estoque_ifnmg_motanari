<?php
include("/Projeto-Montanari/Back-End/conexao.php");
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

$insert = mysqli_query($conexao, "INSERT INTO produtos (usuario_id, codigo, nome, quantidade, preco, estoque_minimo, categoria) VALUES ('$id', '$codigo', '$nome_produto', '$quantidade', '$preco', '$estoque_minimo', '$categoria')");
if ($insert) {
    header("Location: ../Paginas/home.php?mensagem='Erro ao Cadastrar Produto'");
    mysqli_close($conexao);
    exit;
}
?>