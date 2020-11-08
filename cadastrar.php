<?php

require __DIR__.'/vendor/autoload.php';
use \App\entity\Categoria;

$obCategoria = new Categoria;

define('TITLE', 'Cadastrar Categoria');

if(isset($_POST['descricao'], $_POST['ativo'])){
 
    $obCategoria->descricao = $_POST['descricao'];
    $obCategoria->ativo = $_POST['ativo'];
    
    //Invoca o Método Cadastrar da classe Categoria
    $obCategoria->cadastrar();
    
    header('location: index.php?status=success');
    exit;
    
}

include __DIR__.'/includes/header.php';
include __DIR__.'/includes/formulario.php';
include __DIR__.'/includes/footer.php';