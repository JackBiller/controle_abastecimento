<?php

$cont = 0;

$sql = "SELECT * FROM entrada;";
$verifica = $pdo->query($sql);
foreach ($verifica as $dados) {
	$cont++;
}
if ($cont == 0) {
	echo "
	<div class=\"col-md-4\">
		<div class=\"panel panel-primary\">
			<div class=\"panel-heading\" style=\"padding-top: 1px;padding-bottom: 1px;\">
				<h3>Situação da Bomba</h3>
			</div>
			<div class=\"panel-body\">
				<h4>Nenhum registro encontrado</h4>
				<img src=\"app/img/sem_registro.png\" width=\"100%\" height=\"auto\">
				<br>
				<div class=\"text-center\">
					<span>
						Aguardando Operações...
					</span>
				</div>
			</div>
		</div>
	</div>
	";
} else {
	$sql = "SELECT * FROM entrada ORDER BY data_entrada DESC LIMIT 1;";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$vlr_unit = number_format($dados["vlr_unit"], 2, ',', ' ');

		$sql ="SELECT * FROM empresa WHERE id_empresa = ".$dados["empresa_id"].";";
		$verifica2 = $pdo->query($sql);
		foreach ($verifica2 as $dados2) {
			$empresa = $dados2["nome"];
		}

		$sql ="SELECT * FROM bomba WHERE id_bomba = ".$dados["bomba_id"].";";
		$verifica3 = $pdo->query($sql);
		foreach ($verifica3 as $dados3) {
			$bomba        = $dados3["descricao"];
			$volume_atual = $dados3["volume_atual"];
			$volume_total = $dados3["volume_total"];
		}

		$sql ="SELECT * FROM usuario WHERE id_usuario = ".$dados["usuario_id"].";";
		$verifica4 = $pdo->query($sql);
		foreach ($verifica4 as $dados4) {
			$usuario = $dados4["nome"];
		}
	}
}

if ($cont == 1) {
	$sql = "SELECT * FROM entrada ORDER BY data_entrada DESC LIMIT 1;";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		echo "
		<div class=\"col-md-4\">
			<div class=\"panel panel-primary\">
				<div class=\"panel-heading\" style=\"padding-top: 1px;padding-bottom: 1px;\">
					<h3>Média do valor Únitario</h3>
				</div>
				<div class=\"panel-body\">
					<h4>Pela ".$empresa." para ".$bomba."</h4>
					<br>
					<div class=\"text-center\">
						<span>
							O valor do Diesel de acordo com os ultimos registros esta atualmente R$".$vlr_unit." por litro
						</span>
					</div>
				</div>
			</div>
		</div>
		";
	}
} else if ($cont > 1){
	$atual = 0;
	$mediaGeral	= 0;
	$mediaMensal = 0;
	$registrosMensal = 0;
	$mesAtual = 0;
	$ultimoValor = 0;
	$pUltimoValor = 0;

	$sql = "SELECT * FROM entrada ORDER BY data_entrada ASC;";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$atual ++;
		if ($mesAtual != 0) {
			if ($mesAtual != $dados["mes"]) {
				$mediaMensal = $dados["vlr_unit"];
				$mesAtual = $dados["mes"];
				$registrosMensal = 1;
			} else {
				$mediaMensal = $mediaMensal + $dados["vlr_unit"];
				$registrosMensal ++;
			}
		}

		$mediaGeral = $mediaGeral + $dados["vlr_unit"];
		if ($atual == 1) {
			$mediaMensal = $dados["vlr_unit"];
			$mesAtual = $dados["mes"];
			$registrosMensal = 1;
		}

		if ($atual == $cont) {
			$ultimoValor = $dados["vlr_unit"];
			$vlr_unit = number_format($dados["vlr_unit"], 2, ',', ' ');
		} else if ($atual == $cont - 1) {
			$pUltimoValor = $dados["vlr_unit"];
		}
	}

	$ultimoValor = $ultimoValor - $pUltimoValor;

	if ($ultimoValor < 0) {
		$estatistica = "
		<br>
		<h1 style=\"font-size:70px;padding-top: 10px;\">
			<i class=\"fa fa-long-arrow-down\" style=\"color:green; transform:scale(1) rotate(315deg);\" aria-hidden=\"true\">
			</i>
		</h1>
		<h4 style=\"padding-top: 0px;padding-bottom: 1px;\">
			<b>Abaixo do último lançamento</b>
		</h4>
		";
	} else if ($ultimoValor > 0) {
		$estatistica = "
		<br>
		<h1 style=\"font-size:70px;padding-top: 10px;\">
			<i class=\"fa fa-long-arrow-up\" style=\"color:red; transform:scale(1) rotate(45deg);\" aria-hidden=\"true\"></i>
		</h1>
		<h4 style=\"padding-top: 0px;padding-bottom: 1px;\">
			<b>Acima do último lançamento</b>
		</h4>			
		";
	}

	$mediaMensal = $mediaMensal / $registrosMensal;
	$mediaMensal = number_format($mediaMensal, 2, ',', ' ');

	$mediaGeral = $mediaGeral / $cont;
	$mediaGeral = number_format($mediaGeral, 2, ',', ' ');

	echo "
	<div class=\"row\">
		<div class=\"col-md-6\">
			<div class=\"panel panel-primary\">
				<div class=\"panel-heading\" style=\"padding-top: 1px;padding-bottom: 1px;\">
					<h3>Média do valor Únitario</h3>
				</div>
				<div class=\"panel-body text-center\">
					<h4>De acordo com os últimos registros</h4><br>
					<h4>Pela: <b>".$empresa."</b><br>Para: <b>".$bomba."</b></h4>
					<br>
					<div class=\"text-center\">
						<span>
							O valor do Diesel esta atualmente <b>R$".$vlr_unit."</b> por litro<br>
							".$estatistica."<br><br>
							A média do último mês é igual <b>R$".$mediaMensal."</b> por litro
							<br>
							A média geral é igual <b>R$".$mediaGeral."</b> por litro
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class=\"col-md-6\">
			<div class=\"panel panel-primary\">
				<div class=\"panel-heading\" style=\"padding-top: 1px;padding-bottom: 1px;\">
					<h3>Média do valor Únitario</h3>
				</div>
				<div class=\"panel-body text-center\">
					<h4>De acordo com os últimos registros</h4><br>
					<h4>Pela: <b>".$empresa."</b><br>Para: <b>".$bomba."</b></h4>
					<br>
					<div class=\"text-center\">
						<span>
							O valor do Diesel esta atualmente <b>R$".$vlr_unit."</b> por litro<br>
							".$estatistica."<br><br>
							A média do último mês é igual <b>R$".$mediaMensal."</b> por litro
							<br>
							A média geral é igual <b>R$".$mediaGeral."</b> por litro
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	";
}
?>