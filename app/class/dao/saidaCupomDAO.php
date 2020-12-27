<?php 
require "../class/conexao.php";

class saidaCupomDAO{
	function __construct(){
		$this->conn = new Conexao();
		$this->pdo = $this->conn->Connect();
	}
	function cadastraSaidaCupom(SaidaCupom $entidadeSaidaCupom){
		try{
			$param = array(
				":usuario_id"=>$entidadeSaidaCupom->get('usuario_id'),
				":bomba_id"=>$entidadeSaidaCupom->get('bomba_id'),
				":data_abastecimento"=>$entidadeSaidaCupom->get('data_abastecimento'),
				":mes"=>$entidadeSaidaCupom->get('mes'),
				":ano"=>$entidadeSaidaCupom->get('ano'),
				":numero"=>$entidadeSaidaCupom->get('numero'),
				":odometro"=>$entidadeSaidaCupom->get('odometro'),
				":terceiros_id"=>$entidadeSaidaCupom->get('terceiros_id'),
				":caminhao_id"=>$entidadeSaidaCupom->get('caminhao_id'),
				":litros"=>$entidadeSaidaCupom->get('litros'),
				":vlr_unit"=>$entidadeSaidaCupom->get('vlr_unit'),
				":total"=>$entidadeSaidaCupom->get('total'),
				":bool_cupom"=>$entidadeSaidaCupom->get('bool_cupom'),
				":bool_fitinha"=>$entidadeSaidaCupom->get('bool_fitinha'),
				":bool_acerto"=>$entidadeSaidaCupom->get('bool_acerto'),
				":bool_placa_fit"=>$entidadeSaidaCupom->get('bool_placa_fit')
				);
			
			$stmt = $this->pdo->prepare("INSERT INTO abastecimento (usuario_id, bomba_id, numero, odometro, terceiros_id, caminhao_id, data_abastecimento, mes, ano, litros, vlr_unit, total, bool_cupom, bool_fitinha, bool_acerto, bool_placa_fit ) VALUES ( :usuario_id, :bomba_id, :numero, :odometro, :terceiros_id, :caminhao_id, :data_abastecimento, :mes, :ano, :litros, :vlr_unit, :total, :bool_cupom, :bool_fitinha, :bool_acerto, :bool_placa_fit);UPDATE bomba SET volume_atual = volume_atual - :litros WHERE id_bomba = :bomba_id;"
			);
			return $stmt->execute($param);
		}catch(PDOException $ex){
			return "Erro ao cadastrar Entrada ".$ex->getMessage();
		}
	}

	function pendeciaCupomFitinha(SaidaCupom $entidadeSaidaCupom, $idCup){
		try{
			if ($entidadeSaidaCupom->get('bool_cupom') == "") {
				$bool_cupom = "";
				$bool_acerto = " bool_acerto = ".$entidadeSaidaCupom->get('bool_acerto');
			} else {
				$bool_cupom = "bool_cupom = ".$entidadeSaidaCupom->get('bool_cupom');
				$bool_acerto = ", bool_acerto = ".$entidadeSaidaCupom->get('bool_acerto');
			}

			if ($entidadeSaidaCupom->get('numero') != "") {
				$numero = ", numero = ".$entidadeSaidaCupom->get('numero');
			} else $numero = "";

			if ($entidadeSaidaCupom->get('odometro') != "") {
				$odometro = ", odometro = ".$entidadeSaidaCupom->get('odometro');
			} else $odometro = "";

			if ($entidadeSaidaCupom->get('caminhao_id') != "") {
				$caminhao_id = ", caminhao_id = ".$entidadeSaidaCupom->get('caminhao_id');
			} else $caminhao_id = "";

			if ($entidadeSaidaCupom->get('terceiros_id') != "") {
				$terceiros_id = ", terceiros_id = ".$entidadeSaidaCupom->get('terceiros_id');
			} else $terceiros_id = "";
			
			
			$stmt = $this->pdo->prepare("UPDATE abastecimento SET 
				".$bool_cupom." ".$bool_acerto." ".$numero." ".$odometro." ".$terceiros_id." ".$caminhao_id." WHERE  id_abastecimento = ".$idCup.";"
			);
			return $stmt->execute();
		}catch(PDOException $ex){
			return "Erro ao cadastrar Entrada ".$ex->getMessage();
		}
	}
	function atualizaSaidaCupom(SaidaCupom $entidadeSaidaCupom, $id){
		try{
			$param = array(
				":usuario_id"=>$entidadeSaidaCupom->get('usuario_id'),
				":bomba_id"=>$entidadeSaidaCupom->get('bomba_id'),
				":data_abastecimento"=>$entidadeSaidaCupom->get('data_abastecimento'),
				":mes"=>$entidadeSaidaCupom->get('mes'),
				":ano"=>$entidadeSaidaCupom->get('ano'),
				":numero"=>$entidadeSaidaCupom->get('numero'),
				":odometro"=>$entidadeSaidaCupom->get('odometro'),
				":terceiros_id"=>$entidadeSaidaCupom->get('terceiros_id'),
				":caminhao_id"=>$entidadeSaidaCupom->get('caminhao_id'),
				":litros"=>$entidadeSaidaCupom->get('litros'),
				":vlr_unit"=>$entidadeSaidaCupom->get('vlr_unit'),
				":total"=>$entidadeSaidaCupom->get('total'),
				":bool_cupom"=>$entidadeSaidaCupom->get('bool_cupom'),
				":bool_fitinha"=>$entidadeSaidaCupom->get('bool_fitinha'),
				":bool_acerto"=>$entidadeSaidaCupom->get('bool_acerto'),
				":bool_placa_fit"=>$entidadeSaidaCupom->get('bool_placa_fit')
				);

			$stmt = $this->pdo->prepare("
				UPDATE bomba SET volume_atual = volume_atual + (SELECT litros FROM abastecimento WHERE id_abastecimento = ".$id.") WHERE id_bomba = :bomba_id;
				UPDATE abastecimento SET usuario_id = :usuario_id,  bomba_id = :bomba_id, numero = :numero, odometro = :odometro, data_abastecimento = :data_abastecimento, mes = :mes, ano = :ano, terceiros_id = :terceiros_id, caminhao_id = :caminhao_id, litros = :litros, vlr_unit = :vlr_unit, total = :total, bool_cupom = :bool_cupom, bool_fitinha = :bool_fitinha, bool_acerto = :bool_acerto, bool_placa_fit = :bool_placa_fit WHERE id_abastecimento = ".$id."; UPDATE bomba SET volume_atual = volume_atual - :litros WHERE id_bomba = :bomba_id;"
			);
			return $stmt->execute($param);
		}catch(PDOException $ex){
			return "Erro ao atualizar Entrada ".$ex->getMessage();
		}
	}
	function cadastraSaidaFitinha(SaidaCupom $entidadeSaidaCupom){
		try{
			$param = array(
				":usuario_id"=>$entidadeSaidaCupom->get('usuario_id'),
				":bomba_id"=>$entidadeSaidaCupom->get('bomba_id'),
				":data_abastecimento"=>$entidadeSaidaCupom->get('data_abastecimento'),
				":mes"=>$entidadeSaidaCupom->get('mes'),
				":ano"=>$entidadeSaidaCupom->get('ano'),
				":horas"=>$entidadeSaidaCupom->get('horas'),
				":terceiros_id"=>$entidadeSaidaCupom->get('terceiros_id'),
				":caminhao_id"=>$entidadeSaidaCupom->get('caminhao_id'),
				":litros"=>$entidadeSaidaCupom->get('litros'),
				":vlr_unit"=>$entidadeSaidaCupom->get('vlr_unit'),
				":total"=>$entidadeSaidaCupom->get('total'),
				":bool_cupom"=>$entidadeSaidaCupom->get('bool_cupom'),
				":bool_fitinha"=>$entidadeSaidaCupom->get('bool_fitinha'),
				":bool_acerto"=>$entidadeSaidaCupom->get('bool_acerto'),
				":bool_placa_fit"=>$entidadeSaidaCupom->get('bool_placa_fit')
				);
			
			$stmt = $this->pdo->prepare("INSERT INTO abastecimento (usuario_id, bomba_id,  horas, terceiros_id, caminhao_id, data_abastecimento, mes, ano, litros, vlr_unit, total, bool_cupom, bool_fitinha, bool_acerto, bool_placa_fit ) VALUES ( :usuario_id, :bomba_id, :horas, :terceiros_id, :caminhao_id, :data_abastecimento, :mes, :ano, :litros, :vlr_unit, :total, :bool_cupom, :bool_fitinha, :bool_acerto, :bool_placa_fit);UPDATE bomba SET volume_atual = volume_atual - :litros WHERE id_bomba = :bomba_id;"
			);
			return $stmt->execute($param);
		}catch(PDOException $ex){
			return "Erro ao cadastrar Entrada ".$ex->getMessage();
		}
	}

	function pendeciaSaidaFitinha(SaidaCupom $entidadeSaidaCupom, $idFit){
		try{
			$param = array(
				":horas"=>$entidadeSaidaCupom->get('horas'),
				":bool_fitinha"=>$entidadeSaidaCupom->get('bool_fitinha'),
				":bool_placa_fit"=>$entidadeSaidaCupom->get('bool_placa_fit')
			);
			
			$stmt = $this->pdo->prepare("UPDATE abastecimento SET horas = :horas, bool_fitinha = :bool_fitinha, bool_placa_fit = :bool_placa_fit WHERE  id_abastecimento = ".$idFit.";"
			);
			return $stmt->execute($param);
		}catch(PDOException $ex){
			return "Erro ao cadastrar Entrada ".$ex->getMessage();
		}
	}
}
?>