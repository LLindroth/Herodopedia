<script type = 'text/javascript' src = "<?php echo base_url(); ?>assets/js/notificacao.js"></script>
<section class="container">
    <nav class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </nav>
    <nav class="navbar-collapse collapse navbar-left">
        <ul class="nav navbar-nav">
            <li><a href="<?php echo base_url();?>index.php/pages/index">HERODOPEDIA</a></li>
            <?php if(isset($_SESSION['id'])){
                echo "<li><a href='".base_url()."index.php/pages/novoartigo'>ARTIGO</a></li>";
            }
            ?>
        </ul>
    </nav>
    <nav class="navbar-collapse collapse navbar-right">
        <ul class="nav navbar-nav">
            <?php if(!isset($_SESSION['id'])){
            echo "<li><a href='".base_url()."index.php/pages/login'>LOGIN</a></li>";
            echo "<li><a href='".base_url()."index.php/pages/register'>CADASTRO</a></li>";
            }
            else{

                if($_SESSION['cod_tipo'] == 2){
                    echo "<li class='dropdown'>";
                        echo "<a class='dropdown-toggle' data-toggle='dropdown'>ADMIN<b class='caret'></b></a>";
                        echo "<ul class='dropdown-menu'>";
                            echo "<li><a href='".base_url()."index.php/pages/usuarios'>USUARIOS</a></li>";
                            echo "<li><a href='".base_url()."index.php/pages/aprovacao'>APROVAÇÃO</a></li>";
                            echo "<li><a href='".base_url()."index.php/pages/criticas'>CRITÍCAS</a></li>";
                            echo "<li><a href='".base_url()."index.php/pages/gerenciar'>GERENCIAR</a></li>";
                        echo "</ul>";
                    echo "</li>";    
                }
                echo "<li><a href='".base_url()."index.php/pages/perfil/{$_SESSION['usuario']}'>BEM-VINDO ".  strtoupper($_SESSION['usuario'])."</a></li>";
                echo "<li>";
                    if ($qtd_nots == 0) {
                        echo "<button class='nots-button'>NOTIFICAÇÕES</button>";
                    } else {
                        echo "<button class='nots-button'>NOTIFICAÇÕES<span class='badge'>".$qtd_nots."</span></button>";
                    }
                    echo "<section class='nots'>";
                    if (!empty($notificacao)) {
                        foreach ($notificacao as $not){
                        echo "<ul class='list-group nots-list'>";
                        echo "<li class='list-group-item'><p>$not->texto_n</p><h6>".str_replace(":00", "", str_replace("-", "/", $not->data_n))."</h6></li>";
                        echo "</ul>";
                        } 
                    }
                    else{
                        echo "<ul class='list-group nots-list'>";
                        echo "<li class='list-group-item'><p>Não tem notificações ainda</p></li>";
                        echo "</ul>";
                    }
                    echo "</section>";
                echo "</li>";
                echo "<li><a href='".base_url()."index.php/registro/logout'>SAIR</a></li>";
            }
             ?>
            <!--
            
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">PAGES <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="blog.html">BLOG</a></li>
                <li><a href="single-post.html">SINGLE POST</a></li>
                <li><a href="portfolio.html">PORTFOLIO</a></li>
                <li><a href="single-project.html">SINGLE PROJECT</a></li>
              </ul>
            </li>
            -->
        </ul>
    </nav><!--/.nav-collapse -->
</section>