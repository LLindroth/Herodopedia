<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artigos extends CI_Controller {

    /**
    * Trata dados enviados e chama a função dentro do model
    *
    * Redireciona
    */

    public function inserir(){

        date_default_timezone_set('America/Sao_Paulo');
        $this->load->model('artigo');
        $this->load->model('usuario');
        $this->load->model('notificacao');
                
        $dados['titulo'] = strtolower(str_replace(" ", "_", $this->input->post('titulo')));
        $dados['conteudo'] = $this->input->post('conteudo');
        $dados['tag'] = $this->input->post('tag');
        $dados['status'] = 1;
        $dados['data_art'] = date("Y-m-d-H-i-s");
        $dados['art_id_usuario'] = $_SESSION['id'];

        $retorno = $this->artigo->criarArtigo($dados);

        $dadosEdit['text_edit'] = $this->input->post('conteudo');
        $dadosEdit['status_edit'] = 3;
        $dadosEdit['edi_id_usuario'] = $_SESSION['id'];
        $dadosEdit['edi_cod_artigo'] = $this->artigo->consultaId();
        $dadosEdit['data_edit'] = $dados['data_art'];

        $retorno = $this->artigo->criarEdicao($dadosEdit);

        if($retorno){
            $admins = $this->usuario->todosAdmins();
            foreach ($admins as $admin) {
                $dadosN['nuser_id_usuario'] = $admin->id_usuario;
                $dadosN['nuser_cod_n'] = 11;
                $dadosN['status_n'] = 2;
                $dadosN['data_n'] = date("Y-m-d-H-i");
                $this->notificacao->insereNotificacao($dadosN);
            }
            redirect("/pages/index");
        }
        else{           
            redirect("/pages/index");
        }   
    }

    /**
    * Trata dados enviados e chama a função dentro do model
    *
    * Redireciona
    */
    public function editar($titulo) {

        $this->load->model('artigo');

        date_default_timezone_set('America/Sao_Paulo');
        $novosDados['titulo'] = strtolower(str_replace(" ", "_", $this->input->post('titulo')));
        $novosDados['conteudo'] = $this->input->post('conteudo');
        $novosDados['tag'] = $this->input->post('tag');
        $novosDados['data_art'] = date("Y-m-d-H-i-s");

        $retorno = $this->artigo->editarArtigo($novosDados, $titulo);

        $dadosEdit['text_edit'] = $this->input->post('conteudo');
        $dadosEdit['status_edit'] = 3;
        $dadosEdit['edi_id_usuario'] = $_SESSION['id'];
        $dadosEdit['edi_cod_artigo'] = $this->artigo->consulta_id_artigo($titulo);
        $dadosEdit['data_edit'] = date("Y-m-d-H-i-s");

        $retorno = $this->artigo->criarEdicao($dadosEdit);


    

        redirect("../index.php/pages/mostra_artigo/{$novosDados['titulo']}");
        
    }

    /**
    * Trata dados enviados e chama a função dentro do model
    *
    * Redireciona
    */
        
    public function excluir($id) {
    
        $this->load->model('artigo');
        $this->load->model('notificacao');

        date_default_timezone_set('America/Sao_Paulo');

        $dadosN['nuser_id_usuario'] = $this->artigo->usuarioArtigo($id);
        $dadosN['nuser_cod_n'] = 7;
        $dadosN['status_n'] = 2;
        $dadosN['data_n'] = date("Y-m-d-H-i");

        $this->artigo->excluirArtigo($id);
        $this->notificacao->insereNotificacao($dadosN);

        redirect("pages/gerenciar");
        
    }

    /**
    * Reativa um artigo excluido
    *
    * Redireciona
    */
        
    public function reativar($id) {
    
        $this->load->model('artigo');
        $this->load->model('notificacao');

        date_default_timezone_set('America/Sao_Paulo');

        $dadosN['nuser_id_usuario'] = $this->artigo->usuarioArtigo($id);
        $dadosN['nuser_cod_n'] = 18;
        $dadosN['status_n'] = 2;
        $dadosN['data_n'] = date("Y-m-d-H-i");

        $this->artigo->reativarArtigo($id);
        $this->notificacao->insereNotificacao($dadosN);

        redirect("pages/gerenciar");
        
    }

    /**
    * Aprova artigo desejado para ser publicado no site
    *
    * Redireciona
    */
    public function aprovar($nome){

        $this->load->model('artigo');
        $this->load->model('notificacao');
        date_default_timezone_set('America/Sao_Paulo');

        //$dados['nuser_id_usuario'] = $_SESSION['id'];
        $artigo = $this->artigo->artigoSelecionado($nome);
        $dadosN['nuser_id_usuario'] = $artigo['edi_id_usuario'];
        $dadosN['nuser_cod_n'] = 1;
        $dadosN['status_n'] = 2;
        $dadosN['data_n'] = date("Y-m-d-H-i");

        $retorno = $this->artigo->aprovarArtigo($nome);
        if ($retorno) {
            $this->notificacao->insereNotificacao($dadosN);
        }
        
        redirect("pages/aprovacao");
    }

    /**
    * Rejeita o artigo desejado
    *
    * Redireciona
    */
    public function rejeitar($nome){

        $this->load->model('artigo');
        $this->load->model('notificacao');
        date_default_timezone_set('America/Sao_Paulo');

        $artigo = $this->artigo->artigoSelecionado($nome);
        $dadosN['nuser_id_usuario'] = $artigo['edi_id_usuario'];
        $dadosN['nuser_cod_n'] = 20;
        $dadosN['status_n'] = 2;
        $dadosN['data_n'] = date("Y-m-d-H-i");

        $retorno = $this->artigo->rejeitarArtigo($nome);
        if ($retorno) {
            $this->notificacao->insereNotificacao($dadosN);
        }
        
        redirect("pages/aprovacao");
    }

    /**
    * Trata dados enviados e chama a função dentro do model
    *
    * Redireciona
    */
    public function aprovarSugestao($id, $usuario){

        $this->load->model('artigo');
        $this->load->model('usuario');
        $this->load->model('notificacao');

        date_default_timezone_set('America/Sao_Paulo');

        $dadosN['nuser_id_usuario'] = $this->artigo->usuarioSugestao($id);
        $dadosN['nuser_cod_n'] = 5;
        $dadosN['status_n'] = 2;
        $dadosN['data_n'] = date("Y-m-d-H-i");

        $retorno = $this->artigo->aprovarSugestao($id);

        if ($retorno) {
            $this->notificacao->insereNotificacao($dadosN);
            $admins = $this->usuario->todosAdmins();
            foreach ($admins as $admin) {
                $dadosN['nuser_id_usuario'] = $admin->id_usuario;
                $dadosN['nuser_cod_n'] = 12;
                $dadosN['status_n'] = 2;
                $dadosN['data_n'] = date("Y-m-d-H-i");
                $this->notificacao->insereNotificacao($dadosN);
            }
        }

        redirect("pages/perfil/$usuario");
    }

    public function rejeitarSugestao($id, $usuario){

        $this->load->model('artigo');
        $this->load->model('notificacao');

        date_default_timezone_set('America/Sao_Paulo');

        $dadosN['nuser_id_usuario'] = $this->artigo->usuarioSugestao($id);
        $dadosN['nuser_cod_n'] = 15;
        $dadosN['status_n'] = 2;
        $dadosN['data_n'] = date("Y-m-d-H-i");

        $retorno = $this->artigo->rejeitarSugestao($id);

        if ($retorno) {
            $this->notificacao->insereNotificacao($dadosN);
        }

        redirect("pages/perfil/$usuario");
    }

    
    /**
    * Trata dados enviados e chama a função dentro do model
    *
    * Redireciona
    */
    public function aprovarEdicao($id){

        $this->load->model('artigo');
        $this->load->model('notificacao');

        date_default_timezone_set('America/Sao_Paulo');

        $dados['data_edit'] = date("Y-m-d-H-i-s");
        $dados['edi_cod_artigo'] = $this->artigo->dadosEdicao($id);
        $idArt = $dados['edi_cod_artigo'];
        $dadosN['nuser_id_usuario'] = $this->artigo->usuarioSugestao($id);
        $dadosN['nuser_cod_n'] = 6;
        $dadosN['status_n'] = 2;
        $dadosN['data_n'] = date("Y-m-d-H-i-s");

        $retorno =$this->artigo->preparaEdicao($id);

        $retorno = $this->artigo->substituirEdicao($idArt);

        $retorno = $this->artigo->aprovarEdicao($id, $dados);

        if ($retorno) {
            $this->notificacao->insereNotificacao($dadosN);
        }

        redirect("pages/aprovacao");

    }

    public function rejeitarEdicao($id){

        $this->load->model('artigo');
        $this->load->model('notificacao');

        date_default_timezone_set('America/Sao_Paulo');

        $dados['data_edit'] = date("Y-m-d-H-i-s");
        $dadosN['nuser_id_usuario'] = $this->artigo->usuarioSugestao($id);
        $dadosN['nuser_cod_n'] = 16;
        $dadosN['status_n'] = 2;
        $dadosN['data_n'] = date("Y-m-d-H-i-s");

        $retorno = $this->artigo->rejeitarEdicao($id, $dados);

        if ($retorno) {
            $this->notificacao->insereNotificacao($dadosN);
        }

        redirect("pages/aprovacao");

    }


    
    /**
    * Trata dados enviados e chama a função dentro do model
    *
    * Redireciona
    */
    public function sugerirEdicao($id, $nome){

        $this->load->model('artigo');
        $this->load->model('notificacao');
        date_default_timezone_set('America/Sao_Paulo');
                
        $dados['text_edit'] = $this->input->post('conteudo');
        $dados['status_edit'] = 1;
        $dados['edi_id_usuario'] = $_SESSION['id'];
        $dados['edi_cod_artigo'] = $id;
        $dados['data_edit'] = date("Y-m-d-H-i-s");
        $dadosN['nuser_id_usuario'] = $this->artigo->usuarioArtigo($id);
        $dadosN['nuser_cod_n'] = 4;
        $dadosN['status_n'] = 2;
        $dadosN['data_n'] = date("Y-m-d-H-i-s");
        $retorno = $this->artigo->sugerirEdicao($dados);

        if($retorno){
            $this->notificacao->insereNotificacao($dadosN);
            redirect("/pages/mostra_artigo/{$nome}");
        }
        else{           
            redirect("/pages/index");
        }
    }

    
    
}