<?php

include_once("comum.php");

if ($email) {
	$retorno = envia_email('vitorhf@gmail.com','vitorhf@gmail.com','Erro site gama',$mensagem,true);
	echo $retorno;
} else {
	echo 0;
}
	
?>	