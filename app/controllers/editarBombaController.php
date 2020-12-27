<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

// funções da unidade consumidora
$cont = 0;
$id_bomba = $_REQUEST['id_bomba'];

$sql = "SELECT * FROM `bomba` WHERE id_bomba = ".$id_bomba;
$verifica = $pdo->query($sql);
foreach ($verifica as $dados) {
	echo 	$dados[0].",,".
			$dados[1].",,".
			$dados[2].",,".
			$dados[3];
}
?>