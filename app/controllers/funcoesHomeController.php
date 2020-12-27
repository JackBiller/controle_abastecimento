<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

// include "funcoesHomeControllerEx.php";

// status bomba
$cont = 0;
$porcentagemAtual = 0;
$img = "";

$sql = "SELECT * FROM bomba;";
$verifica = $pdo->query($sql);
foreach ($verifica as $dados) {
	$cont++;
}
if ($cont != 0) {
	$verifica = $pdo->query($sql);
	foreach ($verifica as $dados) {
		$porcentagemAtual = ($dados["volume_atual"] * 100) / $dados["volume_total"];
		
		if ($porcentagemAtual > 90) {
			$img = "abastecimento100.png";
		} else if ($porcentagemAtual > 80) {
			$img = "abastecimento90.png";
		} else if ($porcentagemAtual > 70) {
			$img = "abastecimento80.png";
		} else if ($porcentagemAtual > 60) {
			$img = "abastecimento70.png";
		} else if ($porcentagemAtual > 50) {
			$img = "abastecimento60.png";
		} else if ($porcentagemAtual > 40) {
			$img = "abastecimento50.png";
		} else if ($porcentagemAtual > 30) {
			$img = "abastecimento40.png";
		} else if ($porcentagemAtual > 20) {
			$img = "abastecimento30.png";
		} else if ($porcentagemAtual > 15) {
			$img = "abastecimento20.png";
		} else {
			$img = "abastecimento.gif";
		}

		$porcentagemForm = (int) $porcentagemAtual;

		echo "
		<div class=\"row\">
          <div class=\"col-md-12\">
            <div class=\"panel panel-primary\">
                <div class=\"panel-heading\" style=\"padding-top: 1px;padding-bottom: 1px;\">
                    <h3>Situação da Bomba</h3>
                </div>
                <div class=\"panel-body\">
                    <div class=\"row\">
                     <div class=\"col-md-4\">

                        <img src=\"app/img_abastecimento_nivel/".$img."\" width=\"100%\" height=\"auto\">

                    </div>

                    <div class=\"col-md-8\" style=\"padding-top: 10%;\">
                        <div class=\"row\">
                            <div class=\"col-md-12\">
                                <h2 class=\"text-center\">".$dados["descricao"]."</h2>
                                <br>
                                <div class=\"progress\">
                                    <div class=\"progress-bar progress-bar-warning progress-bar-striped\" role=\"progressbar\" aria-valuenow=\"".$porcentagemAtual."\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"color: black;width: ".$porcentagemAtual."%\">
                                        <span class=\"sr-only\">
                                         ".$porcentagemAtual."% Complete (warning)
                                     </span>
                                 </div>
                             </div>
                             <div class=\"text-center\">
                                <span>
                                 Lt: ".$dados["volume_atual"]." / Lt: ".$dados["volume_total"]."
                                 &nbsp;-&nbsp;&nbsp;<b>".$porcentagemForm."%</b>
                             </span>
                         </div>

                     </div>

                 </div>
             </div>
         </div>
     </div>
 </div>
</div>";
}
} else {
    // echo "<h1>Nenhuma bomba de Abastecimento cadastrado</h1>";
	echo "
  <div class=\"col-md-4\">
    <div class=\"panel panel-primary\">
        <div class=\"panel-heading\" style=\"padding-top: 1px;padding-bottom: 1px;\">
            <h3>Situação da Bomba</h3>
        </div>
        <div class=\"panel-body\">
            <h4>Nenhum registro encontrado</h4>
            <img src=\"app/img_abastecimento_nivel/abastecimento.gif\" width=\"100%\" height=\"auto\">
            <br>
            <div class=\"progress\">
                <div class=\"progress-bar progress-bar-warning progress-bar-striped\" role=\"progressbar\" aria-valuenow=\"100\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 100%\">
                    <span class=\"sr-only\">100% Complete (warning)</span>
                </div>
            </div>
            <div class=\"text-center\">
                <span>
                 Lt: 000.00 / Lt: 000.00
             </span>
         </div>
     </div>
 </div>
</div>
";
}
?>