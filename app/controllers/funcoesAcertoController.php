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
$placa = $_REQUEST['placa'];

$bool_numero = false;
$bool_tipo = false;
$bool_odometro = false;

$sql = "SELECT * FROM caminhao WHERE placa = '".$placa."' LIMIT 1;";
$verifica = $pdo->query($sql);
foreach ($verifica as $dados) {
	$cont++;
}

if ($cont != 0) {
	$sql = "SELECT * FROM caminhao WHERE placa = '".$placa."' LIMIT 1;";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$id_caminhao = $dados[0];
	}



$sql = "SELECT * FROM abastecimento WHERE bool_acerto = 0 AND bomba_id = ".$id_bomba." AND caminhao_id = ".$id_caminhao." ORDER BY data_abastecimento ASC;";
$verifica = $pdo->query($sql);
foreach ($verifica as $dados) {
	$cont++;
}
if ($cont != 0) {
	$verifica = $pdo->query($sql);
	echo "
		<table class='table'>
			<tr bgcolor='white'>
				<td align='center'><b>Data</b></td>
				<td align='center'><b>Litros</b></td>
				<td align='center'><b>Numero</b></td>
				<td align='center'><b>Placa</b></td>
				<td align='center'><b>Odômetro</b></td>
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



		$dataDia = substr($dados["data_abastecimento"] , -2);
		$dataMes = substr($dados["data_abastecimento"] , -5 , -3);
		$dataAno = substr($dados["data_abastecimento"] ,  0 ,  4);
		$dataCerta = $dataDia ."/". $dataMes ."/". $dataAno;
		echo "<td class=\"col-md-1\">".$dataCerta."</td>";


		$litros = str_replace(".", ",", $dados["litros"]);
		echo "
				<td class=\"col-md-1\" align='right'>".substr($litros , 0, -1)." L</td>
		";


		if ($dados["numero"] != 0) {
			echo "<td align='center'>".$dados["numero"]."</td>";
			$bool_numero = "0";
		} else {
			$bool_numero = "1";
			echo "
				<td class=\"col-md-2\" align='center'>
				<div class=\"col-md-12\">
				<input class='form-control' type='number' size='2' id='numero__".$dados[0]."'>
				</div>
				</td>
			";
		}

		$bool_tipo = '0';
		$sql = "SELECT * FROM caminhao WHERE id_caminhao = ".$dados["caminhao_id"].";";
		$verifica2 = $pdo->query($sql);
		foreach ($verifica2 as $dados2) {
			echo "<td align='center' class=\"col-md-2\">".$dados2["placa"]."</td>";
		}

		if ($dados["odometro"] != 0) {
			echo "<td align='center'>".$dados["odometro"]."</td>";
			$bool_odometro = "0";
		} else {
			$bool_odometro = "1";
			echo "
				<td class=\"col-md-2\" align='center'>
				<div class=\"col-md-12\">
				<input class='form-control' type='number' size='2' id='odometro__".$dados[0]."'>
				</div>
				</td>
			";
		}

		echo "
				<td align='right' class=\"col-md-1\">
					<button class='btn btn-success' style='color:white' onclick='salvarCupomT(".$dados[0].", ".$bool_numero.", ".$bool_tipo.", ".$bool_odometro.")' title='Salvar'>
						<b><i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></b>
					</button>
				</td>
		";

		echo "</tr>";
	}



$sql = "SELECT * FROM abastecimento WHERE bool_acerto = 0 AND bomba_id = ".$id_bomba." AND caminhao_id = 0 AND terceiros_id = 0 ORDER BY data_abastecimento ASC;";
$verifica = $pdo->query($sql);
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



		$dataDia = substr($dados["data_abastecimento"] , -2);
		$dataMes = substr($dados["data_abastecimento"] , -5 , -3);
		$dataAno = substr($dados["data_abastecimento"] ,  0 ,  4);
		$dataCerta = $dataDia ."/". $dataMes ."/". $dataAno;
		echo "<td class=\"col-md-1\">".$dataCerta."</td>";


		$litros = str_replace(".", ",", $dados["litros"]);
		echo "
				<td class=\"col-md-1\" align='right'>".substr($litros , 0, -1)." L</td>
		";


		$bool_numero = "1";
		echo "
			<td class=\"col-md-2\" align='center'>
			<div class=\"col-md-12\">
			<input class='form-control' type='number' size='2' id='numero__".$dados[0]."'>
			</div>
			</td>
		";


		$sql = "SELECT * FROM caminhao WHERE id_caminhao = ".$id_caminhao.";";
		$verifica2 = $pdo->query($sql);
		foreach ($verifica2 as $dados2) {
			echo "
				<td align='center' class=\"col-md-2\">
					<input  class='form-control' type='text' value='".$dados2["placa"]."' disabled>
				</td>";
		}

		$bool_odometro = "1";
		echo "
			<td class=\"col-md-2\" align='center'>
			<div class=\"col-md-12\">
			<input class='form-control' type='number' size='2' id='odometro__".$dados[0]."'>
			</div>
			</td>
		";

		echo "
				<td align='right' class=\"col-md-1\">
					<button class='btn btn-success' style='color:white' onclick='salvarCupomT(".$dados[0].", ".$bool_numero.", ".$id_caminhao.", ".$bool_odometro.")' title='Salvar'>
						<b><i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></b>
					</button>
				</td>
		";

		echo "</tr>";
}

	echo "</table>";
} else {
	echo "<h3 class='text-center'>Nada pendente para Cupom</h3>";
}
}  else {
	echo "<h3 class='text-center'>Placa ínvalida para acerto</h3>";
}
?>