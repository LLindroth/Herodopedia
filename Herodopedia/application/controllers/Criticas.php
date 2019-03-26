<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Criticas extends CI_Controller {

	/**CREATE
    * Cria critica sobre um usuario
    *
    * 
    *   $this->load->model('critica');
    *   $this->load->model('usuario');
    *   $this->load->model('notificacao');
    */
        
    public function inserir(){
        
        date_default_timezone_set('America/Sao_Paulo');
        
        $dados['motivo'] = $this->input->post('motivo');
        $dados['texto_critica'] = $this->input->post('texto');
        $dados['usuario_criticado'] = $this->input->post('denunciado');
        $dados['crit_id_usuario'] = $_SESSION['id'];
        $dados['status_critica'] = 0;

        $retorno = $this->critica->criarCritica($dados);
        
        if ($retorno) {
            $admins = $this->usuario->todosAdmins();
            foreach ($admins as $admin) {
                $dadosN['nuser_id_usuario'] = $admin->id_usuario;
                $dadosN['nuser_cod_n'] = 9;
                $dadosN['status_n'] = 2;
                $dadosN['data_n'] = date("Y-m-d-H-i");
                $this->notificacao->insereNotificacao($dadosN);
            }
        }    

        redirect("/pages/index");
        
    }

    /**
    * Busca todos os usuários no banco e mostra em admuser.php
    *
    * Carrega index.php com os dados do banco
    */
    public function resolver($id){

        session_start();

        date_default_timezone_set('America/Sao_Paulo');
        
        $this->load->model('critica');
        $this->load->model('usuario');
        $this->load->model('notificacao');
        
        $dados['critica'] = $this->critica->resolveCritica($id);

        $admins = $this->usuario->todosAdmins();
        foreach ($admins as $admin) {
            if ($_SESSION['id'] !== $admin->id_usuario) {
                $dadosN['nuser_id_usuario'] = $admin->id_usuario;
                $dadosN['nuser_cod_n'] = 10;
                $dadosN['status_n'] = 2;
                $dadosN['data_n'] = date("Y-m-d-H-i");
                $this->notificacao->insereNotificacao($dadosN);
            }
        }
        
        redirect("pages/criticas");
    }
}