<?php

    $id_cliente_unid_cons = $_GET["id"];

    $bool_unid_cons_ok = false;
    $bool_cliente_ok = false;
    $bool_proprietario_ok = false;
    $bool_cia_energia_ok = false;
    $bool_sec_estado_ok = false;
    $bool_situacao_ok = false;

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
    $uc_sigla = '';
    $uc_cliente_cia_energia_id = 0;
    $uc_cliente_sec_estado_id = 0;
    $uc_situacao = 0;
    $uc_vlr_causa = 0.00;

    if (!empty($id_cliente_unid_cons)) {
        $query = "SELECT * FROM cliente_unid_cons "
                . "LEFT JOIN estado ON estado.id_estado=cliente_unid_cons.estado_id "
                . "WHERE id_cliente_unid_cons=" . $id_cliente_unid_cons . ";";

        $result = $pdo->query($query);

        // $registros = mysqli_num_dadoss($result);
        // if ($registros >= 1) {
            // while ($dados = mysqli_fetch_assoc($result)) {
            foreach ($result as $dados1) {
                $uc_id_cliente_unid_cons    = $dados1["id_cliente_unid_cons"];
                $uc_cliente_id              = $dados1["cliente_id"];
                $uc_nro_instalacao          = $dados1["nro_instalacao"];
                $uc_unid_cons_nome_terceiro = $dados1["unid_cons_nome_terceiro"];
                $uc_classificacao           = $dados1["classificacao"];
                $uc_endereco                = $dados1["endereco"];
                $uc_numero                  = $dados1["numero"];
                $uc_complemento             = $dados1["complemento"];
                $uc_bairro                  = $dados1["bairro"];
                $uc_cep                     = $dados1["cep"];
                $uc_cidade                  = $dados1["cidade"];
                $uc_estado_id               = $dados1["estado_id"];
                $uc_sigla                   = $dados1["sigla"];
                $uc_cliente_cia_energia_id  = $dados1["cliente_cia_energia_id"];
                $uc_cliente_sec_estado_id   = $dados1["cliente_sec_estado_id"];
                $uc_situacao_id             = $dados1["situacao_id"];
                $uc_vlr_causa               = $dados1["vlr_causa"];
                $uc_estado                  = $dados1["estado"];

                $bool_unid_cons_ok = true;
            }
        // }
    }
    // if ($bool_unid_cons_ok) {
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
        $cl_sigla = '';
        $cl_telefone = '';
        $cl_celular = '';
        $cl_nextel = '';
        $cl_email = '';

        if (!empty($uc_cliente_id)) {
            $query = "SELECT * FROM cliente "
                    . "LEFT JOIN estado ON estado.id_estado=cliente.estado_id "
                    . "WHERE id_cliente=" . $uc_cliente_id . ";";
            $result = $pdo->query($query);

            // $registros = mysqli_num_dadoss($result);
            // if ($registros >= 1) {
                foreach ($result as $dados2) {
                    $cl_cliente         = $dados2["cliente"];
                    $cl_pessoa_tipo     = $dados2["pessoa_tipo"];
                    $cl_reg_federal     = $dados2["reg_federal"];
                    $cl_reg_estadual    = $dados2["reg_estadual"];
                    $cl_profissao       = $dados2["profissao"];
                    $cl_nacionalidade   = $dados2["nacionalidade"];
                    $cl_representante   = $dados2["representante"];
                    $cl_estado_civil    = $dados2["estado_civil"];
                    $cl_endereco        = $dados2["endereco"];
                    $cl_numero          = $dados2["numero"];
                    $cl_complemento     = $dados2["complemento"];
                    $cl_bairro          = $dados2["bairro"];
                    $cl_cep             = $dados2["cep"];
                    $cl_cidade          = $dados2["cidade"];
                    $cl_estado_id       = $dados2["estado_id"];
                    $cl_estado          = $dados2["estado"];
                    $cl_sigla           = $dados2["sigla"];
                    $cl_telefone        = $dados2["telefone"];
                    $cl_celular         = $dados2["celular"];
                    $cl_nextel          = $dados2["nextel"];
                    $cl_email           = $dados2["email"];

                    $bool_cliente_ok = true;
                }
            // }
        }

        // Ler dados do proprietário, Se necessário
        $pr_cliente_unid_cons_proprietario = '';
        $pr_pessoa_tipo = '';
        $pr_reg_federal = '';
        $pr_reg_estadual = '';
        $pr_profissao = '';
        $pr_nacionalidade = '';
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
        $pr_sigla = '';
        $pr_telefone = '';
        $pr_celular = '';
        $pr_nextel = '';

        // if ($uc_unid_cons_nome_terceiro == 1) {
            if (!empty($id_cliente_unid_cons)) {
                $query = "SELECT * FROM cliente_unid_cons_proprietario "
                ."LEFT JOIN estado ON estado.id_estado=cliente_unid_cons_proprietario.estado_id "
                        . "WHERE cliente_unid_cons_id = " . $id_cliente_unid_cons . ";";
                
                $result = $pdo->query($query);

                // $registros = mysqli_num_dadoss($result);
                // if ($registros >= 1) {
                    foreach ($result as $dados3) {
                        $pr_cliente_unid_cons_proprietario  = $dados3["cliente_unid_cons_proprietario"];
                        $pr_pessoa_tipo                     = $dados3["pessoa_tipo"];
                        $pr_reg_federal                     = $dados3["reg_federal"];
                        $pr_reg_estadual                    = $dados3["reg_estadual"];
                        $pr_profissao                       = $dados3["profissao"];
                        $pr_nacionalidade                   = $dados3["nacionalidade"];
                        $pr_representante                   = $dados3["representante"];
                        $pr_estado_civil                    = $dados3["estado_civil"];
                        $pr_endereco                        = $dados3["endereco"];
                        $pr_numero                          = $dados3["numero"];
                        $pr_complemento                     = $dados3["complemento"];
                        $pr_bairro                          = $dados3["bairro"];
                        $pr_cep                             = $dados3["cep"];
                        $pr_cidade                          = $dados3["cidade"];
                        $pr_estado_id                       = $dados3["estado_id"];
                        $pr_estado                          = $dados3["estado"];
                        $pr_sigla                           = $dados3["sigla"];
                        $pr_telefone                        = $dados3["telefone"];
                        $pr_celular                         = $dados3["celular"];
                        $pr_nextel                          = $dados3["nextel"];

                        $bool_proprietario_ok = true;
                    }
                }
        //     }
        // }

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
        $ce_sigla = '';

        if (!empty($uc_cliente_cia_energia_id)) {
            $query = "SELECT * FROM cliente_cia_energia "
                ."LEFT JOIN estado ON estado.id_estado=cliente_cia_energia.estado_id "
                    . "WHERE id_cliente_cia_energia=" . $uc_cliente_cia_energia_id . ";";
            
            $result = $pdo->query($query);

            // $registros = mysqli_num_dadoss($result);
            // if ($registros >= 1) {
                foreach ($result as $dados4) {
                    $ce_cia_energia     = $dados4["cia_energia"];
                    $ce_reg_federal     = $dados4["reg_federal"];
                    $ce_reg_estadual    = $dados4["reg_estadual"];
                    $ce_endereco        = $dados4["endereco"];
                    $ce_numero          = $dados4["numero"];
                    $ce_complemento     = $dados4["complemento"];
                    $ce_bairro          = $dados4["bairro"];
                    $ce_cep             = $dados4["cep"];
                    $ce_cidade          = $dados4["cidade"];
                    $ce_estado_id       = $dados4["estado_id"];
                    $ce_estado          = $dados4["estado"];
                    $ce_sigla           = $dados4["sigla"];

                    $bool_cia_energia_ok = true;
                }
            }
        // }

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
        $sf_sigla = '';

        if (!empty($uc_cliente_sec_estado_id)) {
            $query = "SELECT * FROM cliente_sec_estado "
                ."LEFT JOIN estado ON estado.id_estado=cliente_sec_estado.estado_id "
                    . "WHERE id_cliente_sec_estado=" . $uc_cliente_sec_estado_id . ";";
            
            $result = $pdo->query($query);

            // $registros = mysqli_num_dadoss($result);
            // if ($registros >= 1) {
                foreach ($result as $dados5) {
                    $sf_sec_estado   = $dados5["sec_estado"];
                    $sf_endereco     = $dados5["endereco"];
                    $sf_numero       = $dados5["numero"];
                    $sf_complemento  = $dados5["complemento"];
                    $sf_bairro       = $dados5["bairro"];
                    $sf_cep          = $dados5["cep"];
                    $sf_cidade       = $dados5["cidade"];
                    $sf_estado_id    = $dados5["estado_id"];
                    $sf_estado       = $dados5["estado"];
                    $sf_sigla        = $dados5["sigla"];

                    $bool_sec_estado_ok = true;
                }
                
            // }
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
            $result = $pdo->query($query);

            // $registros = mysqli_num_dadoss($result);
            // if ($registros >= 1) {
                foreach ($result as $dados6) {
                    $st_situacao            = $dados6["situacao"];
                    $st_descricao           = $dados6["descricao"];
                    $st_documento_titulo    = $dados6["documento_titulo"];
                    $st_documento_terceiro  = $dados6["documento_terceiro"];
                    $st_documento           = $dados6["documento"];

                    $bool_situacao_ok = true;
                }
            // }
        }

        $cl_endereco =      ($cl_endereco == "")    ? $uc_endereco      : $cl_endereco;
        $cl_numero =        ($cl_numero == "")      ? $uc_numero        : $cl_numero;
        $cl_complemento =   ($cl_complemento == "") ? $uc_complemento   : $cl_complemento;
        $cl_bairro =        ($cl_bairro == "")      ? $uc_bairro        : $cl_bairro;
        $cl_cidade =        ($cl_cidade == "")      ? $uc_cidade        : $cl_cidade;
        $cl_estado =        ($cl_estado == "")      ? $uc_estado        : $cl_estado;
        $cl_cep =           ($cl_cep == "")         ? $uc_cep           : $cl_cep;

        $cl_endereco_completo = " ".$cl_endereco.", numero ".$cl_numero." ".$cl_complemento.", bairro ".$cl_bairro.", cidade ".$cl_cidade.", Estado de ".$cl_estado.", CEP ".$cl_cep;

        $uc_endereco_completo = " ".$uc_endereco.", numero ".$uc_numero." ".$uc_complemento.", bairro ".$uc_bairro.", cidade ".$uc_cidade.", Estado de ".$uc_estado.", CEP ".$uc_cep;

        $pr_endereco_completo = " ".$pr_endereco.", numero ".$pr_numero." ".$pr_complemento.", bairro ".$pr_bairro.", cidade ".$pr_cidade.", Estado de ".$pr_estado.", CEP ".$pr_cep;

        $ce_endereco_completo = " ".$ce_endereco.", numero ".$ce_numero." ".$ce_complemento.", bairro ".$ce_bairro.", cidade ".$ce_cidade.", Estado de ".$ce_estado.", CEP ".$ce_cep;

        $sf_endereco_completo = " ".$sf_endereco.", numero ".$sf_numero." ".$sf_complemento.", bairro ".$sf_bairro.", cidade ".$sf_cidade.", Estado de ".$sf_estado.", CEP ".$sf_cep;

        $gl_local_e_data = date('d/m/Y');


        // Dados da situação lidos
        // $gl_valor_causa_formatado = number_format($uc_vlr_causa, 2, ",", ".");
        // $gl_valor_causa_extenso = valorPorExtenso($uc_vlr_causa);

    // } else {
    //     echo "<p>\n<center>\n<font color=red>\n<b>\n";
    //     echo "A unidade consumidora não foi encontrada. Por favor, tente novamente ou entre em contato com o administrador!!";
    //     echo "</b>\n</font>\n<br>\n</center>\n<\p>\n\n";
    // }
?>