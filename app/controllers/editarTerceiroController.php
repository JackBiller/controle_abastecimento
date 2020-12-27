<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

// funções da unidade consumidora
$cont = 0;
$id_terceiros = $_REQUEST['id_terceiros'];

$sql = "SELECT * FROM `terceiros` WHERE id_terceiros = ".$id_terceiros;
$verifica = $pdo->query($sql);
foreach ($verifica as $dados) {
	echo 	$dados[0].",,".
			$dados[1];
}
?>