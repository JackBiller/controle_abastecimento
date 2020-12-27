<?php 
	require_once "../class/entidade/Entrada.php";
	require_once "../class/dao/entradaDAO.php";

	$entidadeEntrada = new Entrada();
	$entradaDAO = new entradaDAO();

	$entidadeEntrada->set($_REQUEST['id_usuario'] , 'usuario_id');
	$entidadeEntrada->set($_REQUEST['bomba_id'] , 'bomba_id');
	$entidadeEntrada->set($_REQUEST['empresa_id'] , 'empresa_id');
	$entidadeEntrada->set($_REQUEST['num_nfe'] , 'num_nfe');
	$entidadeEntrada->set($_REQUEST['data_entrada'] , 'data_entrada');
	$entidadeEntrada->set($_REQUEST['mes'] , 'mes');
	$entidadeEntrada->set($_REQUEST['ano'] , 'ano');
	$entidadeEntrada->set($_REQUEST['qtd_litros'] , 'qtd_litros');
	$entidadeEntrada->set($_REQUEST['vlr_unit'] , 'vlr_unit');
	$entidadeEntrada->set($_REQUEST['total'] , 'total');

	$retorno = $entradaDAO->cadastraEntrada($entidadeEntrada);
	echo $retorno;
 ?>