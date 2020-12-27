<?php 
	require_once "../class/entidade/Usuario.php";
	require_once "../class/dao/usuarioDAO.php";

	$entidadeUsuario = new Usuario();
	$usuarioDAO = new usuarioDAO();

	$entidadeUsuario->set($_REQUEST['nome']		, 'nome');
	$entidadeUsuario->set($_REQUEST['login']	, 'login');
	$entidadeUsuario->set($_REQUEST['senha']	, 'senha');

	$retorno = $usuarioDAO->cadastraUsuario($entidadeUsuario);
	echo $retorno;
 ?>