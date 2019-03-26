<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Discussao extends CI_Model{

   /**
    * Insere um registro na tabela
    *
    * @param array $dados Dados a serem inseridos
    *
    * @return boolean
    */
    
    public function criarDiscussao($dados = NULL){
      if ($dados != NULL) {
        $this->db->insert('discussao', $dados);
        return true;
      }
      else{
        return false;
      }
    }
    
    /**
  	* Lista todos os registros da tabela
  	*
  	* @param int $id Id do artigo do qual se quer as discussoes
  	*
  	* @return array
  	*/

	public function discussoesArtigo($id , $status = 0){
            $this->db->where('disc_cod_artigo', $id);
            $this->db->where('status_disc', $status);
            $this->db->limit(4);
	    $query = $this->db->get('discussao');

	    if ($query->num_rows() > 0) {
	    	return $query->result();
	    } else {
	    	return null;
	    }
	}
  /**
    * Lista todos os registros da tabela
    *
    * @param int $id Id do artigo do qual se quer as discussoes
    *
    * @return array
    */  
  public function discussaoSelecionada($nome){
    if(is_null($nome)){
      return false;
    } else{
      $this->db->where('disc_id_usuario = id_usuario');
      $this->db->where('titulo_discussao', $nome);
      $this->db->where('disc_cod_artigo = cod_artigo');
      $this->db->where('tag_discussao = id_tag');
      $query = $this->db->get('discussao, usuario, artigo,tag');

      if ($query->num_rows() > 0) {
          return $query->row_array();
      } else {
          return null;
      }
    }
  }

        
   /**READ
    * Lista todas as discussões de um artigo em status 2 e ativas
    *
    * @param int $numero número de discussões
    *  
    * @param string $ordenar Campo para ordenação dos registros
    *
    * @param string $ordem Tipo de ordenação: ASC ou DESC
    * 
    * @param int $status status do artigo
    *
    * @param int $status_disc status da discussão
    * 
    * @return array
    */
    public function listaDiscussoes($numero, $ordenar = 'cod_discussao', $ordem = 'desc', $status = 2, $status_disc = 0){
      
       $query = $this->db->select('*')
      ->from('discussao , usuario, artigo, tag')
      ->where('id_usuario = disc_id_usuario')
      ->where('cod_artigo = disc_cod_artigo')
      ->where('tag_discussao = id_tag')
      ->where('status' , $status)
      ->where('status_disc' , $status_disc)
      ->order_by($ordenar, $ordem)
      ->limit($numero)
      ->get();


    	if ($query->num_rows() > 0) {
    	    return $query->result();
    	} else {
    	    return null;
    	}
    }

    /**READ
    * Lista todas as discussões
    *
    * @param int $numero número de discussões
    *  
    * @param string $ordenar Campo para ordenação dos registros
    *
    * @param string $ordem Tipo de ordenação: ASC ou DESC
    *  
    * @return array
    */
    public function listarDiscussoes($numero = 1000, $ordenar = 'cod_discussao', $ordem = 'asc'){
        
        $query = $this->db->select('*')
        ->from('discussao, artigo , usuario, tag, status_discussao')
        ->where('disc_id_usuario = id_usuario')
        ->where('disc_cod_artigo = cod_artigo')
        ->where('status_disc = id_status_disc')
        ->where('tag_discussao = id_tag')
        ->order_by($ordenar, $ordem)
        ->limit($numero)
        ->get();

      	if ($query->num_rows() > 0) {
      	    return $query->result();
      	} else {
      	    return null;
      	}
    }

    public function listarDiscussoesUsuario($usuario, $numero = 1000, $ordenar = 'data_disc', $ordem = 'desc'){
        
        $query = $this->db->select('*')
        ->from('discussao, usuario, tag, status_discussao')
        ->where('disc_id_usuario = id_usuario')
        ->where('status_disc = id_status_disc')
        ->where('tag_discussao = id_tag')
        ->where('usuario' , $usuario)
        ->order_by($ordenar, $ordem)
        ->limit($numero)
        ->get();

            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return null;
            }
    }

    /** READ
    * Busca as discussoes parecidas ou iguais a pesquisa
    *
    * @param int $numero número de artigos
    *  
    * @param string $ordenar Campo para ordenação dos registros
    *
    * @param string $ordem Tipo de ordenação: ASC ou DESC
    *
    * @param string $pesquisa Pesquisa do usuario
    * 
    * @return array
    */
    public function pesquisaDiscussoes($pesquisa, $numero = 100, $ordenar = 'data_disc', $ordem = 'desc'){
        $query = $this->db->select('*')
        ->from('discussao, usuario, artigo, tag')
        ->where('disc_id_usuario = id_usuario')
        ->where('disc_cod_artigo = cod_artigo')
        ->where('tag_discussao = id_tag')
        ->where('status_disc' , 0)
        ->like('titulo_discussao', $pesquisa)
        ->order_by($ordenar, $ordem)
        ->limit($numero)
        ->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function pesquisarDiscussoesTag($tag, $numero = 100, $ordenar = 'data_disc', $ordem = 'desc'){
        $query = $this->db->select('*')
        ->from('discussao, usuario, tag, artigo')
        ->where('disc_id_usuario = id_usuario')
        ->where('disc_cod_artigo = cod_artigo')
        ->where('tag_discussao = id_tag')
        ->where('status_disc' , 0)
        ->where('descricao_tag' , $tag)
        ->order_by($ordenar, $ordem)
        ->limit($numero)
        ->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    /** READ
    * Seleciona o usuario que criou a discussao
    * @param int $id código da discussao enviado por método GET
    *
    * @return array
    */

    public function usuarioDisc($id){
        $query = $this->db->select('disc_id_usuario')
        ->from('discussao')
        ->where('cod_discussao', $id)
        ->get();

        $retorno = $query->result();
        return $retorno[0]->disc_id_usuario;
    }


    /**UPDATE
    * Reativa a discussão escolhida
    *
    * @param int $id id da discussão a ser excluida
    *  
    * @return boolean
    */
    public function reativarDiscussao($id) {
        if(is_null($id)){
            return false;
        }
        else{
            $this->db->where('cod_discussao', $id); 
            $this->db->set('status_disc', '0');
            $this->db->where('status_disc' ,'1');
            $this->db->update('discussao');
        }
    }

    /**DELETE
    * Exclui a discussão escolhida
    *
    * @param int $id id da discussão a ser excluida
    *  
    * @return boolean
    */
    public function excluirDiscussao($id) {
        if(is_null($id)){
            return false;
        }
        else{
            $this->db->where('cod_discussao', $id); 
            $this->db->set('status_disc', '1');
            $this->db->where('status_disc' ,'0');
            $this->db->update('discussao');
        }
    }
}