<?php

namespace App\db;

/**
 * 
 */
class Pagination{

	/**
	*numero máximo de registros por pagina
	*@var integer 
	*/
	private $limit;

	/**
	*Quantidade de resultados do banco
	*@var integer 
	*/
	private $results;

	/**
	*Número de paginas
	*@var integer 
	*/
	private $pages;

	/**
	*Pagina atual
	*@var integer 
	*/
	private $currentPage;
	
	function __construct($result, $currentPage=1, $limit=10){
		$this->results = $result;		
		$this->limit = $limit;
		$this->currentPage = (is_numeric($currentPage) and $currentPage > 0) ? $currentPage : 1;
		$this->calculate();
	}

	/**
	*Método que calcula a paginação
	*/
	public function calculate(){
		//CALCULA O NÚMERO TOTAL DE PAGINAS
		$this->pages = $this->results > 0 ? ceil($this->results / $this->limit) : 1;

		//VERIFICA DE A PAGINA ATUAL NÃO EXCEDE O LIMITE DE PAGINAS
		$this->currentPage = $this->currentPage <= $this->pages ? $this->currentPage : $this->pages;
	}

	/**
	*Método responsável pela clausula limit
	*@return String
	*/
	public function getLimit(){
		$offSet = ($this->limit * ($this->currentPage - 1));
		return $offSet . ',' . $this->limit;
	}

	/**
	*Método responsável pela opção de página
	*@return String
	*/
	public function getPages(){
		//NAO RETORNA PAGINAS
		if($this->pages == 1)
			return [];

		$paginas = [];
		for($i = 1; $i == $this->pages; $i++){
			$paginas = [
				'pagina' => $i,
				'atual'  => $i == $this->currentPage
			];
		}
	}
}