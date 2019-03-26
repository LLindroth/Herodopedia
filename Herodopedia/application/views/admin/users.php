<!DOCTYPE html>
<?php
if($_SESSION['cod_tipo'] != 2){
    exit();
}
?>
<html>
    <head>
        <title>Administração</title>
        <?php require_once 'templates/head.php'; ?>
        <?php require_once 'scripts.php'; ?>
    </head>
    <body>
        <!-- Fixed navbar -->
        <header class="navbar navbar-default navbar-fixed-top">
            <?php require_once 'templates/header.php'; ?>
        </header>

        <section class="row">
            <section class="tabela-users">
                <table class="table table-hover table-inverse">
                    <caption>Usuários</caption>
                    <thead class="thead-users">
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Data De Nascimento</th>
                        <th>Email</th>
                        <th>Usuário</th>
                        <th>Tipo de Usuário</th>
                        <th>Ações</th>
                    </thead>
                    <tbody class="tbody-users">
                        <?php foreach($usuarios as $usuario) : ?>
                        <tr class="trow-users">
                            <td class="tdata-users"><?=$usuario->id_usuario;?></td>
                            <td class="tdata-users"><?=$usuario->nome;?></td>
                            <td class="tdata-users"><?=$usuario->sobrenome;?></td>
                            <td class="tdata-users"><?=$usuario->dt_nasc;?></td>
                            <td class="tdata-users"><?=$usuario->email;?></td>
                            <td class="tdata-users"><?=$usuario->usuario;?></td>
                            <td class="tdata-users"><?=$usuario->desc_tipo;?></td>
                            <?php if ($usuario->cod_tipo == 1 ){
                                echo "<td class='tdata-users'><a style='color:red;' class='' href='../registro/banir/$usuario->id_usuario'>Banir</a></td>";
                            } ?>
                            <?php if ($usuario->cod_tipo == 2 ){
                                echo "<td class='tdata-users'>Sem ação</td>";
                            } ?>
                            <?php if ($usuario->cod_tipo == 3 ){
                                echo "<td class='tdata-users'><a style='color:darkblue;' class='' href='../registro/desbanir/$usuario->id_usuario'>Desbanir</a></td>";
                            } ?>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </section>
        </section>
        
         <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        
    </body>
</html>