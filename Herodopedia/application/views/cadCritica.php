<?php 
if (!isset($_SESSION['id'])) {
  header("location:../index");
} 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Cadastro de Crítica</title>
    <?php require_once 'templates/head.php'; ?>
    <?php require_once 'scripts.php'; ?>
  </head>

  <body>
    <!-- Fixed navbar -->
    <header class="navbar navbar-default navbar-fixed-top">
        <?php require_once 'templates/header.php'; ?>
    </header>

    <section class="container">
      <form class="critica-form" action="../../criticas/inserir" method="POST">
        <h2 class="critica-heading">Denuncia de usuario: <?=$usuario['nome']?></h2>
        <script src="../../../ckeditor/ckeditor.js"></script>
        <input type="hidden" name="denunciado" value="<?=$usuario['id_usuario']?>">
        <label for="inputMotivo" class="label-crit">Motivo</label>
        <input type="text" id="inputMotivo" class="form-control" placeholder="Motivo" name="motivo" maxlength="80" required autofocus>
        <label for="inputTexto" class="label-crit">Texto</label>
        <textarea id="texto" name="texto" maxlength="1000"></textarea>
        <script>
            CKEDITOR.replace( 'texto' );
        </script>
        <input id="botao" class="btn btn-lg btn-primary btn-block" type="submit">
      </form>

    </section> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
