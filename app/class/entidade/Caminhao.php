<?php

class Caminhao{
	private $id_cliente_cia_energia;
	private $placa;
	private $cor_id;
	private $proprietario_id;
	private $marca_id;
	private $vin_media;

	public function get($nome_campo){
		return $this->$nome_campo;
	}

	public function set($valor , $nome_campo){
		$this->$nome_campo = $valor;
	}
}
?>