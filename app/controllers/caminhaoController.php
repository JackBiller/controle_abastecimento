<?php 
	require_once "../class/entidade/Caminhao.php";
	require_once "../class/dao/caminhaoDAO.php";

	$entidadeCaminhao = new Caminhao();
	$caminhaoDAO = new caminhaoDAO();

	$entidadeCaminhao->set($_REQUEST['placa']  			, 'placa');
	$entidadeCaminhao->set($_REQUEST['cor_id'] 			, 'cor_id');
	$entidadeCaminhao->set($_REQUEST['proprietario_id'] , 'proprietario_id');
	$entidadeCaminhao->set($_REQUEST['marca_id']		, 'marca_id');
	$entidadeCaminhao->set($_REQUEST['vin_media']		, 'vin_media');

	$retorno = $caminhaoDAO->cadastraCaminhao($entidadeCaminhao);
	echo $retorno;
 ?>