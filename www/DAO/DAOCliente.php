<?php

namespace LOJA\DAO;
use LOJA\Model\Conexao;
use LOJA\Model\Cliente;

class DAOCliente{




    /*public function cadastrar(Cliente $cliente){

        
        $sql = "INSERT INTO cliente
        VALUES (default, :nome, :cpf, :cep, :endereco, :telefone, :email, :senha)";
        
        $con = Conexao::getInstance()->prepare($sql);
        $con->bindValue(":nome", $cliente->getNome());
        $con->bindValue(":cpf", $cliente->getCpf());
        $con->bindValue(":cep", $cliente->getCep());
        $con->bindValue(":endereco", $cliente->getEndereco());
        $con->bindValue(":telefone", $cliente->getTelefone());
        $con->bindValue(":email", $cliente->getEmail());
        $con->bindValue(":senha", $cliente->getSenha());
        $con->execute();
        return "Cadastrado com sucesso";*/


    public $lastId;
    public function cadastrar(Cliente $cliente){


        $pdo = Conexao::getInstance(); // Cria objeto de conexão
        $pdo->beginTransaction(); // Inicia a transação

        try{
            $con = $pdo->prepare(
                "INSERT INTO cliente VALUES (default, :nome, :cpf, :cep, :endereco, :telefone, :email, :senha)"
            );
            $con->bindValue(":nome", $cliente->getNome());
            $con->bindValue(":cpf", $cliente->getCpf());
            $con->bindValue(":cep", $cliente->getCep());
            $con->bindValue(":endereco", $cliente->getEndereco());
            $con->bindValue(":telefone", $cliente->getTelefone());
            $con->bindValue(":email", $cliente->getEmail());
            $con->bindValue(":senha", $cliente->getSenha());
            $con->execute();

        $this->lastId = $pdo->lastInsertId(); // Retorna o id do cliente cadastrado
        $pdo->commit(); // finaliza a transação
        return "Cadastrado com Sucesso";
        }
        catch(Exception $e) {
            $this->lastId = 0;
            $pdo->rollback();
            return "Erro ao Cadastrar";
        }
    }
    //
    public function buscoPorNomeSenha(Cliente $cliente){
        $sql = "SELECT pk_cliente as id,nome 
        FROM cliente WHERE nome = :nome AND 
        senha = :senha";
        
        $con = Conexao::getInstance()->prepare($sql);
        $con->bindValue(":nome", $cliente->getNome());
        $con->bindValue(":senha", $cliente->getSenha());
        $con->execute();
        $con->bindValue(":endereco", $cliente->getEndereco());
        
      
        $cliente = new Cliente();
        $cliente = $con->fetch(\PDO::FETCH_ASSOC);
        return $cliente;
       
       

    }
    public function listaCliente(){
        $sql = "SELECT * FROM cliente";
        $con = Conexao::getInstance()->prepare($sql);
        $con->execute();

        $lista = array();

        while($cliente = $con->fetch(\PDO::FETCH_ASSOC)){
            $lista[] = $cliente;
        }
        return $lista;
    }

    public function buscaPorId($id){

        $sql = "SELECT * FROM cliente WHERE pk_cliente = :id";
        $con = Conexao::getInstance()->prepare($sql);
        $con->bindValue(":id", $id);
        
        $con->execute();

        $cliente = new Cliente();

        $cliente = $con->fetch(\PDO::FETCH_ASSOC);
        //print_r($cliente);//testa saida 
        return $cliente;

    }
    public function deleteAll() {
        $sql = "delete from cliente";
        $con =  Conexao::getInstance()->prepare($sql);
        $con->execute();
        return "Excluído todos com sucesso";
    }
    public function deleteFromId($id) {
        $sql = "delete from cliente where pk_cliente = {$id}";
        $con = Conexao::getInstance()->prepare($sql);
        $con->execute();
        return "Excluído Todos com sucesso";
    }
}
?>
