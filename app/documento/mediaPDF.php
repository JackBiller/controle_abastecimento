<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();


$cont = 0;
if ($_REQUEST['dt_inicial'] == '' && $_REQUEST['dt_final'] == '') {
	$dt_inicial = "";
	$dt_inicial_v = "";
	//$dt_inicial_v = " AND  data_abastecimento = ''";
	$dt_final = "";
} else {
	$dt_inicial = " AND  data_abastecimento >= '".$_REQUEST['dt_inicial']."'";
	$dt_inicial_v = "";
	//$dt_inicial_v = " AND  data_abastecimento < '".$_REQUEST['dt_inicial']."'";
	$dt_final = " AND  data_abastecimento <= '".$_REQUEST['dt_final']."'";
}

$bomba_id = $_REQUEST['bomba_id'];
$tabela = "";
$headTabela = "";
$totalQuantidade = 0;
$totalTotal = 0;
$totalRodado = 0;
$mediaLitro = 0;

if ($_REQUEST["idFiltro"] != '') {
	$filtro = " AND caminhao_id = ".$_REQUEST["idFiltro"];
} else {
	$filtro = "";
}


// data_abastecimento >= '

$cont = 0;
$dia = 0;
$diaAnterior = 0;
$atual = 0;
// $cor1 = "#ffe";
// $cor2 = "#af8f7f";
$cor1 = "#eee";
$cor2 = "#ccc";
$estiloCor = "black";
$totalDia = 0;
$total = 0;
$totalLitros = 0;
$kmAnterior = 0;
$cor = $cor1;

$sql =  "SELECT * FROM abastecimento WHERE bomba_id = ".$bomba_id.$dt_inicial_v.$filtro." ORDER BY data_abastecimento DESC LIMIT 1;";
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

$sql =  "SELECT * FROM abastecimento ";
$sql .= " WHERE bomba_id = ".$bomba_id.$dt_inicial;
$sql .= " ".$dt_final." ".$filtro;
$sql .= " ORDER BY data_abastecimento ASC;";
$verifica = $pdo->query($sql);
foreach ($verifica as $dados) {
	$cont++;
}
if ($cont > 0) {
	$verifica = $pdo->query($sql);
	$tabela .=  "
	<table class=\"table\">
		<tr bgcolor=\"white\">
			<td align=\"center\"><b>Data</b></td>
			<td align=\"center\"><b>Placa</b></td>
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
					$totalDia = (float) $totalDia + (float) $dados["total"];

					$dia = substr($dados["data_abastecimento"] , -2);
					$tabela .=  "<tr bgcolor=\"".$cor."\" style=\"color:".$estiloCor."\" class=\"selecionado_linha\" id=\"linha".$dados[0]."\">";
				}

				else if ($dia != substr($dados["data_abastecimento"] , -2)) {
					$dia = substr($dados["data_abastecimento"] , -2);
					$totalDia = number_format($totalDia, 2, ',', ' ');
					// $tabela .=  "
					// <tr>
					// 	<td colspan=\"4\"></td>
					// 	<td colspan=\"1\" align=\"right\">Total (dia):</td>
					// 	<td colspan=\"1\" align=\"left\"><b>R$ ".$totalDia."</b></td>
					// </tr>";
					$totalDia = (float) $dados["total"];
					$cor = $cor == $cor1 ? $cor2 : $cor1;

					$tabela .=  "<tr bgcolor=\"".$cor."\" style=\"color:".$estiloCor."\" class=\"selecionado_linha\" id=\"linha".$dados[0]."\">";
				} else {
					$totalDia = (float) $totalDia + (float) $dados["total"];

					$tabela .=  "<tr bgcolor=\"".$cor."\" style=\"color:".$estiloCor."\" class=\"selecionado_linha\" id=\"linha".$dados[0]."\">";
				}

				$dataDia = substr($dados["data_abastecimento"] , -2);
				$dataMes = substr($dados["data_abastecimento"] , -5 , -3);
				$dataAno = substr($dados["data_abastecimento"] ,  0 ,  4);
				$dataCerta = $dataDia ."/". $dataMes ."/". $dataAno;
				$tabela .=  "
				<td>".$dataCerta."</td>";

				$sql = "SELECT * FROM caminhao WHERE id_caminhao = ".$dados["caminhao_id"].";";
				$verifica2 = $pdo->query($sql);
				foreach ($verifica2 as $dados2) {
					$tabela .=  "<td align=\"center\">".$dados2["placa"]."</td>";
				}

				$litros = str_replace(".", ",", $dados["litros"]);
				$tabela .=  "
				<td align=\"right\">".substr($litros , 0, -1)." L</td>
				";

				$tabela .=  "<td align=\"center\">".$kmAnterior."</td>";

				$tabela .=  "<td align=\"center\">".$dados["odometro"]."</td>";

				$totalRodado = $dados["odometro"] - $kmAnterior;

				$tabela .=  "<td align=\"center\">".$totalRodado."</td>";

				$mediaLitro = $totalRodado / $dados["litros"];

				$mediaLitro = number_format($mediaLitro, 2, ',', ' ');

				$tabela .=  "<td align=\"center\">".$mediaLitro."</td>";

				$kmAnterior = $dados["odometro"];

				$tabela .=  "</tr>	";
				if ($atual == $cont) {
					$totalDia = number_format($totalDia, 2, ',', ' ');
					// $tabela .=  "
					// <tr>
					// 	<td colspan=\"4\"></td>
					// 	<td colspan=\"1\" align=\"right\">Total (dia):</td>
					// 	<td colspan=\"1\" align=\"left\"><b>R$ ".$totalDia."</b></td>
					// </tr>";
				}
			}
		}
		$media = $total/$totalLitros;
		$total = number_format($total, 2, ',', ' ');
		$totalLitros = number_format($totalLitros, 2, ',', ' ');
		$media = number_format($media, 2, ',', ' ');
		$tabela .=  "
		<tr>
			<td colspan=\"1\"></td>
			<td align=\"right\">Total Litros:</td>
			<td colspan=\"1\" align=\"left\">Lt ".$totalLitros."</td>
			<!--td align=\"right\">Total:</td>
			<td colspan=\"1\" align=\"left\">R$ ".$total."</td-->
			</tr>
			<!--tr>
			<td colspan=\"4\"></td>
			<td colspan=\"1\" align=\"right\">Média por Litro:</td>
			<td colspan=\"1\">R$ ".$media."</td>
		</tr-->
	</table>";
} else {
	$tabela .= "<><h3 class=\"text-center\">Nenhum registro encontrado</h3>";
}


$sql = "SELECT * FROM bomba WHERE id_bomba = ".$bomba_id.";";
$verifica3 = $pdo->query($sql);
foreach ($verifica3 as $dados3) {
	$bombaAbastecimento = $dados3["descricao"];
}

use Dompdf\Dompdf;
require_once "../dompdf_gerar/dompdf/autoload.inc.php";

if ($_REQUEST['dt_inicial'] == '' && $_REQUEST['dt_final'] == '') {

	$sql =  "SELECT * FROM abastecimento WHERE bomba_id = ".$bomba_id." ORDER BY data_abastecimento ASC LIMIT 1;";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$dt_inicial = $dados["data_abastecimento"];
	}

	$sql =  "SELECT * FROM abastecimento WHERE bomba_id = ".$bomba_id." ORDER BY data_abastecimento DESC LIMIT 1;";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$dt_final = $dados["data_abastecimento"];
	}

} else {
	$dt_inicial = $_REQUEST['dt_inicial'];
	$dt_final = $_REQUEST['dt_final'];
}

$dataDia = substr($dt_inicial , -2);
$dataMes = substr($dt_inicial , -5 , -3);
$dataAno = substr($dt_inicial ,  0 ,  4);
$dt_inicial = $dataDia ."/". $dataMes ."/". $dataAno;

$dataDia = substr($dt_final , -2);
$dataMes = substr($dt_final , -5 , -3);
$dataAno = substr($dt_final ,  0 ,  4);
$dt_final = $dataDia ."/". $dataMes ."/". $dataAno;

$dompdf = new DOMPDF();
$dompdf->load_html('



	<!DOCTYPE html>

	<html>
	<head>

		<meta charset="utf-8">
		<title>Relatório</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">

		<style>
			@page { margin: 180px 50px 50px 50px; }
    #header { position: fixed; left: -15px; top: -180px; right: -15px; height: 180px; background-color: fff; text-align: center; }
    #footer { position: fixed; left: 0px; bottom: -50px; right: 80px; height: 50px; background-color: #fff; }
    #footer .page:after { content: counter(page, upper-roman); }
		</style>
		<body>
			<div id="header">
				<div class="col-md-12">
					<div align="center">
						<h1>Relatório de Média por Litro Diesel</h1>
						<h4>'.$bombaAbastecimento.'</h4>
						<h4>
							'.$dt_inicial.' - '.$dt_final.'
						</h4>

						
					</div>
				</div>
			</div>
			<div id="footer" class="text-right">
				<span class="page">Página </span>
			</div>


			<div id="content">

				'.$tabela.'

			</div>
		</body>
		</html>




		<!--html>
		<head>
		</head>
		<body>
			<div class="container">
				<div class="row">

					<br>

				</div>
			</div>
		</body>
		</html-->


		');

if ($_REQUEST['orientacao'] == 1 || $_REQUEST['orientacao'] == "1") {
	$dompdf->setPaper('A4', 'landscape');
}

$dompdf->render();
$dompdf->stream(
	"nome.pdf",
	array(
		"Attachment" => false
		)
	);
	?>