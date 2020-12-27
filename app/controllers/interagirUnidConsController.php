<?php
require_once "../class/conexao.php";
require_once "../class/entidade/ClienteUnidConsConta.php";
require_once "../class/dao/clienteUnidConsContaDAO.php";

$conn = new Conexao();
$pdo = $conn->Connect();

if (!empty($_REQUEST['inpc'])) {
	$condicao = true;
	$mes_esperado = (date('m')+1);
	$ano_esperado = (date('Y')-5);

	$sql = "SELECT * FROM `inpc` ORDER BY id_inpc DESC";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		if ($dados[2] == $ano_esperado && $dados[1] == $mes_esperado) {
			echo 	$dados[0] .",". $dados[1] ."/". $dados[2] .",". $dados[3];
			$condicao = false;
		} else if ($condicao) {
			echo 	$dados[0] .",". $dados[1] ."/". $dados[2] .",". $dados[3] . ",,";
		}
	}
}

if (!empty($_REQUEST['adicionaConta'])) {
	$entidadeClienteUnidConsConta = new ClienteUnidConsConta();
	$clienteUnidConsContaDAO = new clienteUnidConsContaDAO(); 

	$entidadeClienteUnidConsConta->set($_REQUEST['cliente_unid_cons_id'] , 'cliente_unid_cons_id');
	$entidadeClienteUnidConsConta->set($_REQUEST['mes']					 , 'mes');
	$entidadeClienteUnidConsConta->set($_REQUEST['ano']					 , 'ano');
	$entidadeClienteUnidConsConta->set($_REQUEST['inpc_id']				 , 'inpc_id');
	$entidadeClienteUnidConsConta->set($_REQUEST['vlr_distribuicao']	 , 'vlr_distribuicao');
	$entidadeClienteUnidConsConta->set($_REQUEST['vlr_transmissao']		 , 'vlr_transmissao');
	$entidadeClienteUnidConsConta->set($_REQUEST['vlr_encargos']		 , 'vlr_encargos');
	$entidadeClienteUnidConsConta->set($_REQUEST['vlr_restituicao']		 , 'vlr_restituicao');
	$entidadeClienteUnidConsConta->set($_REQUEST['perc_aliq_icms']		 , 'perc_aliq_icms');
	$entidadeClienteUnidConsConta->set($_REQUEST['vlr_subtotal']		 , 'vlr_subtotal');

	if ($_REQUEST['operacao'] == "I") {
		$retorno = $clienteUnidConsContaDAO->cadastraClienteUnidConsConta($entidadeClienteUnidConsConta);
	} else if ($_REQUEST['operacao'] == "U") {
		$retorno = $clienteUnidConsContaDAO->atualizaClienteUnidConsConta($entidadeClienteUnidConsConta , $_REQUEST['cliente_unid_cons_id']);
	}
	
	echo $retorno;
}

if (!empty($_REQUEST['pesquisa_unid_cons'])) {
	$cont = 0;
	$numConta = 0;
	$totalRestituicao = 0;
	$cliente_unid_cons_id = $_REQUEST['cliente_unid_cons_id'];
	$mesStr = '';
	$condicao = true;
	$mes_esperado = (date('m')+1);
	$ano_esperado = (date('Y')-5);

	$sql = "SELECT * FROM cliente_unid_cons_conta WHERE cliente_unid_cons_id = ".$cliente_unid_cons_id." ORDER BY inpc_id DESC;";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$cont++;
	}
	if ($cont != 0) {
		$verifica = $pdo->query($sql);
		echo "
			<table class=\"table\" align=\"center\">
				<tr bgcolor=\"white\">
					<td>N°</td>
					<td align=\"center\">Mês/Ano</td>
					<td align=\"center\">Valor Distribuição</td>
					<td align=\"center\">Valor Transmissão</td>
					<td align=\"center\">Valor Encargos</td>
					<td align=\"center\">Valor Retituição</td>
					<td align=\"center\">Percentual de Aliquota</td>
					<td align=\"center\">Valor Subtotal</td>
					<td align=\"center\">Editar</td>
					<td align=\"center\">Excluir</td>
				</tr>
			";
		foreach ($verifica as $dados) {
			$totalRestituicao = (float) $totalRestituicao + (float) $dados[10];
			$numConta++;
			if ($condicao) {

				 if ($dados[2] ==  1) $mesStr = "Jan";
			else if ($dados[2] ==  2) $mesStr = "Fev";
			else if ($dados[2] ==  3) $mesStr = "Mar";
			else if ($dados[2] ==  4) $mesStr = "Abr";
			else if ($dados[2] ==  5) $mesStr = "Mai";
			else if ($dados[2] ==  6) $mesStr = "Jun";
			else if ($dados[2] ==  7) $mesStr = "Jul";
			else if ($dados[2] ==  8) $mesStr = "Ago";
			else if ($dados[2] ==  9) $mesStr = "Set";
			else if ($dados[2] == 10) $mesStr = "Out";
			else if ($dados[2] == 11) $mesStr = "Nov";
			else if ($dados[2] == 12) $mesStr = "Dez";

			$valor1 = round($dados[5], 2);
			$valor2 = round($dados[6], 2);
			$valor3 = round($dados[7], 2);
			$valor4 = round($dados[8], 2);
			$valor5 = round($dados[10], 2);

			$valor1 = str_replace(".", ",", $valor1);
			$valor2 = str_replace(".", ",", $valor2);
			$valor3 = str_replace(".", ",", $valor3);
			$valor4 = str_replace(".", ",", $valor4);
			$valor5 = str_replace(".", ",", $valor5);

			echo "

				<tr id='linha".$dados[0]."'>
					<td>".$numConta."</td>
					<td id='modal".$dados[2]."/".$dados[3]."'>".$mesStr."/".$dados[3]."</td>
					<td id='modal_distribuicao".$dados[2]."/".$dados[3]."'>R$".$valor1."</td>
					<td id='modal_transmissao".$dados[2]."/".$dados[3]."'>R$".$valor2."</td>
					<td id='modal_encargos".$dados[2]."/".$dados[3]."'>R$".$valor3."</td>
					<td id='modal_restituicao".$dados[2]."/".$dados[3]."'>R$".$valor4."</td>
					<td id='modal_perc".$dados[2]."/".$dados[3]."'>%" .$dados[9]."</td>
					<td id='modal_subtotal".$dados[2]."/".$dados[3]."'>R$".$valor5."</td>
					<td>
						<a style='color: #f0ad4e;' data-id='".$dados[0]."' href='#!interagir_cliente_unid_cons_m' data-toggle=\"modal\" data-target=\"#modal_edit_conta\" title='Editar' onclick='joga_valor_modal(this , \"".$dados[2]."/".$dados[3]."\");'>
							<b>
								<i class=\"fa fa-pencil\" aria-hidden=\"true\"></i>
							</b>
						</a>
					</td>
					<td>
						<a href='#!interagir_cliente_unid_cons_m' style='color: red;' data-id='".$dados[0]."' onclick=\"excluir(this , 'cliente_unid_cons_conta');clickCheck('".$dados[2]."/".$dados[3]."');\" title='Excluir' >
							<i class=\"fa fa-times\" aria-hidden=\"true\"></i>
						</a>
					</td>
				</tr>
			";

			}
			if ($dados[3] == $ano_esperado && $dados[2] == $mes_esperado) $condicao = false;
		}
		echo "
			</table>
			<div class='text-right'>
				<h4>Total: R$".$totalRestituicao."&nbsp;&nbsp;&nbsp;&nbsp;</h4>
			</div>
		";
	} else {
		echo "<h3>Nenhum cadastro encontrado</h3>";
	}
}

if (!empty($_REQUEST['pesquisa_click_unid_cons_conta'])) {
	$cont = 0;
	$atual = 0;
	$condicao = true;
	$mes_esperado = (date('m')+1);
	$ano_esperado = (date('Y')-5);
	$cliente_unid_cons_id = $_REQUEST['cliente_unid_cons_id'];

	$sql = "SELECT * FROM cliente_unid_cons_conta WHERE cliente_unid_cons_id = ".$cliente_unid_cons_id." ORDER BY inpc_id DESC;";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$cont++;
	}
	if ($cont != 0) {
		$verifica = $pdo->query($sql);
		foreach ($verifica as $dados) {
			$atual++;
			if ($cont == $atual || $dados[2] == $ano_esperado && $dados[1] == $mes_esperado) {
				echo 	$dados[2] ."/". $dados[3];
				$condicao = false;
			} else if ($cont > $atual && $condicao) {
				echo 	$dados[2] ."/". $dados[3] . ",,";
			}
		}
	}
}



if (!empty($_REQUEST['atualizarValorCausa'])) {
	$totalRestituicao = 0;
	$cliente_unid_cons_id = $_REQUEST['cliente_unid_cons_id'];

	$sql = "SELECT * FROM cliente_unid_cons_conta WHERE cliente_unid_cons_id = ".$cliente_unid_cons_id." ORDER BY inpc_id DESC;";
	$verifica = $pdo->query($sql);

	foreach ($verifica as $dados) {
		$totalRestituicao = (float) $totalRestituicao + (float) $dados[10];
	}

	$sql = "UPDATE cliente_unid_cons SET vlr_causa = ".$totalRestituicao." WHERE id_cliente_unid_cons = ".$cliente_unid_cons_id.";";
	$verifica = $pdo->prepare($sql);
	$verifica->execute();
	
	echo $verifica;
}
?>