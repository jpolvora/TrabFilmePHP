<?php
function redirect($extra) {
	$host = $_SERVER ['HTTP_HOST'];
	$uri = rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/\\' );
	Header ( "Location: http://$host$uri/$extra" );
}
function getnextid($tabela, $campo) {
	$sql = "SELECT $campo FROM $tabela ORDER BY $campo DESC LIMIT 0, 1";
	$result = mysql_query ( $sql );
	$row = mysql_fetch_row ( $result );
	$id = $row [0];
	return $id + 1;
}
function mysql_insert($table, $registro) {
	$values = array_map ( 'mysql_real_escape_string', array_values ( $registro ) );
	$keys = array_keys ( $registro );
	
	return mysql_query ( 'INSERT INTO `' . $table . '` (`' . implode ( '`,`', $keys ) . '`) VALUES (\'' . implode ( '\',\'', $values ) . '\')' );
}
function hasError($required) {
	$error = false;
	foreach ( $required as $field ) {
		if (empty ( $_POST [$field] )) {
			$error = true;
		}
	}
	return $error;
}
function validaGenero($edicao) {
	$required = array (
			'descricao' 
	);
	
	$erro = hasError ( $required );
	
	if ($erro) {
		return "Preencha todos os campos!";
	} else {
		if ($edicao == true) {
			return true;
		} else {
			$sql = "SELECT COUNT(*) FROM GENERO WHERE DESCRICAO = '" . $_POST ['descricao'] . "'";
			$result = mysql_query ( $sql );
			$row = mysql_fetch_row ( $result );
			if ($row [0] > 0) {
				return "Genero ja existe !!!";
			}
		}
	}
	
	return true;
}
function validaFilme($edicao) {
	$required = array (
			'Nome',
			'idGenero',
			'AnoLancamento',
			'Duracao' 
	);
	
	$erro = hasError ( $required );
	
	if ($erro) {
		return "Preencha todos os campos!";
	} else {
		
		$ano = $_POST ['AnoLancamento'];
		$duracao = $_POST ['Duracao'];
		
		if ($ano <= 1900 or $ano >= 2100)
			return "Ano deve ser preenchido com um valor entre 1900 e 2100";
		
		if ($duracao <= 0)
			return "Duracao deve ser preenchido com um valor maior que zero";		
		
		if ($edicao == true) {
			return true;
		} else {
			$sql = "SELECT COUNT(*) FROM Filme WHERE Nome = '" . $_POST ['Nome'] . "'";
			$result = mysql_query ( $sql );
			$row = mysql_fetch_row ( $result );
			if ($row [0] > 0) {
				return "Filme ja existe !!!";
			}
		}
	}	
	
	return true;
}
?>