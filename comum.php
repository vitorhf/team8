<?php
// Seta sem limite de tempo
set_time_limit(0);

// libs
include_once('lib/lib_geral.php');
include_once('lib/lib_html.php');
include_once('lib/lib_db.php');
//include_once('lib/lib_msg.php');
//include_once('lib/lib_data.php');

$db = new db; // chamada de banco

// pega as variaveis passadas por post
if (is_array($_POST)) {
   foreach($_POST as $k=>$v) ${$k} = $v;
}


?>