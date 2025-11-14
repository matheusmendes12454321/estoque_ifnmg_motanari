<?php
include("conexao.php");
session_start();

$nome_empresa = $_POST["nome"];
$email = $_POST["email"];
$senha = $_POST["senha"];

if(mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM a WHERE email = '$email'"))){
    die("Email já cadastrado");
}
$cadastro = mysqli_query($conexao, "INSERT INTO a(nome,email,senha) VALUES ('$nome_empresa', '$email', '$senha')");
$verificacao = mysqli_query($conexao, "SELECT id from a where email = '$email' AND senha = '$senha'");
if(!$cadastro || mysqli_num_rows($verificacao) == 0){
    die("<script>
    alert('Erro no Cadastro')
    window.location.href = '../Paginas/cadastro.html'
    </script>");
}

$_SESSION["id"] = mysqli_fetch_row($verificacao)[0];
header("Location: ../Paginas/inicio.php");

mysqli_close($conexao);
exit;
?>