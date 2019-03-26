<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Artigo extends CI_Model{

   /** CREATE
    * Insere um registro na tabela
    *
    * @param array $dados Dados a serem inseridos
    *
    * @return boolean
    */

    public function criarArtigo($dados = NULL){
      if ($dados != NULL) {
        $this->db->insert('artigo', $dados);
        return true;
      }
    }

    /** CREATE
    * Insere um registro na tabela
    *
    * @param array $dados Dados a serem inseridos
    *
    * @return boolean
    */

    public function criarEdicao($dadosEdit = NULL){
      if ($dadosEdit != NULL) {
        $this->db->where('edi_cod_artigo', $dadosEdit['edi_cod_artigo']);
        $this->db->set('status_edit','5');
        $this->db->where('status_edit', '3');
        $this->db->update('edicao');
        $this->db->insert('edicao', $dadosEdit);
        return true;
      }
    }
    
   /** READ
    * Lista todos os registros da tabela
    *
    * @param int $numero número de artigos
    *  
    * @param string $ordenar Campo para ordenação dos registros
    *
    * @param string $ordem Tipo de ordenação:  ASC ou DESC
    *
    * @param int $status status do artigo
    * 
    * @return array
    */
   
    public function listaArtigos($qtd, $inicio, $ordenar = 'data_art', $ordem = 'desc', $status=2){
        $query = $this->db->select('titulo, text_edit, tag, descricao_tag, usuario, data_art')
        ->from('artigo , usuario, tag, edicao')
        ->where('art_id_usuario = id_usuario')
        ->where('tag = id_tag')
        ->where('edi_cod_artigo = cod_artigo')
        ->where('status', $status)
        ->where('status_edit', 3)
        ->order_by($ordenar, $ordem)
        ->limit($qtd, $inicio)
        ->get();
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    /** READ
    * Lista todas as edicoes para um artigo com o titulo x
    *  
    * @param string $ordenar Campo para ordenação dos registros
    *
    * @param string $ordem Tipo de ordenação:  ASC ou DESC
    * 
    * @return array
    */

    public function pesquisarEdicoes($titulo, $ordenar = 'data_edit', $ordem = 'desc'){
        $query = $this->db->select('titulo, usuario, text_edit, data_edit, cod_edit')
        ->from('artigo , edicao, usuario')
        ->where('cod_artigo = edi_cod_artigo')
        ->where('titulo', $titulo)
        ->group_start()
        ->where('status_edit' , 3)
        ->or_where('status_edit' , 5)
        ->group_end()
        ->where('id_usuario = edi_id_usuario')
        ->order_by($ordenar, $ordem)
        ->get();
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function dadosEdicao($id){
        $query = $this->db->select('edi_cod_artigo')
        ->from('edicao')
        ->where('cod_edit' , $id)
        ->get();
        
        if ($query->num_rows() > 0) {

            $retorno = $query->result();
            return $retorno[0]->edi_cod_artigo;

        } else {
            return null;
        }
    }

    public function substituirEdicao($idArt){
        
        $this->db->set('status_edit', 5);
        $this->db->where('edi_cod_artigo', $idArt);
        $this->db->where('status_edit', 3);
        $this->db->update('edicao');
    }


    /** READ
    * Lista todos os artigos que estão em status de espera
    *
    * @param int $numero número de artigos
    *  
    * @param string $ordenar Campo para ordenação dos registros
    *
    * @param string $ordem Tipo de ordenação: ASC ou DESC
    * 
    * @return array
    */
    public function artigosEspera($numero = 5, $ordenar = 'cod_artigo', $ordem = 'desc'){
        $status = 1;
        $query = $this->db->select('cod_artigo, titulo, conteudo, descricao_status')
        ->from('artigo , usuario, tag, status_artigo')
        ->where('art_id_usuario = id_usuario')
        ->where('status = id_status')
        ->where('status', $status)
        ->where('tag = id_tag')
        ->order_by($ordenar, $ordem)
        ->limit($numero)
        ->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } 
        else {
            return null;
        }
    }

    public function edicoesEspera($numero = 5, $ordenar = 'cod_edit', $ordem = 'desc'){
        $query = $this->db->select('titulo, cod_edit, conteudo, descricao_status_edicao')
        ->from('edicao , usuario, artigo, tag, status_edicao')
        ->where('edi_cod_artigo = cod_artigo')
        ->where('edi_id_usuario = id_usuario')
        ->where('id_status_edicao = status_edit')
        ->where('status_edit', 2)
        ->where('tag = id_tag')
        ->order_by($ordenar, $ordem)
        ->limit($numero)
        ->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } 
        else {
            return null;
        }
    }

    public function listarSugestoesUsuario ($usuario, $numero = 5, $ordenar = 'cod_edit', $ordem = 'desc'){
        $query = $this->db->select('data_edit,cod_artigo, titulo, text_edit, edi_id_usuario, id_tag, descricao_tag, usuario, cod_edit')
        ->from('edicao, usuario, artigo, tag')
        ->where('edi_cod_artigo = cod_artigo')
        ->where('art_id_usuario = id_usuario')
        ->where('usuario', $usuario)
        ->where('tag = id_tag')
        ->where('status_edit', 1)
        ->order_by($ordenar, $ordem)
        ->limit($numero)
        ->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
        else {
            return null;
        }
    }

    /** READ
    * Busca os artigos parecidos ou iguais a pesquisa
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
    public function pesquisaArtigos($pesquisa, $numero = 100, $ordenar = 'data_art', $ordem = 'desc'){
        $query = $this->db->select('titulo, data_art, text_edit, descricao_tag, usuario')
        ->from('artigo, usuario, tag, edicao')
        ->where('art_id_usuario = id_usuario')
        ->where('tag = id_tag')
        ->where('edi_cod_artigo = cod_artigo')
        ->where('status' , 2)
        ->where('status_edit' , 3)
        ->like('titulo', $pesquisa)
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
    * Busca os artigos parecidos ou iguais a pesquisa
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

    public function pesquisarArtigosTag($tag, $numero = 100, $ordenar = 'data_art', $ordem = 'desc'){
        $query = $this->db->select('titulo, data_art, text_edit, descricao_tag, usuario')
        ->from('artigo, usuario, tag, edicao')
        ->where('art_id_usuario = id_usuario')
        ->where('tag = id_tag')
        ->where('edi_cod_artigo = cod_artigo')
        ->where('status' , 2)
        ->where('status_edit' , 3)
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
    * Lista todos os registros da tabela
    *
    * @param int $numero número de artigos
    *  
    * @param string $ordenar Campo para ordenação dos registros
    *
    * @param string $ordem Tipo de ordenação: ASC ou DESC
    *
    * @param int $status status do artigo
    * 
    * @return array
    */
    public function listarArtigos($numero = 1000, $ordenar = 'data_art', $ordem = 'desc'){
        
        $query = $this->db->select('cod_artigo, titulo, data_art, usuario, descricao_tag, descricao_status, status')
        ->from('artigo , usuario, tag, status_artigo')
        ->where('art_id_usuario = id_usuario')
        ->where('tag = id_tag')
        ->where('status = id_status')
        ->group_start()
        ->where('status' , 2)
        ->or_where('status' , 3)
        ->group_end()
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
    * Busca os artigos parecidos ou iguais a pesquisa
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
    // public function listarArtigosUsuario($usuario, $numero = 1000, $ordenar = 'data_art', $ordem = 'desc'){
        
    //     $query = $this->db->select('*')
    //     ->from('artigo , usuario, tag, status_artigo')
    //     ->where('art_id_usuario = id_usuario')
    //     ->where('tag = id_tag')
    //     ->where('status = id_status')
    //     ->where('usuario' , $usuario)
    //     ->order_by($ordenar, $ordem)
    //     ->limit($numero)
    //     ->get();

    //     if ($query->num_rows() > 0) {
    //         return $query->result();
    //     } else {
    //         return null;
    //     }
    // }
   
    /** READ
    * Seleciona o artigo desejado
    *
    * @param string $nome título do artigo enviado por método GET
    *  
    * @return array
    */
    
    public function artigoSelecionado($nome, $ordenar = 'data_edit', $ordem = 'desc', $numero = 1, $status = 3){
       if(is_null($nome)){
            return false;
        }
        else{
            $this->db->where('art_id_usuario = id_usuario');
            $this->db->where('titulo', $nome);
            $this->db->where('edi_cod_artigo = cod_artigo');
            $this->db->where('status_edit', $status);
            $this->db->where('tag = id_tag');
            $this->db->order_by($ordenar,$ordem);
            $this->db->limit($numero);
            $query = $this->db->get('artigo, usuario, edicao, tag');

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
            else {
               return null;
            }
        }
    }

    /** READ
    * Seleciona o artigo desejado
    *
    * @param string $nome título do artigo enviado por método GET
    *  
    * @return array
    */

    public function edicaoSelecionada($id){
       if(is_null($id)){
            return false;
        }
        else{
            $this->db->where('edi_cod_artigo = cod_artigo');
            $this->db->where('edi_id_usuario = id_usuario');
            $this->db->where('cod_edit' , $id);
            $query = $this->db->get('artigo, usuario, edicao');

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
            else {
               return null;
            }
        }
    }

     /** READ
    * Seleciona a edicao desejada
    *
    * @param string $id id da discussão selecionada
    *  
    * @return array
    */

    public function consultaId($ordenar = 'cod_artigo', $ordem = 'desc', $numero = 1){
        $query = $this->db->select('cod_artigo')
        ->from('artigo')
        ->order_by($ordenar,$ordem)
        ->limit($numero)
        ->get();

        $retorno = $query->result();
        return $retorno[0]->cod_artigo;
    }

    /** READ
    * Seleciona o artigo desejado
    *
    * @param string $nome título do artigo enviado por método GET
    *  
    * @return array
    */
    public function consulta_id_artigo($titulo){
        $query = $this->db->select('cod_artigo')
        ->from('artigo')
        ->where('titulo', $titulo )
        ->get();

        $retorno = $query->result();
        return $retorno[0]->cod_artigo;
    }

    /** READ
    * Seleciona o usuario que criou o artigo
    * @param int $id código do artigo enviado por método GET
    *
    * @return array
    */

    public function usuarioArtigo($id){
        $query = $this->db->select('art_id_usuario')
        ->from('artigo')
        ->where('cod_artigo', $id)
        ->get();

        $retorno = $query->result();
        return $retorno[0]->art_id_usuario;
    }

    /** READ
    * Seleciona o usuario que sugeriu a edição
    * @param int $id código da edição enviado por método GET
    *
    * @return array
    */

    public function usuarioSugestao($id){
        $query = $this->db->select('edi_id_usuario')
        ->from('edicao')
        ->where('cod_edit', $id)
        ->get();

        $retorno = $query->result();
        return $retorno[0]->edi_id_usuario;
    }

    /**UPDATE
    * Edita o artigo desejado
    *
    * @param string $id Id do artigo que será excluído
    *  
    * @return boolean
    */

    public function editarArtigo($novosDados = NULL, $titulo){
        if(is_null($novosDados)){
            return false;
        }
        else{
            
            $this->db->where('titulo', $titulo); 
            $this->db->set('titulo', $novosDados['titulo']);
            $this->db->set('conteudo', $novosDados['conteudo']);
            $this->db->set('tag', $novosDados['tag']);
            $this->db->update('artigo');

            return true;
        }
    }

    /**UPDATE
    * Edita o artigo desejado
    *
    * @param string $id Id do artigo que será excluído
    *  
    * @return boolean
    */

    public function sugerirEdicao($dados = NULL){
        if(is_null($dados)){
            return false;
        }
        else{

            $this->db->insert('edicao', $dados);
            return true;
                
        }

    }
    
    /**UPDATE
    * Reativa o artigo desejado
    *
    * @param string $id Id do artigo que será excluído
    *  
    * @return boolean
    */
    
    public function reativarArtigo($id) {
        if(is_null($id)){
            return false;
        }
        else{
            $this->db->where('cod_artigo', $id); 
            $this->db->set('status', '2');
            $this->db->where('status' ,'3');
            $this->db->update('artigo');
        }
    }


   /**DELETE
    * Deleta artigo desejado
    *
    * @param string $id Id do artigo que será excluído
    *  
    * @return boolean
    */
    
    public function excluirArtigo($id) {
        if(is_null($id)){
            return false;
        }
        else{
            $this->db->where('cod_artigo', $id); 
            $this->db->set('status', '3');
            $this->db->where('status' ,'2');
            $this->db->update('artigo');
        }
    }

    /**OUTRAS FUNÇOES
    * Aprova o artigo enviado
    *
    * @param string $id Id do artigo que será excluído
    *  
    * @return boolean
    */

    public function aprovarArtigo($nome){
       if(is_null($nome)){
            return false;
        }
        else{
            $this->db->where('titulo', $nome);
            $this->db->set('status','2');
            $this->db->where('status', '1');
            $this->db->update('artigo');
            return true;            
        }
    }

    /**OUTRAS FUNÇOES
    * Rejeita o artigo enviado
    *
    * @param string $id Id do artigo que será excluído
    *  
    * @return boolean
    */

    public function rejeitarArtigo($nome){
       if(is_null($nome)){
            return false;
        }
        else{
            $this->db->where('titulo', $nome);
            $this->db->set('status','4');
            $this->db->where('status', '1');
            $this->db->update('artigo');
            return true;            
        }
    }

    /**OUTRAS FUNÇOES
    * Rejeita o artigo enviado
    *
    * @param string $id Id do artigo que será excluído
    *  
    * @return boolean
    */
    public function aprovarSugestao($id){

        if(is_null($id)){
            return false;
        }
        else{
            $this->db->where('cod_edit', $id);
            $this->db->set('status_edit','2');
            $this->db->where('status_edit', '1');
            $this->db->update('edicao');
            return true;            
        }

    }

    /**OUTRAS FUNÇOES
    * Rejeita o artigo enviado
    *
    * @param string $id Id do artigo que será excluído
    *  
    * @return boolean
    */
    public function rejeitarSugestao($id){

        if(is_null($id)){
            return false;
        }
        else{
            $this->db->where('cod_edit', $id);
            $this->db->set('status_edit','4');
            $this->db->where('status_edit', '1');
            $this->db->update('edicao');
            return true;            
        }

    }

    /**OUTRAS FUNÇOES
    * Rejeita o artigo enviado
    *
    * @param string $id Id do artigo que será excluído
    *  
    * @return boolean
    */
    public function preparaEdicao($id){

        if(is_null($id)){
            return false;
        }
        else{
            $this->db->where('cod_edit', $id);
            $this->db->where('status_edit', 2);
            $this->db->set('status_edit', 3);
            $this->db->update('edicao');

            return true;           
        }

    }

    /**OUTRAS FUNÇOES
    * Rejeita o artigo enviado
    *
    * @param string $id Id do artigo que será excluído
    *  
    * @return boolean
    */
    public function aprovarEdicao($id, $dados){

        if(is_null($id)){
            return false;
        }
        else{
            $this->db->where('cod_edit', $id);
            $this->db->where('status_edit', 5);
            $this->db->set('status_edit', 3);
            $this->db->set('data_edit', $dados['data_edit']);
            $this->db->update('edicao');

            return true;           
        }

    }
    
    /**OUTRAS FUNÇOES
    * Rejeita o artigo enviado
    *
    * @param string $id Id do artigo que será excluído
    *  
    * @return boolean
    */
    public function rejeitarEdicao($id, $dados){

        if(is_null($id)){
            return false;
        }
        else{
            $this->db->where('cod_edit', $id);
            $this->db->set('status_edit','4');
            $this->db->set('data_edit', $dados['data_edit']);
            $this->db->where('status_edit', '2');
            $this->db->update('edicao');

            return true;           
        }

    }

}