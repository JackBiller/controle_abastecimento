<?php 
	require_once "../class/entidade/Proprietario.php";
	require_once "../class/dao/proprietarioDAO.php";

	$entidadeProprietario = new Proprietario();
	$proprietarioDAO = new proprietarioDAO();

	$entidadeProprietario->set($_REQUEST['descricao'] , 'descricao');

	$retorno = $proprietarioDAO->atualizaProprietario($entidadeProprietario, $_REQUEST['id_proprietario']);
	echo $retorno;
 ?>