<?php
include("conexao.php");
session_start();

$codigo = $_POST['codigo'];

$acao = mysqli_query($conexao, "DELETE FROM produtos WHERE codigo = '$codigo'");
if(!$acao){
    header("Location: ../Paginas/home.php?mensagem='Erro ao Deletar Produto'");
    mysqli_close($conexao);
    exit;
}

header("Location: ../Paginas/home.php?mensagem='Produto Deletado com Sucesso'&tipo=success");
mysqli_close($conexao);
exit;
?>