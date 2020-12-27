<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

// funções da unidade consumidora
$cont = 0;
$id_entrada = $_REQUEST['id_entrada'];

$sql = "SELECT * FROM `entrada` WHERE id_entrada = ".$id_entrada;
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