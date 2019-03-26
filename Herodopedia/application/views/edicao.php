<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Edição de Artigo</title>
    <?php require_once 'templates/head.php'; ?>
    <?php require_once 'scripts.php' ?>
  </head>

  <body>
    <!-- Fixed navbar -->
    <header class="navbar navbar-default navbar-fixed-top">
        <?php require_once 'templates/header.php'; ?>
    </header>

    <section class="container">
        <form action="../../../artigos/editar/<?=$artigo['titulo'];?>" method="POST">
            <script src="<?php echo base_url();?>ckeditor/ckeditor.js"></script>
            <section class="row container">
                <section class="art-header header-fixed-top">
                    <input type="text" id="inputTitulo" name="titulo" value="<?=strtoupper(str_replace("_", " ",$artigo['titulo']));?>" required autofocus>
                </section>
                <section class="artigo_cont">

                    <section class="conteudo_art">
                        <label for="inputTexto" class="text-label">Conteudo</label>
                        <textarea id="inputTexto" name="conteudo"><?php echo htmlspecialchars($artigo['text_edit']); ?></textarea>
                        <script>
                            CKEDITOR.replace( 'inputTexto' );
                        </script>
                    </section>

                    <label for="inputTag" class="label-tag">Tag</label>
                    <select id="inputTag" class="form-control" name="tag" required>
                      <?php foreach($tags as $tag): ?>
                      <option value="<?= $tag['id_tag'] ?>"><?=$tag['descricao_tag']?></option>
                      <?php endforeach;?>
                    </select>
                    <input id="botao" class="btn btn-lg btn-primary btn-block" type="submit" value="Editar">
                </section>
            </section> <!-- /container -->
        </form>
    </section> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
