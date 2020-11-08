<?php

require __DIR__.'/vendor/autoload.php';
use \App\entity\Categoria;
use \App\db\Pagination;


//BUSCA POR DESCRICAO
$busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);

//BUSCA POR STATUS
$filtroStatus = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_STRING);

$filtroStatus = in_array($filtroStatus, ['s','n']) ? $filtroStatus : '';

//Montando os critérios de busca
$criterios = [
				strlen($busca) ? 'descricao LIKE "%'.str_replace(' ', '%', $busca).'%"' : null,
				strlen($filtroStatus) ? 'ativo = "'.$filtroStatus.'"' : null
			 ];

//Remove posições vazias do array
$criterios = array_filter($criterios);

//Organizando a clausula where
$where = implode(' AND ', $criterios);

//Paginação
$qtdVaga = Categoria::getQuantidadeCategorias($where);

$obPagination = new Pagination($qtdVaga, $_GET['pagina'] ?? 1, 5);

//Recebe as categorias
$categorias = Categoria::getCategorias($where, null, $obPagination->getLimit());

include __DIR__.'/includes/header.php';
include __DIR__.'/includes/listagem.php';
include __DIR__.'/includes/footer.php';