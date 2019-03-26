<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Critica extends CI_Model{

   /**
    * Insere um registro na tabela
    *
    * @param array $dados Dados a serem inseridos
    *
    * @return boolean
    */

    public function criarCritica($dados = NULL){
        if ($dados != NULL) {
        $this->db->insert('criticas', $dados);
        return true;
      }
    }

    /**
    * Busca todas as críticas com status em aberto
    *
    * @return array
    */
    public function todasCriticas(){
      $status = 0;
      $query = $this->db->select('cod_critica, motivo, texto_critica, usuario, usuario_criticado')  
      ->from('criticas, usuario')
      ->where('crit_id_usuario = id_usuario')
      ->where('status_critica', $status)
      ->get();
       
	     if ($query->num_rows() > 0) {
	       return $query->result_array();
	     } else {
	       return null;
	     }
    }

    // public function listarCriticasUsuario($usuario){
    //   $query = $this->db->select('*')  
    //   ->from('criticas, usuario, status_critica')
    //   ->where('crit_id_usuario = id_usuario')
    //   ->where('usuario', $usuario)
    //   ->where('status_critica = id_status_critica')
    //   ->get();
       
    //   if ($query->num_rows() > 0) {
    //     return $query->result_array();
    //   } else {
    //   return null;
    //   }
    // }
    
    /**
    * Resolve crítica
    *
    * @param int $id id da crítica que foi resolvida
    *
    * @return boolean
    */
    public function resolveCritica($id){
       if(is_null($id)){
	    	return false;
	    }
	    else{
	    	$this->db->where('cod_critica', $id);
        $this->db->set('status_critica','1');
        $this->db->where('status_critica', '0');
        $this->db->update('criticas');	    	
      }
    }
}
