<?php
include("conexao.php");
session_start();

$nome_empresa = $_POST["nome"];
$email = $_POST["email"];
$senha = $_POST["senha"];


if(mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM usuarios WHERE email = '$email'")) > 0){
    header("Location: ../Paginas/entrada.php?mensagem='Usuário Já Cadastrado'");
    mysqli_close($conexao);
    exit;
}

$cadastro = mysqli_query($conexao, "INSERT INTO usuarios(nome, email, senha) VALUES ('$nome_empresa', '$email', '$senha')");
$verificacao = mysqli_query($conexao, "SELECT id from usuarios where email = '$email' AND senha = '$senha'");
if(!$cadastro || mysqli_num_rows($verificacao) == 0){
    header("Location: ../Paginas/entrada.php?mensagem='Erro no Cadastro'");
    mysqli_close($conexao);
    exit;
}

$_SESSION["id"] = mysqli_fetch_row($verificacao)[0];
header("Location: ../Paginas/home.php");

mysqli_close($conexao);
exit;
?>