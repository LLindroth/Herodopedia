<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tag extends CI_Model{

	public function buscaTags(){

		$query = $this->db->select('*')
        ->from('tag')
        ->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }


	}

	public function buscaTagDesc($nome){

		$query = $this->db->select('descricao_tag')
        ->from('tag, artigo')
        ->where('titulo', $nome)
        ->where('tag = id_tag')
        ->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }


	}

    public function buscaTagDescDisc($nome){

        $query = $this->db->select('descricao_tag')
        ->from('tag, discussao')
        ->where('titulo_discussao', $nome)
        ->where('tag_discussao = id_tag')
        ->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }


    }

}