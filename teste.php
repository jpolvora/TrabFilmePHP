<?php
include_once 'conecta.inc.php';
if (! $link) {
	die ( '<br />Nao foi possível conectar: ' . mysql_error () );
}
echo '<br />Conexao bem sucedida com o banco de dados';

$con = mysql_select_db ( $banco );
if (! $con) {
	die ( '<br />Banco de dados nao encontrado: ' . mysql_error () );
}
echo '<br />Banco de dados selecionado com sucesso: ' . $banco;

mysql_close ( $link );
?>