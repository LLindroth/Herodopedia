<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Registro</title>
    <?php require_once 'templates/head.php'; ?>
    <?php require_once 'scripts.php'; ?>
    <script type="text/javascript" src = "<?php echo base_url(); ?>assets/js/erroRegistro.js"></script>
    <script type="text/javascript" src = "<?php echo base_url(); ?>assets/js/dadosInput.js"></script>
  </head>

  <body>

    <?php

      if (isset($_SESSION['erro'])) {
        echo "<section class='error-box-r'>";
        echo "<h2>Erro</h2>";
        $erros = explode("\n", $_SESSION['erro']);
        foreach ($erros as $erro) {
          echo "<h6>".$erro."</h6>";
        }
        echo "<button class='error-button'>Fechar</buttons>";
        echo "</section>";
      }

      unset($_SESSION['erro']);

      if (isset($_SESSION['nome'])) {
        $nome = $_SESSION['nome'];
        $sobrenome = $_SESSION['sobrenome'];
        $email = $_SESSION['email'];
        $usuario = $_SESSION['usuario'];

        unset($_SESSION['nome']);
        unset($_SESSION['sobrenome']);
        unset($_SESSION['email']);
        unset($_SESSION['usuario']);
      }

    ?>

    <section class="container">

      <form class="form-register" action="../registro/inserir" method="POST">
        <h2 class="form-register-heading">Cadastre-se</h2>
        <label for="inputNome">Nome</label>
        <input type="text" id="inputNome" class="form-control" placeholder="Nome" name="nome" value="<?php echo $nome; ?>" required autofocus>
        <label for="inputSobrenome">Sobrenome</label>
        <input type="text" id="inputSobrenome" class="form-control" placeholder="Sobrenome" name="sobrenome" value="<?php echo $sobrenome; ?>" required autofocus>
        <label for="inputDtNasc">Data de Nascimento</label>
        <input type="date" id="inputDtNasc" class="form-control" name="dt_nasc" required autofocus>
        <label for="inputEmail">Email</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>" required autofocus>
        <label for="inputUsuario">Usuário</label>
        <input type="text" id="inputUsuario" class="form-control" placeholder="Nome de Usuário" name="usuario" value="<?php echo $usuario; ?>" required autofocus>
        <label for="inputPassword">Senha</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="senha" required>
        <section class="dadosInput">
          <h4>Sua senha precisa conter:</h1>
          <ul>
            <li>8 caracteres</li>
            <li>pelo menos 1 letra</li>
            <li>pelo menos 1 numero</li>
            <li>pelo menos 1 caracter especial</li>
          </ul>
        </section>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Cadastrar</button>
        <a href="<?php echo base_url();?>index.php/pages/index"><span class="glyphicon glyphicon-home"></a>
      </form>

    </section> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
