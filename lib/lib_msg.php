<?php
class div_mensagem { 
   var $id;
   var $cabecalho;
   var $campo_foco;
   var $conteudo; 
   var $largura;
   var $altura;
   var $botao_foco;
   function div_mensagem() {
      $this->id = 'div_mensagem_'.rowid();
      $this->largura = 300;
      $this->altura = 90;
      $this->campo_foco = '';
      $this->cabecalho = 'CONFIRMAÇÃO DO USUÁRIO';
   }
   function html() {
      if (substr($this->id,0,11) == 'div_msg_ok_') {
         $acao = "javascript: fecha_div_mensagem('".$this->id."','".$this->campo_foco."'); ";
         $acao.= $this->acao;
         $botao = "<INPUT TYPE=\"button\" ID=\"bt_ok\" VALUE=\"OK\" style=\"WIDTH:100\" ONCLICK=\"$acao\" CLASS=\"botao\">";
      } else {
         $acao = "javascript: fecha_div_mensagem('".$this->id."'); ";
         $acao.= $this->acao_confirmar;
         $botao = "<INPUT TYPE=\"button\" ID=\"bt_confirmar\" VALUE=\"Confirmar\" style=\"WIDTH:100\" ONCLICK=\"$acao\" CLASS=\"botao\">";
         $acao = "javascript: fecha_div_mensagem('".$this->id."'); ";
         $acao.= $this->acao_cancelar;
         $botao.= nbsp()."<INPUT TYPE=\"button\" ID=\"bt_cancelar\" VALUE=\"Cancelar\" style=\"WIDTH:100\" ONCLICK=\"$acao\" CLASS=\"botao\">";
      }
      // tabela
      $dado = array();
      $dados = array();
      $dado['conteudo'] = array( 'align'=>'C'
                               , 'valor'=>br().$this->conteudo.br().$botao.br(2)
                               );
      $dados[] = $dado;
      $cabecalho = array($this->cabecalho);
      $tabela = tabela($dados,0,'100%','tabela_msg','',$cabecalho);
      // html
      $r = "\n<DIV ID='".$this->id."' CLASS='div_msg' STYLE='position:absolute;left:-400px;top:-400px;width:".$this->largura."px;height:".$this->altura."px;z-index:-100;visibility:hidden;'>\n"
         . str_replace("\n",'',$tabela)."\n"
         . "</DIV>\n"
      ;
      return $r;
   }
   function exibir() {
      return "mostra_div_mensagem('".$this->id."','','','','".$this->botao_foco."'); "; 
   }
}
class div_mensagem_confirmar_cancelar extends div_mensagem { 
   var $acao_confirmar;
   var $acao_cancelar;
   function div_mensagem_confirmar_cancelar($msg,$acao_confirmar='',$acao_cancelar='') {
      parent::div_mensagem();
      $this->id = 'div_msg_confirmar_cancelar_'.rowid(); 
      $this->conteudo = $msg.br(2);
      $this->acao_confirmar = $acao_confirmar;
      $this->acao_cancelar = $acao_cancelar;
   }
   function html() {
      echo parent::html();
      return parent::exibir();
   }
}
class div_mensagem_ok extends div_mensagem { 
   var $acao;
   function div_mensagem_ok($msg,$acao='') {
      parent::div_mensagem();
      $this->id = 'div_msg_ok_'.rowid(); 
      $this->conteudo = $msg.br(2);
      $this->acao = $acao;
   }
   function html() {
      echo parent::html(); 
      return parent::exibir();
   }
}
function msg_confirmar_cancelar($msg,$acao_confirmar='',$acao_cancelar='',$campo_foco='', $largura=0) { 
   $e = new div_mensagem_confirmar_cancelar($msg,$acao_confirmar,$acao_cancelar); 
   if ($largura) $e->largura = $largura;
   $e->botao_foco = 'bt_cancelar';
   return $e->html();
}
function msg_ok($msg,$campo_foco='',$largura=0,$cabecalho='',$acao='') { 
   $e = new div_mensagem_ok($msg,$acao); 
   $e->campo_foco = $campo_foco;
   $e->botao_foco = 'bt_ok';
   if ($cabecalho) $e->cabecalho = $cabecalho; 
   if ($largura) $e->largura = $largura;
   return $e->html();
}
?>
