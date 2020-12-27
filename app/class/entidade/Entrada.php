<?php

class Entrada{

	private $usuario_id;
	private $bomba_id;
	private $empresa_id;
	private $num_nfe;
	private $data_entrada;
	private $mes;
	private $ano;
	private $qtd_litros;
	private $vlr_unit;
	private $total;

	public function get($nome_campo){
		return $this->$nome_campo;
	}

	public function set($valor , $nome_campo){
		$this->$nome_campo = $valor;
	}
}
?>