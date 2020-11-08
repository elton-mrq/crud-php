<?php

namespace App\entity;
use \App\db\Database;
use \PDO;

class Categoria{
    
    public $id;
    public $descricao;
    public $ativo;

    /**
     * Método responsável por cadastrar uma categoria de produtos no banco de dados
     * @return boolean
     */
    public function cadastrar(){
        
        //inserir categoria no banco e atribui o retorno no id
        $obDatabase = new Database('categoria');
        $this->id = $obDatabase->insert([
                                        'descricao' => $this->descricao,
                                        'ativo' => $this->ativo
                                    ]);

        return true;
    }

    public function atualizar(){
        return (new Database('categoria'))->update('id = ' . $this->id, [
                                                                            'descricao' => $this->descricao,
                                                                            'ativo' => $this->ativo
                                                                        ]);
    }

    /**
    *Método resposável por excluir uma categoria do banco
    *@return boolean
    */
    public function excluir(){
        return (new Database('categoria'))->delete('id = ' . $this->id);      
    }

    /**
     * Método responsável por listar as categorias do banco
     * @param String
     * @return Array
     */
    public static function getCategorias($where = null, $order = null, $limit = null){
        return (new Database('categoria'))->select($where,$order,$limit)
                                                    ->fetchAll(PDO::FETCH_CLASS, self::class);
      }

      /**
       * Método responsável por buscar categorias por id
       * @param integer
       * @return categoria
       */
      public static function getCategoria($id){

        return (new Database('categoria'))->select('id = ' . $id)
                                                   ->fetchObject(self::class);

      }

      /**
     * Método responsável por verificar a qtd de categorias no banco
     * @param String
     * @return integer
     */
    public static function getQuantidadeCategorias($where = null){
        return (new Database('categoria'))->select($where, null, null, 'COUNT(*) AS qtd')
                                                    ->fetchObject()
                                                    ->qtd;
      }
}