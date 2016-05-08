<?php
class db {
   var $host = 'localhost';
   var $banco = 'teste';
   var $usuario = 'root';
   var $senha = '';
   var $r = array();
   var $id_conectar = false;
   var $id_query = false;
   var $erro=false;
   var $sgbd = 'mysql'; // tipo do banco: postgresql ou mysql
   var $posicao = 0;
   function erro($msg='') {
      if ($msg) {
         $aux = addslashes(trim(str_replace("\n","",$msg)));
         $this->erro=$msg;
      }
      return $this->erro;
   }
   function conectar() {
      global $desenvolvimento;
      if ($this->sgbd=='mysql') {
         $this->id_conectar = @mysql_connect($this->host, $this->usuario, $this->senha, true);
		 mysql_set_charset('utf8',$this->id_conectar);
         @mysql_select_db($this->banco);
      } else if ($this->sgbd=='postgresql') {
         if (!$GLOBALS['tty']) $GLOBALS['tty']=1;
         else $GLOBALS['tty']++;
         $aux = 'host='.$this->host.' dbname='.$this->banco;
         if ($this->usuario) $aux.=' user='.$this->usuario;
         if ($this->senha) $aux.=' password='.$this->senha;
         $aux.=' tty='.$GLOBALS['tty'];
         $this->id_conectar = @pg_connect($aux);
      }
      if (!$this->id_conectar) {
         $erro = 'Erro ao conectar ao banco de dados';
         $erros_sql['erro_bd'] = $erro;
         $erros_sql['sql'] = "mysql_connect($this->host, $this->usuario, $this->senha, true)";
         $erros_sql['programa'] = basename($GLOBALS['PHP_SELF']);
         $erros_sql['evento_id'] = '';
         if ($desenvolvimento) echos($erro);
         else {
            echo $erro;
         }
        exit;
      }
   }
   function exec($sql) {
      global $erros_sql,$desenvolvimento;
      //echo br().$sql;
      if (!$this->id_conectar) $this->conectar();
      if ($this->sgbd=='mysql') {
         $this->id_query = @mysql_query($sql);
         $this->erro(@mysql_error($this->id_conectar));
      } else if ($this->sgbd=='postgresql') {
         $this->posicao = 0;
         $sql = "SET DATESTYLE TO 'SQL,European'; SET TIMEZONE TO 'UTC'; SET CLIENT_ENCODING TO 'LATIN1'; ".$sql;
         $this->id_query = @pg_query($this->id_conectar,$sql);
         $this->erro(@pg_last_error($this->id_conectar));
      }
      if ($this->erro) {
         $erros_sql['erro_bd'] = $this->erro;
         $erros_sql['sql'] = $sql;
         $erros_sql['programa'] = basename($GLOBALS['PHP_SELF']);
         $erros_sql['data_hora'] = date('d/m/Y - H:i:s');
         $erros_sql['evento_id'] = $evento_id;
         if ($desenvolvimento) echos($sql,$this->erro);
      }
      return $this->erro;
   }
   function fetch($type='A') {
      if ($this->sgbd=='mysql') {
         $result_types = array('A'=>MYSQL_ASSOC,'N'=>MYSQL_NUM,'B'=>MYSQL_BOTH,'a'=>MYSQL_ASSOC,'n'=>MYSQL_NUM,'b'=>MYSQL_BOTH);
         $this->r = @mysql_fetch_array($this->id_query,$result_types[$type]);
      } else if ($this->sgbd=='postgresql') {
         if ($this->posicao>$this->numrows()) {
            $this->r = array();
            return false;
         }
         $result_types = array('A'=>PGSQL_ASSOC,'N'=>PGSQL_NUM,'B'=>PGSQL_BOTH,'a'=>PGSQL_ASSOC,'n'=>PGSQL_NUM,'b'=>PGSQL_BOTH);
         $this->r = @pg_fetch_array($this->id_query,$this->posicao,$result_types[$type]);
         $this->posicao++;
      }
      if ($this->r) return true;
      else return false;
   }
   function numrows() {
      if ($this->sgbd=='mysql') return @mysql_num_rows($this->id_query);
      else if ($this->sgbd=='postgresql') return @pg_num_rows($this->id_query);
   }
   function begin() {
      $this->erro = false;
      if ($this->sgbd=='postgresql') return $this->exec("BEGIN;");
      else if ($this->sgbd=='mysql') return $this->exec("START TRANSACTION;");
   }
   function commit() {
      $this->erro = false;
      return $this->exec("COMMIT;");
   }
   function rollback() {
      $this->erro = false;
      return $this->exec("ROLLBACK;");
   }
   function free_result() {
      if ($this->sgbd=='mysql') return @mysql_free_result($this->id_query);
      else if ($this->sgbd=='postgresql') return @pg_free_result($this->id_query);
   }
   function registros_afetados() {
      if ($this->sgbd=='mysql') return @mysql_affected_rows($this->id_conectar);
      else if ($this->sgbd=='postgresql') return @pg_affected_rows($this->id_query);
   }
   /**
    * Retorna um array com os nomes dos campos de uma tabela, cujo índice é tambem o próprio campo
    * @param string $tabela nome da tabela
    * @param bool $com_id_rowid define se traz os campos id e rowid
    * @return array campos da tabela
    * @deprecated mantido por compatibilidade - deve-se utilizar o método fields() desta classe
   */
   function campos($tabela,$com_id_rowid=true) { return $this->fields($tabela,$com_id_rowid); } // 013
   /**
    * Retorna um array com os nomes dos campos de uma tabela, cujo índice é tambem o próprio campo
    * @param string $tabela nome da tabela
    * @param bool $com_id_rowid define se traz os campos id e rowid
    * @return array campos da tabela
   */
   function fields($tabela,$com_id_rowid=true) { // 004 // 013
      if (strpos($tabela,'.')!==false) { // 037 // 039
         $aux = explode('.',$tabela);
         $schema = $aux[0];
         $tabela = $aux[1];
      } else {
         $sql = "SELECT relname "
                 ."FROM pg_class "
                ."WHERE relname = 'pg_namespace' "
         ;
         $this->exec($sql);
         if ($this->numrows()) {
            $sql = "SHOW search_path";
            $this->exec($sql);
            $this->fetch(n);
            $aux = explode(',',$this->r[0]); // 051 // 086
            $schema = $aux[1]; // 086
         }
      }
      if ($schema) {
         $sql_aux = "AND pg_class.relnamespace IN ( SELECT oid "
                                                    ."FROM pg_namespace "
                                                   ."WHERE nspname = '$schema') "
         ;
      }
      // ATENCAO FAVOR NAO APAGAR!
      // o sql comentado abaixo traz mais campos mas nao na ordem do banco
      // por isso o sql foi mudado
      // $sql = "SELECT attname AS field, typname AS type, atttypmod-4 as length, NOT attnotnull AS \"null\", adsrc AS def FROM pg_attribute, pg_class, pg_type, pg_attrdef WHERE pg_class.oid=attrelid AND pg_type.oid=atttypid AND attnum>0 AND pg_class.oid=adrelid AND adnum=attnum AND atthasdef='t' AND relname='$tabela' UNION SELECT attname AS field, typname AS type, atttypmod-4 as length, NOT attnotnull AS \"null\", '' AS def FROM pg_attribute, pg_class, pg_type WHERE pg_class.oid=attrelid AND pg_type.oid=atttypid AND attnum>0 AND atthasdef='f' AND relname='$tabela'";
      $sql = "SELECT pg_attribute.attname AS field "
                 .", pg_type.typname AS type "
                 .", pg_attribute.atttypmod-4 as length "
              ."FROM pg_attribute "
                 .", pg_class "
                 .", pg_type "
             ."WHERE pg_class.oid=attrelid "
               ."AND pg_type.oid=atttypid "
               ."AND pg_attribute.attnum > 0 "
               ."AND pg_attribute.attisdropped IS FALSE " // 047 // 048
               ."AND pg_class.relname='$tabela' "
               .$sql_aux;
      $sql.= "ORDER BY pg_attribute.attnum ";
      $this->exec($sql);
      while ($this->fetch('a')) $campos[$this->r['field']] = $this->r['field'];
      if (!$com_id_rowid) unset($campos['id'],$campos['rowid']); // 073
      return $campos;
   }
   /*
   * Retorna o número de registros afetados pelo comando sql (INSERT, DELETE ou UPDATE)
   * return integer quantidade de registros
   **/
   function affected_rows() { // 015
      return @pg_affected_rows($this->id_query);
   }


}
// gera um rowid
function rowid() {
   $aux = gettimeofday();
   return date('YmdHis').$aux['usec'];
}
?>
