<?php
$_SESSION['id_discussao'] = $discussao['cod_discussao'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?= strtoupper(str_replace("_", " ", $discussao['titulo_discussao'])); ?></title>
    <?php require_once 'templates/head.php'; ?>
    <?php require_once 'scripts.php'; ?>
  </head>

  <body>
    <!-- Fixed navbar -->
    <header class="navbar navbar-default navbar-fixed-top">
        <?php require_once 'templates/header.php'; ?>
    </header>

    <section class="row container">
        <section class="disc-header header-fixed-top">
            <section class="art-name"><h2><a href="../mostra_artigo/<?= $discussao['titulo']?>">
                <?= strtoupper(str_replace("_", " ", $discussao['titulo'])); ?></a></h2></section>
            <section class="disc-name"><h2><?= strtoupper(str_replace("_", " ", $discussao['titulo_discussao'])); ?></h2>
            <h3>Autor: <a href='../perfil/<?= $discussao['usuario']; ?>'><?= $discussao['usuario']; ?></a></h3></section>
        </section>
        <section class="disc_cont">     
            <section class="conteudo_disc">
                <p><?= $discussao['texto_discussao']; ?></p>
                <h4 class="titulo">Tag: <?= $discussao['descricao_tag']; ?></h4>
                <br>
                <h4 class="titulo"><?= $discussao['data_disc']; ?></h4>    
            </section>
        </section>
    </section> <!-- /container -->
    
    <section class="com-disc">
        <h3 class="titulo">Comentários para esta Discussão:</h3>
        <?php 
        if (!is_null($comentarios)) {
            foreach($comentarios as $comentario): ?>
            <section class="comentario">
                <h4><a href="../perfil/<?= $comentario->usuario;?>"><?= $comentario->usuario; ?></a> comentou:</h4>
                <p><?= $comentario->texto_comentario;?></p>
                <h6 ><?= $comentario->data_com;?></h6>
                <?php 
                    if (isset($_SESSION['usuario'])) {
                        if ($_SESSION['usuario'] == $comentario->usuario) {
                            echo "<a class='btn btn-info' href='../../Comentarios/excluir/$comentario->cod_comentario'>Deletar</a>";
                        }
                    }    
                ?>
                
            </section>
            <?php endforeach; 
        }else{
            echo "<section class='comentario'>";
            echo "<h4>Sem comentários</h4> <p>Seja o primeiro a comentar!!</p>";
            echo "</section";
        }?>
    </section>
    
    <?php
    if(isset($_SESSION['usuario'])){
        echo "<section class='form-group'>";
        echo "<form class='form-comment' action='../../comentarios/inserir' method='POST'>";
        echo "<label for='comment'>Deixe seu comentário:</label>";
        echo "<textarea class='form-control' rows='5' id='comment' name='comentario'></textarea>";
        echo "<button class='btn btn-lg btn-primary btn-block' type='submit'>Comentar</button>";
        echo "</form>";
        echo "</section>";
    } else {
        echo "<a class='btn btn-info' href='../login'>Logar-se</a>";
    }?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php require_once 'scripts.php'; ?>
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>


