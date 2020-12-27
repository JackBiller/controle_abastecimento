<?php 
require_once "../class/conexao.php";

class clienteEmpresaDAO{
	function __construct(){
		$this->conn = new Conexao();
		$this->pdo = $this->conn->Connect();
	}
	function cadastraEmpresa(Empresa $entidadeEmpresa){
		try{
			$param = array(
				':nome'=>$entidadeEmpresa->get('nome'),
				':reg_federal'=>$entidadeEmpresa->get('reg_federal'),
				':reg_estadual'=>$entidadeEmpresa->get('reg_estadual'),
				':cep'=>$entidadeEmpresa->get('cep'),
				':endereco'=>$entidadeEmpresa->get('endereco'),
				':numero'=>$entidadeEmpresa->get('numero'),
				':complemento'=>$entidadeEmpresa->get('complemento'),
				':bairro'=>$entidadeEmpresa->get('bairro'),
				':cidade'=>$entidadeEmpresa->get('cidade'),
				':estado'=>$entidadeEmpresa->get('estado')
				);
			
			$stmt = $this->pdo->prepare("INSERT INTO empresa (nome, reg_federal, reg_estadual, cep, endereco, numero, complemento, bairro, cidade, estado_id) VALUES ( :nome , :reg_federal , :reg_estadual , :cep , :endereco , :numero , :complemento , :bairro , :cidade , :estado);"
			);

			return $stmt->execute($param);

		}catch(PDOException $ex){
			return "Erro ao cadastrar Empresa ".$ex->getMessage();
		}
	}
	function atualizaEmpresa(Empresa $entidadeEmpresa, $id){
		try{
			$param = array(
				':nome'=>$entidadeEmpresa->get('nome'),
				':reg_federal'=>$entidadeEmpresa->get('reg_federal'),
				':reg_estadual'=>$entidadeEmpresa->get('reg_estadual'),
				':cep'=>$entidadeEmpresa->get('cep'),
				':endereco'=>$entidadeEmpresa->get('endereco'),
				':numero'=>$entidadeEmpresa->get('numero'),
				':complemento'=>$entidadeEmpresa->get('complemento'),
				':bairro'=>$entidadeEmpresa->get('bairro'),
				':cidade'=>$entidadeEmpresa->get('cidade'),
				':estado'=>$entidadeEmpresa->get('estado')
				);

			$stmt = $this->pdo->prepare("UPDATE empresa SET nome = :nome, reg_federal = :reg_federal, reg_estadual = :reg_estadual, cep = :cep, endereco = :endereco, numero = :numero, complemento = :complemento, bairro = :bairro, cidade = :cidade, estado_id = :estado WHERE id_empresa = ".$id.";"
			);

			return $stmt->execute($param);

		}catch(PDOException $ex){
			return "Erro ao cadastrar Empresa ".$ex->getMessage();
		}
	}
}
?>