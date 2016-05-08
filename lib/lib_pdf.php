<?php
include_once('lib/fpdf.php');
class pdf extends FPDF {
   var $arquivo; // nome do arquivo em pdf a ser gerado
   // funcao para exibir o cabecalho padrao no pdf
   function Header() {
      $this->SetFont('arial','B',8);
      $margem = ($GLOBALS['margem_esquerda']?$GLOBALS['margem_esquerda']:1.5);
      $this->SetY(1.6);
      $this->SetX(0);
      $largura = $this->w-$margem;
      $aux = ($GLOBALS['titulo_sistema']?$GLOBALS['titulo_sistema']:'Condomínio Simples');
      $this->Cell($largura,0.9,$aux,0,1,'R');
      $y = $this->GetY()-0.2;
      $this->Line($margem,$y,$largura,$y);
      $this->SetX($margem);
   }
   // funcao para exibir o rodape padrao no pdf
   function Footer() {
      $this->SetFont('','I',6); // seta o italico
      $this->SetX(0);
      $this->SetY(($this->PageBreakTrigger+0.5));
      if ($this->AliasNbPages) $p.=' / '.$this->AliasNbPages;
      $aux=($GLOBALS['titulo_sistema']?$GLOBALS['titulo_sistema']:'Condomínio Simples');
      $this->Cell(0,0.4,$aux,0,0,'L');
      $this->Cell(0,0.4,'Pág. '.$this->PageNo().$p,0,1,'R');
   }
   // funcao para exibir o pdf em nova janela
   function exibir() {
      $js="nova_janela('".$this->arquivo."');";
      echo "<script>$js</script>";
   }
   // funcao para verificar se cabem n linhas na pagina do pdf
   function cabe_linhas($n=1) {
      global $salto_linha;
      if ($this->y+($salto_linha*$n)>$this->PageBreakTrigger and !$this->InFooter and $this->AcceptPageBreak()) return false;
      else return true;
   }
   // funcao para limpar o diretorio relatorios
   function limpa_relatorios($dir='relatorios',$arquivo='') {
      $data=date('Ymd',mktime(0,0,0,date('m'),date('d')-1,date('Y'))); // data anterior a data atual
      $d=dir($dir);
      while ($arquivo=$d->read()) {
         $pos=strrpos($arquivo,'_');
         if ($pos>0) {
            $data_arquivo=substr(str_replace('.pdf','',$arquivo),$pos+1,strlen($data));
            if ($data_arquivo<=$data) @unlink($dir.'/'.$arquivo);
         }
      }
      $d->close();
   }
}
?>
