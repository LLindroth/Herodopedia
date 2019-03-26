<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comentario extends CI_Model{

   /**
    * Insere um registro na tabela
    *
    * @param array $dados Dados a serem inseridos
    *
    * @return boolean
    */

    public function criarComentario($dados = NULL){
        if ($dados != NULL) {
        $this->db->insert('comentario', $dados);
        return true;
      }
    }
    
    public function comentariosDiscussao($id){
       $query = $this->db->select('texto_comentario, data_com, usuario, cod_comentario')  
       ->from('comentario, usuario')
       ->where('com_id_usuario = id_usuario')
       ->where('cod_discussao', $id)
       ->order_by('cod_comentario', 'desc')
       ->get();

	if ($query->num_rows() > 0) {
	    	return $query->result();
	    } else {
	    	return null;
	    }
	}
        
    public function discSelecionada($id){
        if(is_null($id)){
            return false;
        }
        else{
            $this->db->where('cod_discussao', $id);
            $query = $this->db->get('discussao');
            //$query = $this->db->select('titulo_discussao');

            if ($query->num_rows() > 0) {
            return $query->row_array();
            }
            else {
            return null;
            }
        }
    }

    public function excluirComentario($id){
        if(is_null($id)){
            return false;
        }
        else{
            $this->db->where('cod_comentario', $id); 
            $this->db->delete('comentario');

        }
    } 

}
