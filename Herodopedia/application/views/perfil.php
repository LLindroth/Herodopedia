<?php $i = 0; ?>
<html>
    <head>
        <title>Perfil</title>
        <?php require_once 'templates/head.php'; ?>
        <?php require_once 'scripts.php'; ?>
    </head>
    <body>
        <!-- Fixed navbar -->
        <header class="navbar navbar-default navbar-fixed-top">
            <?php require_once 'templates/header.php'; ?>
        </header>
        <!-- INFORMACOES USUARIO -->
        <section class="row">
            <section class="mtb container perfil">
                <h2>Perfil de <?=$usuario['nome'];?> <?=$usuario['sobrenome'];?></h2>
                <ul class="list-group">
                    <li class="list-group-item">Nome: <?=$usuario['nome'];?></li>
                    <li class="list-group-item">Sobrenome: <?=$usuario['sobrenome'];?></li>
                    <li class="list-group-item">Email: <?=$usuario['email'];?></li>
                    <li class="list-group-item">Usuario: <?=$usuario['usuario'];?></li>
                    <li class="list-group-item">Data de Nascimento: <?=$usuario['dt_nasc'];?></li>
                    <li class="list-group-item">Tipo: <?=$usuario['desc_tipo'];?></li>
                </ul>
                <?php 
                if (isset($_SESSION['id'])) {
                if ($_SESSION['id'] != $usuario['id_usuario']) {?>
                <h3><a href="../denuncia/<?=$usuario['usuario'];?>">Denunciar usuário</a></h3>
                <?php } } ?>
            </section>
        </section>
        
        <!-- SUGESTOES EM ARTIGOS -->
        <?php
        if (isset($_SESSION['id'])) {
        if ($_SESSION['id'] == $usuario['id_usuario']) {
        if (!is_null($sugestoes)) {?>
        <section class="col-md-8 col-md-offset-2 sugestao">
            <table class="table table-hover">
              <caption>Sugestões sobre seus artigos</caption>
              <thead class="thead-light">
                <tr>
                  <th scope="col">Artigo</th>
                  <th scope="col">Conteúdo</th>
                  <th scope="col">Usuario</th>
                  <th scope="col">Data</th>
                  <th scope="col">Ação</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($sugestoes as $sugestao): ?>
                <tr>
                  <td><a href="../mostra_edicao/<?=$sugestao['cod_edit']?>"><?= strtoupper(str_replace("_", " ", $sugestao['titulo'])); ?></a></td>
                  <td><?= substr($sugestao['text_edit'], 0, 200); ?></td>
                  <td><a href="<?=$edi_usuario[$i]['usuario']; ?>"><?= $edi_usuario[$i]['usuario']; ?></h3></a></td>
                  <td><?=$sugestao['data_edit']?></td>
                  <td>
                    <a class='btn btn-danger' href="../../artigos/rejeitarSugestao/<?=$sugestao['cod_edit'];?>/<?=$_SESSION['usuario'];?>">Rejeitar Sugestão</a>
                    <a class='btn btn-success' href="../../artigos/aprovarSugestao/<?=$sugestao['cod_edit'];?>/<?=$_SESSION['usuario'];?>">Aprovar Sugestão</a>
                  </td>
                </tr>
                <?php $i++; endforeach; } } }?>
              </tbody>
            </table>
        </section>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <?php require_once 'scripts.php'; ?>
    </body>
</html>
