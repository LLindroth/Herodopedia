<?php 
$_SESSION['titulo_art'] = $artigo['titulo'];

if ($artigo['status'] == 1) {
    if ($_SESSION['cod_tipo'] != 2) {
        exit();
    }
}
?>
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
            <h3 class="art-usuario"><a href='../perfil/<?= $artigo['usuario']; ?>'>Usuário que criou: <?= $artigo['usuario']; ?></a></h3></span>
        </section>
        <section class="artigo_cont">

            <section class="conteudo_art">
                <p><?= $artigo['text_edit']; ?></p>
                <?php
                if ($artigo['status'] != 1) {
                if (isset($_SESSION['usuario'])) {
                    if ($_SESSION['usuario'] == $artigo['usuario']) {
                        $tipoEdicao= 'padrao';
                        echo "<a class='btn btn-info' href='../editar/{$artigo['titulo']}/{$tipoEdicao}'>Editar</a>";
                    }
                    else{
                        $tipoEdicao = 'sugestao';
                        echo "<a class='btn btn-info' href='../editar/{$artigo['titulo']}/{$tipoEdicao}'>Sugerir Edição</a>";
                    }
                }
                }
                ?>
                <h4>Tag: <?= $artigo['descricao_tag']; ?></h4>
                <h4>Editado por último em: <?= $artigo['data_edit']; ?></h4> 
                <?php 
                if ($artigo['status'] != 1) {
                echo "<a class='btn btn-success' href='../verEdicoes/{$artigo['titulo']}'>Ver Histórico de Edições</a>";
                }?>
            </section>
            <?php 
            if ($artigo['status'] != 1) { ?>
            <section class="disc_art">
                <h3>Discussões sobre esse artigo</h3>

                <?php if (!is_null($discussoes)) {
                    foreach($discussoes as $disc): ?>
                    <section class="discussoes">
                        <h4><a href="../mostra_discussao/<?=$disc->titulo_discussao;?>"><?= strtoupper(str_replace("_", " ", $disc->titulo_discussao)); ?></a></h4>
                        <p><?= substr($disc->texto_discussao, 0, 300); ?>...</p>
                    </section>
                <?php endforeach; 
                }
                else{
                    echo "<section class='semdiscussoes'>";
                    echo    "<h4>Não existem discussões para este artigo</h4>";
                    echo "</section>";
                }?>

                <?php
                 if(!isset($_SESSION['id'])){
                    echo "<a class='btn btn-info' href='../login'>Logar-se</a>";
                 }
                 else{
                    $_SESSION['id_artigo'] = $artigo['cod_artigo'];
                    echo "<a class='btn btn-info' href='../novadiscussao'>Criar Discussão</a>";
                 }
                 ?> 
            </section>
            <?php } ?>
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


