<?php
	require_once "../class/conexao.php";

	$conn = new Conexao();
	$pdo = $conn->Connect();

	include "dados.php";

	$gl_local_e_data = "";

	use Dompdf\Dompdf;
	require_once "../dompdf_gerar/dompdf/autoload.inc.php";

	$dompdf = new DOMPDF();
	$dompdf->load_html('

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Concessão de Direitos</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div align="center">
					<font size="5">
						Concessão de Direitos
					</font>
					<br>
				</div>
				<br><br><br><br>
				<div align="justify">
					<font size="3">
					Eu, <b>'.$pr_cliente_unid_cons_proprietario.'</b>, '.$pr_nacionalidade.', '.$pr_profissao.', '.$pr_estado_civil.', residente e domiciliado na '.$pr_endereco_completo.', registrado no CPF sob número '.$pr_reg_federal.' e RG '.$pr_reg_estadual.', referido como e na qualidade de Proprietário do imóvel Locado ou Cedido para <b>'.$cl_cliente.'</b>, '.$cl_nacionalidade.', '.$cl_profissao.',&nbsp; registrado no CPF sob número '.$cl_reg_federal.' e RG '.$cl_reg_estadual.', residente e domiciliado na '.$cl_endereco_completo.', referido como Ocupante, emito esta Concessão de Direitos para que o&nbsp; Ocupante requeira as restituições de ICMS sobre os pagamentos de impostos recolhidos sobre Energia Elétrica cujos pagamentos foram pagos pelo Ocupante.
					</font>
					<br>
				</div>
				<div align="justify">
					<br>
				</div>
				<div align="justify">
					<br>
					<font size="3">
						O imóvel está registrado junto a empresa <b>'.$ce_cia_energia.'</b> sob o número de instalação <b>'.$uc_nro_instalacao.'</b>, e se encontra na
						<i> '.$uc_endereco_completo.'</i>.
					</font>
					<br>
				</div>
				<font size="3">
					<br><br><br><br>
					Sendo só para o momento,
					<br><br><br><br>
					'.$gl_local_e_data.'
					<br><br><br><br><br>
				</font>
				<div align="center">
				<font size="3">
				________________________________________________
				</font>
				<br>
				</div>
				<div align="center">
				<font size="3">
				<b>'.$pr_cliente_unid_cons_proprietario.'</b>
				</font>
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