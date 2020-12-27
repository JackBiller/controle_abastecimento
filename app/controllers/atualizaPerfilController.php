<?php 
	require_once "../class/entidade/Usuario.php";
	require_once "../class/dao/usuarioDAO.php";

	$entidadeUsuario = new Usuario();
	$usuarioDAO = new usuarioDAO();

	$entidadeUsuario->set($_REQUEST['nome']	, 'nome');

	$retorno = $usuarioDAO->atualizaUsuario($entidadeUsuario, $_REQUEST['id_usuario']);

	echo $retorno;
 ?>