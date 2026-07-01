<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$nomeBanco = "wisdom_porch";

$conexao = new mysqli($servidor, $usuario, $senha, $nomeBanco);

if ($conexao->connect_error) {
    die("Falha ao se conectar ao banco de dados: " . $conexao->connect_error);
}
