<?php
function fonte($a,$s='',$c='',$t='') {
   $aux = "<font";
   if ($s or $c or $t) $aux.= " style=\"";
   if ($s) $aux.= "font-size:".$s."pt; ";
   if ($c) $aux.= "color:$c; ";
   if ($t) $aux.= "font-face:$t; ";
   if ($s or $c or $t) $aux.= "\"";
   $aux.= ">".$a."</font>";
   return $aux;
}

function nbsp($n=1) {
   return str_repeat('&nbsp;',$n);
}

function br($n=1) {
   return str_repeat('<br>'."\n",$n);
}

function hr($n=1) {
   return str_repeat('<hr>'."\n",$n);
}

function u($s) {
   return '<u>'.$s.'</u>';
}

function b($s) {
   return '<b>'.$s.'</b>';
}

function i($s) {
   return '<i>'.$s.'</i>';
}

function center($s) {
   return '<center>'.$s.'</center>'."\n";
}

function esquerda2($s) {
   return '<div align="left">'.$s.'</div>'."\n";
}

function direita2($s) {
   return '<div align="right">'.$s.'</div>'."\n";
}

function tam($s,$t=3) {
   return fonte($s,$t);
}

function cor($s,$c) {
   return fonte($s,'',$c);
}

function tipo($s,$t) {
   return fonte($s,'','',$t);
}

function input($tipo,$nome='',$valor='',$complemento='',$classe='',$onfocus='',$onkeyup='',$onblur='',$onchange='',$onkeypress='') {
   $aux = "<input type=\"$tipo\"";
   if ($nome) $aux.= " name=\"$nome\" ID=\"$nome\"";
   if ($valor) $aux.= " value=\"$valor\"";
   if ($tipo != 'hidden') {
      $onfocus.= " this.select();k=0;";
      $disabled = false;
      if (strpos($classe,'readonly')) {
         $disabled = true;
         //para inputs readonly nao perderem valor
         echo input('hidden','readonly_'.$nome,$valor);
      } else {
         $onfocus.= " this.style.backgroundColor = '#E4EDF6';";
         $onblur.= " this.style.backgroundColor = '';";
      }
   }
   if ($classe == 'valor') {
      $onkeyup.= " formata_numero(this.name,'8','2'); ";
      $onblur.= " formata_final(this.name,'2'); ";
      $onchange.= " formata_final(this.name,'2'); ";
      if (!$disabled) $classe = " inputvalor";
      else $classe = "input_readonly_valor";
   } else if ($classe == 'data') {
      $aux.= " SIZE=\"11\" MAXLENGTH=\"10\"";
      $onkeyup.= " formatar_data(this,'##/##/####');";
   } else if ($classe == 'text') {

   }
   if ($classe) $aux.= " CLASS=\"$classe\"";
   if ($disabled) $aux.= " DISABLED=\"DISABLED\"";
   if ($onfocus) $aux.= " ONFOCUS=\"$onfocus\"";
   if ($onkeyup) $aux.= " ONKEYUP=\"$onkeyup\"";
   if ($onblur) $aux.= " ONBLUR=\"$onblur\"";
   if ($onchange) $aux.= " ONCHANGE=\"$onchange\"";
   if ($onkeypress) $aux.= " ONKEYPRESS=\"$onkeypress\"";
   if ($complemento) $aux.= ' '.$complemento;
   $aux.= ">"."\n";
   return $aux;
}

// funcao para criar uma tabela com dados
function tabela($dados,$border=0,$width='',$class='tabela_link',$style='',$cabecalho='',$area_livre='') {
   $aligns = array('L'=>'left','C'=>'center','R'=>'right');
   $valigns = array('T'=>'top','B'=>'bottom','M'=>'middle');
   $tab = '<table';
   if ($border) $tab.= " border='$border'";
   if ($width) $tab.= " width='$width'";
   if ($class) $tab.= " class='$class'";
   if ($style) $tab.= " style='$style'";
   $tab.= ' CELLSPACING=1px>'."\n";
   if ($dados) {
      $num_cols = count($cabecalho);
      if ($area_livre) {
         $tab.= "<TR>";
         $tab.= "   <TD COLSPAN=\"$num_cols\" ALIGN=\"center\">";
         $tab.=        center(cor($area_livre,'#006699'));
         $tab.= "   </TD>";
         $tab.= "</TR>";
      }
      if ($cabecalho) {
         foreach ($cabecalho as $col=>$titulo) {
            $tab.= "<TH>".$titulo."</TH>";
         }
      }
      foreach ($dados as $linha=>$dado) {
         $aux='';
         if ($colspan < $num_cols) $colspan = $num_cols;
         if ($dado['onclick']) {
            $aux=' onclick="javascript:'.$dado['onclick'].'" ';
            $aux.=' onmouseover=" javascript:this.style.backgroundColor=\'#CFCFCF\'; this.style.cursor=(ie)?\'hand\':\'pointer\';" ';
            //$aux.=' onmouseover="javascript:this.style.backgroundColor=\'#ECECEC\'" ';
            $aux.=' onmouseout="javascript:this.style.backgroundColor=\'\'" ';
            unset($dado['onclick']);
         }
         $tab.= '<tr '.$aux.'>'."\n";
         foreach ($dado as $coluna=>$d) {
            $aux = '';
            if ($d['align']) $aux.= ' align="'.$aligns[strtoupper($d['align'])].'"';
            else $aux.= ' align="'.$aligns['L'].'"';
            if ($d['valign']) $aux.= ' valign="'.$valigns[strtoupper($d['valign'])].'"';
            else $aux.= ' valign="'.$valigns['T'].'"';
            if ($d['colspan']) $aux.= ' colspan="'.$d['colspan'].'"';
            if ($d['width']) $aux.= ' width="'.$d['width'].'%"';
            if ($d['class']) $aux.= ' class="'.$d['class'].'"';
            if ($d['style']) $aux.= ' style="'.$d['style'].'"';
            if ($d['onclick']) $aux.=' onclick="javascript:'.$d['onclick'].'" ';
            if ($d['onmouseover']) $aux.=' onmouseover="javascript:'.$d['onmouseover'].'" ';
            if ($d['onmouseout']) $aux.=' onmouseout="javascript:'.$d['onmouseout'].'" ';
            if ($d['complemento']) $aux.=' '.$d['complemento'];
            if ($d['bgcolor']) $aux.= "bgcolor= \"".$d['bgcolor']."\"";
            if ($d['nowrap']) $tab.= "<td $aux>".wordwrap($d['valor'],($d['width']+8),'<BR>')."</td>\n";
            else $tab.= "<td $aux>".$d['valor']."</td>\n";
         }
         $tab.= '</tr>'."\n";
      }
   }
   $tab.= '</table>'."\n";
   return $tab;
}

function editor_mes($mes) {
   echo "\n<select name=\"mes\">\n";
   $mes_array = array();
   $mes_array[] = array(1,"Janeiro");
   $mes_array[] = array(2,"Fevereiro");
   $mes_array[] = array(3,"Março");
   $mes_array[] = array(4,"Abril");
   $mes_array[] = array(5,"Maio");
   $mes_array[] = array(6,"Junho");
   $mes_array[] = array(7,"Julho");
   $mes_array[] = array(8,"Agosto");
   $mes_array[] = array(9,"Setembro");
   $mes_array[] = array(10,"Outubro");
   $mes_array[] = array(11,"Novembro");
   $mes_array[] = array(12,"Dezembro");
   foreach($mes_array as $i=>$v) {
      if ($i != $mes) echo "<option value=\"".$i."\">".$mes_array[$i]."</option>\n";
      else echo "<option value=\"".$i."\" selected>".$mes_array[$i]."</option>\n";
   }
   echo "</select>\n\n";
}

function editor_ano($ano) {
   echo "<select name=\"ano\">\n";
   $z = 3;
   for($i=1;$i < 8; $i++) {
      if ($z == 0) echo "   <option value=\"".($ano - $z)."\" selected>".($ano-$z)."</option>\n";
      else echo "   <option value=\"".($ano - $z)."\">".($ano - $z)."</option>\n";
      $z--;
   }
   echo "</select>\n\n";
}
?>
