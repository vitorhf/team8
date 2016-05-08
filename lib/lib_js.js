ns = (navigator.appName=="Netscape");
ie = (!ns);
//document.onkeydown = monitora_teclado;
//if (!ie) document.onkeypress = cancela_teclas;
//document.onhelp = function() { return false; }
// Monitora o teclado
/*
function monitora_teclado(e) {
   if (!e) var e = window.event;
   if (e.keyCode) k = e.keyCode;
   else if (e.which) k = e.which;
   if (ie) cancela_teclas(evento);
   var operacao = '';
   if (k == 117 && document.getElementById('btn_excluir')) operacao = 'excluir';
   else if (k == 120 && document.getElementById('btn_limpar')) operacao = 'limpar';
   else if (k == 121 && document.getElementById('btn_gravar')) operacao = 'gravar';
   else if (k == 123 && document.getElementById('btn_relatorio')) operacao = 'relatorio';
   if (operacao) {
      document.forms[0].operacao.value = operacao;
      document.forms[0].submit();
   }
}
function cancela_teclas(evento) {
   if (ie) evento = window.event;
   var k_aux = evento.keyCode;
   // teclas esc e f1 a f12
   if (string_na_lista(k_aux,'27,112,113,114,115,116,117,118,119,120,121,122,123')) {
      if (!ie) evento.preventDefault();
      else {
         evento.keyCode = 0;
         evento.returnValue = false;
      }
   }
}
*/
function string_na_lista(valor,lista) {
   var i;
   var aux = new String(lista);
   aux = aux.split(',');
   for (i in aux) {
      if (aux[i] && valor==aux[i]) return true;
   }
   return false;
}
function loc(complemento) { 
   document.location = document.forms[0].action+complemento;
}
function confirma_exclusao(msg,sim,nao) {
   if (confirm(msg)) {
      location.replace(sim);
   } else if (nao) {
      location.replace(nao);
   }
}
function zeros(valor,qtde) {
   var i;
   if (valor.length<qtde) {
      for (i=0;i<valor.length;i++) {
         if (valor.length<qtde) valor = '0'+valor; 
         else break;
      }
   }
   if (!valor) {
      valor = '';
      for (i=0;i<qtde;i++) valor = '0'+valor;
   }
   return valor;
}
function calcula_horas() {
   var inicio = document.getElementById('inicio');
   var termino = document.getElementById('termino');
   if (inicio.value && termino.value) {
      var i_hora = inicio.value.substr(0,2);
      var i_min = inicio.value.substr(3,2);
      var t_hora = termino.value.substr(0,2);
      var t_min = termino.value.substr(3,2);
      if (i_hora > 23 || i_hora < 0 || t_hora > 23 || t_hora < 0) {
         alert('Hora inv�lida. Digite entre 00 e 23 horas');
      } else if (i_min > 59 || i_min < 0 || t_min > 59 || t_min < 0) {
         alert('Minutos inv�lido. Digite entre 00 e 59 minutos');
      } else if ((t_hora != '00' || t_min != '00') && ((i_hora > t_hora) || (i_hora == t_hora && i_min > t_min))) {
         alert('Hora de in�cio deve ser menor do que hora de t�rmino.');
      } else if (i_hora == t_hora && i_min == t_min) {
         alert('Hora de in�cio igual a hora do t�rmino.');
      } else {
         if (t_hora == '00' && t_min == '00') t_hora = 24;
         // calcula a diferen�a de hor�rio
         var i_segundos, t_segundos, h_total, m_total;
         // in�cio
         i_segundos = i_hora * 3600;
         i_segundos+= i_min * 60;
         // t�rmino
         t_segundos = t_hora * 3600;
         t_segundos+= t_min * 60;
         // total
         h_total = parseInt((t_segundos - i_segundos)/3600);
         m_total = parseInt(((t_segundos - i_segundos)%3600)/60);
         var h_aux = new String(h_total);
         h_aux = zeros(h_aux,2);
         var m_aux = new String(m_total);
         m_aux = zeros(m_aux,2);
         var total = document.getElementById('total');
         total.value = h_aux+':'+m_aux;
      }
   }
}
function formatar_data(campo, mask) {
   if (k != 8 && k != 191 && k !=111 && k !=37 && k !=38 && k !=39 && k !=40){ // backspace e '/'
      var i = campo.value.length;
      var saida = mask.substring(0,1);
      var texto = mask.substring(i)
      if (texto.substring(0,1) != saida) {
         campo.value += texto.substring (0,1);
      }
   }
   if (k==0 && campo.value.length == 10) campo.select();
}

function formatar(src, mask) {
   if (k != 8) { //backspace
      var i = src.value.length;
      var saida = mask.substring(0,1);
      var texto = mask.substring(i)
      if (texto.substring(0,1) != saida) {
         src.value += texto.substring (0,1);
      }
   }
   if (k==0 && src.value.length == mask.length) src.select();
}
function formata_numero(campo,inteiros,decimais) {
   var v, negativo, dec, virgula, pos, inte, ponto, i, a, b;
   v = document.getElementsByName(campo)[0].value.replace(/[^0-9,-\.]/g,'');
   negativo = '';
   if (v.indexOf('-')==0) {
      negativo = '-';
      v = v.substr(1);
   }
   if (v.indexOf('-')!=-1) v = v.replace(/-/g,'');
   dec = '';
   virgula = '';
   if (v.substr(v.length-1,1)=='.') v = v.substr(0,v.length-1)+',';
   if (v.indexOf(',')!=-1) {
      pos = v.indexOf(',');
      dec = v.substr(pos+1,decimais);
      if (decimais>0) virgula = ',';
      v = v.substr(0,pos);
      if (v.length<1) v = '0';
   }
   while (v.indexOf('.')!=-1) v = v.replace(/\./,'');
   if (v.indexOf(',')==-1 && v.length>=inteiros && k!=8) virgula = ',';
   a = 0;
   inte = '';
   for (i=v.length; i>0; i--) {
      if(a>0 && a%3==0) ponto = '.';
      else ponto = '';
      b = v.substr(i-1,1);
      inte = b+ponto+inte;
      a++;
   }
   if (document.getElementsByName(campo)[0].value != negativo+inte+virgula+dec) document.getElementsByName(campo)[0].value = negativo+inte+virgula+dec;
}
function valida_ano(ano) {
   if (ano.value.length == 4) {
      if (!isNaN(ano.value)) {
         document.forms[0].operacao.value = 'ano_alterado';
         document.forms[0].submit();
      } else if (isNaN(ano.value)){
         alert('Ano inv�lido. Digite somente n�meros.');
         return false;
      } 
   }
}
function mostra_div_mensagem(div_id,div_largura,vertical,horizontal,botao_foco) {
   var h, w, o;
   o = document.getElementById(div_id);
   if (o) {
      o = o.style;
      if (!div_largura) {
         if (o.width) div_largura = o.width.replace(/[^0-9]/g,''); // elimina o caracteres n�o num�ricos
         else div_largura = 0;
      }
      if (parent && parent.principal) var t = parent.principal.document.body;
      else var t = ttpd.body;
      w = t.clientWidth-div_largura;
      if (!vertical) o.left = (w/2)+'px';
      else if (vertical=='L') o.left = '10px';
      else if (vertical=='R') o.left = w+'px';
      h = (ns?screen.height:screen.availHeight);
      if (!horizontal) o.top = ((h/2)+t.scrollTop-175)+'px';
      else if (horizontal=='T') o.top = '10px';
      else if (horizontal=='B') o.bottom = '0px';
      o.visibility = 'visible';
      o.zIndex = 11;
      div_transparente(10);
      setTimeout("o = document.getElementById('"+botao_foco+"'); o.focus()",1);
   }
   void 0;
}
function fecha_div_mensagem(div_id,campo_foco) {
   k=0;
   o = document.getElementById(div_id);
   if (o) {
      o = o.style;
      o.top = '-400px';
      o.left = '-400px';
      o.visibility = 'hidden';
      o.zIndex = -400;
      div_transparente(0);
      if (campo_foco) {
         o = document.getElementById(campo_foco);
         if (o) o.focus();
      }
   }
   void 0;
}
function div_transparente(z) {
   var o, w, h, btw, bth;
   o = document.getElementById('div_transparente');
   if (o) {
      if (!z) {
         z = -100;
         o.style.backgroundColor = '';
         w = h = 0;
         btw = bth = 0;
      } else {
         var cor = '#FFFFFF';
         o.style.backgroundColor = cor;
         if (parent && parent.principal) var t = parent.principal.document.body;
         else var t = ttpd.body;
         w = t.scrollWidth;
         var w1 = t.clientWidth;
         w = Math.max(w,w1); // evita problemas no ie
         h = t.scrollHeight;
         var h1 = t.clientHeight;
         h = Math.max(h,h1); // evita problemas no ie
      }
      /*
      o.style.width = w+'px';
      o.style.height = h+'px';
      */
      o.style.width = '100%';
      o.style.height = '100%';
      o.style.zIndex = z;
   }
}
function nova_janela(url,w,h,l,t,nome,sb) {
   if (!sb) sb = 'yes';
   if (!l) l = 0;
   if (!w) w = screen.availWidth-(l*2);
   if (ns) {;
      if (!t) t = (screen.height*22.5/100);
      if (!h) h = screen.height - t;
   } else {
      if (!t) t = 70;
      if (!h) h = screen.availHeight - 100;
      w = w - 10;
   }
   parm = 'left='+l+',top='+t+',width='+w+',height='+h+',scrollbars='+sb+',menubar=no,statusbar=no,location=no';
   if (!nome) nome = (new Date()).getTime();
   win = window.open(url,nome,parm);
   if (win) win.focus();
}
function campos_readonly(lista_campos,flag,atraso_ie) {
   var obj, campos, i, total;
   campos = lista_campos.split(',');
   var aux = '';
   for (i in campos) {
      obj = document.getElementsByName(campos[i]); // ATEN��O: os objs foram buscados pelo nome para tratar radio/checkbox
      total = obj.length;
      for (var j=0;j<total;j++) {
         if (obj[j]) {
            if (flag) obj[j].blur(); // retira o foco do campo, quando for desabilit�-lo
            if (atraso_ie || !ie) {
               if (string_na_lista(obj[j].type,'radio,checkbox,select-one')) obj[j].disabled = (flag?true:false);
               else obj[j].disabled = (flag?true:false);
               if (flag) aux = ((obj[j].className=='input' || obj[j].className=='input_readonly')?'input_readonly':'input_readonly_valor');
               else aux = ((obj[j].className=='input' || obj[j].className=='input_readonly')?'input':'');
               obj[j].className = aux;
            }
         }
      }
   }
   if (ie && !atraso_ie) setTimeout("campos_readonly('"+lista_campos+"',"+(flag?1:0)+",1);",1);
}
function foco(campo) {
   var o = document.getElementById(campo);
   if (o) o.focus();
}
// limpa os campos do formul�rio sem submit
function limpa_campos(lista_campos) {
   var obj, campos, i, total;
   campos = lista_campos.split(',');
   var aux = '';
   for (i in campos) {
      obj = document.getElementsByName(campos[i]); // ATEN��O: os objs foram buscados pelo nome para tratar radio/checkbox
      total = obj.length;
      for (var j=0;j<total;j++) {
         if (obj[j]) {
            // inclui campo e valor na url conforme o tipo do campo
            if (string_na_lista(obj[j].type,'select-one,select-multiple')) {
               for (var j=0;j<obj[j].options.length;j++) obj[j].options[j].selected = false;
            } else if (string_na_lista(obj[j].type,'checkbox,radio')) {
               obj[j].checked = false;
            } else {
               obj[j].value = '';
            }
         }
      }
   }
}
