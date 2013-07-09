<?php
$servidor = 'localhost:3306';
$usuario = 'root';
$senha = '3306';
$banco = 'TrabFilme';

$link = @mysql_connect ( $servidor, $usuario, $senha );
@mysql_select_db ( $banco, $link );
?>