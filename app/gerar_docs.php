<?php
// cliente_unid_cons_docs_exec.php
// Emissão de documentos da Unidade Consumidora

header("Cache-Control: no-cache, must-revalidate");
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<HTML>
    <HEAD>
        <TITLE>Administrativo - Intranet</TITLE>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />

        <link type="text/css" rel="stylesheet" href="../css/formatButtons.css">

        <?php
        include_once("../style.inc");

        include_once("../config.inc.php");
        include_once("../sql.inc.php");
        include_once("../funcoes.inc.php");
        include_once("../date.inc.php");
        include_once("./documento.inc.php");

        $id_cliente_unid_cons = $_GET["id"];

        $uc_cliente_id = 0;
        $uc_nro_instalacao = '';
        $uc_unid_cons_nome_terceiro = '';
        $uc_classificacao = '';
        $uc_endereco = '';
        $uc_numero = '';
        $uc_complemento = '';
        $uc_bairro = '';
        $uc_cep = '';
        $uc_cidade = '';
        $uc_estado_id = '';
        $uc_estado = '';
        $uc_estado_sigla = '';
        $uc_cliente_cia_energia_id = 0;
        $uc_cliente_sec_estado_id = 0;
        $uc_situacao = 0;
        $uc_vlr_causa = 0.00;

        $bool_unid_cons_ok = false;
        $bool_cliente_ok = false;
        $bool_proprietario_ok = false;
        $bool_cia_energia_ok = false;
        $bool_sec_estado_ok = false;
        $bool_situacao_ok = false;

        if (!empty($id_cliente_unid_cons)) {
            $query = "SELECT * FROM cliente_unid_cons "
                    . "LEFT JOIN estado ON estado.id_estado=cliente_unid_cons.estado_id "
                    . "WHERE id_cliente_unid_cons=" . $id_cliente_unid_cons . ";";

            $result = mysqli_query($link, $query) or die("Erro executando a consulta '$query'.");

            $registros = mysqli_num_rows($result);
            if ($registros >= 1) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $uc_id_cliente_unid_cons = $row["id_cliente_unid_cons"];
                    $uc_cliente_id = $row["cliente_id"];
                    $uc_nro_instalacao = $row["nro_instalacao"];
                    $uc_unid_cons_nome_terceiro = $row["unid_cons_nome_terceiro"];
                    $uc_classificacao = $row["classificacao"];
                    $uc_endereco = $row["endereco"];
                    $uc_numero = $row["numero"];
                    $uc_complemento = $row["complemento"];
                    $uc_bairro = $row["bairro"];
                    $uc_cep = $row["cep"];
                    $uc_cidade = $row["cidade"];
                    $uc_estado_id = $row["estado_id"];
                    $uc_estado = $row["estado"];
                    $uc_estado_sigla = $row["estado_sigla"];
                    $uc_cliente_cia_energia_id = $row["cliente_cia_energia_id"];
                    $uc_cliente_sec_estado_id = $row["cliente_sec_estado_id"];
                    $uc_situacao_id = $row["situacao_id"];
                    $uc_vlr_causa = $row["vlr_causa"];

                    $bool_unid_cons_ok = true;
                }
            }
        }
        ?>
    </HEAD>
    <body>

        <?php
        if ($bool_unid_cons_ok) {
            // Ler dados do cliente
            $cl_cliente = '';
            $cl_pessoa_tipo = '';
            $cl_reg_federal = '';
            $cl_reg_estadual = '';
            $cl_profissao = '';
            $cl_representante = '';
            $cl_estado_civil = '';
            $cl_endereco = '';
            $cl_numero = '';
            $cl_complemento = '';
            $cl_bairro = '';
            $cl_cep = '';
            $cl_cidade = '';
            $cl_estado_id = '';
            $cl_estado = '';
            $cl_estado_sigla = '';
            $cl_telefone = '';
            $cl_celular = '';
            $cl_nextel = '';
            $cl_email = '';

            if (!empty($uc_cliente_id)) {
                $query = "SELECT * FROM cliente "
                        . "LEFT JOIN estado ON estado.id_estado=cliente.estado_id "
                        . "WHERE id_cliente=" . $uc_cliente_id . ";";
                $result = mysqli_query($link, $query) or die("Erro executando a consulta '$query'.");

                $registros = mysqli_num_rows($result);
                if ($registros >= 1) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $cl_cliente = $row["cliente"];
                        $cl_pessoa_tipo = $row["pessoa_tipo"];
                        $cl_reg_federal = $row["reg_federal"];
                        $cl_reg_estadual = $row["reg_estadual"];
                        $cl_profissao = $row["profissao"];
                        $cl_representante = $row["representante"];
                        $cl_estado_civil = $row["estado_civil"];
                        $cl_endereco = $row["endereco"];
                        $cl_numero = $row["numero"];
                        $cl_complemento = $row["complemento"];
                        $cl_bairro = $row["bairro"];
                        $cl_cep = $row["cep"];
                        $cl_cidade = $row["cidade"];
                        $cl_estado_id = $row["estado_id"];
                        $cl_estado = $row["estado"];
                        $cl_estado_sigla = $row["estado_sigla"];
                        $cl_telefone = $row["telefone"];
                        $cl_celular = $row["celular"];
                        $cl_nextel = $row["nextel"];
                        $cl_email = $row["email"];

                        $bool_cliente_ok = true;
                    }
                }
            }

            // Ler dados do proprietário, Se necessário
            $pr_cliente_unid_cons_proprietario = '';
            $pr_pessoa_tipo = '';
            $pr_reg_federal = '';
            $pr_reg_estadual = '';
            $pr_profissao = '';
            $pr_representante = '';
            $pr_estado_civil = '';
            $pr_endereco = '';
            $pr_numero = '';
            $pr_complemento = '';
            $pr_bairro = '';
            $pr_cep = '';
            $pr_cidade = '';
            $pr_estado_id = '';
            $pr_estado = '';
            $pr_estado_sigla = '';
            $pr_telefone = '';
            $pr_celular = '';
            $pr_nextel = '';

            if ($uc_unid_cons_nome_terceiro) {
                if (!empty($cliente_unid_cons_id)) {
                    $query = "SELECT * FROM cliente_unid_cons_proprietario "
                    ."LEFT JOIN estado ON estado.id_estado=cliente_unid_cons_proprietario.estado_id "
                            . "WHERE cliente_unid_cons_id=" . $id_cliente_unid_cons . ";";
                    
                    $result = mysqli_query($link, $query) or die("Erro executando a consulta '$query'.");

                    $registros = mysqli_num_rows($result);
                    if ($registros >= 1) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $pr_cliente_unid_cons_proprietario = $row["cliente_unid_cons_proprietario"];
                            $pr_pessoa_tipo = $row["pessoa_tipo"];
                            $pr_reg_federal = $row["reg_federal"];
                            $pr_reg_estadual = $row["reg_estadual"];
                            $pr_profissao = $row["profissao"];
                            $pr_representante = $row["representante"];
                            $pr_estado_civil = $row["estado_civil"];
                            $pr_endereco = $row["endereco"];
                            $pr_numero = $row["numero"];
                            $pr_complemento = $row["complemento"];
                            $pr_bairro = $row["bairro"];
                            $pr_cep = $row["cep"];
                            $pr_cidade = $row["cidade"];
                            $pr_estado_id = $row["estado_id"];
                            $pr_estado = $row["estado"];
                            $pr_estado_sigla = $row["estado_sigla"];
                            $pr_telefone = $row["telefone"];
                            $pr_celular = $row["celular"];
                            $pr_nextel = $row["nextel"];

                            $bool_proprietario_ok = true;
                        }
                    }
                }
            }

            // Ler dados da Cia. de Energia
            $ce_cia_energia = '';
            $ce_reg_federal = '';
            $ce_reg_estadual = '';
            $ce_endereco = '';
            $ce_numero = '';
            $ce_complemento = '';
            $ce_bairro = '';
            $ce_cep = '';
            $ce_cidade = '';
            $ce_estado_id = '';
            $ce_estado = '';
            $ce_estado_sigla = '';

            if (!empty($uc_cliente_cia_energia_id)) {
                $query = "SELECT * FROM cliente_cia_energia "
                    ."LEFT JOIN estado ON estado.id_estado=cliente_cia_energia.estado_id "
                        . "WHERE id_cliente_cia_energia=" . $uc_cliente_cia_energia_id . ";";
                
                $result = mysqli_query($link, $query) or die("Erro executando a consulta '$query'.");

                $registros = mysqli_num_rows($result);
                if ($registros >= 1) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $ce_cia_energia = $row["cia_energia"];
                        $ce_reg_federal = $row["reg_federal"];
                        $ce_reg_estadual = $row["reg_estadual"];
                        $ce_endereco = $row["endereco"];
                        $ce_numero = $row["numero"];
                        $ce_complemento = $row["complemento"];
                        $ce_bairro = $row["bairro"];
                        $ce_cep = $row["cep"];
                        $ce_cidade = $row["cidade"];
                        $ce_estado_id = $row["estado_id"];
                        $ce_estado = $row["estado"];
                        $ce_estado_sigla = $row["estado_sigla"];

                        $bool_cia_energia_ok = true;
                    }
                }
            }

            // Ler dados da Sec. da Fazenda
            $sf_sec_estado = '';
            $sf_endereco = '';
            $sf_numero = '';
            $sf_complemento = '';
            $sf_bairro = '';
            $sf_cep = '';
            $sf_cidade = '';
            $sf_estado_id = '';
            $sf_estado = '';
            $sf_estado_sigla = '';

            if (!empty($uc_cliente_sec_estado_id)) {
                $query = "SELECT * FROM cliente_sec_estado "
                    ."LEFT JOIN estado ON estado.id_estado=cliente_sec_estado.estado_id "
                        . "WHERE id_cliente_sec_estado=" . $uc_cliente_sec_estado_id . ";";
                
                $result = mysqli_query($link, $query) or die("Erro executando a consulta '$query'.");

                $registros = mysqli_num_rows($result);
                if ($registros >= 1) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sf_sec_estado = $row["sec_estado"];
                        $sf_endereco = $row["endereco"];
                        $sf_numero = $row["numero"];
                        $sf_complemento = $row["complemento"];
                        $sf_bairro = $row["bairro"];
                        $sf_cep = $row["cep"];
                        $sf_cidade = $row["cidade"];
                        $sf_estado_id = $row["estado_id"];
                        $sf_estado = $row["estado"];
                        $sf_estado_sigla = $row["estado_sigla"];

                        $bool_sec_estado_ok = true;
                    }
                }
            }

            // Ler contas
            // Aller - achei desnecessário no momento. Ler depois, se preciso for
            // Ler situacao
            $st_situacao = '';
            $st_descricao = '';
            $st_documento_titulo = '';
            $st_documento_terceiro = 0;
            $st_documento = '';

            if (!empty($uc_situacao_id)) {
                $query = "SELECT * FROM situacao WHERE id_situacao=" . $uc_situacao_id . ";";
                $result = mysqli_query($link, $query) or die("Erro executando a consulta '$query'.");

                $registros = mysqli_num_rows($result);
                if ($registros >= 1) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $st_situacao = $row["situacao"];
                        $st_descricao = $row["descricao"];
                        $st_documento_titulo = $row["documento_titulo"];
                        $st_documento_terceiro = $row["documento_terceiro"];
                        $st_documento = $row["documento"];

                        $bool_situacao_ok = true;
                    }
                }
            }

            // Dados da situação lidos
            $gl_valor_causa_formatado = number_format($uc_vlr_causa, 2, ",", ".");
            $gl_valor_causa_extenso = valorPorExtenso($uc_vlr_causa);

            // Se houver um documento
            if (!empty($st_documento)) {
                // Fazer substituições
                $st_documento_final = subst_campo($st_documento);
                // Emitir documento
                echo $st_documento_final;
            } else {
                echo "<p>\n<center>\n<font color=red>\n<b>\n";
                echo "Não foi encontrado o conteúdo do documento $st_documento_titulo. Por favor, tente novamente ou entre em contato com o administrador!!";
                echo "</b>\n</font>\n<br>\n</center>\n<\p>\n\n";
            }
        } else {
            echo "<p>\n<center>\n<font color=red>\n<b>\n";
            echo "A unidade consumidora não foi encontrada. Por favor, tente novamente ou entre em contato com o administrador!!";
            echo "</b>\n</font>\n<br>\n</center>\n<\p>\n\n";
        }

        mysqli_close($link);
        ?>

        <script language="javascript" src="../allerscripts/funcoes.js"></script>
    </BODY>
</HTML>