<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

if (!empty($_REQUEST['excluir_unid_cons'])) {
	$id 	= $_REQUEST['id'];
	$table 	= $_REQUEST['table'];
	$colunn = "";

	if ($table == 'abastecimento') {
		$colunn = "id_abastecimento";
	}
	if ($table == 'bomba') {
		$colunn = "id_bomba";
	}
	if ($table == 'caminhao') {
		$colunn = "id_caminhao";
	}
	if ($table == 'cor') {
		$colunn = "id_cor";
	}
	if ($table == 'estado') {
		$colunn = "id_estado";
	}
	if ($table == 'marca') {
		$colunn = "id_marca";
	}
	if ($table == 'empresa') {
		$colunn = "id_empresa";
	}
	if ($table == 'terceiros') {
		$colunn = "id_terceiros";
	}
	if ($table == 'proprietario') {
		$colunn = "id_proprietario";
	}

	$sql = "DELETE FROM ".$table." WHERE ".$colunn." = ".$id.";";
	if ($table == "vinculado") {
		$verifica = "Registro possui vinculo e não pode se excluido!";
	} else {
		$verifica = $pdo->prepare($sql);
		$verifica->execute();
		$verifica = "1";
	}
	echo $verifica;
}

if (!empty($_REQUEST['atualiza_valores'])) {
	$id_bomba = $_REQUEST['bomba'];
	$sql = "SELECT * FROM bomba WHERE id_bomba = ".$id_bomba.";";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		echo $dados["volume_atual"].",,".$dados["volume_total"];
	}
}

if (!empty($_REQUEST['validar_placa'])) {
	$placa = $_REQUEST['placa'];
	$sql = "SELECT COUNT(placa) FROM caminhao WHERE placa = '".$placa."';";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		if ($dados[0] > 0) {
			echo "0";
		} else{
			echo "1";
		}
	}
}

if (!empty($_REQUEST['pesquisa_empresa_select'])) {
	$sql = "SELECT * FROM empresa;";
	$verifica = $pdo->query($sql);
	echo " 
		<label class=\"label-float\">Empresa:</label>
		<select class='form-control' id='empresa_id' require> ";
	foreach ($verifica as $dados) {
		echo "<option value='".$dados[0]."'>".$dados[1]."</option>";
	}
	echo "</select>";
}

if (!empty($_REQUEST['pesquisa_bomba_select'])) {
	$sql = "SELECT * FROM bomba;";
	$verifica = $pdo->query($sql);
	echo " 
		<label class=\"label-float\">Bomba de Abastecimento:</label>
		<select class='form-control' id='bomba_id' onchange='atualizaValores();' require> ";
	foreach ($verifica as $dados) {
		echo "<option value='".$dados[0]."'>".$dados[1]."</option>";
	}
	echo "</select>";
}

if (!empty($_REQUEST['pesquisa_bomba_select_ex'])) {
	$sql = "SELECT * FROM bomba;";
	$verifica = $pdo->query($sql);
	echo " 
		<label class=\"label-float\">Bomba de Abastecimento:</label>
		<select class='form-control' id='bomba_id' onchange='definiBomba();'> ";
	foreach ($verifica as $dados) {
		echo "<option value='".$dados[0]."'>".$dados[1]."</option>";
	}
	echo "</select>";
}

if (!empty($_REQUEST['pesquisa_estado_select'])) {
	$sql = "SELECT * FROM estado;";
	$verifica = $pdo->query($sql);
	echo " 
		<label class=\"label-float\">Estado/UF:</label>
		<select class='form-control' id='estado_id' require> ";
	foreach ($verifica as $dados) {
		echo "<option value='".$dados[0]."'>".$dados[1]."</option>";
	}
	echo "</select>";
}


if (!empty($_REQUEST['pesquisa_cor_select'])) {
	$sql = "SELECT * FROM cor;";
	$verifica = $pdo->query($sql);
	echo " 
		<label class=\"label-float\">Cor:</label>
		<select class='form-control' id='cor_id' require> ";
	foreach ($verifica as $dados) {
		echo "<option value='".$dados[0]."'>".$dados[1]."</option>";
	}
	echo " </select>";
}

if (!empty($_REQUEST['pesquisa_marca_select'])) {
	$sql = "SELECT * FROM marca;";
	$verifica = $pdo->query($sql);
	echo " 
		<label class=\"label-float\">Marca:</label>
		<select class='form-control' id='marca_id' require> ";
	foreach ($verifica as $dados) {
		echo "<option value='".$dados[0]."'>".$dados[1]."</option>";
	}
	echo " </select>";
}



if (!empty($_REQUEST['pesquisa_prprietario_select'])) {
	$sql = "SELECT * FROM proprietario;";
	$verifica = $pdo->query($sql);
	echo " 
		<label class=\"label-float\">Proprietario:</label>
		<select class='form-control' id='proprietario_id' require> ";
	foreach ($verifica as $dados) {
		echo "<option value='".$dados[0]."'>".$dados[1]."</option>";
	}
	echo " </select>";
}



if (!empty($_REQUEST['pesquisa_terceiros_select'])) {
	$sql = "SELECT * FROM terceiros ORDER BY descricao ASC;";
	$verifica = $pdo->query($sql);
	echo " 
		<label class=\"label-float\">Terceiros:</label>
		<select class='form-control' id='terceiros_id' require> ";
	foreach ($verifica as $dados) {
		echo "<option value='".$dados[0]."'>".$dados[1]."</option>";
	}
	echo " </select>";
}


if (!empty($_REQUEST['pesquisa_terceiros_doc_select'])) {
	$sql = "SELECT * FROM terceiros ORDER BY descricao ASC;";
	$verifica = $pdo->query($sql);
	echo " 
		<label class=\"label-float\">Terceiros:</label>
		<select class='form-control' id='terceiros_id' onchange='definriId();' require> ";
	foreach ($verifica as $dados) {
		echo "<option value='".$dados[0]."'>".$dados[1]."</option>";
	}
	echo " </select>";
}



if (!empty($_REQUEST['pesquisa_caminhao_select'])) {
	$sql = "SELECT * FROM caminhao ORDER BY placa ASC;";
	$verifica = $pdo->query($sql);
	echo " 
		<datalist class='hidden' id='caminhao'> ";
	foreach ($verifica as $dados) {
		echo "<option value='".$dados["placa"]."'>";
	}
	echo " </datalist>";
}

if (!empty($_REQUEST['pesquisa_caminhao_vin_select'])) {
	$sql = "SELECT * FROM caminhao WHERE vin_media = 1 ORDER BY placa ASC;";
	$verifica = $pdo->query($sql);
	echo " 
		<datalist class='hidden' id='caminhao_vin'> ";
	foreach ($verifica as $dados) {
		echo "<option value='".$dados["placa"]."'>";
	}
	echo " </datalist>";
}

if (!empty($_REQUEST['pesquisa_caminhao_n_vin_select'])) {
	$sql = "SELECT * FROM caminhao WHERE vin_media = 0 ORDER BY placa ASC;";
	$verifica = $pdo->query($sql);
	echo " 
		<datalist class='hidden' id='caminhao_n_vin'> ";
	foreach ($verifica as $dados) {
		echo "<option value='".$dados["placa"]."'>";
	}
	echo " </datalist>";
}



if (!empty($_REQUEST['pesquisa_estado_nome'])) {
	$id_estado = $_REQUEST['id_estado'];
	$sql = "SELECT * FROM estado WHERE id_estado = ".$id_estado.";";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		echo $dados[1];
	}
}


if (!empty($_REQUEST['pesquisa_ano_entrada_select'])) {
	$cont = 0;
	$sql = "SELECT COUNT(ano), ano FROM entrada GROUP BY ano ORDER BY ano ASC;";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$cont ++;
	}
	echo "
		<label class=\"label-float\">Ano:</label>
		<select class=\"form-control\" onchange=\"definiAno()\" id=\"selectAno\">
	";
	if ($cont != 0) {
		$verifica = $pdo->query($sql);
		foreach ($verifica as $dados) {
			echo "<option value=".$dados[1].">".$dados[1]."</option>";
		}
	} else {
		echo "<option value=".date('Y').">".date('Y')."</option>";
	}
	echo "</select>";
}

if (!empty($_REQUEST['pega_id_caminhao'])) {
	$cont = 0;
	$placa = $_REQUEST['placa'];
	$sql = "SELECT * FROM caminhao WHERE placa = '".$placa."';";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$cont ++;
	}
	if ($cont != 0) {
		$verifica = $pdo->query($sql);
		foreach ($verifica as $dados) {
			echo $dados[0] . ",," . $dados["vin_media"];
		}
	} else {
		echo "0";
	}
}

if (!empty($_REQUEST['pesquisa_ano_saida_select'])) {
	$cont = 0;
	$sql = "SELECT COUNT(ano), ano FROM abastecimento GROUP BY ano ORDER BY ano ASC;";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$cont ++;
	}
	echo "
		<label class=\"label-float\">Ano:</label>
		<select class=\"form-control\" onchange=\"definiAno()\" id=\"selectAno\">
	";
	if ($cont != 0) {
		$verifica = $pdo->query($sql);
		foreach ($verifica as $dados) {
			echo "<option value=".$dados[1].">".$dados[1]."</option>";
		}
	} else {
		echo "<option value=".date('Y').">".date('Y')."</option>";
	}
	echo "</select>";
}

if (!empty($_REQUEST['pesquisa_mim_max_entrada'])) {
	$id_entrada = $_REQUEST['id_entrada'];
	$sql = "SELECT * FROM desconto_diesel WHERE entrada_id = ".$id_entrada.";";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		echo $dados["vlr_min"].",,".$dados["vlr_max"];
	}
}

if (!empty($_REQUEST['pesquisa_vlr_unit_data_select'])) {
	$cont = 0;
	$data = $_REQUEST['data'];
	$sql = "SELECT * FROM `entrada` WHERE data_entrada <= '".$data."' ORDER BY data_entrada DESC LIMIT 1;";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$cont ++;
	}
	if ($cont != 0) {
		$verifica = $pdo->query($sql);
		foreach ($verifica as $dados) {
			echo $dados["vlr_unit"];
		}
	}
	
}









if (!empty($_REQUEST['atualiza_situacao'])) {
	$id_unid_cons 	= $_REQUEST['id_unid_cons'];

	$sql = "SELECT * FROM cliente_unid_cons WHERE id_cliente_unid_cons = ".$id_unid_cons;
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$situacao = ($dados["situacao_id"] < 5) ? ((int) $dados["situacao_id"] + 1) : $situacao = $dados["situacao_id"];
	}

	$sql = "UPDATE cliente_unid_cons SET situacao_id = ".$situacao." WHERE id_cliente_unid_cons = ".$id_unid_cons.";";
	$verifica = $pdo->prepare($sql);
	$verifica->execute();
	echo $verifica;
}


if (!empty($_REQUEST['verificarVendas'])) {
	$id_cliente	= $_REQUEST['id_cliente'];
	$compra = 0;
	$unidades = 0;

	$sql = "SELECT * FROM venda WHERE cliente_id = ".$id_cliente.";";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$compra += $dados[2];
	}
	$sql = "SELECT * FROM cliente_unid_cons WHERE cliente_id = ".$id_cliente.";";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$unidades ++;
	}
	if ($unidades < $compra) {
		echo "1";
	} else {
		echo "0";
	}
}

if (!empty($_REQUEST['listar_questionario'])) {
	$cont = 0; $atual = 0;
	$sql = "SELECT * FROM pergunta";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$cont ++;
	}
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		?>
		<div ng-model="questoes" class='info' ng-init="questoes = 0"  class="pergunta">
			<!-- {{questoes}} -->
			<span class='ativar' id="ja<?php echo $dados[0]?>" onclick="questao(<?php echo $dados[0].",".$cont.",'j'"?>)">
				<i class="fa fa-chevron-right" aria-hidden="true"></i>&nbsp;&nbsp;
				<?php echo $dados[1]?>
			</span>
			<span class='ativar' id="fechar<?php echo $dados[0]?>" onclick="questao(<?php echo $dados[0].",".$cont.",'f'"?>)">
				<i class="fa fa-chevron-down" aria-hidden="true"></i>&nbsp;&nbsp;
				<?php echo $dados[1]?>
			</span>
			<span class='desativar' id="abrir<?php echo $dados[0]?>" onclick="questao(<?php echo $dados[0].",".$cont.",'a'"?>)">
				<i class="fa fa-chevron-right" aria-hidden="true"></i>&nbsp;&nbsp;
				<?php echo $dados[1]?>
			</span>
			<span id="resp<?php echo $dados[0]?>" class="resposta">
				<br><br>
				<?php echo $dados[2]?>
				<br><br>
			</span>
		</div>
		<?php		
	}
}
?>