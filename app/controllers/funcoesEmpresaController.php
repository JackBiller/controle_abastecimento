<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

$cont = 0;

$sql = "SELECT * FROM empresa;";
$verifica = $pdo->query($sql);
foreach ($verifica as $dados) {
	$cont++;
}
if ($cont != 0) {
	$verifica = $pdo->query($sql);
	echo "
		<table class='table'>
			<tr bgcolor='white'>
				<td><b>Nome Fantasia</b></td>
				<td><b>CNPJ</b></td>
				<td><b>Reg. Estadual</b></td>
				<td><b>Cidade</b></td>
				<td><b>Estado</b></td>
				<td><b>Editar</b></td>
				<td><b>Excluir</b></td>
			</tr>
		";
	foreach ($verifica as $dados) {
		echo "
			<tr id='linha".$dados[0]."'>
				<td>".$dados["nome"]."</td>
				<td>".$dados["reg_federal"]."</td>
				<td>".$dados["reg_estadual"]."</td>
				<td>".$dados["cidade"]."</td>
				";
		$sql = "SELECT * FROM estado WHERE id_estado = ".$dados["estado_id"].";";
		$verifica4 = $pdo->query($sql);
		foreach ($verifica4 as $dados4) {
			echo "<td>".$dados4["sigla"]."</td>";
		}
		echo "
				<td>
					<a href='#!editar_empresa' style='color: #f0ad4e;' data-id='".$dados[0]."' onclick='editar(this);' title='Editar'>
						<b><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></b>
					</a>
				</td>
				<td>
					<a href='#!empresas' style='color: red;' data-id='".$dados[0]."' onclick=\"excluir(this , 'empresa')\" title='Excluir'>
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