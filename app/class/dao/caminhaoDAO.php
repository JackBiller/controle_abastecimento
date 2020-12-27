<?php 
require_once "../class/conexao.php";

class caminhaoDAO{
	function __construct(){
		$this->conn = new Conexao();
		$this->pdo = $this->conn->Connect();
	}
	function cadastraCaminhao(Caminhao $entidadeCaminhao){
		try{
			$param = array(
				':placa'=>$entidadeCaminhao->get('placa'),
				':cor_id'=>$entidadeCaminhao->get('cor_id'),
				':proprietario_id'=>$entidadeCaminhao->get('proprietario_id'),
				':marca_id'=>$entidadeCaminhao->get('marca_id'),
				':vin_media'=>$entidadeCaminhao->get('vin_media')
				);
			
			$stmt = $this->pdo->prepare("INSERT INTO caminhao (placa, cor_id, proprietario_id, marca_id, vin_media) VALUES ( :placa , :cor_id , :proprietario_id , :marca_id, :vin_media);"
			);
			return $stmt->execute($param);
		}catch(PDOException $ex){
			return "Erro ao cadastrar Caminhao ".$ex->getMessage();
		}
	}
	function atualizaCaminhao(Caminhao $entidadeCaminhao, $id){
		try{
			$param = array(
				':placa'=>$entidadeCaminhao->get('placa'),
				':cor_id'=>$entidadeCaminhao->get('cor_id'),
				':proprietario_id'=>$entidadeCaminhao->get('proprietario_id'),
				':marca_id'=>$entidadeCaminhao->get('marca_id'),
				':vin_media'=>$entidadeCaminhao->get('vin_media')
				);

			$stmt = $this->pdo->prepare("UPDATE caminhao SET placa = :placa, proprietario_id = :proprietario_id, marca_id = :marca_id, cor_id = :cor_id, vin_media = :vin_media WHERE id_caminhao = ".$id.";"
			);
			return $stmt->execute($param);
		}catch(PDOException $ex){
			return "Erro ao atualizar Caminhao ".$ex->getMessage();
		}
	}
}
?>