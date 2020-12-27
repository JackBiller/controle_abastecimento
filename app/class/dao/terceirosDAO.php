<?php 
require_once "../class/conexao.php";

class terceirosDAO{
	function __construct(){
		$this->conn = new Conexao();
		$this->pdo = $this->conn->Connect();
	}
	function cadastraTerceiros(Terceiros $entidadeTerceiros){
		try{
			$param = array(
				':descricao'=>$entidadeTerceiros->get('descricao')
				);
			
			$stmt = $this->pdo->prepare("INSERT INTO terceiros (descricao) VALUES ( :descricao );"
			);
			return $stmt->execute($param);
		}catch(PDOException $ex){
			return "Erro ao cadastrar Terceiros ".$ex->getMessage();
		}
	}
	function atualizaTerceiros(Terceiros $entidadeTerceiros, $id){
		try{
			$param = array(
				':descricao'=>$entidadeTerceiros->get('descricao')
				);

			$stmt = $this->pdo->prepare("UPDATE terceiros SET descricao = :descricao WHERE id_terceiros = ".$id.";"
			);
			return $stmt->execute($param);
		}catch(PDOException $ex){
			return "Erro ao atualizar Terceiros ".$ex->getMessage();
		}
	}
}
?>