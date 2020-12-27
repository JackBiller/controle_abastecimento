<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

// funções da unidade consumidora
$id_usuario = $_REQUEST['id_usuario'];

$sql = "SELECT * FROM `usuario` WHERE id_usuario = ".$id_usuario;
$verifica = $pdo->query($sql);
foreach ($verifica as $dados) {
	echo 	$dados[0] .",,".
			$dados[1];
}
?>