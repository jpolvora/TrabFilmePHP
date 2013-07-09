<?php
include 'layout_topo.inc.php';
include_once 'conecta.inc.php';
include_once 'utils.inc.php';
$msgValidacao = '';
$edicao = false;
$data = array (
		'idGenero' => 0,
		'descricao' => '' 
);

if ($_SERVER ['REQUEST_METHOD'] === 'GET') {
	if (isset ( $_GET ['id'] )) {
		$id = $_GET ['id'];
		$edicao = true;
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
		$edicao = false;
		$data ['idGenero'] = getnextid ( 'genero', 'idGenero' );
	}
} else if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
	$edicao = $_POST ['edicao'];
	$data ['idGenero'] = $_POST ['idGenero'];
	$data ['descricao'] = $_POST ['descricao'];
	
	$valido = validaGenero ( $edicao );
	if ($valido === true) {
		if ($edicao == true) {
			
			$updateSql = "UPDATE genero SET descricao = '" . $data ['descricao'] . "' where idGenero = " . $data ['idGenero'];
			if (mysql_query ( $updateSql )) {
				redirect ( 'generos.php' );
				exit ();
			} else {
				echo mysql_error ();
			}
		} else {
			$data ['idGenero'] = getnextid ( 'genero', 'idGenero' );
			
			$registro = array (
					'idGenero' => $data ['idGenero'],
					'descricao' => $data ['descricao'] 
			);
			
			if (mysql_insert ( 'GENERO', $registro )) {
				redirect ( 'generos.php' );
				exit ();
			} else {
				echo mysql_error ();
			}
		}
	} else {
		$msgValidacao = $valido;
	}
}
?>

<h2>Dados do Genero</h2>

<form
	action="<?=htmlentities($_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'])?>"
	method="post">
	<input id="edicao" name="edicao" type="hidden"
		value="<?=$edicao == true ? 1: 0?>" />


	<fieldset>
		<legend>genero</legend>

		<div class="editor-label">
			<label for="idGenero">Id</label>
		</div>
		<div class="editor-field">
			<input class="text-box single-line" id="idGenero" name="idGenero"
				type="text" readonly="readonly" value="<?=$data['idGenero']?>" />
		</div>

		<div class="editor-label">
			<label for="descricao">Descricao</label>
		</div>
		<div class="editor-field">
			<input class="text-box single-line" id="descricao" name="descricao"
				type="text" value="<?=$data['descricao']?>" />
		</div>
		<div><?=$msgValidacao?></div>

		<p>
			<input type="submit" value="Enviar" />
		</p>
	</fieldset>
</form>
<div>
	<a href="generos.php">Voltar</a>
</div>

<?php include 'layout_rodape.inc.php'; ?>