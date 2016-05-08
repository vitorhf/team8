<?php
// comando necessario para os nomes dos meses e dias da semana virem em portugues alem é claro da acentuação (strtoupper)
// se não setado NÃO usa a variavel ambiental LC_ALL ou LC_TIME ou LANG
setlocale(LC_TIME,"pt_BR"); // 016 // 017
/**
 * @package Geral
 * @subpackage Data
**/
/**
 * Converte datas para o formato dd/mm/aaaa
 * @param string $data data
 * @param string $separador separador para formatação da data
 * @return string data formatada
**/
function convdt($data,$separador='/') { // 006
   if (!$data) return $data; // 004
   $data = str_replace('-','',$data); // 002
   $data = str_replace('.','',$data); // 002
   $data = str_replace('/','',$data); // 002
   $dia  = substr($data,0,2);
   $mes  = substr($data,2,2);
   $ano  = trim(substr($data,4,4));
   if (ereg('^[0-9]{2}$',$ano)) { // 008 // 022 // 023
      if ($ano < 30) $ano += 2000;
      else $ano += 1900;
   }
   return $dia.$separador.$mes.$separador.$ano; // 006
}
/**
 * Retorna o dia a partir de uma data no formato dd/mm/aaaa
 * @param string $data data
 * @return string dia
**/
function dia($data) {
   $aux = explode("/",convdt($data)); // 025
   return $aux[0]; // 012
}
/**
 * Retorna o mês a partir de uma data no formato dd/mm/aaaa
 * @param string $data data
 * @return string mês
**/
function mes($data) {
   $aux = explode("/",convdt($data)); // 025
   return $aux[1]; // 012
}
/**
 * Retorna o ano a partir de uma data no formato dd/mm/aaaa
 * @param string $data data
 * @return string ano
**/
function ano($data) {
   $aux = explode("/",convdt($data)); // 025
   return $aux[2]; // 012
}
/**
 * Testa se a data no formato dd/mm/aaaa é válida
 * @param string $data data
 * @return mixed true se válido ou false ou zero
**/
function dtok($data) {
   if (strlen($data)<10) return false; // 018
   $aux = explode("/",convdt($data)); // 025
   @$dia = $aux[0]; // 007
   @$mes = $aux[1]; // 007
   @$ano = $aux[2]; // 007
   if (is_numeric($dia) and is_numeric($mes) and is_numeric($ano)) return checkdate($mes,$dia,$ano);
   else if($data=="") return 0; // 008
   else return false;
}
/**
 * Converte data de inteiros para o formato dd/mm/aaaa
 * @param integer $inteiros data em inteiros
 * @return string data no formato dd/mm/aaaa
**/
function dts($inteiros) { // 021
   if ($inteiros==0) return "";
   $aux = explode("/",jdtojulian($inteiros));
   $mes = str_pad($aux[0],2,0,STR_PAD_LEFT);
   $dia = str_pad($aux[1],2,0,STR_PAD_LEFT);
   $ano = $aux[2];
   return "$dia/$mes/$ano";
}
/**
 * Converte data no formato dd/mm/aaaa para inteiros (ATENÇÃO: comparação entre datas devem ser feitas como inteiros)
 * @param string $data data no formato dd/mm/aaaa
 * @return integer data em inteiros se válido ou zero se inválido
**/
function dt($data) { // 008 // 021
   if (!dtok($data)) return 0;
   $aux = explode("/",convdt($data)); // 025
   $dia = $aux[0];
   $mes = $aux[1];
   $ano = $aux[2];
   return juliantojd($mes,$dia,$ano);
}
/**
 * Retorna a data atual no formato dd/mm/aaaa
 * @return string data
**/
function hoje() { // 009
   return date('d/m/Y');
}
/**
 * Retorna a hora atualdata atual no formato hh:mm:ss
 * @return string hora
**/
function hora() {
   return date('H:i:s');
}
/**
 * Retorna o nome do mês por extenso
 * @param integer $mes número do mês
 * @return string mês por extenso
**/
// Obs: depende de setlocale(LC_TIME,"pt_BR");
function nomemes($mes) { // 016
   if (!$mes or $mes < 1 or $mes > 12) return ''; // 024
   return ucwords(strftime('%B',mktime(0,0,0,$mes,1))); // 017 // 019
}
/**
 * Retorna a data do último dia do mês a partir de uma data no formato dd/mm/aaaa
 * @param string $data data
 * @return string data
**/
function data_ultimo_dia_mes($data) { // 013
   if (!dtok($data)) return 0;
   $data = addmonthdt($data,1);
   $aux = explode("/",$data);
   $dia = $aux[0];
   return adddaydt($data,-1*$dia);
}
/**
 * Retorna a data do primeiro dia do mês a partir de uma data no formato dd/mm/aaaa
 * @param string $data data
 * @return string data
**/
function data_primeiro_dia_mes($data) { // 013
   if (!dtok($data)) return 0;
   $aux = explode("/",convdt($data)); // 025
   $dia = $aux[0];
   return adddaydt($data,-1*$dia+1);
}
/**
 * Adiciona ou subtrai (caso dias seja negativo) n dias numa data no formato dd/mm/aaaa
 * @param string $data data
 * @param integer $dias quantidade de dias
 * @return string data
 * @deprecated mantido por compatibilidade - deve-se utilizar a função data_mais_dias()
**/
function adddaydt($data,$dias) { return data_mais_dias($data,$dias); }
/**
 * Adiciona ou subtrai (caso dias seja negativo) n dias numa data no formato dd/mm/aaaa
 * @param string $data data
 * @param integer $dias quantidade de dias
 * @return string data
**/
function data_mais_dias($data,$dias) {
   if (!dtok($data)) return 0;
   $aux = explode("/",convdt($data)); // 025
   $dia = $aux[0];
   $mes = $aux[1];
   $ano = $aux[2];
   return date("d/m/Y",mktime(0,0,0,$mes,$dia+$dias,$ano));
}
/**
 * Adiciona ou subtrai (caso meses seja negativo) n meses numa data no formato dd/mm/aaaa
 * @param string $data data
 * @param integer $meses quantidade de meses
 * @return string data
 * @deprecated mantido por compatibilidade - deve-se utilizar a função data_mais_meses()
**/
function addmonthdt($data,$meses) { return data_mais_meses($data,$meses); }
/**
 * Adiciona ou subtrai (caso meses seja negativo) n meses numa data no formato dd/mm/aaaa
 * @param string $data data
 * @param integer $meses quantidade de meses
 * @return string data
**/
function data_mais_meses($data,$meses) {
   $aux = explode("/",convdt($data)); // 025
   $dia = $aux[0];
   $mes = $aux[1];
   $ano = $aux[2];
   $data = date("d/m/Y",mktime(0,0,0,$mes+$meses,$dia,$ano));
   $aux = explode("/",$data);
   $dia2 = $aux[0];
   $mes2 = $aux[1];
   $ano2 = $aux[2];
   if ($dia2<$dia) return date("d/m/Y",mktime(0,0,0,$mes2,"01",$ano2));
   else return $data;
}
// 014
/**
 * Adiciona ou subtrai (caso anos seja negativo) n anos numa data no formato dd/mm/aaaa
 * @param string $data data
 * @param integer $anos quantidade de anos
 * @return string data
 * @deprecated mantido por compatibilidade - deve-se utilizar a função data_mais_anos()
**/
function addyeardt($data,$anos) { return data_mais_anos($data,$anos); }
/**
 * Adiciona ou subtrai (caso anos seja negativo) n anos numa data no formato dd/mm/aaaa
 * @param string $data data
 * @param integer $anos quantidade de anos
 * @return string data
**/
function data_mais_anos($data,$anos) {
   $aux = explode("/",convdt($data)); // 025
   $dia = $aux[0];
   $mes = $aux[1];
   $ano = $aux[2];
   $data = date("d/m/Y",mktime(0,0,0,$mes,$dia,$ano+$anos));
   $aux = explode("/",$data);
   $dia2 = $aux[0];
   $mes2 = $aux[1];
   $ano2 = $aux[2];
   if ($dia2<$dia) return date("d/m/Y",mktime(0,0,0,$mes2,"01",$ano2));
   else return $data;
}

function diasemana($data) {
   $aux = explode("/",convdt($data));
   $dia = $aux[0];
   $mes = $aux[1];
   $ano = $aux[2];
   $diasemana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes,$dia,$ano));
   switch($diasemana) {
      case"0": $diasemana = "Domingo"; break;
      case"1": $diasemana = "Segunda"; break;
      case"2": $diasemana = "Terca"; break;
      case"3": $diasemana = "Quarta"; break;
      case"4": $diasemana = "Quinta"; break;
      case"5": $diasemana = "Sexta"; break;
      case"6": $diasemana = "Sabado"; break;
   }
   return $diasemana;
}
?>
