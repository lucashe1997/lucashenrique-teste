<?php

$servidor = 'localhost';
$usuario = 'empresa';
$senha = 'empresa';
$banco = 'SENHA';

setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
date_default_timezone_set('America/Sao_Paulo');

// Conecta-se ao banco de dados MySQL
//$mysqli = new mysqli($servidor, $usuario, $senha, $banco);
$con=mysqli_connect($servidor,$usuario,$senha,$banco);

// Caso algo tenha dado errado, exibe uma mensagem de erro
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
?>