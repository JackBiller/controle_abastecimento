<?php
	require_once "../class/conexao.php";

	$conn = new Conexao();
	$pdo = $conn->Connect();

	include "dados.php";

	// $gl_local_e_data = "";

	use Dompdf\Dompdf;
	require_once "../dompdf_gerar/dompdf/autoload.inc.php";

	$dompdf = new DOMPDF();
	$dompdf->load_html('

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Declaração de Hiposuficiência</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div align="center">
					<font size="3">
						<font size="4">
							<b>DECLARAÇÃO DE HIPOSSUFICIÊNCIA</b>
						</font>
					</font>
					<br>
				</div>
				<font size="3">
					<br>
					<font size="4">
						<br>&nbsp;<br><br>
					</font>
				</font>
				<div align="justify">
					<font size="4">
						Eu,<b> '.$cl_cliente.'</b>, '.$cl_nacionalidade.', '.$cl_estado_civil.',&nbsp; '.$cl_profissao.', portador(a) do RG n° '.$cl_reg_estadual.' e do CPF n° '.$cl_reg_federal.', residente e domiciliado(a) na '.$cl_endereco_completo.', DECLARO, para todos os fins de direito e sob as penas da lei, que não tenho condições de arcar com as despesas inerentes ao presente processo, sem prejuízo do meu sustento e de minha família, necessitando, portanto, da Gratuidade da Justiça, nos termos do art. 98 e seguintes da Lei 13.105/2015 (Código de Processo Civil). Requeiro, ainda, que o benefício abranja a todos os atos do processo.
					<br>
					</font>
				</div>
				<font size="4">
					<br><br><br>&nbsp;<br><br>
				</font>
				<div align="right">
					<font size="4">'.$gl_local_e_data.'
						<br>
					</font>
				</div>
				<font size="4">
					<br><br><br><br>
				</font>
				<div align="center">
					<font size="4">
						___________________________________<br>
						<b>'.$cl_cliente.'</b>
					</font>
					<br>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
	 ');
	 $dompdf->render();
	 $dompdf->stream(
	 	"nome.pdf",
	 	array(
	 		"Attachment" => false
	 	)
	 );
?>