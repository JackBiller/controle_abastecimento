<?php
use Dompdf\Dompdf;
require_once "../dompdf_gerar/dompdf/autoload.inc.php";
include "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();
$cont = 0;
$erro404 = '<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br"><head><title>Objeto n&atilde;o encontrado!</title><link rev="made" href="mailto:postmaster@localhost" /><style type="text/css"><!--/*--><![CDATA[/*><!--*/ body { color: #000000; background-color: #FFFFFF; }a:link { color: #0000CC; }p, address {margin-left: 3em;}span {font-size: smaller;}/*]]>*/--></style></head><body><h1>Objeto n&atilde;o encontrado!</h1><p>A URL requisitada n&atilde;o foi encontrada neste servidor.Se voc&ecirc; digitou o endere&ccedil;o (URL) manualmente,por favor verifique novamente a sintaxe do endere&ccedil;o.</p><p>Se voc&ecirc; acredita ter encontrado um problema no servidor,por favor entre em contato com o <a href="mailto:postmaster@localhost">webmaster</a>.</p><h2>Error 404</h2><address><a href="/">localhost</a><br /><span>Apache/2.4.25 (Win32) OpenSSL/1.0.2j PHP/7.1.1</span></address></body></html>';

$codigo = $_GET['ptGl'];
$sigla = substr($codigo , -2);
$aleatorio = substr($codigo , -5 , -2);
$codigo2 = strlen($codigo)-5;
$codigo = substr($codigo , 0 , $codigo2);

if ($aleatorio < 500 && $aleatorio%2 == 0 && $sigla == "en") {
	$valido = true;
} else
if ($aleatorio < 500 && $aleatorio%2 != 0 && $sigla == "fr") {
	$valido = true;
} else
if ($aleatorio > 500 && $aleatorio%2 != 0 && $sigla == "ru") {
	$valido = true;
} else
if ($aleatorio > 500 && $aleatorio%2 == 0 && $sigla == "br") {
	$valido = true;
} else $valido = false;
if ($valido) {
	if ($codigo%89 == 0) {
		$id = $codigo/89;
		$sql  = "SELECT uc.* , ce.* , c.*" ;
		$sql .= " FROM cliente_unid_cons uc ";
		$sql .= " LEFT JOIN cliente_cia_energia ce ";
		$sql .= " ON uc.cliente_cia_energia_id = ce.id_cliente_cia_energia ";
		$sql .= " LEFT JOIN cliente c ";
		$sql .= " ON c.id_cliente = uc.cliente_id ";
		$sql .= " WHERE uc.id_cliente_unid_cons = ".$id;
		$verifica = $pdo->query($sql);
		foreach ($verifica as $dados) {
			$cont++;
		}
		if ($cont != 0) {
		 	$verifica = $pdo->query($sql);
		 	foreach ($verifica as $dados) {		
				$cia_energia = $dados[16];
				$estado_cia_energia = $dados[25];
				$anos_requeridos = 5;
				$cidade_cia_energia = $dados[24];
				$cidade_cliente = $dados[39] == null ? $dados[10] : $dados[39];
				$data_atual = date('m/Y');
				$requerente = $dados[27];
				$estado_civil = $dados[33];
				$reg_federal = $dados[29];
				$endereco = $dados[34] == null ? $dados[5] : $dados[34];
				$numero = $dados[34] == 0 ? $dados[6] : $dados[34];
				$cidade_uni_cons = $dados[10];
				$estado_uni_cons = $dados[11];
				$registro_geral = $dados[30];
				$bairro = $dados[37] == null ? $dados[8] : $dados[37];
				$cep_unid_cons = $dados[9];
				$cliente = $dados[27];
				$cpf_cliente = $dados[29];
				$rg_cliente = $dados[30];
				$num_isntalacao = $dados[2];
				$endereco_unid_cons = $dados[5].", n. ".$dados[6]." ".$dados[7].",bairro ".$dados[8].", ".$cidade_uni_cons."/".$estado_uni_cons;
				$mes_esperado = (date('m')+1) < 10 ? "0".(date('m')+1) : (date('m')+1);
				$data_inicial = $mes_esperado."/".(date('Y')-$anos_requeridos);
				$data_final = date('m/Y');

					$dompdf = new DOMPDF();
					$dompdf->load_html('

				<!DOCTYPE html>
				<html>
				<head>
					<title>Requirimento das Contas de Luz</title>
					<meta chaset="utf-8">
					<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
				</head>
				<body>
					<div class="container">
						<div class="row">
							<div class="col-md-12">
					<h3><b>
					ILMO. SR. DIRETOR DA '.$cia_energia.' (DISTRIBUIDORA DE ENERGIA) – AGÊNCIA DE '.$cidade_cia_energia.'/'.$estado_cia_energia.'<br><br><br>
					</b></h3>
					<h4>
					'.$cidade_cliente.' - '.$data_atual.'<br><br>
					Assunto: Solicitação de cópias das contas de energias do(os) último(os) '.$anos_requeridos.' ano(os) <br><br>
					</h4>
					<p class="lead text-justify">
					O/A '.$requerente.', brasileiro, '.$estado_civil.', portador do CPF n. '.$reg_federal.', RG n. '.$registro_geral.', residente e domiciliado na '.$endereco.', n. '.$numero.', bairro '.$bairro.', '.$cidade_uni_cons.'/'.$estado_uni_cons.', CEP '.$cep_unid_cons.', vem, através da presente solicitação, requerer a emissão de cópia das contas de energia do(os) último(os) '.$anos_requeridos.' ano(os) da sua unidade consumidora, onde conste a base de cálculo do ICMS pago.<br><br>
					Seguem os dados para consulta:<br>
					<ul>
					<li>Consumidor: '.$cliente.'</li>
					<li>CPF: '.$cpf_cliente.'</li>
					<li>RG: '.$rg_cliente.'</li>
					<li>Nº da Unidade Consumidora: '.$num_isntalacao.'</li>
					<li>Endereço da unidade consumidora: '.$endereco_unid_cons.'</li>
					<li>Período solicitado: '.$data_inicial.' até '.$data_final.'</li>
					</ul><br>
					Segue anexa cópia da última conta de energia.<br><br>
					Firmo o presente em 2 (duas) vias.</p><br><br>
					Att. <br><br><br>
					<b>
					__________________________ <br>
					REQUERENTE
					</b>
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
			}
		 }
	} else echo $erro404;
} else echo $erro404;
?>