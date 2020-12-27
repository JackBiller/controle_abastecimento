<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

$cont = 0;

$sql = "SELECT * FROM bomba;";
$verifica = $pdo->query($sql);
foreach ($verifica as $dados) {
	$cont++;
}
if ($cont != 0) {
	$verifica = $pdo->query($sql);
	echo "
		<table class='table'>
			<tr bgcolor='white'>
				<td><b>Descrição</b></td>
				<td><b>Volume Atual</b></td>
				<td><b>Volume Total</b></td>
				<td><b>Editar</b></td>
				<td><b>Excluir</b></td>
			</tr>
		";
	foreach ($verifica as $dados) {
		echo "
			<tr id='linha".$dados[0]."'>
				<td>".$dados[1]."</td>
				<td>".$dados[2]."</td>
				<td>".$dados[3]."</td>
				<td align='center'>
					<a href='#!editar_bomba' style='color: #f0ad4e;' data-id='".$dados[0]."' onclick='editar(this);' title='Editar'>
						<b><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></b>
					</a>
				</td>
				<td align='center'>
					<a href='#!bomba' style='color: red;' data-id='".$dados[0]."' onclick=\"excluir(this , 'bomba')\" title='Excluir'>
						<i class=\"fa fa-times\" aria-hidden=\"true\"></i>
					</a>
				</td>
			</tr>
		";
	}
	echo "</table>";
} else {
	echo "<h3>Nenhum cadastro encontrado</h3>";
}
?>