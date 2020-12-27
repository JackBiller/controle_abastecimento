<?php
// Escolher_Plano_Processar.PHP
// Alterar plano do cliente - validar pagamento


?>

<HTML>
<HEAD>
<TITLE></TITLE>

</HEAD>

<script language="javascript" src="allerscripts/mascara.js"></script>
<script language="javascript" src="allerscripts/funcoes.js"></script>

<body>


<?php

// $plano_id � pego pelo POST acima
$plano_nome = "Teste pag seguro";
$plano_valor = 100.00;

$nome = "Alex Leandro Rosa";
$email = "aller@aller.com.br";

$ddd = '35';
$fone = "37223916";

   require_once "PagSeguroLibrary/PagSeguroLibrary.php";
   echo "Voc&ecirc; ser&aacute; direcionado para o PagSeguro para processar o pagamento.<br>";
   
   //

// Verificar: comentado porque esta com erro sint�tico.
// Fazer: verificar.
//   $url =
   
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
   

?>
    

</table>

<p></p>

</body>
</html>
