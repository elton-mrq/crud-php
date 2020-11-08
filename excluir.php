<?php

require __DIR__.'/vendor/autoload.php';
use \App\entity\Categoria;

define('TITLE', 'Editar Categoria');

//Valida o id
if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
    header('location : index.php?status=error');
    exit;
}

//Consulta a categoria
$obCategoria = Categoria::getCategoria($_GET['id']);

//Validação da Categoria
if(!$obCategoria instanceof Categoria){
    header('location: index.php?status=error');
}

if(isset($_POST['excluir'])){
    
    
    $obCategoria->excluir();
    
    //echo '<pre>'; print_r($obCategoria); echo '</pre>'; exit;
       
    header('location: index.php?status=success');
    exit;
    
}

include __DIR__.'/includes/header.php';
include __DIR__.'/includes/confirmar-exclusao.php';
include __DIR__.'/includes/footer.php';