<?php 
	require_once "../class/entidade/Empresa.php";
	require_once "../class/dao/clienteEmpresaDAO.php";

	$entidadeEmpresa = new Empresa();
	$clienteEmpresaDAO = new clienteEmpresaDAO();

	$entidadeEmpresa->set($_REQUEST['nome'] 		, 'nome');
	$entidadeEmpresa->set($_REQUEST['reg_federal'] 	, 'reg_federal');
	$entidadeEmpresa->set($_REQUEST['reg_estadual']	, 'reg_estadual');
	$entidadeEmpresa->set($_REQUEST['cep']      	, 'cep');
	$entidadeEmpresa->set($_REQUEST['endereco']    	, 'endereco');
	$entidadeEmpresa->set($_REQUEST['numero']      	, 'numero');
	$entidadeEmpresa->set($_REQUEST['complemento'] 	, 'complemento');
	$entidadeEmpresa->set($_REQUEST['bairro']      	, 'bairro');
	$entidadeEmpresa->set($_REQUEST['cidade']      	, 'cidade');
	$entidadeEmpresa->set($_REQUEST['estado']      	, 'estado');

	$retorno = $clienteEmpresaDAO->atualizaEmpresa($entidadeEmpresa, $_REQUEST['id_empresa']);
	echo $retorno;
 ?>