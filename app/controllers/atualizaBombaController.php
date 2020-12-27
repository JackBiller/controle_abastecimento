<?php 
	require_once "../class/entidade/Bomba.php";
	require_once "../class/dao/bombaDAO.php";

	$entidadeBomba = new Bomba();
	$bombaDAO = new bombaDAO();

	$entidadeBomba->set($_REQUEST['descricao'] , 'descricao');
	$entidadeBomba->set($_REQUEST['volume_atual'] , 'volume_atual');
	$entidadeBomba->set($_REQUEST['volume_total'] , 'volume_total');

	$retorno = $bombaDAO->atualizaBomba($entidadeBomba, $_REQUEST['id_bomba']);
	echo $retorno;
 ?>