<?php

include_once("comum.php");

if ($email) {
	// grava no banco de dados os dados do form
	$ipUsuario = $_SERVER["REMOTE_ADDR"];
	$sql = "INSERT INTO leads (email, ip, nome, empresa) VALUES ('$email', '$ipUsuario', ".($nome?"'".$nome."'":"NULL").", ".($empresa?"'".$empresa."'":"NULL").")";
	$db->exec($sql);
	$erro = $db->erro();
	if ($erro) {
		$mensagem = 'ERRO NO SITE GAMA<BR>'.$sql.' - '.$db->erro();
		envia_email('vitorhf@gmail.com','vitorhf@gmail.com','Erro site gama',$mensagem,true);		
		echo 0;
	} else {
		echo 1;
	}
} else {
	echo 0;
}
	
?>	