<?php
require_once "../class/conexao.php";

//pegar dados do formulario
$usuario = (trim($_POST['login']));
$senha = (trim($_POST['senha']));

$conn = new Conexao();
$pdo = $conn->Connect();

$paran = array(
	':usuario'=>$usuario = ($_POST['login']),
	':senha'=>$senha = ($_POST['senha'])
	);

$sql = "SELECT * FROM usuario WHERE login = :usuario AND senha = password(:senha) LIMIT 1";

$verifica = $pdo->prepare($sql);
$verifica->execute($paran);

if ($verifica->rowCount() != 0) {
	$sql = "SELECT * FROM usuario WHERE login = '".$usuario."' AND senha = password('".$senha."') LIMIT 1";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		echo "

		<div class='row'>
			<div class-'col-md-12 text-center'>
				<center>
				<i class=\"fa fa-user-circle\" aria-hidden=\"true\" style='opacity: 0;'></i>
				<i class=\"fa fa-user-circle\" aria-hidden=\"true\"></i>&nbsp;".
				$dados["nome"]."&nbsp;
				</center>
				<input type=\"hidden\" id=\"id_usuario\" value=\"".$dados["id_usuario"]."\">
				<input type=\"hidden\" id=\"pwd\" value=\"".$dados["senha"]."\">
			</div>
			<div class='col-md-12'>
				<a type=\"button\" style=\"margin-right: 10px;\" class=\"btn btn-warning btn-block\" onclick=\"deslogar()\" href=\"#!home\">
					Sair
				</a>
			</div>
		</div>
		



		,/,".$dados["nivel"];
	}
}
else{
	echo "0";
}
?>