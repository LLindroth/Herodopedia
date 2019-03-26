<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* CLASSE PARA NAVEGAÇÃO */
class Pages extends CI_Controller {

    /* Carrega index.php com os dados buscados
    *   model('artigo')
    *   model('discussao')
    *   model('notificacao')
    *   model('tag')
    */

    public function index(){

        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/pages/index');
        $config['total_rows'] = count($this->artigo->listaArtigos(1000, 0));
        $config['per_page'] = 3;

        $qtd = $config['per_page'];

        ($this->uri->segment(3) != '') ? $inicio = $this->uri->segment(3) : $inicio = 0;

        $this->pagination->initialize($config);
        
        $dados['notificacao'] = $this->notificacao->recebeNotificacoes();
        $dados['qtd_nots'] = $this->notificacao->contaNots();
        $dados['artigos'] = $this->artigo->listaArtigos($qtd, $inicio);     
        $dados['discussoes'] = $this->discussao->listaDiscussoes(3);
        $dados['tags'] = $this->tag->buscaTags();
        $dados['pagination'] = $this->pagination->create_links();
        
        $this->load->view('index', $dados);
           
    }

    /* Carrega login.php */
    public function login()
    {
        $this->load->view('login');
    }


    /* Carrega register.php */
    public function register()
    {
        $this->load->view('register');
    }


    /* Carrega cadArtigo.php com os dados do banco*/

    public function novoartigo()
    {
        $this->load->model('notificacao');
        $this->load->model('tag');
        
        $dados['notificacao'] = $this->notificacao->recebeNotificacoes();
        $dados['qtd_nots'] = $this->notificacao->contaNots();
        $dados['tags'] = $this->tag->buscaTags();

        
        $this->load->view('cadArtigo', $dados);
    }


    /* Carrega cadDiscussao.php com os dados do banco */

     public function novadiscussao()
    {
        $this->load->model('notificacao');
        $this->load->model('tag');
      
        $dados['notificacao'] = $this->notificacao->recebeNotificacoes();
        $dados['qtd_nots'] = $this->notificacao->contaNots();
        $dados['tags'] = $this->tag->buscaTags();
         
        $this->load->view('cadDiscussao', $dados);
    }


    /* Carrega cadCritica.php com os dados do banco */

    public function denuncia($usuario){
        $this->load->model('notificacao');
        
        $dados['notificacao'] = $this->notificacao->recebeNotificacoes();
        $dados['qtd_nots'] = $this->notificacao->contaNots();
        $dados['usuario'] = $this->usuario->procurarUsuario($usuario);
        
        $this->load->view('cadCritica', $dados);
    }

    
    /* Carrega perfil.php com os dados do banco */

    public function perfil($usuario)
    {
        $this->load->model('usuario');
        $this->load->model('notificacao');
        $this->load->model('artigo');
        $this->load->model('critica');
        $this->load->model('artigo');
        $this->load->model('discussao');

        $i = 0;
        
        $dados['notificacao'] = $this->notificacao->recebeNotificacoes();
        $dados['qtd_nots'] = $this->notificacao->contaNots();
        $dados['usuario'] = $this->usuario->procurarUsuario($usuario);
        $dados['sugestoes'] = $this->artigo->listarSugestoesUsuario($usuario);
        //$dados['criticas'] = $this->critica->listarCriticasUsuario($usuario);
        //$dados['artigos'] = $this->artigo->listarArtigosUsuario($usuario);
        //$dados['discussoes'] = $this->discussao->listarDiscussoesUsuario($usuario);

        foreach ($dados['sugestoes'] as $sugestoes) {
            $dados['edi_usuario'][$i] = $this->usuario->pegarNome($sugestoes['edi_id_usuario']);
            $i++;
        }

        $this->load->view('perfil', $dados);
    }
    
    
    /* Carrega conteudo.php com os dados do banco */

    public function mostra_artigo($nome){
        
        $this->load->model('artigo');
        $this->load->model('discussao');
        $this->load->model('notificacao');
        
        $dados['notificacao'] = $this->notificacao->recebeNotificacoes();
        $dados['qtd_nots'] = $this->notificacao->contaNots();
        $dados['artigo'] = $this->artigo->artigoSelecionado($nome);
        $dados['discussoes'] = $this->discussao->discussoesArtigo($dados['artigo']['cod_artigo']);

        $this->load->view('conteudo', $dados);
    }

    public function mostra_edicao($id){

        $this->load->model('artigo');
        $this->load->model('notificacao');

        $dados['notificacao'] = $this->notificacao->recebeNotificacoes();
        $dados['artigo'] = $this->artigo->edicaoSelecionada($id);
        $dados['qtd_nots'] = $this->notificacao->contaNots();

        $this->load->view('conteudo_edicao', $dados);    }


    /* Carrega discussao.php com os dados do banco */ 
     
    public function mostra_discussao($nome){
        
        $this->load->model('discussao');
        $this->load->model('comentario'); 
        $this->load->model('notificacao');
        
        $dados['notificacao'] = $this->notificacao->recebeNotificacoes();
        $dados['qtd_nots'] = $this->notificacao->contaNots();
        $dados['discussao'] = $this->discussao->discussaoSelecionada($nome);
        $dados['comentarios'] = $this->comentario->comentariosDiscussao($dados['discussao']['cod_discussao']);

        $this->load->view('discussao', $dados);
    }

    /* Carrega edicao.php/sugestao.php com os dados do banco 
        $this->load->model('artigo');
        $this->load->model('notificacao');
        $this->load->model('tag');
    */

    public function editar($nome, $tipo){

        $dados['notificacao'] = $this->notificacao->recebeNotificacoes();
        $dados['qtd_nots'] = $this->notificacao->contaNots();
        $dados['artigo'] = $this->artigo->artigoSelecionado($nome);
        $dados['tags'] = $this->tag->buscaTags();

        if ($tipo == 'padrao')
            $this->load->view('edicao', $dados);
        else 
            $this->load->view('sugestao' , $dados);
    }


    /* Carrega pesquisa.php com os dados do banco */

    public function pesquisa(){
        $this->load->model('artigo');
        $this->load->model('discussao');

        $pesquisado = $this->input->post('pesquisa');

        if (empty($pesquisado) || is_null($pesquisado)) {
            header('location:index');
        }
        else{

            $dados['artigos'] = $this->artigo->pesquisaArtigos($pesquisado);
            $dados['discussoes'] = $this->discussao->pesquisaDiscussoes($pesquisado);
            $dados['pesquisa'] = $pesquisado;

            $this->load->view('pesquisa', $dados);
        }
    }

    /* Carrega pesquisa.php com os dados do banco */

    public function pesquisarTag($tag = NULL){
        $this->load->model('artigo');
        $this->load->model('discussao');

        if (is_null($tag)) {
            $tag = $this->input->post('pesquisaTag');
        }

        $dados['artigos'] = $this->artigo->pesquisarArtigosTag($tag);
        $dados['discussoes'] = $this->discussao->pesquisarDiscussoesTag($tag);
        $dados['pesquisa'] = $tag;

        $this->load->view('pesquisa', $dados);
        
    }


    /* Carrega historico.php com os dados do banco */

    public function verEdicoes($titulo){
        $this->load->model('artigo');
        $this->load->model('notificacao');
        
            $dados['notificacao'] = $this->notificacao->recebeNotificacoes();
            $dados['qtd_nots'] = $this->notificacao->contaNots();
            $dados['edicoes'] = $this->artigo->pesquisarEdicoes($titulo);
            $dados['artigo'] = $this->artigo->artigoSelecionado($titulo);

            $this->load->view('historico', $dados);
        
    }

    /*ADMIN
    /* Carrega aprovacao.php com os dados do banco */ 

    public function aprovacao(){
        
        $this->load->model('artigo');
        $this->load->model('notificacao');
        
        $dados['notificacao'] = $this->notificacao->recebeNotificacoes();
        $dados['qtd_nots'] = $this->notificacao->contaNots();
        $dados['artigos'] = $this->artigo->artigosEspera();
        $dados['edicoes'] = $this->artigo->edicoesEspera();

        $this->load->view('admin/aprovacao.php', $dados);
        
    }


    /* Carrega criticas.php com os dados do banco*/

    public function criticas(){
       
        $this->load->model('critica');
        $this->load->model('notificacao');

        $i = 0;
        
        $dados['notificacao'] = $this->notificacao->recebeNotificacoes();
        $dados['qtd_nots'] = $this->notificacao->contaNots();
        $dados['criticas'] = $this->critica->todasCriticas();
        foreach ($dados['criticas'] as $criticas) {
            $dados['criticado'][$i] = $this->usuario->pegarNome($criticas['usuario_criticado']);
            $i++;
        }
        
        $this->load->view('admin/criticas', $dados);
    }


    
    /* Carrega gerenciamento_a.php com os dados do banco */

    public function gerenciar(){
                
        $this->load->model('artigo');
        $this->load->model('discussao');
        $this->load->model('notificacao');
        
        $dados['notificacao'] = $this->notificacao->recebeNotificacoes();
        $dados['qtd_nots'] = $this->notificacao->contaNots();
        $dados['artigos'] = $this->artigo->listarArtigos();
        $dados['discussoes'] = $this->discussao->listarDiscussoes();
        
        $this->load->view('admin/gerenciamento.php', $dados);
        
    }
    
    /* Carrega users_a.php com os dados do banco */

    public function usuarios(){
        $this->load->model('usuario');
        $this->load->model('notificacao');
        
        $dados['notificacao'] = $this->notificacao->recebeNotificacoes();
        $dados['qtd_nots'] = $this->notificacao->contaNots();
        $dados['usuarios'] = $this->usuario->todosUsuarios();

        $this->load->view('admin/users', $dados);

    }
}

