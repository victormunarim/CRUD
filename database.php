<?php

try {
    $conexao = new mysqli("localhost", "root", "", "empresa");
} catch(exception $e){
    echo $e;
}