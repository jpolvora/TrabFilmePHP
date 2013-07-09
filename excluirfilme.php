<?php
include 'layout_topo.inc.php';
include_once 'conecta.inc.php';
include_once 'utils.inc.php';
$data = array (
		'idFilme' => 0,
		'Nome' => '',
		'idGenero' => 0,
		'AnoLancamento' => 0,
		'Duracao' => 0,
		'genero' => '' 
);

if ($_SERVER ['REQUEST_METHOD'] === 'GET') {
	if (isset ( $_GET ['id'] )) {
		$id = $_GET ['id'];
		$sql = "SELECT F.idFilme, F.Nome, F.idGenero, F.AnoLancamento, F.Duracao, G.Descricao as genero FROM filme F LEFT JOIN genero G on f.idGenero = g.idGenero where idFilme = " . $id;
		$result = mysql_query ( $sql );
		$row = mysql_fetch_row ( $result );
		if ($row) {
			$data ['idFilme'] = $row [0];
			$data ['Nome'] = $row [1];
			$data ['idGenero'] = $row [2];
			$data ['AnoLancamento'] = $row [3];
			$data ['Duracao'] = $row [4];
			$data ['genero'] = $row [5];
		} else {
			// id nao encontrado
			redirect ( 'filmes.php' );
			exit ();
		}
	} else {
		// NAO VEIO O ID
		redirect ( 'filmes.php' );
		exit ();
	}
} else if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
	$data ['idFilme'] = $_POST ['idFilme'];
	
	$updateSql = "DELETE FROM filme WHERE idFilme = " . $data ['idFilme'];
	if (mysql_query ( $updateSql )) {
		redirect ( 'filmes.php' );
		exit ();
	} else {
		echo mysql_error ();
	}
}
?>

<h2>Exclusao</h2>

<h3>Confirma a exclusao deste filme ?</h3>
<fieldset>
	<legend>Dados do Filme</legend>
	<div class="display-label">Id</div>
	<div class="display-field"><?=$data['idFilme'] ?></div>

	<div class="display-label">Nome</div>
	<div class="display-field"><?=$data['Nome'] ?></div>

	<div class="display-label">Genero</div>
	<div class="display-field"><?=$data['genero'] ?></div>

	<div class="display-label">AnoLancamento</div>
	<div class="display-field"><?=$data['AnoLancamento'] ?></div>

	<div class="display-label">Duracao</div>
	<div class="display-field"><?=$data['Duracao'] ?></div>
</fieldset>
<form
	action="<?=htmlentities($_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'])?>"
	method="post">

	<input type="hidden" id="idFilme" name="idFilme"
		value="<?=$data['idFilme']?>" />

	<p>
		<input type="submit" /> | <a href="filmes.php">Cancelar</a>
	</p>
</form>

<?php include 'layout_rodape.inc.php'; ?>