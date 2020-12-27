<?php 
require_once "../class/conexao.php";

class proprietarioDAO{
	function __construct(){
		$this->conn = new Conexao();
		$this->pdo = $this->conn->Connect();
	}
	function cadastraProprietario(Proprietario $entidadeProprietario){
		try{
			$param = array(
				':descricao'=>$entidadeProprietario->get('descricao')
				);
			
			$stmt = $this->pdo->prepare("INSERT INTO proprietario (nome) VALUES (:descricao);"
			);
			return $stmt->execute($param);
		}catch(PDOException $ex){
			return "Erro ao cadastrar Proprietário ".$ex->getMessage();
		}
	}
	function atualizaProprietario(Proprietario $entidadeProprietario, $id){
		try{
			$param = array(
				':descricao'=>$entidadeProprietario->get('descricao')
				);

			$stmt = $this->pdo->prepare("UPDATE proprietario SET nome = :descricao WHERE id_proprietario = ".$id.";"
			);
			return $stmt->execute($param);
		}catch(PDOException $ex){
			return "Erro ao atualizar Proprietáio ".$ex->getMessage();
		}
	}
}
?>