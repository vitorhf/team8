<?php

include_once("comum.php");

// pega as variaveis passadas por GET
if (is_array($_GET)) {
	foreach($_GET as $k=>$v) ${$k} = $v;
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="pt-BR">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Gama BootCamp 2016 Team 8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="description" content="Blog destinado a capacitacao de equipes para grandes empresas" />
    <meta name="keywords" content="">
    <meta name="rating" content="General" />
    <meta name="revisit-after" content="1 week" />
    <meta name="robots" content="all" />
    <meta name="geo.country" content="BR" />
    <meta name="geo.placename" content="BELO HORIZONTE - MG" />
    <meta name="DC.title" content="Capacite sua Equipe" />
    <meta name="DC.creator " content="Gama BootCamp 2016 Team 8" />
    <meta name="DC.creator.address" content="vitor@consultoriati.net" />
    <meta name="DC.subject" content="">
    <meta name="DC.description" content="Blog destinado a capacitacao de equipes para grandes empresas" />
    <meta name="DC.publisher" content="Gama BootCamp 2016 Team 8" />
    <meta name="DC.format" content="text/html" />	

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
	<title>Capacite sua Equipe - Team 8</title>
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
                            <li><a href="index.php"><div>Home</div></a></li>
                            <li><a href="quem-somos.php"><div>Quem Somos</div></a></li>
                            <li><a href="contato.php"><div>Contato</div></a></li>
                        </ul>
                    </div>
                </nav><!-- #primary-menu end -->
            </div>
        </header><!-- #header end -->

        <!-- Content
        ============================================= -->
        <section id="content">
            <div class="content-wrap">
                <div class="container clearfix">
                    <!-- Post Content
                    ============================================= -->
                    <div class="postcontent nobottommargin clearfix">
                        <div class="single-post nobottommargin">
<?php
if (!$idPost or !is_numeric($idPost)) $postagemInexistente = true;
else {
	$sql = "SELECT titulo, "
				." autor, "
				." data, "
				." url_imagem, "
				." texto "
				." FROM postagem "
				." WHERE id = $idPost "
	;
	$db->exec($sql);
	if (!$db->numrows()) $postagemInexistente = true;
	else {
		$db->fetch('a');
?>
                            <div class="entry clearfix">
                                <div class="entry-title">
                                    <h2><?=$db->r['titulo']?></h2>
                                </div>
                                <ul class="entry-meta clearfix">
                                    <li><i class="icon-calendar3"></i> <?=$db->r['data']?></li>
                                    <li><a href="#"><i class="icon-user"></i> <?=$db->r['autor']?></a></li>
                                </ul>
                                <div class="entry-content notopmargin">
                                    <div class="entry-image alignleft">
                                        <a href="#"><img src="<?=$db->r['url_imagem']?>" alt="<?=$db->r['titulo']?>"></a>
                                    </div>
                                    <p><?=$db->r['texto']?></p>

                                    <div class="clear"></div>

                                    <div class="si-share noborder clearfix">
                                        <span>COMPARTILHE:</span>
                                        <div>
                                            <a target="_blank" href="http://www.facebook.com/sharer.php?u=http://www.capacitesuaequipe.com.br/postagem.php?idPost=<?=$idPost?>" class="social-icon si-borderless si-facebook">
                                                <i class="icon-facebook"></i>
                                                <i class="icon-facebook"></i>
                                            </a>
                                            <a target="_blank" href="https://twitter.com/intent/tweet?original_referer=http://www.capacitesuaequipe.com.br/postagem.php?idPost=<?=$idPost?>&source=tweetbutton&text=<?=$db->r['titulo']?>&url=http://www.capacitesuaequipe.com.br" class="social-icon si-borderless si-twitter">
                                                <i class="icon-twitter"></i>
                                                <i class="icon-twitter"></i>
                                            </a>
                                            <a target="_blank" href="https://plus.google.com/share?url=http://www.capacitesuaequipe.com.br/postagem.php?idPost=<?=$idPost?>" class="social-icon si-borderless si-gplus">
                                                <i class="icon-gplus"></i>
                                                <i class="icon-gplus"></i>
                                            </a>
                                            <a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=http://www.capacitesuaequipe.com.br/postagem.php?idPost=<?=$idPost?>&title=<?=$db->r['titulo']?>&summary=<?=$db->r['titulo']?>" class="social-icon si-borderless si-linkedin">
                                                <i class="icon-linkedin"></i>
                                                <i class="icon-linkedin"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

<?php
		// busca outras postagens
		$sql = "SELECT titulo, "
					." url_imagem, "
					." data, "
					." id "
					." FROM postagem "
					." WHERE id != $idPost "
					." LIMIT 4 "
		;
		$db->exec($sql);
		if ($db->numrows()) {
			echo "<h4>Postagens Relacionadas:</h4>\n";
			echo "<div class=\"related-posts clearfix\">\n";
			echo "   <div class=\"col_half nobottommargin\">\n";
			$cont = 0;
			while ($db->fetch('a')) {
				$cont++;
				if ($cont > 2) {
					echo "</div><div class=\"col_half nobottommargin col_last\">\n";
				}
				echo "									 <div class=\"mpost clearfix\">\n";
				echo "                                        <div class=\"entry-image\">\n";
				echo "                                            <a href=\"postagem.php?idPost=".$db->r['id']."\"><img src=\"".$db->r['url_imagem']."\" alt=\"".$db->r['titulo']."\"></a>\n";
				echo "                                        </div>\n";
				echo "                                        <div class=\"entry-c\">\n";
				echo "                                            <div class=\"entry-title\">\n";
				echo "                                                <h4><a href=\"postagem.php?idPost=".$db->r['id']."\">".$db->r['titulo']."</a></h4>\n";
				echo "                                            </div>\n";
				echo "                                            <ul class=\"entry-meta clearfix\">\n";
				echo "                                                <li><i class=\"icon-calendar3\"></i> ".$db->r['data']."</li>\n";
				echo "                                            </ul>\n";
				echo "                                        </div>\n";
				echo "                                    </div>\n";
			}
			echo "</div></div>";
		}
	}
}
if ($postagemInexistente) {
?>	
					<div class="postcontent nobottommargin clearfix">
                        <div class="single-post nobottommargin">
                            <div class="entry clearfix">
                                <div class="entry-title">
                                    <h2>Postagem inexistente</h2>
                                </div>
                            </div>
                        </div>
                    </div>
<?php					
}
?>
                            
 

							

                        </div>

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