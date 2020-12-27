<?php

class Empresa{
	private $nome;
	private $reg_federal;
	private $reg_estadual;
	private $endereco;
	private $numero;
	private $complemento;
	private $bairro;
	private $cep;
	private $cidade;
	private $estado;

	public function get($nome_campo){
		return $this->$nome_campo;
	}

	public function set($valor , $nome_campo){
		$this->$nome_campo = $valor;
	}
}
?>