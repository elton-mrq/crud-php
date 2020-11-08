<?php

namespace App\db;

use \PDO;
use \PDOException;

class Database{
    /**
     * HOST DE CONEXAO COM O BANCO
     */
    const HOST = 'localhost';

    /**
     * NOME DO BANCO DE DADOS
     */
    const DB =  'dbloja';

    /**
     * USUARIO DO BANCO
     */
    const USER = 'root';

    /**
     * SENHA DE ACESSO AO BANCO
     */
    const PASS = '';

    /**
     * NOME DA TABELA A SER MANIPULADA
     */

    /**
     * Nome da tabela a ser manipulada
    */
    private $table;

    /**
     * Instancia de conexao com o banco de dados
    */
    private $connection;

    public function __construct($table){
        $this->table = $table;
        $this->setConnection();
    }

    /**
     * Método responsável por criar a conexão com o banco de dados
     */
    private function setConnection(){

        try{
            $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::DB,self::USER,self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die('Erro: ' . $e->getMessage());
        }

    }
    /**
     * Executa as queries
     */
    public function execute($query, $params = []){
        try{
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            return $stmt;
        }catch(PDOException $e){
            die('Erro: ' . $e->getMessage());
        }
    }

    /**
     * Método responsável por inserir dados no banco
     * @param array
     * @return integer inserido
     */
    public function insert($values){
        //DADOS DA QUERY
        $fields = array_keys($values);
        $binds = array_pad([],count($fields),'?');
       
        //MONTA A QUERY
        $query = 'INSERT INTO ' .$this->table. ' ('.implode(',', $fields ) .') VALUES('.implode(',', $binds).')';
        
        //CHAMO O MÉTODO QUE EXECUTA O INSERT
        $this->execute($query, array_values($values));
       
        //RETORNA O ULTIMO ID INSERIDO
        return $this->connection->lastInsertId();
    }

    /**
     * Método responsável por executar a atualização da categoria de produtos no banco
     * @param string $where
     * @param array $values (field => value)
     * @return boolean
     */
    public function update($where, $values){
        //TRATA OS DADOS
        $fields = array_keys($values);

        //MONTA A QUERY
        $query = "UPDATE $this->table SET ".implode(' = ?, ', $fields) ." = ? WHERE $where";

        //EXECUTA A QUERY
        $this->execute($query, array_values($values));
        
        return true;
    }

    /**
    *Método responsável por executar operação de exclusão
    *@return boolean
    */
    public function delete($where){
        //MONTA A QUERY DE EXCLUSAO
        $query = "DELETE FROM $this->table WHERE $where";

        //EXCUTA A QUERY
        $this->execute($query);

        return true;
    }

    public function select($where = null, $order = null, $limit = null, $fields = '*'){
        //DADOS DA QUERY
        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';


        $query = 'SELECT '. $fields .' FROM ' . $this->table . ' ' . $where .' '. $order .' '. $limit;
        
        return $this->execute($query);
    }
}
