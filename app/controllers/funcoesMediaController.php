<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

$cont = 0;


$mes = $_REQUEST['mes'];
$ano = $_REQUEST['ano'];
$bomba_id = $_REQUEST['bomba'];

$sql =  "SELECT * FROM caminhao WHERE vin_media = 1 ORDER BY placa ASC;";
$verifica = $pdo->query($sql);
foreach ($verifica as $dados99) {
	$cont++;
}
if ($cont != 0) {
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados99) {


		$totalQuantidade = 0;
		$totalTotal = 0;
		$totalRodado = 0;
		$mediaLitro = 0;

		$cor1 = "#ffe";
		$cor2 = "#af8f7f";


		$cont = 0;

		$dia = 0;
		$diaAnterior = 0;
		$atual = 0;
		$cor1 = "#eee";
		$cor2 = "#ccc";

		$estiloCor = "black";
		$total = 0;
		$totalLitros = 0;
		$kmAnterior = 0;
		$mesAnterior = 0;
		$anoAnterior = 0;
		$cor = $cor1;

		if ($mes == 1) {
			$mesAnterior = 12;
			$anoAnterior = $ano - 1;
		} else {
			$mesAnterior = $mes - 1;
			$anoAnterior = $ano;
		}

		$sql =  "SELECT * FROM abastecimento";
		$sql .= " WHERE bomba_id = ".$bomba_id;
		$sql .= " AND caminhao_id = ".$dados99[0];
		$sql .= " AND mes <= '".$mesAnterior."' AND ano <= '".$anoAnterior."'";
		$sql .= " ORDER BY data_abastecimento DESC LIMIT 1;";

		
		$verifica = $pdo->query($sql);
		foreach ($verifica as $dados) {
			$cont++;
		}

		if ($cont > 0) {
			$verifica = $pdo->query($sql);
			foreach ($verifica as $dados) {
				$kmAnterior = $dados["odometro"];
			}
		}


		$cont = 0;

		$sql  = "SELECT * FROM abastecimento";
		$sql .= " WHERE bomba_id = ".$bomba_id;
		$sql .= " AND caminhao_id = ".$dados99[0];
		$sql .= " AND mes = '".$mes."' AND ano = '".$ano."'";
		$sql .= " ORDER BY data_abastecimento ASC;";
		$verifica = $pdo->query($sql);
		foreach ($verifica as $dados) {
			$cont++;
		}
		if ($cont > 0) {
			$verifica = $pdo->query($sql);
			echo "
			<table class=\"table\">
				<tr>
					<td colspan='6' class='text-center'><h2>".$dados99[1]."</h2></td>
				</tr>
				<tr bgcolor=\"white\">
					<td align=\"center\"><b>Data</b></td>
					<td align=\"center\"><b>Litros</b></td>
					<td align=\"center\"><b>Odometro Anterior</b></td>
					<td align=\"center\"><b>Odometro Atual</b></td>
					<td align=\"center\"><b>Total Rodado</b></td>
					<td align=\"center\"><b>Média</b></td>
				</tr>

				";
				foreach ($verifica as $dados) {
					$atual++;
					$total = $total + $dados["total"];
					$totalLitros = $totalLitros + $dados["litros"];

					if ($kmAnterior == 0) {
						$kmAnterior = $dados["odometro"];
					} else {
						if ($dia == 0) {

							$dia = substr($dados["data_abastecimento"] , -2);
							echo "<tr bgcolor=\"".$cor."\" style=\"color:".$estiloCor."\" class=\"selecionado_linha\" id=\"linha".$dados[0]."\">";
						}

						else if ($dia != substr($dados["data_abastecimento"] , -2)) {
							$dia = substr($dados["data_abastecimento"] , -2);
							$cor = $cor == $cor1 ? $cor2 : $cor1;

							echo "<tr bgcolor=\"".$cor."\" style=\"color:".$estiloCor."\" class=\"selecionado_linha\" id=\"linha".$dados[0]."\">";
						} else {

							echo "<tr bgcolor=\"".$cor."\" style=\"color:".$estiloCor."\" class=\"selecionado_linha\" id=\"linha".$dados[0]."\">";
						}

						$dataDia = substr($dados["data_abastecimento"] , -2);
						$dataMes = substr($dados["data_abastecimento"] , -5 , -3);
						$dataAno = substr($dados["data_abastecimento"] ,  0 ,  4);
						$dataCerta = $dataDia ."/". $dataMes ."/". $dataAno;
						echo "
						<td>".$dataCerta."</td>";

						$litros = str_replace(".", ",", $dados["litros"]);
						echo "
						<td align=\"right\">".substr($litros , 0, -1)." L</td>
						";

						echo "<td align=\"center\">".$kmAnterior."</td>";

						echo "<td align=\"center\">".$dados["odometro"]."</td>";

						$totalRodado = $dados["odometro"] - $kmAnterior;

						echo "<td align=\"center\">".$totalRodado."</td>";

						$mediaLitro = $totalRodado / $dados["litros"];

						$mediaLitro = number_format($mediaLitro, 2, ',', ' ');

						echo "<td align=\"center\">".$mediaLitro."</td>";

						$kmAnterior = $dados["odometro"];

						echo "</tr>	";
					}
				}

				$totalLitros = number_format($totalLitros, 2, ',', ' ');
				echo "
				<tr>
					<td align=\"center\" bgcolor='#ffd'>Total Litros:</td>
					<td colspan=\"1\" align=\"center\" bgcolor='#ffd'>Lt ".$totalLitros."<br><br></td>
				</tr>
			</table>";
		} else {
			echo "<h3 class=\"text-center\">Nenhum registro encontrado para <br><br>".$dados99[1]."</h3>";
		}
	}
} else {
	echo "<h3 class=\"text-center\">Nenhum registro encontrado</h3>";
}
?>