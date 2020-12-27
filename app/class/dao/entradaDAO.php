<?php 
require "../class/conexao.php";

class entradaDAO{
	function __construct(){
		$this->conn = new Conexao();
		$this->pdo = $this->conn->Connect();
	}
	function cadastraEntrada(Entrada $entidadeEntrada){
		try{
			$param = array(
				":usuario_id"=>$entidadeEntrada->get('usuario_id'),
				":bomba_id"=>$entidadeEntrada->get('bomba_id'),
				":empresa_id"=>$entidadeEntrada->get('empresa_id'),
				":num_nfe"=>$entidadeEntrada->get('num_nfe'),
				":data_entrada"=>$entidadeEntrada->get('data_entrada'),
				":mes"=>$entidadeEntrada->get('mes'),
				":ano"=>$entidadeEntrada->get('ano'),
				":qtd_litros"=>$entidadeEntrada->get('qtd_litros'),
				":vlr_unit"=>$entidadeEntrada->get('vlr_unit'),
				":total"=>$entidadeEntrada->get('total')
				);
			
			$stmt = $this->pdo->prepare("INSERT INTO entrada (usuario_id, bomba_id, empresa_id, num_nfe, data_entrada, mes, ano, qtd_litros, vlr_unit, total ) VALUES ( :usuario_id, :bomba_id, :empresa_id, :num_nfe, :data_entrada, :mes, :ano, :qtd_litros, :vlr_unit, :total );UPDATE bomba SET volume_atual = volume_atual + :qtd_litros WHERE id_bomba = :bomba_id;INSERT INTO desconto_diesel (entrada_id, vlr_atual, vlr_min, vlr_max) VALUES ((SELECT id_entrada FROM entrada ORDER BY id_entrada DESC LIMIT 1), 0, 0, :qtd_litros);"
			);
			return $stmt->execute($param);
		}catch(PDOException $ex){
			return "Erro ao cadastrar Entrada ".$ex->getMessage();
		}
	}
	function atualizaEntrada(Entrada $entidadeEntrada, $id){
		try{
			$param = array(
				":usuario_id"=>$entidadeEntrada->get('usuario_id'),
				":bomba_id"=>$entidadeEntrada->get('bomba_id'),
				":empresa_id"=>$entidadeEntrada->get('empresa_id'),
				":num_nfe"=>$entidadeEntrada->get('num_nfe'),
				":data_entrada"=>$entidadeEntrada->get('data_entrada'),
				":mes"=>$entidadeEntrada->get('mes'),
				":ano"=>$entidadeEntrada->get('ano'),
				":qtd_litros"=>$entidadeEntrada->get('qtd_litros'),
				":vlr_unit"=>$entidadeEntrada->get('vlr_unit'),
				":total"=>$entidadeEntrada->get('total')
				);

			$stmt = $this->pdo->prepare("UPDATE entrada SET usuario_id = :usuario_id,  bomba_id = :bomba_id, empresa_id = :empresa_id, num_nfe = :num_nfe, data_entrada = :data_entrada, mes = :mes, ano = :ano, qtd_litros = :qtd_litros, vlr_unit = :vlr_unit, total = :total, WHERE id_bomba = ".$id."; UPDATE bomba SET volume_atual = volume_atual + :qtd_litros WHERE id_bomba = :bomba_id;"
			);
			return $stmt->execute($param);
		}catch(PDOException $ex){
			return "Erro ao atualizar Entrada ".$ex->getMessage();
		}
	}
}
?>