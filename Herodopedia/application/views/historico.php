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
            <span><h2 class="art-titulo"><?= strtoupper(str_replace("_", " ", $artigo['titulo'])); ?> - HISTÓRICO DE EDIÇÕES</h2>
            <h3 class="art-usuario"><a href='../perfil/<?= $artigo['usuario']; ?>'>Usuário: <?= $artigo['usuario']; ?></a></h3></span>
        </section>
        <section class="row">
            <section class="historico">
                <table class="table table-hover table-inverse">
                    <thead class="thead-default table-head">
                        <th>Código</th>
                        <th>Usuário</th>
                        <th>Data</th> 
                    </thead>
                    <tbody>
                        <?php foreach($edicoes as $edicao) : ?>
                        <tr>
                            <td><a href="../mostra_edicao/<?= $edicao->cod_edit; ?>">
                            <?= $edicao->cod_edit;?></a></td>
                            <td><?=$edicao->usuario;?></td>
                            <td><?=$edicao->data_edit;?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </section>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php require_once 'scripts.php'; ?>
    
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>


