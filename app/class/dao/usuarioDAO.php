<?php 
require_once "../class/conexao.php";

class usuarioDAO{
	function __construct(){
		$this->conn = new Conexao();
		$this->pdo = $this->conn->Connect();
	}
	function cadastraUsuario(Usuario $entidadeUsuario){
		try{
			$param = array(
				':nome'=>$entidadeUsuario->get('nome'),
				':login'=>$entidadeUsuario->get('login'),
				':senha'=>$entidadeUsuario->get('senha')
				);
			
			$stmt = $this->pdo->prepare("INSERT INTO usuario (nome, login, senha, nivel, bool_ativo) VALUES ( :nome ,  :login , password(:senha), 2, 1);");

			return $stmt->execute($param);

		}catch(PDOException $ex){
			return "Erro ao cadastrar Usuario ".$ex->getMessage();

		}
	}
	function atualizaUsuario(Usuario $entidadeUsuario ,$id){
		try{
			$param = array(
				':nome'=>$entidadeUsuario ->get('nome')
			);
			
			$stmt = $this->pdo->prepare("UPDATE usuario SET nome = :nome WHERE id_usuario = ".$id.";");

			return $stmt->execute($param);

		}catch(PDOException $ex){
			return "Erro ao atualizar Usuario ".$ex->getMessage();
		}
	}
}
?>