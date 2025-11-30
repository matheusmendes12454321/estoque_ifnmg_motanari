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
$busca = mysqli_query($conexao, "SELECT quantidade FROM produtos WHERE usuario_id = '$id' AND codigo = '$codigo'");
if(!$busca){
    header("Location: ../Paginas/home.php?mensagem='Produto não encontrado'");
    mysqli_close($conexao);
    exit;
}
$quantidade_inicial = mysqli_fetch_row($busca)[0];
$quantidade = $_POST['quantidade'];
$qtd_final = 0;
$metodo;

if(isset($_POST['comprar'])){
    $qtd_final = $quantidade + $quantidade_inicial;
    $metodo = "comprar";
}
elseif(isset($_POST['vender'])){
    $qtd_final = $quantidade_inicial - $quantidade;
    $metodo = "vender";
}


$acao = mysqli_query($conexao, "UPDATE produtos SET quantidade = $qtd_final WHERE usuario_id = '$id' AND codigo = '$codigo'");

if(!$acao){
    header("Location: ../Paginas/home.php?mensagem='Erro ao $metodo Produto'");
    mysqli_close($conexao);
    exit;
}

header("Location: ../Paginas/home.php?mensagem='Produto Atualizado com Sucesso'&tipo=success");
mysqli_close($conexao);
exit;
?>