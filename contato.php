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
	<script type="text/javascript">

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
		
		$("#enviarEmail").click(function(event) {
			var validacao = validaFormEmail();
			if (validacao != "") alert(validacao);
			else {
				var dadosajax = {
					'nome' : $("#contatonome").val(),
					'email' : $("#contatoemail").val(),
					'empresa' : $("#contatoempresa").val(),
					'mensagem' : $("#contatomensagem").val(),
					'telefone' : $("#contatotelefone").val()
				};
				$.ajax({
					//pegando a url apartir da action do form
					url: 'enviaEmail.php',
					data: dadosajax,
					type: 'POST',
					cache: false,
					success: function(result){
						//se foi inserido com sucesso
						if($.trim(result) == '1')
							alert("Mensagem enviada com sucesso!");
						else
							alert("Ocorreu um erro ao enviar sua mensagem!");
						
					},
					error: function() {
						alert('Erro: Mensagem nao enviada!');
					}
				});
			}
		});
	});	
	function validaFormEmail() {;
		var f = document.formContato;
		var str = '';
		if (f.contatoemail.value.trim() == '') str += 'Favor inserir o e-mail.\n';
		else if (!isEmail(f.contatoemail.value)) str += 'E-mail inválido. Favor digitar um e-mail válido.\n';
		if (f.contatonome.value.trim() == '') str += 'Favor inserir o nome.\n';
		if (f.contatomensagem.value.trim() == '') str += 'Favor inserir a mensagem.\n';
		return str;
	}
	function validaForm() {
		var f = document.newsletter;
		var str = '';
		if (f.email.value.trim() == '') str = 'Favor inserir o e-mail.';
		else if (!isEmail(f.email.value)) str = 'E-mail inválido. Favor digitar um e-mail válido.';
		
		return str;
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
                            <li class="current"><a href="contato.php"><div>Contato</div></a></li>
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
                    <!-- Postcontent
                    ============================================= -->
                    <div class="postcontent nobottommargin">
                        <h3>Entre em contato</h3>
                        <div id="contact-form-result" data-notify-type="success" data-notify-msg="<i class=icon-ok-sign></i> Mensagem enviada com sucesso! Agradecemos pelo contato."></div>
                        <form class="nobottommargin" id="formContato" name="formContato" action="enviaEmail.php" method="post">
                            <div class="form-process"></div>
                            <div class="col_one_third">
                                <label for="contatonome">Nome <small>*</small></label>
                                <input type="text" id="contatonome" name="contatonome" value="" class="sm-form-control required" />
                            </div>
                            <div class="col_one_third">
                                <label for="contatoemail">E-mail <small>*</small></label>
                                <input type="email" id="contatoemail" name="contatoemail" value="" class="required email sm-form-control" />
                            </div>
                            <div class="col_one_third col_last">
                                <label for="contatotelefone">Telefone</label>
                                <input type="text" id="contatotelefone" name="contatotelefone" value="" class="sm-form-control" />
                            </div>
                            <div class="clear"></div>
                            <div class="col_two_third">
                                <label for="contatoempresa">Empresa</label>
                                <input type="text" id="contatoempresa" name="contatoempresa" value="" class="sm-form-control" />
                            </div>
                            <div class="clear"></div>
                            <div class="col_full">
                                <label for="contatomensagem">Mensagem <small>*</small></label>
                                <textarea class="required sm-form-control" id="contatomensagem" name="contatomensagem" rows="6" cols="30"></textarea>
                            </div>
                            <div class="col_full">
                                <button class="button button-3d nomargin" type="button" id="enviarEmail" name="enviarEmail" value="Enviar" onclick="avalidaFormEmail();">Enviar</button>
                            </div>

                        </form>

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