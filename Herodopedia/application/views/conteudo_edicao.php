<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?= strtoupper(str_replace("_", " ", $artigo['titulo'])); ?></title>
    <?php require_once 'templates/head.php'; ?>
    <?php require_once 'scripts.php'; ?>
  </head>

  <body>
    <!-- Fixed navbar -->
    <header class="navbar navbar-default navbar-fixed-top">
        <?php require_once 'templates/header.php'; ?>
    </header>

    <section class="row container">
        <section class="art-header header-fixed-top">
            <span><h2 class="art-titulo"><?= strtoupper(str_replace("_", " ", $artigo['titulo'])); ?></h2>
            <h3 class="art-usuario"><a href='../perfil/<?= $artigo['usuario']; ?>'>Usuário que sugeriu: <?= $artigo['usuario']; ?></a></h3></span>
        </section>
        
        <section class="artigo_cont">
            <section class="conteudo_art">
                <p><?= $artigo['text_edit']; ?></p>
                <h4>Data da Sugestão: <?= $artigo['data_edit'];?></h4> 
            </section>
        </section>
    </section> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php require_once 'scripts.php'; ?>
    
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>


