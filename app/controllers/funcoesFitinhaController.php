<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

$cont = 0;
$dia = 0;
$cor1 = "#ffe";
$cor2 = "#af8f7f";
$cor = $cor1;
$id_bomba = $_REQUEST['bomba_id'];

$sql = "SELECT * FROM abastecimento WHERE bool_fitinha = 0 AND bomba_id = ".$id_bomba." ORDER BY data_abastecimento ASC;";
$verifica = $pdo->query($sql);
foreach ($verifica as $dados) {
	$cont++;
}
if ($cont != 0) {
	$verifica = $pdo->query($sql);
	echo "
		<table class='table'>
			<tr bgcolor='white'>
				<td><b>Placa/Terceiros</b></td>
				<td><b>Data</b></td>
				<td><b>Litros</b></td>
				<td align='center'><b>Tem Placa?</b></td>
				<td><b>Hora</b></td>
				<td align='right'><b>Salvar</b></td>
			</tr>
		";
	foreach ($verifica as $dados) {

		if ($dia == 0) {

			$dia = substr($dados["data_abastecimento"] , -2);
			echo "<tr bgcolor='".$cor."' class='selecionado_linha' id='linha".$dados[0]."'>";
		} else if ($dia != substr($dados["data_abastecimento"] , -2)) {
			$dia = substr($dados["data_abastecimento"] , -2);

			$cor = $cor == $cor1 ? $cor2 : $cor1;

			echo "<tr bgcolor='".$cor."' class='selecionado_linha' id='linha".$dados[0]."'>";
		} else {
			echo "<tr bgcolor='".$cor."' class='selecionado_linha' id='linha".$dados[0]."'>";
		}

		if ($dados["caminhao_id"] != 0) {
			$sql = "SELECT * FROM caminhao WHERE id_caminhao = ".$dados["caminhao_id"].";";
			$verifica2 = $pdo->query($sql);
			foreach ($verifica2 as $dados2) {
				echo "<td>".$dados2["placa"]."</td>";
			}
		} else {
			$sql ="SELECT * FROM terceiros WHERE id_terceiros = ".$dados["terceiros_id"].";";
			$verifica2 = $pdo->query($sql);
			foreach ($verifica2 as $dados2) {
				echo "<td>".$dados2["descricao"]."</td>";
			}
		}

		$dataDia = substr($dados["data_abastecimento"] , -2);
		$dataMes = substr($dados["data_abastecimento"] , -5 , -3);
		$dataAno = substr($dados["data_abastecimento"] ,  0 ,  4);
		$dataCerta = $dataDia ."/". $dataMes ."/". $dataAno;
		echo "
				<td>".$dataCerta."</td>";


		$litros = str_replace(".", ",", $dados["litros"]);
		echo "
				<td align='right'>".substr($litros , 0, -1)." L</td>
		";

		echo "
			<td align='center'>
			<input class='form-control' type='checkbox' id='bool_placa_fit__".$dados[0]."'>
			</td>
			<td align='center'>
			<input class='form-control' type='text' size='2' maxlength='5' rel='hora' id='horas__".$dados[0]."'>
			</td>
		";

		echo "
				<td align='right'>
					<button class='btn btn-success' style='color:white' onclick='salvarFitinhaT(".$dados[0].")' title='Salvar'>
						<b><i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></b>
					</button>
				</td>
		";

		echo "</tr>	";
	}
	echo "</table>";
} else {
	echo "<h3 class='text-center'>Nada pendente para Fitinha</h3>";
}
?>