<?php
function openFile($file, $mode, $input=null) {
   if ($mode == "READ") {
      if (file_exists($file)) {
         $output = file($file);
         return $output; // output file text
      } else {
         return false; // failed.
      }
   } elseif ($mode == "WRITE") {
      $handle = fopen($file, "w");
      if (!fwrite($handle, $input)) {
         return false; // failed.
      } else {
         return true; //success.
      }
   } elseif ($mode == "READ/WRITE") {
      if (file_exists($file) && isset($input)) {
         $handle = fopen($file,"r+");
         $read = fread($handle, filesize($file));
         $data = $read.$input;
         if (!fwrite($handle, $data)) {
            return false; // failed.
         } else {
            return true; // success.
         }
      } else {
         return false; // failed.
      }
   } else {
      return false; // failed.
   }
   fclose($handle);
}

function upload($arquivo,$caminho){
   if(!(empty($arquivo))){
      $arquivo1 = $arquivo;
      $arquivo_minusculo = strtolower($arquivo1['name']);
      $caracteres = array("ç","~","^","]","[","{","}",";",":","´",",",">","<","-","/","|","@","$","%","ã","â","á","à","é","è","ó","ò","+","=","*","&","(",")","!","#","?","`","ã"," ","©");
      $arquivo_tratado = str_replace($caracteres,"",$arquivo_minusculo);
      $destino = $caminho."/".$arquivo_tratado;
      pre($arquivo);
      pre($arquivo1);
      echos($arquivo1['tmp_name'],$destino);
      if(move_uploaded_file($arquivo1['tmp_name'],$destino)){
         return true;
//         echo "<script>window.alert('Arquivo enviado com sucesso.');</script>";
      }else{
         return false;
//         echo "<script>window.alert('Erro ao enviar o arquivo');</script>";
      }
   }
}

function echos() {
   $args = func_get_args();
   foreach ($args as $arg) echo "[".$arg."]";
   echo "\n\n".br(2);
   flush();
}

function pre($v) {
   echo "<pre>";
   var_dump($v);
   echo "</pre>";
}


function limpa_campos($campos='',$nao_limpa_id=false) {
   if ($campos) {
      if (!is_array($campos)) $campos = explode(",",$campos);
      foreach($campos as $k => $valor) {
         $campos[$k] = trim($valor);
      }
      foreach($campos as $campo) {
         if ($GLOBALS[_POST][$campo]) $GLOBALS[_POST][$campo] = "";
         $GLOBALS[$campo] = "";
      }
      if (!$nao_limpa_id) {
         $GLOBALS['id'] = "";
         $GLOBALS['_POST']['id'] = "";
         $GLOBALS['rowid'] = "";
         $GLOBALS['_POST']['rowid'] = "";
      }
   } else {
      foreach($GLOBALS['_POST'] as $campo => $valor) {
         $GLOBALS[_POST][$campo] = "";
      }
   }
}
/**
 * Limpa os valores das variáveis/campos POST/GLOBALS do formulário com exceção das informadas
 * @param string $campos se informado, define quais variáveis/campos NÂO serão limpados, senão limpa tudo
**/
function limpa_campos_exceto($campos="") { // 027
   if ($campos) {
      if (!is_array($campos)) $campos = explode(",",$campos);
      foreach($campos as $k => $valor) { // 054
         $campos[$k] = trim($valor);
      }
      foreach($GLOBALS['_POST'] as $campo => $valor) {
         if (!in_array($campo,$campos)) {
            $GLOBALS[_POST][$campo] = ""; // 057
            if (!in_array($campo,array("backward","forward","fetch_forward","consistiu_modulos"))) $GLOBALS[$campo] = ""; // 146 // 179
         }
      }
   } else {
      foreach($GLOBALS['_POST'] as $campo => $valor) {
         $GLOBALS[_POST][$campo] = ""; // 057
         if (strpos($campo,"COMBO_")===false and !in_array($campo,array("backward","forward","fetch_forward","consistiu_modulos"))) $GLOBALS[$campo] = ""; // 146 // 179
      }
   }
}

/**
 * Retorna o valor formatado
 * @param string $valor
 * @return string valor
**/
function real($valor) {
   $valor = (float) $valor;
   setlocale(LC_MONETARY,"pt_BR", "ptb");
   return money_format('%n', $valor);
}


/**
* Formata o valor para o formato monetário
* @param float $valor valor a ser formatado
* @return string valor formatado
**/
function real2($valor) {
   if (abs($valor) < 0.01) $valor = 0;
   return(number_format($valor,2,",","."));
}


/**
 * Completa o valor com zeros à esquerda até o tamanho especificado
 * @param string $campo valor a ser formatado
 * @param integer $tamanho tamanho máximo para preenchimento da string
 * @return string valor formatado
**/
function zeros($campo,$tamanho) {
   return str_pad($campo,$tamanho,'0',STR_PAD_LEFT); // 152
}
/**
 * Retira os caracteres ponto (.), traço (-), barra (/) e espaços em branco no ínicio e fim de um valor
 * @param string $numero valor a ser manipulado
 * @return string valor sem formatação
**/
function tira_formatacao($numero) { // 028
   $numero = str_replace(".","",$numero);
   $numero = str_replace("-","",$numero);
   $numero = str_replace("/","",$numero);
   $numero = trim($numero);
   return $numero;
}
/**
 * Verifica se o cpf é valido e caso seja, formata-o conforme a máscara 999.999.999-99
 * @param string $cpf valor do cpf
 * @return bool true se válido e false se inválido
**/
function valida_cpf(&$cpf) { // 028
   $numero = tira_formatacao($cpf);
   $tamnum = strlen($numero);
   if ($tamnum != 11 or !is_numeric($numero)) return false;
   for ($i=0;$i<=9;++$i) {
      if ($numero == str_repeat($i,11)) {
         $cpf = formata_string($cpf,"999.999.999-99");
         return false;
      }
   }
   $dv = 0;
   for ($i=0;$i<=8;++$i) {
      $dv += substr($numero,$i,1)*(10-$i);
   }
   $dv = ($dv*10)%11;
   $dv1 = right($dv,1);
   $dv_informado = right($numero,2);
   $numero = left($numero,9).$dv1;
   $dv = 0;
   for ($i=0;$i<=9;++$i) {
      $dv += substr($numero,$i,1)*(11-$i);
   }
   $dv = ($dv*10)%11;
   $dv = right($dv,1);
   $dv = $dv1.$dv;
   $cpf = formata_string($cpf,"999.999.999-99");
   if ($dv_informado == $dv) return true;
   else return false;
}
/**
 * Verifica se o cnpj é valido e caso seja, formata-o conforme a máscara 99.999.999/9999-99
 * @param string $cnpj valor do cnpj
 * @return bool true se válido e false se inválido
**/
function valida_cnpj(&$cnpj) { // 028
   $numero = tira_formatacao($cnpj);
   $tamnum = strlen($numero);
   if ($tamnum != 14 or !is_numeric($numero)) return false;
   $dv = 0;
   for ($i=0;$i<=11;++$i) {
      $dv += substr($numero,$i,1)*(($i<4)?(5-$i):(13-$i));
   }
   $dv = ($dv*10)%11;;
   $dv1 = right($dv,1);
   $dv_informado = right($numero,2);
   $numero = left($numero,12).$dv1;
   $dv = 0;
   for ($i=0;$i<=12;++$i) {
      $dv += substr($numero,$i,1)*(($i<5)?(6-$i):(14-$i));
   }
   $dv = ($dv*10)%11;
   $dv = right($dv,1);
   $dv = $dv1.$dv;
   $cnpj = formata_string($cnpj,"99.999.999/9999-99");
   if ($dv_informado == $dv) return true;
   else return false;
}
/**
 * Formata uma string de acordo com a máscara especificada
 * @global bool fica true caso a string não satisfaça a máscara para formatação (quando o tamanho sem formatação for diferente do definido na máscara)
 * @param string $string string a ser formatada
 * @param string $mascara máscara para formatação
 * @return string string formatada
**/
function formata_string($string,$mascara) { // 028 // 051
   global $formata_string_erro; // 161
   $formata_string_erro = false; // 161
   $mascara = trim($mascara);
   if (strlen(str_replace('9','',$mascara))==0) return zeros($string,strlen($mascara)); // 170
   $fim = strlen($mascara);
   for ($i=0;$i<$fim;++$i) {
      $caracter = substr($mascara,$i,1);
      if (in_array($caracter,array('9','A','a','N','n','X'))) ++$tamanho;
      else $string = str_replace($caracter,'',$string);
   }
   if (!$string) return $string;
   if (strlen($string)!=$tamanho) $formata_string_erro = true; // 161
   $j = 0;
   for ($i=0;$i<$fim;++$i) {
      $caracter = substr($mascara,$i,1);
      if      ($caracter == '9') $nova_string .= $string[$j++];
      else if ($caracter == 'A') $nova_string .= strtoupper($string[$j++]);
      else if ($caracter == 'a') $nova_string .= strtolower($string[$j++]);
      else if ($caracter == 'N') $nova_string .= strtoupper($string[$j++]);
      else if ($caracter == 'n') $nova_string .= strtolower($string[$j++]);
      else if ($caracter == 'X') $nova_string .= $string[$j++];
      else $nova_string .= $caracter;
   }
   return $nova_string;
}
/**
 * Valida uma string de acordo com a máscara especificada, por meio de expressão regular
 * @param string $string string a ser validada
 * @param string $mascara máscara para validação
 * @return bool true se válido e false se inválido
**/
function valida_string($string,$mascara) {  // 051
   $mascara = trim($mascara);
   $fim = strlen($mascara);
   for ($i=0;$i<$fim;++$i) {
      $caracter = substr($mascara,$i,1);
      if      ($caracter == '9') $er .= "[0-9]";
      else if ($caracter == 'A') $er .= "[A-Z]";
      else if ($caracter == 'a') $er .= "[a-z]";
      else if ($caracter == 'N') $er .= "[A-Z0-9]";
      else if ($caracter == 'n') $er .= "[a-z0-9]";
      else if ($caracter == 'X') $er .= ".";
      else                       $er .= "[".$caracter."]";
   }
   return (ereg($er,$string));
}

/**         
 * Exibe mensagem de alerta em javascript
 * @param string $alerta mensagem a ser exibida
 * @param bool $aguarde_on se true, liga o aguarde do sistema após exibir a mensagem
 * @return bool
**/
function alerta($alerta,$aguarde_on=0) { // 117
   $alerta = str_replace("\"","'",$alerta); // 063
   $alerta = str_replace(chr(10),'\n',$alerta); // 063
   // 205
   if (!$GLOBALS['_SERVER']['DOCUMENT_ROOT']) echo $alerta;
   else {
      $script = "<SCRIPT>\n"
              . "    var script_carregado;\n" // 052 // 064
              . "    if (script_carregado) aguarde_off();\n" // 052 // 064
              . "    alert(\"".$alerta."\");\n"
              . ($aguarde_on?"    aguarde();\n":"") // 117
              . "</SCRIPT>\n";
      echo $script;
      flush();
   }
   return true;
}
/**
 * Valida o endereço de e-mail
 * @param string $valor e-mail
 * @return mixed e-mail se válido e false se inválido
**/
function valida_email ($valor) { // 206
   $expressao = "^[_\.0-9a-z-]+@([0-9a-z]+\.)+[a-z]{2,3}$";
   return (!$valor OR !ereg ($expressao, $valor))? FALSE : $valor;
}
/**         
 * Executa um comando em javascript
 * @param string $comando comando para execução
**/
function js($comando) { // 049
   $js  = "\n<SCRIPT>\n"; // 215
   $js .= "$comando";
   $js .= "</SCRIPT>\n";
   echo $js;
}
/**
 * Retira caracteres acentuados de textos
 * @param string $texto texto
 * @return string texto sem acentuação
**/
function tira_acentos($texto) { // 073
   $a = 'áàâãäÁÀÂÃÄéèêëÉÈÊËíìîïÍÌÎÏóòôõöÓÒÔÕÖúùûüÚÙÛÜçÇñÑýÿÝ';
   $b = 'aaaaaAAAAAeeeeEEEEiiiiIIIIoooooOOOOOuuuuUUUUcCnNyyY';
   return strtr($texto,$a,$b);
}    


/**
 * Escreve o valor por extenso
 * @param mixed valor
 * @param boolean monetario 
 * @return string valor por extenso
**/
function extenso_real($valor,$monetario=true) { // 302
   return extenso_numero($valor,$m='M',$monetario); // 303
}
/**
 * Escreve o valor por extenso
 * @param mixed valor
 * @return string valor por extenso
**/
function extenso_numero($valor,$m='M',$monetario=false) { // 240 // 302 // 303
   if (!trim($m)) $m= 'M';
   if (strpos($valor,',')!==false) {
      $valor = str_replace(',','@',$valor);
      $valor = str_replace('.','',$valor);
      $valor = str_replace('@','.',$valor);
   }
   $valor = number_format($valor,2,',','.');
   list($v_inteiro,$v_decimal) = explode(',',$valor);
   // decimais
   if ($monetario) {
      $v_decimal = (int)($v_decimal);
      $decimal = extenso_dezena($v_decimal,$m);
      $decimal.= ($v_decimal?' centavo'.($v_decimal>1?'s':''):'');
   }
   // inteiros
   // centenas - de 100 a 900
   if ($m=='F') $centenas = array(1=>'cento','duzentas','trezentas','quatrocentas','quinhentas','seiscentas','setecentas','oitocentas','novecentas'); // feminino // 303
   else $centenas = array(1=>'cento','duzentos','trezentos','quatrocentos','quinhentos','seiscentos','setecentos','oitocentos','novecentos'); // masculino // 303
   // demais nomeclaturas
   $demais['s'] = array($monetario?'real':'','mil','milhão','bilhão','trilhão'); // singular
   $demais['p'] = array($monetario?'reais':'','mil','milhões','bilhões','trilhões'); // plural
   $v_inteiro = explode('.',$v_inteiro);
   $i=count($v_inteiro)-1;
   $cont=0;
   foreach ($v_inteiro as $v) {
      $v = zeros($v,3);
      $c = (int)(substr($v,0,1));
      $d = (int)(substr($v,1,2));
      $com_e = true;
      if (!$c) {
         if ($d) $com_e = false;
         else {
            $cont++;
            if (!$i and $inteiro) {
               if ($cont>=2) $inteiro.= ' de';
               if ($monetario) $inteiro.= ' reais';
            }
            $i--;
            continue;
         }
      } else if ($c) {
         $cont=0;
         $inteiro.= ($inteiro?' ':'');
         if ($d>0) $inteiro.= $centenas[$c];
         else {
            if ($c>1) $inteiro.= $centenas[$c];
            else $inteiro.= 'cem'; // exceção para 100
            $com_e = false;
         }
      }
      $inteiro.= (($inteiro and $com_e)?' e':'');
      $inteiro.= ' '.extenso_dezena($d,$m);
      $inteiro.= ' '.$demais[($v>1?'p':'s')][$i];
      $i--;
   }
   return trim($inteiro.(($inteiro and $decimal)?' e ':'').($monetario?$decimal:''));
}
/**
 * Escreve o valor por extenso somente dezenas (de 1 a 99)
 * @param mixed valor
 * @return string valor por extenso
**/
function extenso_dezena($v,$s) { // 240 // 302
   // unidades - de 1 - 9
   $sexo['M'] = array(1=>'um','dois','três','quatro','cinco','seis','sete','oito','nove');
   $sexo['F'] = array(1=>'uma','duas','três','quatro','cinco','seis','sete','oito','nove');
   $unidades = $sexo[$s];
   // dezenas_excessao - de 10 a 19
   $dezenas_excessao = array(10=>'dez','onze','doze','treze','quatorze','quinze','dezesseis','dezessete','dezoito','dezenove');
   // dezenas - de 20 a 90
   $dezenas = array(2=>'vinte','trinta','quarenta','cinquenta','sessenta','setenta','oitenta','noventa');
   //
   if (!$v) return '';
   else {
      if ($v<=9) $decimal = $unidades[$v];
      else if ($v<=19) $decimal = $dezenas_excessao[$v];
      else {
         $d = (int)(substr($v,0,1));
         $u = (int)(substr($v,1,1));
         $decimal = $dezenas[$d];
         if ($u) $decimal.= ' e '.$unidades[$u];
      }
   }
   return $decimal;
}

function envia_email($email_origem,$email_destino,$assunto,$mensagem,$html=false,$anexos=array()) { // 258
   $delimitador_area = md5(time()); // delimitador de cabeçalhos do e-mail
   // cabeçalho
   $cabecalho = array();
   $cabecalho[] = 'From: '.$email_origem;
   $cabecalho[] = 'X-Sender: '.$email_origem;
   $cabecalho[] = 'X-Mailer: PHP v'.phpversion();
   $cabecalho[] = 'X-Priority: 1'; // mensagem urgente
   $cabecalho[] = 'Return-Path: '.$email_origem; // retorno em caso de erro
   $cabecalho[] = 'MIME-Version: 1.0';
   $cabecalho[] = 'Content-Type: multipart/mixed; boundary="'.$delimitador_area.'"';
   $cabecalho[] = ''; // precisa gerar mais uma quebra de linha, senão dá erro
   // mensagem
   $msg = array();
   // 1ª parte do e-mail
   $msg[] = '--'.$delimitador_area;
   $delimitador_texto = $delimitador_area.'_htmlalt'; // delimitador de cabeçalho do corpo do e-mail (diferente do delimitador principal)
   // configuração do corpo do e-mail para texto simples ou html
   $msg[] = 'Content-Type: multipart/alternative; boundary="'.$delimitador_texto.'"';
   $msg[] = ''; // precisa gerar mais uma quebra de linha, senão dá erro
   // 269
   if ($html) {
      // texto html
      $msg[] = '--'.$delimitador_texto;
      $msg[] = 'Content-Type: text/html; charset=iso-8859-1';
      $msg[] = 'Content-Transfer-Encoding: 8bit';
      $msg[] = ''; // precisa gerar mais uma quebra de linha, senão dá erro
      $msg[] = $mensagem;
      $msg[] = ''; // precisa gerar mais uma quebra de linha, senão dá erro
   } else {
      // texto simples
      $msg[] = '--'.$delimitador_texto;
      $msg[] = 'Content-Type: text/plain; charset=iso-8859-1';
      $msg[] = 'Content-Transfer-Encoding: 8bit';
      $msg[] = ''; // precisa gerar mais uma quebra de linha, senão dá erro
      $msg[] = strip_tags(eregi_replace('<br>',"\n",$mensagem));
      $msg[] = ''; // precisa gerar mais uma quebra de linha, senão dá erro
   }
   // fecha a parte do corpo do e-mail para texto simples ou html
   $msg[] = '--'.$delimitador_texto.'--';
   $msg[] = ''; // precisa gerar mais uma quebra de linha, senão dá erro
   // anexos
   if ($anexos) {
      foreach ($anexos as $arquivo) {
         if (is_file($arquivo)) {
            // pega conteúdo binário do arquivo a ser anexado
            $a = fopen($arquivo,'rb');
            $conteudo = fread($a,filesize($arquivo));
            fclose($a);
            $conteudo = chunk_split(base64_encode($conteudo));
            // inclui o anexo no e-mail
            $msg[] = '--'.$delimitador_area;
            $msg[] = 'Content-Type: '.mime_content_type($arquivo).'; name="'.basename($arquivo).'"';
            $msg[] = 'Content-Transfer-Encoding: base64';
            $msg[] = 'Content-Description: '.basename($arquivo);
            $msg[] = 'Content-Disposition: attachment; filename="'.basename($arquivo).'"';
            $msg[] = ''; // precisa gerar mais uma quebra de linha, senão dá erro
            $msg[] = $conteudo;
            $msg[] = ''; // precisa gerar mais uma quebra de linha, senão dá erro
         }
      }
   }
   // fim da 1ª parte do e-mail
   $msg[] = '--'.$delimitador_area.'--';
   $msg[] = ''; // precisa gerar mais uma quebra de linha, senão dá erro
   // envia o e-mail
   return mail($email_destino,$assunto,implode("\r\n",$msg),implode("\r\n",$cabecalho));
}

/**
 * Exclui o registro da tabela através do id e rowid setado no formulário
 * @param string $tabela tabela para acesso no banco de dados
 * @return string mensagem de erro caso o registro não seja encontrado no banco de dados
**/
function exclui_registro($tabela) { // 019 // 021
   global $db,$OP_EXCLUIR;
   $db2=$db;
   $self = $GLOBALS['PHP_SELF']; // 021
   if ($GLOBALS['id']) {
      // Valida se registro não foi alterado ou excluido
      if (!$erro) {
         $sql = "DELETE FROM $tabela WHERE id = '" .$GLOBALS['id']. "'";
         $db2->exec($sql);
         $erro .= $db2->erro(); // 142
      }
   } else $erro .= "Você deve escolher um registro para excluir!";
   return $erro;
}
/**
 * Desativa o registro da tabela através do id e rowid setado no formulário
 * @param string $tabela tabela para acesso no banco de dados
 * @return string mensagem de erro caso o registro não seja encontrado no banco de dados
**/
function desativa_registro($tabela) {
   global $db,$OP_EXCLUIR;
   $db2=$db;
   $self = $GLOBALS['PHP_SELF']; // 021
   if ($GLOBALS['id']) {
      // Valida se registro não foi alterado ou excluido
      if (!$erro) {
         $sql = "UPDATE $tabela SET ativo = 0 WHERE id = '" .$GLOBALS['id']. "'";
         $db2->exec($sql);
         $erro .= $db2->erro();
      }
   } else $erro .= "Você deve escolher um registro para excluir!";
   return $erro;
}

/**
 * Insere ou atualiza o registro da tabela usando as informações dos campos do formulário (se tiver ID e ROWID faz UPDATE senão faz INSERT)
 * @param string $tabela tabela para acesso no banco de dados
 * @param string $campos campos da tabela para montagem do comando sql de INSERT ou UPDATE
 * @param bool $post_vars se verdadeiro, usa os valores POST dos campos, senão usa os valores de $GLOBALS
 * @param string $inicio_validade data utilizada para tratamento de registros de histórico
 * @return string mensagem de erro referente à operação realizada no banco de dados
**/
function gravar_dados($tabela,$campos,$post_vars=true,$inicio_validade='') { // 019 // 021
   global $db,$OP_NOVO,$OP_GRAVAR,$OP_ALTERAR,$campo1,$campo2,$campo3,$enviar_ao_mudar; // 212
   $db2 = $db;
   $self = $GLOBALS['PHP_SELF'];
   if ($post_vars) {
      foreach ($GLOBALS['_POST'] as $campo=>$valor) {
         $campos_editados[$campo] = $valor;
      }
   } else {
      foreach($campos as $valor) {
         $campos_editados[$valor] = $GLOBALS[$valor];
      }
   }
   $campos_tabela = $db2->fields($tabela);
   // inclui o usuario automaticamente se não existir 
   if (in_array('usuario',$campos_tabela)) {
      if (!in_array('usuario',$campos)) $campos[] = 'usuario';
      if (!array_key_exists("usuario",$campos_editados) or !$campos_editados['usuario']) $campos_editados['usuario'] = $GLOBALS['usuario'] = $GLOBALS[id_usuario];
   }
   // inclui o data_hora automaticamente se não existir
   if (in_array('data_hora',$campos_tabela)) {
      if (!in_array('data_hora',$campos)) $campos[] = 'data_hora';
      if (!array_key_exists("data_hora",$campos_editados) or !$campos_editados['data_hora']) $campos_editados['data_hora'] = $GLOBALS['data_hora'] = hoje()." ".hora();
   }
   // Se tiver ID então é UPDATE e não INSERT
   if ($GLOBALS['id']) { // UPDATE
      // Relacao de campos e valores a serem setados
      $virgula = "";
      foreach ($campos_editados as $campo => $valor) {
         if (in_array($campo,$campos)) {
            if (strlen($GLOBALS[$campo])) $set.= $virgula.$campo."='".$GLOBALS[$campo]."'";
            else if ($GLOBALS[$campo]===0) $values.= $virgula.$GLOBALS[$campo];
            else if ($GLOBALS[$campo]==='0') $values.= $virgula.$GLOBALS[$campo];
            else $set.= $virgula.$campo."=NULL";
            if (!$virgula) $virgula = ",";
         }
      }
      //$rowid = rowid(); // 025
      $sql = "UPDATE $tabela SET $set ";
      $sql.= " WHERE id = '" . $GLOBALS['id'] . "' ";
      $db2->exec($sql);
      $erro.= $db2->erro();
      if (!$erro and $db2->affected_rows()==0) $erro = vermelho("<B>Este registro acaba de ser alterado ou excluido! Por favor, faça nova pesquisa!</B>");
   } else { // INSERT
      // busca valores default para tabela 
      $sql = "SELECT a.attname "
              ."FROM pg_class c "
                 .", pg_attribute a "
                 .", pg_attrdef d "
             ."WHERE c.oid = a.attrelid "
               ."AND c.oid  = d.adrelid "
               ."AND c.relname = '$tabela' "
               ."AND a.attnum = d.adnum "
               ."AND a.attnum >= 0 "
      ;
      $db->exec($sql);
      $defus = array();
      if ($db->numrows()) {
         while ($db->fetch('a')) $defus[$db->r['attname']] = $db->r['attname'];
      }
      // Relacao de campos a serem gravadas (somente com valores)
      $virgula = "";
      foreach ($campos_editados as $campo => $valor) {
         if (in_array($campo,$campos) and isset($GLOBALS[$campo])) {
            // 192
            if ($GLOBALS[$campo]) {
               $campos_aux .= $virgula.$campo; 
               $values.= $virgula."'".$GLOBALS[$campo]."'";
            } else if ($GLOBALS[$campo]===0) {
               $campos_aux .= $virgula.$campo; 
               $values.= $virgula.$GLOBALS[$campo];
            } else if ($GLOBALS[$campo]==='0') {
               $campos_aux .= $virgula.$campo; 
               $values.= $virgula.$GLOBALS[$campo];
            } else if (!$defus[$campo]) {
               $campos_aux .= $virgula.$campo;
               $values.= $virgula."NULL";
            }
            if (!$virgula) $virgula = ",";
         }
      }
      // Gera um rowid unico para o registro
      $sql = "INSERT INTO $tabela ";
      $sql.= "(" .$campos_aux .")";
      $sql.= " VALUES (" .$values .")";
      //echos($sql);
      $db2->exec($sql);
      $erro .= $db2->erro(); // 142
   }
   return $erro;
}

function busca_dados_usuario($tabela,$campos_tabela) {
   global $id_usuario, $db;


   $sql = "SELECT id "
              .", ".implode(",",$campos_tabela)." "
           ."FROM $tabela "
          ."WHERE usuario = $id_usuario "
   ;
   $db->exec($sql);
   $db->fetch('a');
   return $db->r;
}

function busca_dados_id($tabela,$campos_tabela) {
   global $id, $db;


   $sql = "SELECT id "
              .", ".implode(",",$campos_tabela)." "
           ."FROM $tabela "
          ."WHERE id = $id "
   ;
   $db->exec($sql);
   $db->fetch('a');
   return $db->r;
}

function string_na_lista($str,$lista) { // 119
   return (in_array ($str, explode(',',$lista)));
}

/**
* Valida se um valor é numérico e caso seja retorna-o formatado
* @param float $valor valor a ser formatado
* @param integer $decimais quantide de casas decimais para formatação do valor
* @param bool $branco_qdo_zero define se retorna zero ou vazio quando não houver valor
* @return mixed false ou valor formatado
**/
function vrok(&$valor,$decimais=0,$branco_qdo_zero=false) {
   $valor_aux = trim($valor);
   $pospto = strpos($valor_aux,'.');
   if ($pospto===false and strpos($valor_aux,',')==strrpos($valor_aux,',')) $valor_aux = str_replace(',','.',$valor_aux);
   if (!$valor_aux) $valor_aux = 0.0;
   if (!is_numeric($valor_aux)) {
      $valor_aux = str_replace(',','.',str_replace('.','',$valor_aux)); // 299
      if (!is_numeric($valor_aux)) return false;
   }
   if ($branco_qdo_zero and $valor_aux==0) return ''; // 075
   $valor_aux = round($valor_aux,10); // previne por exemplo $a = (float) -5.5511151231258E-17; que é zero  // 105
   $valor_aux = number_format($valor_aux,$decimais,'.','');
   // previne o retorno de -0.0000.... // 105
   $aux = str_replace("0","",$valor_aux);
   if ($aux == "-.") $valor_aux = str_replace("-","",$valor_aux);
   $valor = $valor_aux;
   return $valor;
}
