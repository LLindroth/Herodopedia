<html>
    <head>
        <title>Aprovações</title>
        <?php require_once 'templates/head.php'; ?>
        <?php require_once 'scripts.php'; ?>
    </head>
    <body>
        <!-- Fixed navbar -->
        <header class="navbar navbar-default navbar-fixed-top">
            <?php require_once 'templates/header.php'; ?>
        </header>
        <section class="row">
            <section class="aprovacao">
                <table class="table table-hover table-inverse">
                    <caption>Aprovacao de Artigos</caption>
                    <thead class="thead-default table-head">
                        <th>Código</th>
                        <th>Título do Artigo</th>
                        <th>Conteudo</th>
                        <th>Status</th>
                        <th>Ação</th>    
                    </thead>
                    <tbody>
                        <?php 
                        if (!is_null($artigos)) {
                        foreach($artigos as $artigo) : ?>
                        <tr>
                            <td><?=$artigo->cod_artigo;?></td>
                            <td><a href="mostra_artigo/<?= $artigo->titulo; ?>">
                            <?= strtoupper(str_replace("_", " ", $artigo->titulo));?></a></td>
                            <td><?=strip_tags(substr($artigo->conteudo, 0, 200));?></td>
                            <td><?=$artigo->descricao_status;?></td>
                            <td class="acoes">
                            <a class='btn btn-danger' href='../artigos/rejeitar/<?=$artigo->titulo;?>'>Rejeitar</a>
                            <a class='btn btn-success' href='../artigos/aprovar/<?=$artigo->titulo;?>'>Aprovar</a>
                            </td>
                        </tr>
                        <?php endforeach; }
                        else { ?>
                        <tr class="art-null">
                            <td colspan="5">Não existem artigos para serem aprovados</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </section>
        </section>

        <section class="row">
            <section class="aprovacao">
                <table class="table table-hover table-inverse">
                    <caption>Aprovacao de Edições</caption>
                    <thead class="thead-default table-head">
                        <th>Código da Edição</th>
                        <th>Título do Artigo</th>
                        <th>Conteúdo do Artigo Original</th>
                        <th>Status da Edição</th>
                        <th>Ação</th>    
                    </thead>
                    <tbody>
                        <?php 
                        if (!is_null($edicoes)) {
                        foreach($edicoes as $edicao) : ?>
                        <tr>
                            <td><?=$edicao->cod_edit;?></td>
                            <td><a href="mostra_edicao/<?= $edicao->cod_edit; ?>">
                            <?= strtoupper(str_replace("_", " ", $edicao->titulo));?></a></td>
                            <td><?=strip_tags(substr($edicao->conteudo, 0, 200));?></td>
                            <td><?=$edicao->descricao_status_edicao;?></td>
                            <td class="acoes">
                            <a class='btn btn-danger' href='../artigos/rejeitarEdicao/<?=$edicao->cod_edit;?>'>Rejeitar</a>
                            <a class='btn btn-success' href='../artigos/aprovarEdicao/<?=$edicao->cod_edit;?>'>Aprovar</a>
                            </td>
                        </tr>
                        <?php endforeach; }
                        else { ?>
                        <tr class="art-null">
                            <td colspan="5">Não existem artigos para serem aprovados</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </section>
        </section>

         <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        
    </body>
</html>
