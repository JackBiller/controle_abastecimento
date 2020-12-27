<?php
	require_once "../class/conexao.php";

	$conn = new Conexao();
	$pdo = $conn->Connect();

	include "dados.php";

	$gl_valor_causa_formatado = "";
	$gl_valor_causa_extenso = "";

	use Dompdf\Dompdf;
	require_once "../dompdf_gerar/dompdf/autoload.inc.php";

	$dompdf = new DOMPDF();
	$dompdf->load_html('

<!DOCTYPE html>
<html>
<head>
	<title>Requirimento das Contas de Luz</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div align="justify">

<font size="3">
<b>EXCELENTÍSSIMO(A) SENHOR(A) JUÍZ(A) DE DIREITO DO JUIZADO ESPECIAL CÍVEL&nbsp; DA COMARCA DE '.$uc_cidade.', ESTADO DE '.$uc_estado.'. A QUEM COUBER POR DISTRIBUIÇÃO LEGAL.</b>
<br><br>
'.$cl_cliente.', '.$cl_estado_civil.', '.$cl_profissao.', portador do RG '.$cl_reg_estadual.', e inscrito no CPF/MF sob o n° '.$cl_reg_federal.', residente e domiciliado à '.$cl_endereco_completo.', com fundamentos nos artigos 19, inciso I, 318 e 294 do Código de Processo Civil; e artigos 151, V e 166 do Código Tributário Nacional, e nas Leis&nbsp; N° 9.099, DE 26 DE SETEMBRO DE 1995 e N° 12.153, DE 22 DE DEZEMBRO DE 2009, vem respeitosamente à presença de Vossa Excelência, propor:
<br><br><b>
AÇÃO DECLARATÓRIA c/c REPETIÇÃO DE INDÉBITO COM PEDIDO DE TUTELA ANTECIPADA</b>
<br><br>
Em face da Fazenda Pública do Estado de '.$sf_estado.', na pessoa do seu representante legal, situado à '.$sf_endereco_completo.', pelas razões de fato e de direito a seguir aduzidas.
<br><br>
Ocorre que, conforme será demonstrado, o montante exigido do consumidor final na conta de energia elétrica inclui os custos de transmissão e distribuição da eletricidade e, sobre estes, há incidência de ICMS (Imposto sobre Circulação de Mercadorias e Serviços) mesmo inexistindo fato gerador do tributo em questão neste ponto. Há, ainda, a incidência do mesmo imposto estadual sobre outros valores destacados e que não correspondem ao preço efetivo da energia consumida. 
<br><br>
Com isso, a parte demandante busca o provimento jurisdicional para obter a declaração de inexigibilidade das cobranças impugnadas, o que deverá culminar na exclusão dos valores cobrados a estes títulos (ICMS sobre custos adjacentes ao valor da energia consumida) nas contas de luz vincendas após o trânsito em julgado e na repetição de indébito dos valores indevidamente exigidos e pagos, tanto nos 5 anos anteriores ao ajuizamento desta ação quanto nos meses posteriores ao ajuizamento da lide em que o tributo tenha sido repassado pela concessionária e regularmente pago pelo consumidor.
<br><br><b>
PRELIMINARMENTE
</b><br><br>
De forma preemptiva e de maneira a facilitar o conhecimento da questão principal por Vossa Excelência, relevante se mostra tecer algumas considerações sobre matérias que provavelmente serão alegadas pela requerida em sua peça contestatória. 
<br><br>
Assim sendo, a parte requerente fixa, desde já, as teses segundo as quais deverão ser afastadas eventuais alegações de incompetência deste juízo, bem como de ilegitimidade ativa ou passiva.
<br><br>
Definição da legitimidade ativa
<br><br>
Em casos análogos ao presente, tem sido costumeiro por parte dos Estados-membros alegarem a ilegitimidade ativa ad causam dos demandantes, aduzindo em linhas gerais que estes, como contribuintes de fato, não teriam legitimidade ativa para pleitear a restituição de ICMS pago indevidamente, sendo que apenas os contribuintes de direito é que possuiriam legitimidade para fazê-lo. Defendem que a relação jurídica tributária adjacente ao ICMS incidente sobre a energia elétrica é integrada pelas concessionárias dos respectivos serviços, de forma que estas deteriam exclusivamente a legitimidade ativa para discutir tais questões. No entanto, a matéria objeto de comento já foi alvo de julgamento pelo Superior Tribunal de Justiça. Esta Corte firmou orientação, sob o rito dos recursos repetitivos (REsp 1.299.303-SC, DJe 14/8/2012) que o consumidor final de energia elétrica tem legitimidade ativa para propor ação declaratória cumulada com repetição de indébito que tenha por escopo afastar a incidência de ICMS sobre a demanda contratada e não utilizada de energia elétrica. Outro não poderia ser o entendimento emanado pelo STJ já que, considerando a parceria (e a subserviência) das concessionárias de energia elétrica com o Estado concedente e a completa inexistência de conflito de interesses entre ambos, a declaração de ilegitimidade do consumidor final teria o condão prático de impedir qualquer discussão de ilegalidade de cobrança de ICMS. Há de se levar em conta, finalmente, que o art. 166 do Código Tributário Nacional garante àquele que paga indevidamente o direito de pleitear por sua restituição.
<br><br>
Assim sendo, resta suficientemente delimitada a legitimidade ativa da parte demandante desta lide, sendo permitido eventual litisconsórcio para que figurem vários contribuintes no polo ativo por força do artigo 46, incisos II e IV do Código de Processo Civil. <br><br>Definição da legitimidade passiva 
<br><br>
É possível, adicionalmente, que o Estado demandando aduza em sua contestação a tese de ilegitimidade passiva, defendendo a legitimidade exclusiva da concessionária de energia elétrica para atuar no feito. Inobstante, como é cediço, as concessionárias somente arrecadam e transferem os valores referentes ao tributo para o Estado concedente. Por isso, a legitimidade passiva é exclusiva do Estado federado. Precedentes nesse mesmo sentido: REsp 1.199.427/MT, Relator Ministro Herman Benjamin, julgado em 16/09/2010; REsp 1185820/MT, Relator Ministro Castro Meira, julgado em 17/06/2010. Assim sendo, resta suficientemente delimitada a legitimidade passiva da parte demandada desta lide.
<br><br><b>
DO PEDIDO DE DISPENSA DA AUDIÊNCIA DE CONCILIAÇÃO - INEXISTÊNCIA DE POSSIBILIDADE PRÁTICA DE AUTOCOMPOSIÇÃO NO CASO EM CONCRETO</b>
<br><br>
Com vistas a obter maior celeridade processual, garantindo o efetivo contraditório e evitando diligências inúteis e/ou que não tragam qualquer resultado útil ao processo, o autor pleiteia a Vossa Excelência que dispense a audiência de conciliação normalmente designada em sede de Juizados Especiais.
<br><br>
O pedido acima formulado é realizado, conforme sobredito, diante da primazia pelo provimento jurisdicional satisfativo, de forma a suprimir uma fase processual que notadamente será inócua diante até mesmo de eventual incompetência dos procuradores da Fazenda Estadual demandada para reconhecerem a procedência do pedido - originando a completa impossibilidade de transação nos autos. Destarte, requer seja o réu citado para oferecimento de contestação no prazo legal.
<br><b><br>
DOS FATOS
</b><br><br>
O(a) Autor(a) reside no imóvel sito a Rua '.$uc_endereco_completo.', responsável direto pelo pagamento da conta de energia elétrica referente ao contrato de n° '.$uc_nro_instalacao.'.
<br><br>
Na qualidade de proprietário e usuário do imóvel contribuinte de fato do ICMS, constatou o Autor
<br>
que o Estado de '.$uc_estado.' vem cobrando tributos de forma indevida, uma vez que utiliza como patamar valores diversos daqueles previstos constitucionalmente, pois aplica o referido tributo também sobre as tarifas de uso do sistema de transmissão e distribuição de energia proveniente da rede básica de transmissão (TUST/TUSD) e sobre os engargos setoriais.
<br><br>
Destarte, face à incidência indevida do tributo ICMS na conta de energia elétrica, resta ao Autor
<br>
ver declarada a inexistência de relação jurídica tributária que o obrigue a recolher o Imposto Sobre
<br>
Circulação de Mercadorias e Serviços (ICMS) sobre quaisquer encargos de transmissão e distribuição, resumindo-se à famigerada base de cálculo ao montante efetivamente pago a título de fornecimento e consumo de energia elétrica e, consequentemente, a repetição do indébito do ICMS recolhidos no lustro.
<br><br>
<b>
DO DIREITO:
</b>
<br><br>
A presente ação encontra supedâneo no artigo 155, inciso II da Constituição Federal e artigo 34,
<br>
inciso IX do ADCT, que assim dispõem:
<br><br>
“Artigo 155 - Compete aos Estados e ao Distrito Federal instituir imposto sobre: Inciso II - Operação relativas a à circulação de mercadorias e sobre prestações de serviços de transportes interestadual e intermunicipal e de comunicação ainda que as operações e as prestações se iniciem no exterior”
<br><br>
“Artigo 34 - ADCT - O sistema tributário nacional entrará em vigor a partir do primeiro dia do quinto mês seguinte ao da promulgação da Constituição, mantido, até então, o da Constituição de 1967, com a redação dada pela Emenda n° 1, de 1969, e pelas posteriores.
<br><br>
§ 9° - Até que lei complementar disponha sobre a matéria, as empresas distribuidoras de energia elétrica, na condição de contribuintes ou de substitutos tributários, serão as responsáveis, por ocasião da saída do produto de seus estabelecimentos, ainda que destinado a outra unidade da Federação, pelo pagamento do imposto sobre operações relativas à circulação de mercadorias incidente sobre energia elétrica, desde a produção ou importação até a última operação, calculado o imposto sobre o preço então praticado na operação final e assegurado seu recolhimento ao Estado ou ao Distrito Federal, conforme o local onde deva ocorrer essa operação”.
<br><br>
Registre-se ainda a Lei Complementar n° 87/1996, que determinou e especificou às hipóteses de
<br>
incidência do tributo ICMS; em conformidade com o disposto no artigo 155, inciso II da Constituição Federal, na redação expressa do artigo 2°, in verbis:
<br><br>
“Art. 2° O imposto incide sobre:
<br><br>
I - operações relativas à circulação de mercadorias, inclusive o fornecimento de alimentação e bebidas em bares, restaurantes e estabelecimentos similares;”
<br><br>
Assim sendo, face às características e especificidades, a energia elétrica circula nos fios de
<br>
transmissão da cessionária e somente será individualizada se e quando utilizada.
<br><br>
De igual modo, o fato gerador do imposto só pode ocorrer pela entrega da energia ao consumidor,
<br>
nos termos definidos pelo artigo 12, inciso I da Lei Complementar 87/1997. Vejamos:
<br><br>
“Art. 12. Considera-se ocorrido o fato gerador do imposto no momento:
<br><br>
I - da saída de mercadoria de estabelecimento de contribuinte, ainda que para
<br>
outro estabelecimento do mesmo titular;
<br><br>
Infere-se portanto que o fato gerador do imposto estadual ICMS ocorre na efetiva entrega da
<br>energia elétrica ao consumidor, concretizando no ato da entrada da energia em sua propriedade.
<br>
Entendimento este é ratificado pela Agencia Nacional de Energia Elétrica - ANEEL, na resolução 414/2010, onde esclarece o momento em que ocorre a transferência da mercadoria (energia elétrica), conforme segue:
<br><br>
“Art. 14. O ponto de entrega é a conexão do sistema elétrico da distribuidora com a unidade consumidora e situa-se no limite da via pública com a propriedade onde esteja localizada a unidade consumidora, exceto quando:
<br><br>
“Art. 15. A distribuidora deve adotar todas as providências com vistas a viabilizar o fornecimento, operar e manter o seu sistema elétrico até o ponto de entrega, caracterizado como o limite de sua responsabilidade, observadas as condições estabelecidas na legislação e regulamentos aplicáveis”.
<br><br>
É de conhecimento público e notório que o ponto de entrega da energia elétrica é o relógio
<br>
medidor, oportunidade em que a energia será individualizada; dessa forma, caracterizada a circulação a dar ensejo à cobrança do tributo o que determina o sujeito passivo da obrigação tributária.
<br><br>
Ademais, impor ao contribuinte o pagamento do tributo ICMS sobre as tarifas que remuneram a<br>transmissão e distribuição da energia elétrica, nada mais é do que a incidência do tributo sobre fato gerador não previsto em Lei, caracterizando assim, flagrante violação ao princípio constitucional, artigo 150, incido I, que assim prescreve:<br><br>“Art. 150. Sem prejuízo de outras garantias asseguradas ao contribuinte, é vedado à União, aos Estados, ao Distrito Federal e aos Municípios:<br><br>I - exigir ou aumentar tributo sem lei que o estabeleça”;
<br><br>
Neste sentido, temos a farta jurisprudência:
<br><br>
"PROCESSO CIVIL E TRIBUTÃRIO. VIOLAÇÃO DO ART. 535 DO CPC. NÃO OCORRÊNCIA. ICMS SOBRE "TUST" E "TUSD". NÃO INCIDÊNCIA. AUSÊNCIA DE CIRCULAÇÃO JURÍDICA DA MERCADORIA. RECEDENTES. SÊMULA 83/STJ. RECURSO ESPECIAL NÃO CONHECIDO"(STJ - AgRg no RECURSO ESPECIAL N° 1.408.485 - SC (2013/0330262-7)
<br>
Ação Declaratória c.c. Repetição voltada à exclusão do TUST e do TUSD da base de cálculo do ICMS lançado contra as requerentes. A Tarifa de Uso do Sistema de Transmissão (TUST) e a Tarifa de Uso do Sistema de Distribuição (TUSD) constituem encargos pelo uso da rede geradora de energia, ou pelo uso do sistema de distribuição. Jurisprudência vem se firmando no sentido de não inclusão na base de cálculo do ICMS dos valores das referidas tarifas. Legitimidade ativa das autoras para a presente ação. Repetição do indébito devida. Aplicação da taxa SELIC no que tange a atualização monetária e juros de mora. Verba honorária advocatícia reduzida. Recurso fazendário improvido, acolhido parcialmente o apelo dos autores e a remessa necessária.(TJSP-APELAÇÃO N° 1040095-08.2014.8.26.0053).
<br><br>
Consolidado os precedentes, conclui-se demonstrado a necessidade de afastar-se a cobrança e
<br>
declarar a impossibilidade de incidência do ICMS sobre os encargos de transmissão ou distribuição pagos pelo Autor, especificamente a título de TUST e TUSD.
<br><br>
<b>DA REPETIÇÃO DO INDÉBITO:</b>
<br><br>
Reconhecido o direito aduzido, o Autor requer a repetição de indébito dos pagamentos realizados no último lustro a título de ICMS incidente sobre TUST e TUSD, conforme planilha de cálculos e contas em anexo.
<br><br>
Note-se que este é o entendimento pacífico do Superior Tribunal de Justiça, que nos autos do Recurso Especial n° 1.111.003/PR, sob o rito do artigo 543 do CPCP, assentou que os comprovantes de pagamento no caso de repetição de indébito, não são necessários para conhecimento do direito do Autor, não se fazendo necessário no presente momento a juntada de todos os comprovantes dos pagamentos realizados nos últimos 05 (cinco) anos. Tendo em vista que estes documentos devem ser apresentados aos autos pelas Requeridas, ou mesmo juntados pelo Autor no momento oportuno, qual seja o da liquidação de sentença.
<br><br>
<b>DA TUTELA ANTECIPADA:</b>
<br><br>
Comprovando que estão presentes os requisitos implícitos no artigo 294 do Código de Processo Civil, quais sejam:
<br><br>
1. A prova inequívoca consubstanciada nos documentos ora apresentados que caracteriza e evidencia o direito pleiteado;
<br><br>
2. Fundado receio de dano irreparável ou de difícil reparação, haja vista que a cobrança indevida do tributo ICMS incidente sobre TUST e TUSD, realiza-se mensalmente, caracterizando assim urgência na interrupção das cobranças.
<br><br>
Requer a Vossa Excelência a concessão da Antecipação da Tutela em cognição liminar, determinando à autarquia-ré, a suspensão imediata da cobrança a título de ICMS incidente sobre TUST e TUSD e consequentemente a suspensão da exigibilidade do crédito tributário nos termos do artigo 151, V do Código Tributário Nacional, cujos comprovantes serão apresentados pela mesma.
<br><br>
<b>DOS PEDIDOS E REQUERIMENTOS:</b>
<br><br>
Ex positis requer:
<br><br>
A- A concessão da Antecipação de Tutela em cognição liminar, determinando a suspensão imediata da cobrança a título de ICMS incidente sobre TUST, TUSD e encargos setoriais e, consequentemente, a suspensão da exigibilidade do crédito tributário, nos termos do artigo 151, V do Código Tributário Nacional;
<br><br>
B- A Citação da Requerida para que, querendo, apresente defesa aos termos da presente e no prazo legal, sob pena de incorrer em confissão e revelia.
<br><br>
C- A procedência da presente demanda, declarando a inexistência de relação jurídico tributária quanto ao recolhimento do ICMS incidente sobre os encargos de TUST, TUSD e encargos setoriais, e fixar a base de cálculos do referido tributo, o montante relativo a energia elétrica efetivamente consumida, bem como a fim de condenar a Ré na restituição de todos os valores cobrados/recolhidos indevidamente nos últimos 05 (cinco) anos, acrescidos de juros e correção monetária;
<br><br>
D- Seja concedido à Parte Autora os benefícios da Lei 1060/50, uma vez que é pessoa pobre na acepção jurídica do term.
<br><br>Protesta provar o alegado por todos os meios de provas em direito admitidos, notadamente por juntada de documentos.
<br><br>
Dá-se à causa o valor de R$ '.$gl_valor_causa_formatado.' ('.$gl_valor_causa_extenso.') para fins de alçada.
<br><br>
Termos em que,
<br>
Pede deferimento.
<br><br>
'.$gl_local_e_data.'<br>
</font>
</div>
<font size="3">
<br><br><br>
</font>
<div align="center"><font size="3">
_________________________________________________
<br>
<b>'.$cl_cliente.'</b>
<br>
</font>
</div>
<br>
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