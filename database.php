<?php
$hostname = "localhost";
$bancodedados = "empresa";
$usuario = "root";
$senha = "";

// $mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);
// if ($mysqli->connect_errno) {
//     echo "falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
// }

$conexao = mysqli_connect($hostname, $usuario, $senha, $bancodedados);

if (!$conexao) {
    die("conexao falhou: " . mysqli_connect_error());
}
