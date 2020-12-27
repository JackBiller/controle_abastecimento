<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

// funções da unidade consumidora
$cont = 0;
$id_caminhao = $_REQUEST['id_caminhao'];

$sql = "SELECT * FROM `caminhao` WHERE id_caminhao = ".$id_caminhao;
$verifica = $pdo->query($sql);
foreach ($verifica as $dados) {
	echo 	$dados[0].",,".
			$dados[1].",,".
			$dados[2].",,".
			$dados[3].",,".
			$dados[4].",,".
			$dados[5];
}
?>