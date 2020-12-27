<?php
// Cliente_plano_trans.PHP
// Pegar o ID da transacao do pagSeguro - validar pagamento

// GET -> transaction_id

$usuario_conectado_alterar = false;
if ((!empty($_COOKIE["tipo"])) && (!empty($_COOKIE["cad_id"]))&& (!empty($_COOKIE["email"]))){
   $usuario_conectado_alterar = true;
}


include_once("config.inc.php");
include_once("funcoes.inc.php");
include_once("sql.inc.php");

$msg = "";
$act = isset($_POST["act"])?$_POST["act"]:"";
$id =  isset($_POST["id"])?$_POST["id"]:0;

$tipo = $_COOKIE["tipo"];

// Obter os dados para edi��o
$pessoa_tipo = "";
$nome = "";
$razao_social = "";
$reg_federal = "";
$end_logradouro = "";
$end_numero = 0;
$end_complemento = "";
$end_bairro = "";
$end_cidade = "";
$end_estado = "";
$end_cep = "";
$fone = "";
$fax = "";
$celular = "";
$email = "";
$site = "";
$categoria_id = 0;

// Plano=1, gratu�to, demais processar pagamento
$plano_id = isset($_POST["plano"])?$_POST["plano"]:"";;

if ($_COOKIE["cad_id"]<>""){

      $query = "SELECT * FROM convenio WHERE id_convenio=".$_COOKIE["cad_id"];
 

   $result = mysql_query($query) or die ("Erro executando a consulta '$query'.");

   $registros = mysql_num_rows($result);

   if ($registros >= 1){
      while ($row = mysql_fetch_assoc($result)){
          $pessoa_tipo = $row["pessoa_tipo"];
          $reg_federal = $row["reg_federal"];
          $nome = $row["nome"];
          $razao_social = $row["razao_social"];
          $end_logradouro = $row["end_logradouro"];
          $end_numero = $row["end_numero"];
          $end_complemento = $row["end_complemento"];
          $end_bairro = $row["end_bairro"];
          $end_cidade = $row["end_cidade"];
          $end_estado = $row["end_estado"];
          $end_cep = $row["end_cep"];
          $fone = $row["fone"];
          $fax = $row["fax"];
          $celular = $row["celular"];
          $email = $row["email"];
          $site = $row["site"];
     }
     $act = "edi";
   }
}*/

?>

<HTML>
<HEAD>
<TITLE></TITLE>

</HEAD>

<script language="javascript" src="allerscripts/mascara.js"></script>
<script language="javascript" src="allerscripts/funcoes.js"></script>

<body>

<?php include("link_acesso.php");?>

 <br><br>
 <table width="100%" border="0">
 <tr>
 <td width='200px' valign="top" align="center">
  <font color="#007cc3" size="+2">
 
 <?php
 if ($tipo=='cli'){
 ?>
 
    <img src="./imagens/btn_executivo.jpg" border="0" alt=""><br>
    Plano de Divulga&ccedil;&atilde;o do Cliente

 <?php
 
 }else if ($tipo=='cnv'){

 ?>

     <img src="./imagens/btn_organograma.jpg" border="0" alt=""><br>
    Plano de Divulga&ccedil;&atilde;o do Conv&ecirc;nio
<?php

}

?>

  </font>
 </td>
 <td valign='top'>

  <table cellpadding="2" cellspacing="2" border="0" align="center" width="100%">
        <tbody>

                                              
	  <tr align="center">
        <td bgcolor="#ffea7f" valign="top"><b>Plano de divulga&ccedil;&atilde;o</b><br>
      </td>
    </tr>

       <tr valign="top" align="center">
         <td>

<?php

// $plano_id � pego pelo POST acima
$plano_nome = $plano_[$plano_id][0];
$plano_valor = $plano_[$plano_id][1];

$ddd = substr($fone, 1, 2);
$fone = substr($fone, 5, 4).substr($fone, 10, 4);

// Verifica��o
echo "<h1>Fazer:</h1>";
echo "Plano escolhido: ".$plano_nome."<br>";
echo "DDD $ddd fone $fone<br>";

// Cadastrar a solicita��o
$query = "INSERT INTO cliente_plano(cliente_id,plano,dt_cadastro) VALUES(".$_COOKIE["cad_id"].",".$plano_id.",'".date("Y-m-d")."')";
$result = mysql_query($query) or die ("Erro no cadastramento de plano.");

// Pegar id do plano para se tornar referencia
$plano_referencia = mysql_insert_id();

// Pagar se tiver custo
if (($plano_[$plano_id][1])>0.00){
   require_once "PagSeguroLibrary/PagSeguroLibrary.php";
   echo "Voc&ecirc; ser&aacute; direcionado para o PagSeguro para processar o pagamento.<br>";
   
   //
   
   $url =
   
		// Instantiate a new payment request
		$paymentRequest = new PaymentRequest();

		// Sets the currency
		$paymentRequest->setCurrency("BRL");

		// Add an item for this payment request
		$paymentRequest->addItem('0001', "Plano ".$plano_nome, 1, $plano_valor, 0, 0.00);

		// Sets a reference code for this payment request, it is useful to identify this payment in future notifications.
		$paymentRequest->setReference($plano_referencia);

		// Sets shipping information for this payment request
		$CODIGO_SEDEX = ShippingType::getCodeByType('NOT_SPECIFIED');
		$paymentRequest->setShippingType($CODIGO_SEDEX);
		//$paymentRequest->setShippingAddress($end_cep,  $end_logradouro, $end_numero, $end_complemento, $end_bairro, $end_cidade, $end_estado, 'BRA');

		// Sets your customer information.
		$paymentRequest->setSender($nome, $email, $ddd, $fone);

		$paymentRequest->setRedirectUrl("http://www.zsuper.com.br/cliente_plano_trans.php");

		try {

			/*
			* #### Crendencials #####
			* Substitute the parameters below with your credentials (e-mail and token)
			* You can also get your credentails from a config file. See an example:
			* $credentials = PagSeguroConfig::getAccountCredentials();
			*/
			$credentials = new AccountCredentials("financeiro@aller.com.br", "9ADF3546B7F1463F911E17F2164606DB");

			// Register this payment request in PagSeguro, to obtain the payment URL for redirect your customer.
			$url = $paymentRequest->register($credentials);

			//self::printPaymentUrl($url);
			
    		if ($url) {
	    		echo "<h2>Plano cadastrado! Clique no link abaixo.</h2>";
    			//echo "<p>URL do pagamento: <strong>$url</strong></p>";
     			echo "<p><a title=\"Pagamento\" href=\"$url\">Clique aqui para processar pagamento.</a></p>";
      		}

		} catch (PagSeguroServiceException $e) {
			die($e->getMessage());
		}
   
   //
}

?>

        </td>
      </tr>
    </tbody>
  </table>

<p></p>
</td></tr>

</table>

<p></p>

</body>
</html>
