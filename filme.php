<?php
include 'layout_topo.inc.php';
include_once 'conecta.inc.php';
include_once 'utils.inc.php';
$msgValidacao = '';
$edicao = false;
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
		$edicao = true;
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
		$edicao = false;
		$data ['idFilme'] = getnextid ( 'filme', 'idFilme' );
	}
} else if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
	$edicao = $_POST ['edicao'];
	$data ['idFilme'] = $_POST ['idFilme'];
	$data ['Nome'] = $_POST ['Nome'];
	$data ['idGenero'] = $_POST ['idGenero'];
	$data ['AnoLancamento'] = $_POST ['AnoLancamento'];
	$data ['Duracao'] = $_POST ['Duracao'];
	
	$valido = validaFilme ( $edicao );
	if ($valido === true) {
		if ($edicao == true) {
			
			$updateSql = "UPDATE FILME SET NOME = '" . $data ['Nome'] . "', idGenero = " . $data ["idGenero"] . ", AnoLancamento = " . $data ["AnoLancamento"] . ", Duracao = " . $data ["Duracao"] . " where idFilme = " . $data ['idFilme'];
			
			if (mysql_query ( $updateSql )) {
				redirect ( 'filmes.php' );
				exit ();
			} else {
				echo mysql_error ();
			}
		} else {
			$data ['idFilme'] = getnextid ( 'filme', 'idFilme' );
			
			$registro = array (
					'idFilme' => $data ['idFilme'],
					'Nome' => $data ['Nome'],
					'idGenero' => $data ['idGenero'],
					'AnoLancamento' => $data ['AnoLancamento'],
					'Duracao' => $data ['Duracao'] 
			);
			
			if (mysql_insert ( 'FILME', $registro )) {
				redirect ( 'filmes.php' );
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

<h2>Dados do Filme</h2>

<form
	action="<?=htmlentities($_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'])?>"
	method="post">

	<input id="edicao" name="edicao" type="hidden"
		value="<?=$edicao == true ? 1: 0?>" />

	<fieldset>
		<legend>filme</legend>

		<div class="editor-label">
			<label for="Nome">Id</label>
		</div>
		<div class="editor-field">
			<input data-val="true" id="idFilme" name="idFilme" type="text"
				readonly="readonly" value="<?=$data['idFilme']?>" />
		</div>

		<div class="editor-label">
			<label for="Nome">Nome</label>
		</div>
		<div class="editor-field">
			<input class="text-box single-line" data-val="true"
				data-val-length="O campo Nome deve ser uma cadeia de caracteres com um comprimento máximo de 45."
				data-val-length-max="45" id="Nome" name="Nome" type="text"
				value="<?=$data['Nome']?>" /> <span class="field-validation-valid"
				data-valmsg-for="Nome" data-valmsg-replace="true"></span>
		</div>

		<div class="editor-label">
			<label for="idGenero">Genero</label>
		</div>
		<div class="editor-field">
			<select id="idGenero" name="idGenero"><option value=""></option>
			<?php
			$resultGeneros = mysql_query ( "SELECT idGenero, descricao from Genero order by idGenero " );
			while ( $row = mysql_fetch_array ( $resultGeneros, MYSQL_ASSOC ) ) {
				?>
				<option
					<?= $data['idGenero'] == $row['idGenero'] ? 'selected="selected"' : ""?>
					value="<?=$row['idGenero']?>"><?=$row['descricao']?></option>
				<?php  }?>
			</select>
		</div>

		<div class="editor-label">
			<label for="AnoLancamento">Ano de Lancamento</label>
		</div>
		<div class="editor-field">
			<input class="text-box single-line" data-val="true"
				data-val-number="The field AnoLancamento must be a number."
				data-val-required="O campo AnoLancamento é obrigatório."
				id="AnoLancamento" name="AnoLancamento" type="number"
				value="<?=$data['AnoLancamento']?>" />

		</div>

		<div class="editor-label">
			<label for="Duracao">Duracao</label>
		</div>
		<div class="editor-field">
			<input class="text-box single-line" data-val="true"
				data-val-number="The field Duracao must be a number."
				data-val-required="O campo Duracao é obrigatório." id="Duracao"
				name="Duracao" type="number" value="<?=$data['Duracao']?>" />
		</div>

		<div><?=$msgValidacao?></div>

		<p>
			<input type="submit" value="Save" />
		</p>
	</fieldset>
</form>
<div>
	<a href="Filmes.php">Voltar</a>
</div>

<?php include 'layout_rodape.inc.php'; ?>