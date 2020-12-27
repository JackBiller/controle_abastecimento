<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

// funções da unidade consumidora
$cont = 0;
$id_proprietario = $_REQUEST['id_proprietario'];

$sql = "SELECT * FROM `proprietario` WHERE id_proprietario = ".$id_proprietario;
$verifica = $pdo->query($sql);
foreach ($verifica as $dados) {
	echo 	$dados[0].",,".
			$dados[1];
}
?>