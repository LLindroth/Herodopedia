
<html>
    <head>
        <title>Perfil</title>
        <?php require_once 'templates/head.php'; ?>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <?php require_once 'scripts.php'; ?>
    </head>
    <body>
        <!-- Fixed navbar -->
        <header class="navbar navbar-default navbar-fixed-top">
            <?php require_once 'templates/header.php'; ?>
        </header>
        <!-- *****************************************************************************************************************
         CONTEÚDO
         ***************************************************************************************************************** -->
        <section class="row">
            <section class="mtb container">
                <h1 class="h1-pesquisa">Sua pesquisa:</h1>
                <h2 class="h2-pesquisa">"<?= $pesquisa; ?>"</h2>
                <article class="col-lg-6 col-md-6" id="artigos">
                    <h4>Artigos</h4>
                    <?php if (!isset($artigos)) {
                        echo "<section class='art'>";
                        echo "<h4>Não existem artigos referentes a pesquisa</h4>";
                        echo "</section>";
                    }else{?>
                    <?php foreach($artigos as $artigo): ?>
                    <section class="art">
                        <span><h4><a href="<?php echo base_url();?>index.php/pages/mostra_artigo/<?= $artigo->titulo; ?>">
                        <?=strtoupper(str_replace("_", " ", $artigo->titulo));?></a></h4>
                        <h6>Criado em:  <?= $artigo->data_art ?></h6></span>
                        <p><?=strip_tags(substr($artigo->text_edit, 0, 600));?>...</p>
                        <h5>Tag: 
                        <a href="<?php echo base_url();?>index.php/pages/pesquisarTag/<?=$artigo->descricao_tag;?>/"><?=$artigo->descricao_tag;?></a></h5>
                        <h5>Autor: <a href='<?php echo base_url();?>index.php/pages/perfil/<?= $artigo->usuario;?>'><?= $artigo->usuario; ?></a></h5>
                    </section>
                    <?php endforeach; echo $pagination; } ?>

                </article>

                <aside class="col-lg-5 col-md-5" id="discussoes">
                    <h4>Discussões</h4>
                    <?php if (!isset($discussoes)) {
                        echo "<section class='art'>";
                        echo "<h4>Não existem discussões referentes a pesquisa</h4>";
                        echo "</section>";
                    }else{?>
                    <?php foreach($discussoes as $discussao): ?>
                    <section class="disc">
                        <h4><a href="<?php echo base_url();?>index.php/pages/mostra_discussao/<?= $discussao->titulo_discussao; ?>">
                        <?=strtoupper(str_replace("_", " ", $discussao->titulo_discussao));?></a></h4>
                        <h5> do Artigo <a href="<?php echo base_url();?>index.php/pages/mostra_artigo/<?= $discussao->titulo; ?>">
                        <?=strtoupper(str_replace("_", " ", $discussao->titulo));?></a></h5>
                        <p><?=substr($discussao->texto_discussao, 0, 355);?>...</p>
                        <h5>Tag: <a href="<?php echo base_url();?>index.php/pages/pesquisarTag/<?=$discussao->descricao_tag;?>/"><?=$discussao->descricao_tag;?></a></h5>
                        <h6>Enviado por <a href='<?php echo base_url();?>index.php/pages/perfil/<?= $discussao->usuario;?>'><?= $discussao->usuario; ?></a></h6>
                        <h6>Criado em:  <?= $discussao->data_disc ?></h6>
                        
                    </section>
                    <?php endforeach; } ?>
                </aside>
            </section>  
        </section>
    </body>
</html>
