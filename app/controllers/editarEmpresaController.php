<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

// funções da unidade consumidora
$cont = 0;
$id_empresa = $_REQUEST['id_empresa'];

$sql = "SELECT * FROM `empresa` WHERE id_empresa = ".$id_empresa;
$verifica = $pdo->query($sql);
foreach ($verifica as $dados) {
	echo 	$dados[0] .",,".
			$dados[1] .",,".
			$dados[2] .",,".
			$dados[3] .",,".
			$dados[4] .",,".
			$dados[5] .",,".
			$dados[6] .",,".
			$dados[7] .",,".
			$dados[8] .",,".
			$dados[9] .",,".
			$dados[10];
}
?>