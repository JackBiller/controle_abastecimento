<?php 
	require_once "../class/entidade/Terceiros.php";
	require_once "../class/dao/terceirosDAO.php";

	$entidadeTerceiros = new Terceiros();
	$terceirosDAO = new terceirosDAO();

	$entidadeTerceiros->set($_REQUEST['descricao'] , 'descricao');

	$retorno = $terceirosDAO->cadastraTerceiros($entidadeTerceiros);
	echo $retorno;
 ?>