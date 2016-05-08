<?php
include_once("comum.php");
?>

<!DOCTYPE html>
<html dir="ltr" lang="pt-BR">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Gama BootCamp 2016 Team 8" />
    <!-- Stylesheets
    ============================================= -->
	<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="stylesheet" href="css/dark.css" type="text/css" />
    <link rel="stylesheet" href="css/font-icons.css" type="text/css" />
    <link rel="stylesheet" href="css/animate.css" type="text/css" />
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css" />

    <link rel="stylesheet" href="css/responsive.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!--[if lt IE 9]>
    	<script src="js/css3-mediaqueries.js"></script>
    <![endif]-->

    <!-- External JavaScripts
    ============================================= -->
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/plugins.js"></script>

    <!-- Document Title
    ============================================= -->
	<title>Capacite sua Equipe</title>
<?php
	if ($erro) echo "<script>alert('".$erro."');</script>";
	if ($sucesso) echo "<script>alert('".$sucesso."');</script>";
?>
	<script>

	$(document).ready(function(){
		$("#cadastro").click(function(event) {
			var validacao = validaForm();
			if (validacao != "") alert(validacao);
			else {
				event.preventDefault();
				var dadosajax = {
					'nome' : $("#nome").val(),
					'empresa' : $("#empresa").val(),
					'email' : $("#email").val()
				};
				$.ajax({
					//pegando a url apartir da action do form
					url: 'insereLeads.php',
					data: dadosajax,
					type: 'POST',
					cache: false,
					success: function(result){
						//se foi inserido com sucesso
						if($.trim(result) == '1')
							alert("Obrigado pelo cadastro!");
						else
							alert("Ocorreu um erro ao inserir o seu registo!");
						
					},
					error: function() {
						alert('Erro: Inserir Registo!!');
					}
				});
			}
		});
	});	
	
	function validaForm() {
		var f = document.newsletter;
		var str = '';
		if (f.email.value.trim() == '') str = 'Favor inserir o e-mail.';
		else if (!isEmail(f.email.value)) str = 'E-mail inválido. Favor digitar um e-mail válido.';
		
		return str
	}
	function isEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}		

	</script>
</head>
<body class="stretched">
    <!-- Document Wrapper
    ============================================= -->
    <div id="wrapper" class="clearfix">
		<!-- Header
        ============================================= -->
        <header id="header" class="sticky-style-2">
			<div class="container clearfix">
                <!-- Logo
                ============================================= -->
                <div id="logo" class="divcenter">
					<a href="index.php" class="standard-logo"><img class="banner" src="images/banner.jpg" alt="Capacite sua Equipe"></a>
					<a href="index.php" class="retina-logo"><img class="divcenter banner" src="images/banner.jpg" alt="Capacite sua Equipe"></a>
                </div><!-- #logo end -->
            </div>
            <div id="header-wrap">
                <!-- Primary Navigation
                ============================================= -->
                <nav id="primary-menu" class="style-2 center">
                    <div class="container clearfix">
                        <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
                        <ul>
                            <li class="current"><a href="index.php"><div>Home</div></a></li>
                            <li><a href="quem-somos.php"><div>Quem Somos</div></a></li>
                            <li><a href="contato.php"><div>Contato</div></a></li>
                        </ul>

                    </div>

                </nav><!-- #primary-menu end -->

            </div>

        </header><!-- #header end -->	
        <section id="content">
            <div class="content-wrap">

                <!-- <a href="#" data-toggle="modal" data-target="#contactFormModal" class="button button-full button-red center tright header-stick bottommargin-lg">
                    <div class="container clearfix">
                        Cadastre-se e faça download do nosso e-book gratuitamente. <strong>Clique aqui</strong> <i class="icon-caret-right" style="top:4px;"></i>
                    </div>
                </a> 
				<div class="modal fade" id="contactFormModal" tabindex="-1" role="dialog" aria-labelledby="contactFormModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="contactFormModalLabel">Cadastre-se</h4>
							</div>
							<div class="modal-body">
								<form class="nobottommargin" id="template-contactform" name="template-contactform" action="include/sendemail.php" method="post">

									<div class="col_full">
										<label for="template-contactform-name">Nome</label>
										<input type="text" id="nome" name="nome" value="" class="sm-form-control required"/>
									</div>
									<div class="col_full">
										<label for="template-contactform-name">Empresa</label>
										<input type="text" id="empresa" name="empresa" value="" class="sm-form-control required"/>
									</div>									

									<div class="col_full">
										<label for="template-contactform-email">E-mail <small>*</small></label>
										<input type="email" id="email" name="email" value="" class="required email sm-form-control"/>
									</div>

									<div class="col_full">
										<button class="button button-3d nomargin" type="submit" id="template-contactform-submit" name="template-contactform-submit" value="submit">Cadastrar</button>
                                        
									</div>

								</form>

								<script type="text/javascript">
									$("#template-contactform").validate({
										submitHandler: function(form) {
											$('.form-process').fadeIn();
											$(form).ajaxSubmit({
												target: '#contact-form-result',
												success: function() {
													$('.form-process').fadeOut();
													$('#template-contactform').find('.sm-form-control').val('');
													$('#contact-form-result').attr('data-notify-msg', $('#contact-form-result').html()).html('');
													SEMICOLON.widget.notifications($('#contact-form-result'));
												}
											});
										}
									});
								</script>
								
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>-->
				<!-- Modal Contact Form End -->

                <div class="container clearfix">

                    <!-- <div class="heading-block center">
                        <h1>Artigos Recentes</h1>
                    </div> -->

                    <!-- Post Content
                    ============================================= -->
                    <div class="postcontent nobottommargin clearfix">
                        <!-- Posts
                        ============================================= -->
                        <div id="posts" class="small-thumbs">
<?php
	$sql = "SELECT texto, "
				." url_imagem, "
				." titulo, "
				." autor, "
				." data "
				." FROM postagem "
				." ORDER BY data DESC, id DESC "
	;
	$db->exec($sql);
	if (!$db->numrows()) {
		echo "<div class=\"entry clearfix\">\n";
		echo "   <div class=\"entry-c\">\n";
		echo "  	<div class=\"entry-title\">\n";
		echo "          <h2><a href=\"#\">Sem conteúdo</a></h2>\n";
		echo "      </div>\n";
		echo "		<div class=\"entry-content\">\n";
		echo "         <p>Pedimos desculpas mas estamos sem conteúdo no momento. Em breve as postagens estarão no ar!</p>";
		echo "		</div>\n";
		echo "	</div>\n";
		echo "</div>\n";
	} else {
		while ($db->fetch('a')) {
			echo "							<div class=\"entry clearfix\">
                                <div class=\"entry-image\">
                                    <a href=\"".$db->r['url_imagem']."\" data-lightbox=\"image\"><img class=\"image_fade\" src=\"".$db->r['url_imagem']."\" alt=\"".$db->r['titulo']."\"></a>
                                </div>
                                <div class=\"entry-c\">
                                    <div class=\"entry-title\">
                                        <h2><a href=\"#\">".$db->r['titulo']."</a></h2>
                                    </div>
                                    <ul class=\"entry-meta clearfix\">
                                        <li><i class=\"icon-calendar3\"></i> ".$db->r['data']."</li>
                                        <li><a href=\"#\"><i class=\"icon-user\"></i>".$db->r['autor']."</a></li>
                                    </ul>
                                    <div class=\"entry-content\">
                                        ".$db->r['texto']."
                                    </div>
                                </div>
                            </div>\n";		
		}
	}
?>						
                        </div><!-- #posts end -->
                        <!-- Pagination
                        ============================================= -->
                        <!-- <ul class="pager nomargin">
                            <li class="previous"><a href="#">&larr; Antigos</a></li>
                            <li class="next"><a href="#">Novos &rarr;</a></li>
                        </ul> --><!-- .pager end -->
                    </div><!-- .postcontent end -->
                    <!-- Sidebar
                    ============================================= -->
                    <div class="sidebar nobottommargin col_last clearfix">
                        <div class="sidebar-widgets-wrap">

                            <div class="widget widget-twitter-feed clearfix">

                                <h4>Receba mais informações</h4>
								<form class="nobottommargin" id="newsletter" name="newsletter" action="insereLeads.php" method="post" novalidate="novalidate">

									<div class="form-process"></div>

									<div class="col_full">
										<input type="text" id="nome" name="nome" value="" class="sm-form-control" placeholder="Nome" maxlength="100">
									</div>

									<div class="col_full">
										<input type="text" id="empresa" name="empresa" value="" class="sm-form-control" placeholder="Empresa" maxlength="100">
									</div>									

									<div class="col_full">
										<input type="email" id="email" name="email" value="" class="required email sm-form-control" aria-required="true" placeholder="E-mail (obrigatório)" maxlength="100">
									</div>

									<div class="col_full">
										<button name="cadastro" type="button" id="cadastro" tabindex="5" value="Cadastrar" class="button button-3d nomargin" onclick="validaForm();";>Cadastrar</button>
									</div>
								</form>
                            </div>
							<div class=" si-share noborder clearfix">
								<span>COMPARTILHE:</span>
								<div>
									<a target="_blank" href="http://www.facebook.com/sharer.php?u=http://www.capacitesuaequipe.com.br/index.php" class="social-icon si-borderless si-facebook">
										<i class="icon-facebook"></i>
										<i class="icon-facebook"></i>
									</a>
									<a target="_blank" href="https://twitter.com/intent/tweet?original_referer=http://www.capacitesuaequipe.com.br/index.php&source=tweetbutton&text=Capacite sua Equipe&url=http://www.capacitesuaequipe.com.br" class="social-icon si-borderless si-twitter">
										<i class="icon-twitter"></i>
										<i class="icon-twitter"></i>
									</a>
									<a target="_blank" href="https://plus.google.com/share?url=http://www.capacitesuaequipe.com.br/index.php" class="social-icon si-borderless si-gplus">
										<i class="icon-gplus"></i>
										<i class="icon-gplus"></i>
									</a>
									<a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=http://www.capacitesuaequipe.com.br/index.php&title=Capacite sua Equipe&summary=Capacite sua Equipe" class="social-icon si-borderless si-linkedin">
										<i class="icon-linkedin"></i>
										<i class="icon-linkedin"></i>
									</a>
								</div>
							</div><!-- Post Single - Share End -->	
                           <!--  <div class="widget clearfix">

                                <h4>Tags</h4>
                                <div class="tagcloud">
                                    <a href="#">treinamento online</a>
                                    <a href="#">capacitação de equipes</a>
                                    <a href="#">redução de custo empresarial</a>
                                    <a href="#">comunicação empresarial</a>
                                </div>
                            </div> -->
                        </div>
                    </div><!-- .sidebar end -->
                </div>
            </div>
        </section><!-- #content end -->
        <!-- Footer
        ============================================= -->
        <footer class="footer-gama">
            <!-- Copyrights
            ============================================= -->
                <div class="container clearfix">
                    <div class="footer-gama">
                        Copyrights &copy; 2016 - Gama BootCamp 2016 - #Team 8
                    </div>
                </div>
            <!-- #copyrights end -->
        </footer><!-- #footer end -->
    </div><!-- #wrapper end -->
    <!-- Go To Top
    ============================================= -->
    <div id="gotoTop" class="icon-angle-up"></div>
    <!-- Footer Scripts
    ============================================= -->
    <script type="text/javascript" src="js/functions.js"></script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-77441549-1', 'auto');
	  ga('send', 'pageview');

	</script>	
</body>
</html>