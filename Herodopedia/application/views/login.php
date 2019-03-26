
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login</title>
    <?php require_once 'templates/head.php'; ?>
    <?php require_once 'scripts.php'; ?>
    <script type="text/javascript" src = "<?php echo base_url(); ?>assets/js/erroLogin.js"></script>
  </head>

  <body>

    <?php

      if (isset($_SESSION['erro'])) {
        echo "<section class='error-box'>";
        echo "<h2>Erro</h2>";
        $erros = explode("\n", $_SESSION['erro']);
        foreach ($erros as $erro) {
          echo "<h6>".$erro."</h6>";
        }
        echo "<button class='error-button'>Fechar</buttons>";
        echo "</section>";
      }

      unset($_SESSION['erro']);

    ?>

    <section class="container">
      <p><?php $msg ?></p>

      <form class="form-signin" action="../registro/logar" method="POST">
        <h2 class="form-signin-heading">Efetuar Login</h2>
        <label for="inputEmail" class="form-label">Email</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Ex: exemplo@outlook.com" name="email" required autofocus>
        <label for="inputSenha" class="form-label">Senha</label>
        <input type="password" id="inputSenha" class="form-control" placeholder="Ex: 12345" name="senha" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Logar</button>
        <a href="<?php echo base_url();?>index.php/pages/index"><span class="glyphicon glyphicon-home"></a>
      </form>

    </section> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
