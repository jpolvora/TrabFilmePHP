<?php
include 'layout_topo.inc.php';
include_once 'conecta.inc.php';
?>

<h2>Lista de Filmes</h2>

<p>
	<a href="filme.php">Incluir Fime</a>
</p>
<table>
	<tr>
		<th>Id</th>
		<th>Nome</th>
		<th>descricao</th>
		<th>AnoLancamento</th>
		<th>Duracao</th>
		<th></th>
	</tr>
	
	<?php
	$result = mysql_query ( "SELECT F.*, G.Descricao as genero FROM filme F LEFT JOIN genero G on f.idGenero = g.idGenero order by idFilme" );
	
	while ( $row = mysql_fetch_array ( $result, MYSQL_ASSOC ) ) {
		?>
		<tr>
		<td><?=$row["idFilme"]?></td>
		<td><?=$row["Nome"]?></td>
		<td><?=$row["genero"]?></td>
		<td><?=$row["AnoLancamento"]?></td>
		<td><?=$row["Duracao"]?></td>
		<td><a href="filme.php?id=<?=$row["idFilme"]?>">Alterar</a> | <a
			href="excluirfilme.php?id=<?=$row["idFilme"]?>">Excluir</a></td>
	</tr>
		<?php  }?>
	<?php
	mysql_free_result ( $result );
	?>
</table>

<?php include 'layout_rodape.inc.php'; ?>
