<?php

class SaidaCupom{

	private $usuario_id;
	private $bomba_id;
	private $data_entrada;
	private $mes;
	private $ano;
	private $numero;
	private $odometro;
	private $horas;
	private $caminhao_id;
	private $terceiros_id;
	private $litros;
	private $vlr_unit;
	private $total;
	private $bool_cupom;
	private $bool_fitinha;
	private $bool_acerto;
	private $bool_placa_fit;

	public function get($nome_campo){
		return $this->$nome_campo;
	}

	public function set($valor , $nome_campo){
		$this->$nome_campo = $valor;
	}
}
?>