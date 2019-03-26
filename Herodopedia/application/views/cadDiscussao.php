<?php
if (!isset($_SESSION['titulo_art'])) {
  echo"<script>alert('Proibido a entrada sem um artigo vinculado');</script>";
  header('location:index');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Cadastro de Discussão</title>
    <?php require_once 'templates/head.php';?>
    <?php require_once 'scripts.php'; ?>
  </head>

  <body>

    <!-- Fixed navbar -->
    <header class="navbar navbar-default navbar-fixed-top">
        <?php require_once 'templates/header.php'; ?>
    </header>
    
    <form action="../discussoes/inserir" method="POST">
    <script src="../../ckeditor/ckeditor.js"></script>
    <section class="row container">
        <section class="disc-header header-fixed-top">
            <section class="art-name"><h2><a href="mostra_artigo/<?= $_SESSION['titulo_art']?>">
                <?= strtoupper(str_replace("_", " ", $_SESSION['titulo_art'])); ?></a></h2></section>
            <section class="disc-name"><input type="text" id="inputTitulo" class="form-control" placeholder="Titulo" name="titulo" maxlength="80" required autofocus>
            </section>
        </section>
        <section class="disc_cont">     
            <section class="conteudo_disc">
                <label for="inputTexto" class="form-label">Conteudo</label>
                <textarea style="min-width: 500px;" id="texto" name="conteudo" maxlength="2000"></textarea>
                <script>
                    CKEDITOR.replace( 'texto' );
                </script>    
            </section>

            <label for="inputTag" class="label-tag">Tag</label>
            <select id="inputTag" class="form-control" name="tag" required>
              <?php foreach($tags as $tag): ?>
              <option value="<?= $tag['id_tag'] ?>"><?=$tag['descricao_tag']?></option>
              <?php endforeach;?>
            </select>
            <input id="botao" class="btn btn-lg btn-primary btn-block" type="submit">
        </section>
    </section> <!-- /container -->
    </form>


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>