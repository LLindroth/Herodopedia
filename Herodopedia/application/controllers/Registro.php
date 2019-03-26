<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro extends CI_Controller {

    /**
    * Trata dados enviados e chama a função dentro do model
    *
    * Redireciona
    */

    public function inserir(){

    	$this->load->model('usuario');

    	$dados['nome'] = $this->input->post('nome');
    	$dados['sobrenome'] = $this->input->post('sobrenome');
    	$dados['email'] = $this->input->post('email');
    	$dados['usuario'] = str_replace(" ", "_", strtolower($this->input->post('usuario')));
    	$dados['cod_tipo'] = 1;

        $erro = $this->usuario->verificaSenha($this->input->post('senha'));
        $erro .= $this->usuario->verificaDtNasc($this->input->post('dt_nasc'));
        $erro .= $this->usuario->verificaEmail($dados['email']);
        $erro .= $this->usuario->verificaUsuario($dados['usuario']);

        if ($erro == ""){

            $dados['senha'] = md5($this->input->post('senha'));
            $dados['dt_nasc'] = $this->input->post('dt_nasc');

            $this->usuario->registrarUsuario($dados);

            redirect("/pages/index");
        
        } else {

            $_SESSION['erro'] = $erro;
            $_SESSION['nome'] = $dados['nome'];
            $_SESSION['sobrenome'] = $dados['sobrenome'];
            $_SESSION['email'] = $dados['email'];
            $_SESSION['usuario'] = $dados['usuario'];

            redirect("/pages/register");

        }

    }



    /**
    * Verifica se dados conferem e loga usuário
    *
    * Redireciona ao index se correto ou para login se errado
    */

    public function logar(){
    	$this->load->model('usuario');

    	$dados['email'] = $this->input->post('email');
    	$dados['senha'] = md5($this->input->post('senha'));

    	$usuario = $this->usuario->efetuaLogin($dados);

        if ($usuario['cod_tipo'] == 3) {

            $_SESSION['erro'] = "Você foi Banido";
            redirect("/pages/login");
        }
                
        if(!is_null($usuario)){
            session_start();
            $_SESSION['id'] = $usuario['id_usuario'];
            $_SESSION['nome'] = $usuario['nome']; 
            $_SESSION['sobrenome'] = $usuario['sobrenome']; 
            $_SESSION['email'] = $usuario['email']; 
            $_SESSION['usuario'] = $usuario['usuario']; 
            $_SESSION['cod_tipo'] = $usuario['cod_tipo'];
            redirect("/pages/index");
        }
        else{
            $_SESSION['erro'] = "Não foi encontrado nenhum usuário com esse email ou senha";
            redirect("/pages/login");
        }	
    }
    
    /**
    * Desloga usuário quebrando sessão
    *
    * Redireciona para index
    */

    public function logout(){
        unset($_SESSION['id']);
        unset($_SESSION['nome']);
        unset($_SESSION['sobrenome']);
        unset($_SESSION['email']);
        unset($_SESSION['usuario']);
        unset($_SESSION['cod_tipo']);
        session_destroy();
        redirect("/pages/index");
    }

    /**
    * Bane
    *
    * Carrega index.php com os dados do banco
    */
    public function banir($id) {
        
        $this->load->model('usuario');
        $this->load->model('notificacao');
        
        $dados['usuario'] = $this->usuario->banirUsuario($id);

        $dadosN['nuser_id_usuario'] = $id;
        $dadosN['nuser_cod_n'] = 13;
        $dadosN['status_n'] = 2;
        $dadosN['data_n'] = date("Y-m-d-H-i");
        $this->notificacao->insereNotificacao($dadosN);
        
        redirect("pages/usuarios");

    }


    /**
    * Desbane
    *
    * Carrega index.php com os dados do banco
    */
     public function desbanir($id) {
        
        $this->load->model('usuario');
        $this->load->model('notificacao');
        
        $dados['usuario'] = $this->usuario->desbanirUsuario($id);

        $dadosN['nuser_id_usuario'] = $id;
        $dadosN['nuser_cod_n'] = 14;
        $dadosN['status_n'] = 2;
        $dadosN['data_n'] = date("Y-m-d-H-i");
        $this->notificacao->insereNotificacao($dadosN);
        
        redirect("pages/usuarios");

    }
}