<?php

$servidor = "localhost";
$usuario  = "root";
$senha    = "";
$banco    = "testar";

// ======= CRIA A CONEXÃO =======
$conexao = new mysqli($servidor, $usuario, $senha, $banco);

// ======= VERIFICA A CONEXÃO =======
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

?>