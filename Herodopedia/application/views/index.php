<!DOCTYPE html>
<html>
  <head>
    <title>Herodopedia</title>
	<?php require_once 'templates/head.php'; ?>
	<?php require_once 'scripts.php'; ?>
  </head>

  <body>

    <!-- Fixed navbar -->
	<header class="navbar navbar-default navbar-fixed-top">
        <?php require_once 'templates/header.php'; ?>
    </header>

	<!--  *****************************************************************************************************************
	 IMAGEM INDEX
	 ***************************************************************************************************************** -->
	<section id="headerwrap">
		<section class="imgwrap">
			<img src="<?php echo base_url(); ?>assets/img/img-index1.png" class="img-responsive">
		</section>
	</section>

	 <!-- *****************************************************************************************************************
	 NAVEGAÇÃO ARTIGO
	 ***************************************************************************************************************** -->
	 <section class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2" id="nav-art">
	 	<span class="pesquisa1 col-lg-4 col-md-4 col-lg-offset-2 col-md-offset-2">
	        <h4 class="header-nav-art">Pesquisa</h4>
	        <form class="pesq-nav" action="<?php echo base_url().'index.php/pages/pesquisa'?>" method="post">
			    <input class="form-control" type="text" name="pesquisa" placeholder="Informe um título" maxlength="80">
			    <button class="btn-pesquisa" type="submit"><img src="<?php echo base_url(); ?>assets/img/lupa_antiga.png" alt="Pesquisar"></button>
			</form>
		</span>
		<span class="pesquisa2 col-lg-4 col-md-4">
			<h4 class="header-nav-art">Tags</h4>
			<form class="tag-nav" action="<?php echo base_url().'index.php/pages/pesquisartag'?>" method="post">
				<select name="pesquisaTag">
					<?php foreach($tags as $tag): ?>
					<option class="tag" value="<?=$tag['descricao_tag'];?>"><?=$tag['descricao_tag'];?></option>
					<?php endforeach; ?>
				</select>
				<button class="btn-pesquisa" type="submit"><img src="<?php echo base_url(); ?>assets/img/lupa_antiga.png" alt="Pesquisar"></button>
			</form>
		</span>
 	</section>
	 
	<!-- *****************************************************************************************************************
	 CONTEÚDO
	 ***************************************************************************************************************** -->
    <section class="row">
		<section class="mtb container">
			<article class="col-lg-7 col-md-7" id="artigos">
				<h4>Últimos artigos</h4>
            	<?php foreach($artigos as $artigo): ?>
            	<section class="art">
                    <span><h4><a href='<?php echo base_url()."index.php/pages/mostra_artigo/{$artigo->titulo}";?>'>
                    <?=strtoupper(str_replace("_", " ", $artigo->titulo));?></a></h4>
                    <h6>Criado em:  <?= $artigo->data_art ?></h6></span>
                    <p><?=strip_tags(substr($artigo->text_edit, 0, 600));?>...</p>
                    <h5>Tag: <a href='<?php echo base_url()."index.php/pages/pesquisarTag/{$artigo->descricao_tag}";?>'><?=$artigo->descricao_tag;?></a></h5>
                    <h5>Autor: <a href='<?php echo base_url()."index.php/pages/perfil/{$artigo->usuario}";?>'><?= $artigo->usuario; ?></a></h5>
                </section>
                <?php endforeach; echo $pagination; ?>

		 	</article>

		 	<aside class="col-lg-4 col-md-4" id="discussoes">
			 	<h4>Últimas discussões</h4>

                <?php foreach($discussoes as $discussao): ?>
                <section class="disc">
                    <h4><a href='<?php echo base_url()."index.php/pages/mostra_discussao/{$discussao->titulo_discussao}";?>'>
                    <?=strtoupper(str_replace("_", " ", $discussao->titulo_discussao));?></a></h4>
                    <h5> do Artigo <a href='<?php echo base_url()."index.php/pages/mostra_artigo/{$discussao->titulo}";?>'>
                    <?=strtoupper(str_replace("_", " ", $discussao->titulo));?></a></h5>
                    <p><?=substr($discussao->texto_discussao, 0, 355);?>...</p>
                    <h5>Tag: <a href='<?php echo base_url()."index.php/pages/pesquisarTag/{$discussao->descricao_tag}";?>'><?=$discussao->descricao_tag;?></a></h5>
                    <h6>Enviado por <a href='<?php echo base_url()."index.php/pages/perfil/{$discussao->usuario}";?>'><?= $discussao->usuario; ?></a></h6>
                    <h6>Criado em:  <?= $discussao->data_disc ?></h6>
                    
                </section>
                <?php endforeach; ?>
			</aside>
		</section>	
	</section>
        
        
	<!-- *****************************************************************************************************************
	 TESTIMONIALS
	 ***************************************************************************************************************** 
	 <section id="twrap">
	 	<section class="container centered">
	 		<section class="row">
	 			<section class="col-lg-8 col-lg-offset-2">
	 			<i class="fa fa-comment-o"></i>
	 			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
	 			<h4><br/>Marcel Newman</h4>
	 			<p>WEB DESIGNER - BLACKTIE.CO</p>
	 			</section>
	 		</section>
	 	</section>
	 </section>
	 -->
	<!-- *****************************************************************************************************************
	 OUR CLIENTS
	 ***************************************************************************************************************** 
	 <section id="cwrap">
		 <section class="container">
		 	<section class="row centered">
			 	<h3>OUR CLIENTS</h3>
			 	<section class="col-lg-3 col-md-3 col-sm-3">
			 		<img src="assets/img/clients/client01.png" class="img-responsive">
			 	</section>
			 	<section class="col-lg-3 col-md-3 col-sm-3">
			 		<img src="assets/img/clients/client02.png" class="img-responsive">
			 	</section>
			 	<section class="col-lg-3 col-md-3 col-sm-3">
			 		<img src="assets/img/clients/client03.png" class="img-responsive">
			 	</section>
			 	<section class="col-lg-3 col-md-3 col-sm-3">
			 		<img src="assets/img/clients/client04.png" class="img-responsive">
			 	</section>
		 	</section>
		 </section>
	 </section>
	-->
	<!-- *****************************************************************************************************************
	 FOOTER
	 ***************************************************************************************************************** -->
	 <footer id="footerwrap">
	 	<section class="container">
		 	<section class="row">
		 		<section class="col-lg-4 col-md-4">
		 			<h4>Sobre</h4>
		 			<section class="hline-w"></section>
		 			<p>Projeto Final de Curso - 3INFO1.</p>
		 		</section>
		 		<section class="col-lg-4 col-md-4">
		 			<h4>Redes Sociais</h4>
		 			<section class="hline-w"></section>
		 			<p>
		 				<a href="#"><i class="fa fa-dribbble"></i></a>
		 				<a href="#"><i class="fa fa-facebook"></i></a>
		 				<a href="#"><i class="fa fa-twitter"></i></a>
		 				<a href="#"><i class="fa fa-instagram"></i></a>
		 				<a href="#"><i class="fa fa-tumblr"></i></a>
		 			</p>
		 		</section>
		 		<section class="col-lg-4 col-md-4">
		 			<h4>Copyright</h4>
		 			<section class="hline-w"></section>
		 			<p>
		 				Erick Kupas,<br/>
		 				Joao V. Fröhlich,<br/>
		 				Leonardo Lindroth<br/>
		 			</p>
		 		</section>
		 	
		 	</section><!-- /row -->
	 	</section><!-- /container -->
	 </footer><!-- /footerwrap -->
	 
    <!-- Bootstrap core JavaScript -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
