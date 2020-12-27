<?php
require_once "../class/conexao.php";

//pegar dados do formulario
$id = $_POST['id_usuario'];
$senha = $_POST['senha'];

$conn = new Conexao();
$pdo = $conn->Connect();

$sql = "SELECT * FROM usuario WHERE id_usuario = ".$id." AND senha = '".$senha."' LIMIT 1";

$verifica = $pdo->prepare($sql);
$verifica->execute();

if ($verifica->rowCount() != 0) {
	echo "1";
}
else{
	echo "0";
}
?>