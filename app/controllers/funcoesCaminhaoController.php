<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

// funções da cia de energia
if (!empty($_REQUEST['pesquisa_caminhao'])) {
	$cont = 0;

	$sql = "SELECT * FROM caminhao ORDER BY placa ASC;";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$cont++;
	}
	if ($cont != 0) {
		$verifica = $pdo->query($sql);
		echo "
			<table class='table'>
				<tr bgcolor='white'>
					<td><b>Placa</b></td>
					<td><b>Cor</b></td>
					<td><b>Proprietario</b></td>
					<td><b>Marca</b></td>
					<td><b>Vin. Média</b></td>
					<td><b>Editar</b></td>
					<td><b>Excluir</b></td>
				</tr>
			";
		foreach ($verifica as $dados) {
			echo "
				<tr id='linha".$dados[0]."'>
					<td style='text-transform: uppercase;'>".$dados["placa"]."</td>";
			
			$sql = "SELECT * FROM cor WHERE id_cor = ".$dados["cor_id"].";";
			$verifica2 = $pdo->query($sql);
			foreach ($verifica2 as $dados2) {
				echo "<td>".$dados2["descricao"]."</td>";
			}

			$sql = "SELECT * FROM proprietario WHERE id_proprietario = ".$dados["proprietario_id"].";";
			$verifica3 = $pdo->query($sql);
			foreach ($verifica3 as $dados3) {
				echo "<td>".$dados3["nome"]."</td>";
			}

			$sql = "SELECT * FROM marca WHERE id_marca = ".$dados["marca_id"].";";
			$verifica4 = $pdo->query($sql);
			foreach ($verifica4 as $dados4) {
				echo "<td>".$dados4["descricao"]."</td>";
			}

			if ($dados["vin_media"] == 1) {
				echo "<td>Sim</td>";
			} else{
				echo "<td>Não</td>";
			}
			
			echo "
					
					<td>
						<a href='#!editar_caminhao' style='color: #f0ad4e;' data-id='".$dados[0]."' onclick='editar(this);' title='Editar'>
							<b><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></b>
						</a>
					</td>
					<td>
						<a href='#!caminhoes' style='color: red;' data-id='".$dados[0]."' onclick=\"excluir(this , 'caminhao')\" title='Excluir'>
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


if (!empty($_REQUEST['pesquisa_caminhao_placa'])) {
	$cont = 0;
	$placa = $_REQUEST['placa'];
	$placa = str_replace("-","",$placa);
	$placa = str_replace("_","",$placa);

	if (strlen($placa) < 3) {
		$placa = $_REQUEST['placa'];
		$placa = str_replace("-","",$placa);
		$placa = str_replace("_","",$placa);
	} else{
		$placa = $_REQUEST['placa'];
		$placa = str_replace("_","",$placa);
	}

	$sql = "SELECT * FROM caminhao WHERE placa LIKE '".$placa."%' ORDER BY placa ASC;";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$cont++;
	}
	if ($cont != 0) {
		$verifica = $pdo->query($sql);
		echo "
			<table class='table'>
				<tr bgcolor='white'>
					<td><b>Placa</b></td>
					<td><b>Cor</b></td>
					<td><b>Proprietario</b></td>
					<td><b>Marca</b></td>
					<td><b>Vin. Média</b></td>
					<td><b>Editar</b></td>
					<td><b>Excluir</b></td>
				</tr>
			";
		foreach ($verifica as $dados) {
			echo "
				<tr id='linha".$dados[0]."'>
					<td style='text-transform: uppercase;'>".$dados["placa"]."</td>";
			
			$sql = "SELECT * FROM cor WHERE id_cor = ".$dados["cor_id"].";";
			$verifica2 = $pdo->query($sql);
			foreach ($verifica2 as $dados2) {
				echo "<td>".$dados2["descricao"]."</td>";
			}

			$sql = "SELECT * FROM proprietario WHERE id_proprietario = ".$dados["proprietario_id"].";";
			$verifica3 = $pdo->query($sql);
			foreach ($verifica3 as $dados3) {
				echo "<td>".$dados3["nome"]."</td>";
			}

			$sql = "SELECT * FROM marca WHERE id_marca = ".$dados["marca_id"].";";
			$verifica4 = $pdo->query($sql);
			foreach ($verifica4 as $dados4) {
				echo "<td>".$dados4["descricao"]."</td>";
			}

			if ($dados["vin_media"] == 1) {
				echo "<td>Sim</td>";
			} else{
				echo "<td>Não</td>";
			}
			
			echo "
					
					<td>
						<a href='#!editar_caminhao' style='color: #f0ad4e;' data-id='".$dados[0]."' onclick='editar(this);' title='Editar'>
							<b><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></b>
						</a>
					</td>
					<td>
						<a href='#!caminhoes' style='color: red;' data-id='".$dados[0]."' onclick=\"excluir(this , 'caminhao')\" title='Excluir'>
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