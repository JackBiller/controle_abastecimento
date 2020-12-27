<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

$cont = 0;
$mes = $_REQUEST['mes'];
$ano = $_REQUEST['ano'];

$sql = "SELECT * FROM entrada WHERE mes = ".$mes." AND ano = ".$ano." ORDER BY data_entrada ASC;";
$verifica = $pdo->query($sql);
foreach ($verifica as $dados) {
	$cont++;
}
if ($cont != 0) {
	$verifica = $pdo->query($sql);
	echo "
		<table class='table'>
			<tr bgcolor='white'>
				<td><b>Dia</b></td>
				<td><b>Empresa</b></td>
				<td><b>Bomba de Abastecimento</b></td>
				<td><b>N° NFe</b></td>
				<td><b>Qtd. Litros</b></td>
				<td><b>Vlr. Únitario</b></td>
				<td><b>Total</b></td>
			</tr>
		";
		// <td><b>Editar</b></td>
	foreach ($verifica as $dados) {
		echo "
			<tr id='linha".$dados[0]."'>
				<td>".substr($dados["data_entrada"] , -2)."</td>";

		$sql = "SELECT * FROM empresa WHERE id_empresa = ".$dados["empresa_id"].";";
		$verifica2 = $pdo->query($sql);
		foreach ($verifica2 as $dados2) {
			echo "<td>".$dados2["nome"]."</td>";
		}

		$sql = "SELECT * FROM bomba WHERE id_bomba = ".$dados["bomba_id"].";";
		$verifica3 = $pdo->query($sql);
		foreach ($verifica3 as $dados3) {
			echo "<td>".$dados3["descricao"]."</td>";
		}
		echo "
				<td>".$dados["num_nfe"]."</td>
				<td>".$dados["qtd_litros"]."</td>
				<td>R$".substr($dados["vlr_unit"] , 0, -1)."</td>
				<td>R$".substr($dados["total"] , 0, -1)."</td>
				<!--td align='center'>
					<a href='#!editar_entrada' style='color: #f0ad4e;' data-id='".$dados[0]."' onclick='editar(this);' title='Editar'>
						<b><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></b>
					</a>
				</td-->
			</tr>
		";
	}
	echo "</table>";
} else {
	echo "<h3>Nenhum registro encontrado</h3>";
}
?>