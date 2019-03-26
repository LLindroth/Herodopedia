<!DOCTYPE html>
<?php
if($_SESSION['cod_tipo'] != 2){
    exit();
}
?>
<html>
    <head>
        <title>Gerenciamento</title>
        <?php require_once 'templates/head.php'; ?>
        <?php require_once 'scripts.php'; ?>
    </head>
    <body>
        <!-- Fixed navbar -->
        <header class="navbar navbar-default navbar-fixed-top">
            <?php require_once 'templates/header.php'; ?>
        </header>

        <section class="row">
            <section class="tabela-art">
                <table class="table table-hover table-inverse">
                    <caption>Artigos</caption>
                    <thead class="thead-default table-head">
                        <th>Código do Artigo</th>
                        <th>Título do Artigo</th>
                        <th>Data de envio do Artigo</th>
                        <th>Usuário que enviou</th>
                        <th>Tag</th>
                        <th>Status</th>
                        <th>Ação</th>
                        
                    </thead>
                    <tbody>
                        <?php foreach($artigos as $artigo) : ?>
                        <tr>
                            <td><?=$artigo->cod_artigo;?></td>
                            <td><?= strtoupper(str_replace("_", " ", $artigo->titulo)); ?></td>
                            <td><?=$artigo->data_art;?></td>
                            <td><?=$artigo->usuario;?></td>
                            <td><?=$artigo->descricao_tag;?></td>
                            <td><?=$artigo->descricao_status;?></td>
                            
                            <?php if ($artigo->status == 2) {
                                echo "<td><a style='color:red;' class='' href='".base_url()."index.php/artigos/excluir/$artigo->cod_artigo'>Excluir</a></td>";
                            } else {
                                echo "<td><a style='color:blue;' class='' href='".base_url()."index.php/artigos/reativar/$artigo->cod_artigo'>Reativar</a></td>";
                            } ?>
                            
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </section>
        </section>
        <section class="row">
            <section class="tabela-art">
                <table class="table table-hover table-inverse">
                    <caption>Discussões</caption>
                    <thead class="thead-default table-head">
                        <th>Código da Discussão</th>
                        <th>Título da Discussão</th>
                        <th>Data da Discussão</th>
                        <th>Usuário que enviou</th>
                        <th>Tag</th>
                        <th>Status</th>
                        <th>Ação</th>
                        
                    </thead>
                    <tbody>
                        <?php foreach($discussoes as $discussao) : ?>
                        <tr>
                            <td><?=$discussao->cod_discussao;?></td>
                            <td><?= strtoupper(str_replace("_", " ", $discussao->titulo_discussao)); ?></td>
                            <td><?=$discussao->data_disc;?></td>
                            <td><?=$discussao->usuario;?></td>
                            <td><?=$discussao->descricao_tag;?></td>
                            <td><?=$discussao->descricao_status_disc;?></td>
                            
                            <?php if ($discussao->status_disc == 0) {
                                echo "<td><a style='color:red;' class='' href='".base_url()."index.php/discussoes/excluir/$discussao->cod_discussao'>Excluir</a></td>";
                            } else {
                                echo "<td><a style='color:blue;' class='' href='".base_url()."index.php/discussoes/reativar/$discussao->cod_discussao'>Reativar</a></td>";
                            } ?>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </section>
        </section>
        
         <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        
    </body>
</html>