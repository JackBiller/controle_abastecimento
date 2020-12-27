<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

// funções da cia de energia
if (!empty($_REQUEST['pesquisa_caminhao'])) {
	$cont = 0;

	$sql = "SELECT * FROM usuario WHERE nivel = 2 ORDER BY nome ASC;";
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$cont++;
	}
	if ($cont != 0) {
		$verifica = $pdo->query($sql);
		echo "
		<table class='table'>
			<tr bgcolor='white'>
				<td><b>Nome</b></td>
				<td><b>Ativo</b></td>
				<td><b>Editar</b></td>
			</tr>
			";
			foreach ($verifica as $dados) {
				echo "
				<tr id='linha".$dados[0]."'>
					<td>".$dados["nome"]."</td>
					";
					
					if ($dados["bool_ativo"] == 1) {
						echo "<td>Sim</td>";
					} else echo "<td>Não</td>";

					echo "
					<td>
						<a href='#!editar_terceiros' style='color: #f0ad4e;' data-id='".$dados[0]."' onclick='editar(this);' title='Editar'>
							<b><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></b>
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