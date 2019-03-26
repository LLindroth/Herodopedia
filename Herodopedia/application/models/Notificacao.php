<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notificacao extends CI_Model{   
    
    /**
  	* Lista todos os registros da tabela
  	*
  	* @return array
  	*/
   
    public function recebeNotificacoes(){

      if (isset($_SESSION['id'])){

        $id_usuario = $_SESSION['id'];

        $query = $this->db->select('texto_n, data_n')
        ->from('notificacao, not_user')
        ->where('nuser_id_usuario', $id_usuario)
        ->where('cod_n = nuser_cod_n')
        ->order_by('status_n desc, cod_notUser desc')
        ->get();

      	if ($query->num_rows() > 0) {
      	    return $query->result();
      	} else {
      	    return null;
      	}
      }
    }

    public function insereNotificacao($dados = NULL){
      if ($dados != NULL) {
        $this->db->insert('not_user', $dados);
        return true;
      }
    }
    
    public function contaNots() {

      if (isset($_SESSION['id'])){

        $id_usuario = $_SESSION['id'];
        
        $query = $this->db->query("SELECT contaNots($id_usuario)");

        $resultado = $query->result_array()[0];

        return $resultado["contaNots($id_usuario)"];

      }

    }

    public function atualizaNotificacao($id){
        
        $this->db->where('nuser_id_usuario', $id);
        $this->db->set('status_n', 3);
        $this->db->update('not_user');

        return true;
    }
}
