<?php
include 'layout_topo.inc.php';
include_once 'conecta.inc.php';
?>

<h2>Lista de Generos</h2>

<p>
	<a href="genero.php">Incluir Genero</a>
</p>
<table>
	<tr>
		<th>Id</th>
		<th>Descricao</th>
		<th>Opcoes</th>
	</tr>
	
	<?php
	$result = mysql_query ( "SELECT idGenero, descricao FROM genero" );
	
	while ( $row = mysql_fetch_array ( $result, MYSQL_ASSOC ) ) {
		?>
		<tr>
		<td><?=$row["idGenero"]?></td>
		<td><?=$row["descricao"]?></td>
		<td><a href="genero.php?id=<?=$row["idGenero"]?>">Alterar</a> |
			<a href="excluirgenero.php?id=<?=$row["idGenero"]?>">Excluir</a></td>
	</tr>
		<?php  }?>
	<?php
	mysql_free_result ( $result );
	?>
</table>
<?php include 'layout_rodape.inc.php'; ?>