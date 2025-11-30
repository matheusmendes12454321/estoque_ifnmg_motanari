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
$old_codigo = $_POST["old_codigo"];
$nome_produto = $_POST["nome_produto"];
$categoria = $_POST["categoria"];
$quantidade = $_POST["quantidade"];
$estoque_minimo = $_POST["estoque_minimo"];
$preco = $_POST["preco"];

$acao = mysqli_query($conexao, "UPDATE produtos SET codigo='$codigo', nome='$nome_produto', quantidade='$quantidade', preco='$preco', estoque_minimo='$estoque_minimo', categoria='$categoria' WHERE usuario_id = '$id' AND codigo = '$old_codigo'");


if(!$acao){
    header("Location: ../Paginas/home.php?mensagem='Erro ao Deletar Produto'");
    mysqli_close($conexao);
    exit;
}

header("Location: ../Paginas/home.php?mensagem='Produto Atualizado com Sucesso'&tipo=success");
mysqli_close($conexao);
exit;
?>