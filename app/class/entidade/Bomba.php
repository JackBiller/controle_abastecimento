<?php

class Bomba{
	private $id_cliente_cia_energia;
	private $descricao;
	private $volume_atual;
	private $volume_total;

	public function get($nome_campo){
		return $this->$nome_campo;
	}

	public function set($valor , $nome_campo){
		$this->$nome_campo = $valor;
	}
}
?>