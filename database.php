<?php
$hostname = "localhost";
$bancodedados = "empresa";
$usuario = "root";
$senha = "";

$conexao = mysqli_connect($hostname, $usuario, $senha, $bancodedados);

if (!$conexao) {
    die("conexao falhou: " . mysqli_connect_error());
}
