<?php
include 'layout_topo.inc.php';
include_once 'conecta.inc.php';
include_once 'utils.inc.php';
$data = array (
		'idGenero' => 0,
		'descricao' => '' 
);

if ($_SERVER ['REQUEST_METHOD'] === 'GET') {
	if (isset ( $_GET ['id'] )) {
		$id = $_GET ['id'];
		$sql = "select idGenero, descricao from genero where idGenero = " . $id;
		$result = mysql_query ( $sql );
		$row = mysql_fetch_row ( $result );
		if ($row) {
			$data ['idGenero'] = $row [0];
			$data ['descricao'] = $row [1];
		} else {
			// id nao encontrado
			redirect ( 'generos.php' );
			exit ();
		}
	} else {
		// NAO VEIO O ID
		redirect ( 'generos.php' );
		exit ();
	}
} else if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
	$data ['idGenero'] = $_POST ['idGenero'];
	
	$updateSql = "DELETE FROM GENERO WHERE idGenero = " . $data ['idGenero'];
	if (mysql_query ( $updateSql )) {
		redirect ( 'generos.php' );
		exit ();
	} else {
		echo mysql_error ();
	}
}
?>

<h2>Exclusao</h2>

<h3>Confirma a exclusao deste genero ?</h3>
<fieldset>
	<legend>Dados do Genero</legend>
	<div class="display-label">Id</div>
	<div class="display-field"><?=$data['idGenero'] ?></div>

	<div class="display-label">Descricao</div>
	<div class="display-field"><?=$data['descricao'] ?></div>
</fieldset>
<form
	action="<?=htmlentities($_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'])?>"
	method="post">
	<input type="hidden" id="idGenero" name="idGenero"
		value="<?=$data['idGenero']?>" />
	<p>
		<input type="submit" /> | <a href="generos.php">Cancelar</a>
	</p>
</form>
<?php include 'layout_rodape.inc.php'; ?>