<?php
namespace LOJA\API;//Local desta classe
use LOJA\DAO\DAOCliente;
use LOJA\Model\Cliente;

    class ClienteLogar{
        public $msg;

        function __construct($url){
            if($_POST){
                try{
                    $obj = new Cliente();
                    $obj->setNome($_POST['nome']);
                    $obj->setSenha($_POST['senha']);

                    $DAO = new DAOCliente();
                    // Verifica se existe usuario com nome e senha informados
                    $result = $DAO->buscoPorNomeSenha($obj);
                    

                    if($result){//se houver resultado
                        //guardo as informações do usuario na sessão
                        $_SESSION['clienteid'] = $result['id'];
                        $_SESSION['clientenome'] = $result['nome'];

                        //header("location: http://www.qualificaroficina.web70113.uni5.net/painel/cliente");
                        //
                        $this->verificarUrl($url);
                       
                        echo "ok";
                    }else{
                        $this->msg = "Cliente/Senha inválidos";
                    }    
                }catch(\Exception $e){
                    $this->msg = $e->getMessage();
                }
            }

           
        }

    

        function verificarUrl($url) {
            if(isset($_SESSION['url'])) {
                
                
                header("location:".$_SESSION['url']);
            }else {

                header("location: ".$url."/painel/cliente");
            }
        }
    }


?>