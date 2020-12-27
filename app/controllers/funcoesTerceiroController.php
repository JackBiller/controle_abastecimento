<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

// funções da cia de energia
if (!empty($_REQUEST['pesquisa_caminhao'])) {
	$cont = 0;

	$sql = "SELECT * FROM terceiros ORDER BY descricao ASC;";
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
					<td><b>Editar</b></td>
					<td><b>Excluir</b></td>
				</tr>
			";
		foreach ($verifica as $dados) {
			echo "
				<tr id='linha".$dados[0]."'>
					<td>".$dados["descricao"]."</td>
					<td>
						<a href='#!editar_terceiros' style='color: #f0ad4e;' data-id='".$dados[0]."' onclick='editar(this);' title='Editar'>
							<b><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></b>
						</a>
					</td>
					<td>
						<a href='#!terceiros' style='color: red;' data-id='".$dados[0]."' onclick=\"excluir(this , 'terceiros')\" title='Excluir'>
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
}
?>