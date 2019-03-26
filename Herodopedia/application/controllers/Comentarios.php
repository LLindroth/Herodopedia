<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comentarios extends CI_Controller {

	// Função inserir() insere os dados no banco
        
        public function inserir(){
            
            date_default_timezone_set('America/Sao_Paulo');
                
            $this->load->model('comentario');
            $this->load->model('discussao');
            $this->load->model('notificacao');
            
            $dados['texto_comentario'] = $this->input->post('comentario');
            $dados['data_com'] = date("Y-m-d");
            $dados['com_id_usuario'] = $_SESSION['id'];
            $dados['cod_discussao'] = $_SESSION['id_discussao'];

            $retorno = $this->comentario->criarComentario($dados);
            if($retorno){
            $disc = $this->comentario->discSelecionada($dados['cod_discussao']);
            $titulo_dis = $disc['titulo_discussao'];
            redirect("pages/mostra_discussao/".$titulo_dis);
            }
            else{
            redirect("/pages/index");
            }
            
        }
        
        public function buscar(){
            
            $this->load->model('comentario');
            
            $dados['comentarios'] = $this->comentario->comentariosDiscussao();

            $this->load->view('index', $dados);
        }
        
        public function excluir($id){

        $this->load->model('comentario');
        
        $this->comentario->excluirComentario($id);

        $disc = $this->comentario->discSelecionada($_SESSION['id_discussao']);

        redirect("pages/mostra_discussao/".$disc['titulo_discussao']);
        }
}
        
 