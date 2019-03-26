<?php $i = 0; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Análise de Críticas</title>
        <?php require_once 'templates/head.php'; ?>
        <?php require_once 'scripts.php'; ?>
    </head>
    <body>
        <!-- Fixed navbar -->
        <header class="navbar navbar-default navbar-fixed-top">
            <?php require_once 'templates/header.php'; ?>
        </header>
        <section class="row container" id="criticas">
            <h1 class="titulo-crit">Criticas a serem resolvidas:</h1>
            <?php 
            if (!is_null($criticas)){
                foreach ($criticas as $critica): ?>
                <section class="box-critica">
                    <section class="panel panel-default">
                        <section class="panel-heading">
                            <h3 class="panel-title"><a class="criticado" href='perfil/<?= $criticado[$i]['usuario'] ?>'>
                            <?= $criticado[$i]['usuario'] ?></a>
                            Foi denunciado/a por: <span class="label label-primary"><?= strtoupper(str_replace("_", " ", $critica['motivo'])); ?></span></h3>
                        </section>
                        <section class="panel-body">
                            <h6> Descrição da Crítica:</h6><p> <?= $critica['texto_critica']; ?> </p>
                        </section>
                        <section class="panel-footer">
                            
                            <h6> Usuário que fez a critica: <a href='perfil/<?= $critica['usuario']; ?>'>
                            <?= $critica['usuario']; ?></a></h6>
                        </section>
                        
                    </section>
                    <a class='btn btn-primary' href='../criticas/resolver/<?=$critica['cod_critica'];?>'>Marcar como Resolvida</a>
                </section>
                <?php $i++; endforeach; } 
            else { ?>
                <section class="panel panel-default">
                    <section class="panel-heading">
                        <h4>Não existem criticas no momento</h4>
                    </section>
                </section>
            <?php } ?>
            </section>
        </section>
        
    </body>
</html>
