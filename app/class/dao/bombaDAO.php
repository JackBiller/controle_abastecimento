<?php 
require_once "../class/conexao.php";

class bombaDAO{
	function __construct(){
		$this->conn = new Conexao();
		$this->pdo = $this->conn->Connect();
	}
	function cadastraBomba(Bomba $entidadeBomba){
		try{
			$param = array(
				':descricao'=>$entidadeBomba->get('descricao'),
				':volume_atual'=>$entidadeBomba->get('volume_atual'),
				':volume_total'=>$entidadeBomba->get('volume_total')
				);
			
			$stmt = $this->pdo->prepare("INSERT INTO bomba (descricao, volume_atual, volume_total) VALUES (:descricao, :volume_atual, :volume_total);"
			);
			return $stmt->execute($param);
		}catch(PDOException $ex){
			return "Erro ao cadastrar Bomba ".$ex->getMessage();
		}
	}
	function atualizaBomba(Bomba $entidadeBomba, $id){
		try{
			$param = array(
				':descricao'=>$entidadeBomba->get('descricao'),
				':volume_atual'=>$entidadeBomba->get('volume_atual'),
				':volume_total'=>$entidadeBomba->get('volume_total')
				);

			$stmt = $this->pdo->prepare("UPDATE bomba SET descricao = :descricao, volume_atual = :volume_atual, volume_total = :volume_total WHERE id_bomba = ".$id.";"
			);
			return $stmt->execute($param);
		}catch(PDOException $ex){
			return "Erro ao atualizar Bomba ".$ex->getMessage();
		}
	}
}
?>