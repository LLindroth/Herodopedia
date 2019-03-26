<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussoes extends CI_Controller {
 
    /**
    * Insere discussão no banco de dados
    *
    * Redireciona
    */
    public function inserir(){
      
        date_default_timezone_set('America/Sao_Paulo');
        
        $this->load->model('discussao');
        $this->load->model('artigo');
        $this->load->model('notificacao');
        
        $dados['titulo_discussao'] = strtolower(str_replace(" ", "_", $this->input->post('titulo')));
    	$dados['texto_discussao'] = $this->input->post('conteudo');
    	$dados['tag_discussao'] = $this->input->post('tag');
    	$dados['data_disc'] = date("Y-m-d-H-i-s");
    	$dados['disc_id_usuario'] = $_SESSION['id'];
        $dados['disc_cod_artigo'] = $_SESSION['id_artigo'];
        $dados['status_disc'] = 0;
        $dadosN['nuser_id_usuario'] = $this->artigo->usuarioArtigo($_SESSION['id_artigo']);
        $dadosN['nuser_cod_n'] = 3;
        $dadosN['status_n'] = 2;
        $dadosN['data_n'] = date("Y-m-d-H-i");

        
        $retorno = $this->discussao->criarDiscussao($dados);
        if($retorno){
            $this->notificacao->insereNotificacao($dadosN);
            redirect("/pages/mostra_discussao/".$dados['titulo_discussao']);
        }
        else{           
            redirect("/pages/index");
        }      
    }
    
    
    /**
    * Exclui discussão
    *
    * Redireciona
    */
    public function excluir($id) {
        
        $this->load->model('discussao');
        $this->load->model('notificacao');

        $dadosN['nuser_id_usuario'] = $this->discussao->usuarioDisc($id);
        $dadosN['nuser_cod_n'] = 8;
        $dadosN['status_n'] = 2;
        $dadosN['data_n'] = date("Y-m-d-H-i");
        
        $this->discussao->excluirDiscussao($id);
        $this->notificacao->insereNotificacao($dadosN);
        
        redirect("/pages/gerenciar");
    }

    /**
    * Reativa discussão
    *
    * Redireciona
    */
    public function reativar($id) {
        
        $this->load->model('discussao');
        $this->load->model('notificacao');

        $dadosN['nuser_id_usuario'] = $this->discussao->usuarioDisc($id);
        $dadosN['nuser_cod_n'] = 19;
        $dadosN['status_n'] = 2;
        $dadosN['data_n'] = date("Y-m-d-H-i");
        
        $this->discussao->reativarDiscussao($id);
        $this->notificacao->insereNotificacao($dadosN);
        
        redirect("/pages/gerenciar");
    }
    
    
}
    