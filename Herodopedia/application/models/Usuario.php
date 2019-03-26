<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Model{
        
        /*
         * Método Construtor
         */
        function __construct() {
            parent::__construct();
        }

	/**
  	* Insere um registro na tabela
  	*
  	* @param array $dados Dados a serem inseridos
  	*
  	* @return boolean
  	*/
        
        public function registrarUsuario($dados = NULL){
            if ($dados != NULL) {
		$this->db->insert('usuario', $dados);
            }
	}
        
        
	/**
  	* Verifica login de usuário
  	*
  	* @param string $dados Dados para o login
  	*
  	* @return array
  	*/

  	public function efetuaLogin($dados){
            if (is_null($dados)) {
                return false;
            }
            else{
                $this->db->where('email', $dados['email']);
                $this->db->where('senha', $dados['senha']);
                $query = $this->db->get('usuario');
                if ($query->num_rows() > 0) {
                    return $query->row_array();
                }
                else {
                    return null;
                }
            }
  	}

	/**
  	* Lista todos os registros da tabela
  	*
  	* @param string $ordenar Campo para ordenação dos registros
  	*
  	* @param string $ordem Tipo de ordenação: ASC ou DESC
  	*
  	* @return array
  	*/

	public function todosUsuarios($ordenar = 'id_usuario', $ordem = 'asc'){
	    
            $query = $this->db->select('id_usuario, nome, sobrenome, email, dt_nasc, usuario, desc_tipo, usuario.cod_tipo')  
	         ->from('usuario, tipo_user')
            ->where('usuario.cod_tipo = tipo_user.cod_tipo')
            ->order_by($ordenar, $ordem)
            ->get();
                    
	    if ($query->num_rows() > 0) {
	    	return $query->result();
	    } else {
	    	return null;
	    }
	}

  public function todosAdmins(){
      
      $query = $this->db->select('id_usuario')  
      ->from('usuario')
      ->where('cod_tipo', 2)
      ->get();
                    
      if ($query->num_rows() > 0) {
        return $query->result();
      } else {
        return null;
      }
  }

	/**
  	* Busca um registro a partir de um ID
  	*
  	* @param integer $id ID do registro a ser recuperado
  	*
  	* @return array
  	*/
	public function procurarUsuario($usuario) {
	    if(is_null($usuario)){
	    	return false;
	    }
	    else{
	    	$this->db->where('usuario', $usuario);
        $this->db->where('usuario.cod_tipo = tipo_user.cod_tipo');
	    	$query = $this->db->get('usuario, tipo_user');

	    	if ($query->num_rows() > 0) {
	        	return $query->row_array();
	      	}
	      	else {
	        	return null;
	    	}
	    }
	}
  /**
    * Busca um registro a partir de um ID
    *
    * @param integer $id ID do registro a ser recuperado
    *
    * @return array
    */
  public function pegarNome($id) {
      if(is_null($id)){
        return false;
      }
      else{
        $this->db->select('usuario');
        $this->db->where('id_usuario', $id);
        $query = $this->db->get('usuario');

        if ($query->num_rows() > 0) {
            return $query->row_array();
          }
          else {
            return null;
        }
      }
  }
        
        /**
  	* Bane usuário
  	*
  	* @param integer $id ID do usuário a ser banido
  	*
  	* @return boolean
  	*/
        public function banirUsuario($id){
            if(is_null($id)){
	    	return false;
	    }
	    else{
                $this->db->where('id_usuario', $id);
                $this->db->set('cod_tipo','3');
                $this->db->where('cod_tipo', '1');
                $this->db->update('usuario');	    	
            }
        }
        
        /**
  	* Desbane usuário
  	*
  	* @param integer $id ID do usuário a ser desbanido
  	*
  	* @return boolean
  	*/
        
        public function desbanirUsuario($id){
            if(is_null($id)){
	    	return false;
	    }
	    else{
                $this->db->where('id_usuario', $id);
                $this->db->set('cod_tipo','1');
                $this->db->where('cod_tipo', '3');
                $this->db->update('usuario');	    	
            }
        }
        
       /**
        * Atualiza um registro na tabela
        *
        * @param integer $int ID do registro a ser atualizado
        *
        * @param array $data Dados a serem inseridos
        *
        * @return boolean
        */
        public static function Atualizar($id, $data) {
            if(is_null($id) || !isset($data)){
                return false;
            }
            else{
                $this->db->where('id', $id);
                return $this->db->update($this->table, $data);
            }
        }

        public function verificaDtNasc($dt_nasc){
          $erro = "";

          if ($dt_nasc <= date('Y-m-d') && $dt_nasc > '1900-01-01'){
            return $erro;
          } else {
            $erro = "\nA data de nascimento é inválida";
            return $erro;
          }
        }

        public function verificaEmail($email){
          $erro = "";

          if (filter_var($email, FILTER_VALIDATE_EMAIL)){
            $query = $this->db->select('email')
            ->from('usuario')
            ->where('email', $email)
            ->get();

            if ($query->num_rows() > 0) {
              $erro = "\nEsse email já está cadastrado";
              return $erro;
            } else {
              return $erro;
            }
          } else {
            $erro = "\nEsse email é invalido";
          }
        }

        public function verificaUsuario($usuario){
          $erro = "";

          $query = $this->db->select('usuario')
          ->from('usuario')
          ->where('usuario', $usuario)
          ->get();

          if ($query->num_rows() > 0) {
            $erro = "\nEsse usuário já está cadastrado";
            return $erro;
          } else {
            return $erro;
          }
        }

        public function verificaSenha($senha) {

          $erro = "";
          for ($i=0; $i < strlen($senha); $i++) { 
            if (strlen($senha) >= 8) {
              $a = 1;
            } 
            if (is_numeric($senha[$i]) == true) {
              $b = 2;
            } elseif (ctype_alnum($senha[$i]) == true){
              $c = 4;
            } else {
              $d = 8;
            }
          }
          $e = $a + $b + $c + $d;

          switch ($e) {

            case 14:
                $erro = "Senha curta";
                break;
            case 13:
                $erro = "Não possui numero";
                break;
            case 12:
                $erro = "Senha curta\nNão possui numero";
                break;
            case 11:
                $erro = "Não possui letra";
                break;
            case 10:
                $erro = "Não possui letra\nSenha curta";
                break;
            case 9:
                $erro = "Não possui letra\nNão possui numero";
                break;
            case 8:
                $erro = "Não possui letra\nNão possui numero\nSenha curta";
                break;
            case 7:
                $erro = "Não possui caracter especial";
                break;
            case 6:
                $erro = "Não possui caracter especial\nSenha curta";
                break;
            case 5:
                $erro = "Não possui caracter especial\nNão possui numero";
                break;
            case 4:
                $erro = "Não possui caracter especial\nNão possui numero\nSenha curta";
                break;
            case 3:
                $erro = "Não possui caracter especial\nNão possui letra";
                break;
            case 2:
                $erro = "Não possui caracter especial\nNão possui letra\nSenha curta";
                break;
            case 1:
                $erro = "Não possui caracter especial\nNão possui letra\nNão possui numero";
                break;
            case 0:
                $erro = "Não possui caracter especial\nNão possui letra\nNão possui numero\nSenha curta";
                break;
          }
          return $erro;
        }
}