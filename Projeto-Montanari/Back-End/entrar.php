<?php
include("conexao.php");
session_start();

$email = $_POST["email"];
$senha = $_POST["senha"];

$busca = mysqli_query($conexao, "SELECT id FROM usuarios WHERE email = '$email' AND senha = '$senha'");

if(mysqli_num_rows($busca) == 0){
    header("Location: ../Paginas/entrada.php?mensagem='Usuário ou Senha Inválidos'");
    mysqli_close($conexao);
    exit;
}
$_SESSION["id"] = mysqli_fetch_row($busca)[0];
header("Location: ../Paginas/home.php");
mysqli_close($conexao);
exit;
?>