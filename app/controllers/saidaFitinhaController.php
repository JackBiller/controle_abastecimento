<?php 
	require_once "../class/entidade/SaidaCupom.php";
	require_once "../class/dao/saidaCupomDAO.php";

	$entidadeSaidaCupom = new SaidaCupom();
	$saidaCupomDAO = new saidaCupomDAO();

if (!empty($_REQUEST['cadastraFitinha'])) {

	$entidadeSaidaCupom->set($_REQUEST['id_usuario'] , 'usuario_id');
	$entidadeSaidaCupom->set($_REQUEST['bomba_id'] , 'bomba_id');
	$entidadeSaidaCupom->set($_REQUEST['data_abastecimento'] , 'data_abastecimento');
	$entidadeSaidaCupom->set($_REQUEST['mes'] , 'mes');
	$entidadeSaidaCupom->set($_REQUEST['ano'] , 'ano');
	$entidadeSaidaCupom->set($_REQUEST['horas'] , 'horas');
	$entidadeSaidaCupom->set($_REQUEST['caminhao_id'] , 'caminhao_id');
	$entidadeSaidaCupom->set($_REQUEST['terceiros_id'] , 'terceiros_id');
	$entidadeSaidaCupom->set($_REQUEST['litros'] , 'litros');
	$entidadeSaidaCupom->set($_REQUEST['vlr_unit'] , 'vlr_unit');
	$entidadeSaidaCupom->set($_REQUEST['total'] , 'total');
	$entidadeSaidaCupom->set($_REQUEST['bool_cupom'] , 'bool_cupom');
	$entidadeSaidaCupom->set($_REQUEST['bool_fitinha'] , 'bool_fitinha');
	$entidadeSaidaCupom->set($_REQUEST['bool_acerto'] , 'bool_acerto');
	$entidadeSaidaCupom->set($_REQUEST['bool_placa_fit'] , 'bool_placa_fit');

	$retorno = $saidaCupomDAO->cadastraSaidaFitinha($entidadeSaidaCupom);
	echo $retorno;
}

if (!empty($_REQUEST['pendenteFitinha'])) {

	$entidadeSaidaCupom->set($_REQUEST['horas'] , 'horas');
	$entidadeSaidaCupom->set($_REQUEST['bool_fitinha'] , 'bool_fitinha');
	$entidadeSaidaCupom->set($_REQUEST['bool_placa_fit'] , 'bool_placa_fit');

	$retorno = $saidaCupomDAO->pendeciaSaidaFitinha($entidadeSaidaCupom, $_REQUEST['id_abastecimento']);
	echo $retorno;
}

?>