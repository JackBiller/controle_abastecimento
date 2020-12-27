<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

$cont = 0;
$dia = 0;
$diaAnterior = 0;
$atual = 0;
$cor1 = "#ffe";
$cor2 = "#af8f7f";
$estiloCor = "black";
$totalDia = 0;
$total = 0;
$totalLitros = 0;
$cor = $cor1;
$mes = $_REQUEST['mes'];
$ano = $_REQUEST['ano'];
$bomba = $_REQUEST['bomba'];

$sql =  "SELECT * FROM abastecimento ";
$sql .= " WHERE mes = ".$mes." AND ano = ".$ano." AND bomba_id = ".$bomba;
$sql .= " ORDER BY data_abastecimento ASC;";
$verifica = $pdo->query($sql);
foreach ($verifica as $dados) {
	$cont++;
}
if ($cont != 0) {
	$verifica = $pdo->query($sql);
	echo "
		<table class='table'>
			<tr bgcolor='white'>
				<td><b>Data</b></td>
				<td><b>N°</b></td>
				<td><b>Placa/Terceiros</b></td>
				<td><b>Litros</b></td>
				<td><b>Odometro</b></td>
				<td><b>Total</b></td>
				<!--td><b>Editar</b></td-->
				<td><b>Cupom</b></td>
				<td><b>Fitinha</b></td>
				<td><b>Acerto</b></td>
			</tr>
		";
	foreach ($verifica as $dados) {
		$atual++;
		$total = $total + $dados["total"];
		$totalLitros = $totalLitros + $dados["litros"];
		if ($dados["bool_placa_fit"] == 1) {
			$estiloCor = "red";
		} else {
			$estiloCor = "black";
		}

		if ($dia == 0) {
			$totalDia = (float) $totalDia + (float) $dados["total"];

			$dia = substr($dados["data_abastecimento"] , -2);
	echo "<tr bgcolor='".$cor."' style='color:".$estiloCor."' class='selecionado_linha' id='linha".$dados[0]."'>";
		}

		 else if ($dia != substr($dados["data_abastecimento"] , -2)) {
		 	$dia = substr($dados["data_abastecimento"] , -2);
			// $totalDia = (float) $totalDia + 
			$totalDia = number_format($totalDia, 2, ',', ' ');
			echo "
			<tr>
				<td colspan='3'><td>
				<td colspan='1' aligh='right'>Total (dia):</td>
				<td colspan='2' align='left'><b>R$ ".$totalDia."</b></td>
			</tr>";
			$totalDia = (float) $dados["total"];
			$cor = $cor == $cor1 ? $cor2 : $cor1;

	echo "<tr bgcolor='".$cor."' style='color:".$estiloCor."' class='selecionado_linha' id='linha".$dados[0]."'>";
		} else {
			$totalDia = (float) $totalDia + (float) $dados["total"];

	echo "<tr bgcolor='".$cor."' style='color:".$estiloCor."' class='selecionado_linha' id='linha".$dados[0]."'>";
		}

		$dataDia = substr($dados["data_abastecimento"] , -2);
		$dataMes = substr($dados["data_abastecimento"] , -5 , -3);
		$dataAno = substr($dados["data_abastecimento"] ,  0 ,  4);
		$dataCerta = $dataDia ."/". $dataMes ."/". $dataAno;
		echo "
				<td>".$dataCerta."</td>
				<td>".$dados["numero"]."</td>";

		if ($dados["caminhao_id"] != 0) {
			$sql = "SELECT * FROM caminhao WHERE id_caminhao = ".$dados["caminhao_id"].";";
			$verifica2 = $pdo->query($sql);
			foreach ($verifica2 as $dados2) {
				echo "<td>".$dados2["placa"]."</td>";
			}
		} else if ($dados["terceiros_id"] != 0) {
			$sql ="SELECT * FROM terceiros WHERE id_terceiros = ".$dados["terceiros_id"].";";
			$verifica2 = $pdo->query($sql);
			foreach ($verifica2 as $dados2) {
				echo "<td>".$dados2["descricao"]."</td>";
			}
		} else {
			echo "<td></td>";
		}

		$litros = str_replace(".", ",", $dados["litros"]);
		echo "
				<td align='right'>".substr($litros , 0, -1)." L</td>
		";

		if ($dados["caminhao_id"] != 0) {
			echo "<td align='center'>".$dados["odometro"]."</td>";
		} else if ($dados["terceiros_id"] != 0) {
			echo "<td align='center'>Não tem</td>";
		} else {
			echo "<td></td>";
		}

		echo "
			<td>
				<span style='text-align: left; '>R$</span>
				<span style='text-align: right;'>".number_format($dados["total"], 2, ',', ' ')."</span>
			</td>
		";

		echo "
				<!--td align='center'>
					<a href='#!editar_saida' style='color: #f0ad4e;' data-id='".$dados[0]."' onclick='editar(this);' title='Editar'>
						<b><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></b>
					</a>
				</td-->
		";
				
		
		if ($dados["bool_cupom"] == 1) {
		 	echo "<td align='center' style='background-color: #dfd;'> Ok </td>";
		 } else {
		 	echo "<td align='center' style='background-color: #fdd;'> - </td>";
		 }

		 if ($dados["bool_fitinha"] == 1) {
		 	echo "<td align='center' style='background-color: #dfd;'> Ok </td>";
		 } else {
		 	echo "<td align='center' style='background-color: #fdd;'> - </td>";
		 }

		 if ($dados["bool_acerto"] == 1) {
		 	echo "<td align='center' style='background-color: #dfd;'> Ok </td>";
		 } else if ($dados["bool_acerto"] == 2) {
		 	echo "<td align='center' style='background-color: #ddf;'> Não tem </td>";
		 } else if ($dados["bool_acerto"] == 3) {
		 	echo "<td align='center' style='background-color: #ddf;'> Vínculado </td>";
		 } else {
		 	echo "<td align='center' style='background-color: #fdd;'> - </td>";
		 }
		echo "</tr>	";
		if ($atual == $cont) {
			$totalDia = number_format($totalDia, 2, ',', ' ');
			echo "
			<tr>
				<td colspan='3'><td>
				<td colspan='1' aligh='right'>Total (dia):</td>
				<td colspan='2' align='left'><b>R$ ".$totalDia."</b></td>
			</tr>";
		}
	}
	$media = $total/$totalLitros;
	$total = number_format($total, 2, ',', ' ');
	$totalLitros = number_format($totalLitros, 2, ',', ' ');
	$media = number_format($media, 2, ',', ' ');
	echo "
		<tr>
			<td colspan='1'><td>
			<td align='right'>Total Litros:</td>
			<td colspan='1' align='left'>Lt ".$totalLitros."</td>
			<td>Total:</td>
			<td colspan='2' align='left'>R$ ".$total."</td>
		</tr>
		<tr>
			<td colspan='3'><td>
			<td colspan='1' align='left'>Média por Litro:</td>
			<td colspan='2'>R$ ".$media."<td>
		</tr>
	</table>";
} else {
	echo "<h3>Nenhum registro encontrado</h3>";
}
?>