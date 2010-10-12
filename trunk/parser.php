<?php
/*
####################################################################
#                                                                  #
#  Author:  Marcel Ribeiro Dantas <marcel at ribeirodantas.com.br> #
#  Website: http://www.ribeirodantas.com.br/blog                   #
#  This code is licensed under GNU GPLv3 or any other newer        #
#  version of this license released of your choice (GPLv3+).       #
#                                                                  #
#  A copy of the license can be read in:                           #
#  http://www.gnu.org/licenses/gpl-3.0.txt                         #
#  or in the COPYING file which should follow with this		         #
#  source file one.						                                     #	
#                                                                  #  
####################################################################
*/

include "include/funcoes.php";
include "include/config.php";

$db_handle = pg_connect("dbname =$db user=$user password=$pass host=$host");
if (!($db_handle)) {
  echo "\nYou're trying to establish a connection ";
  echo "to a database, but your connection attempt failed.<br>";
  echo pg_errormessage($db_handle);
  exit(1);
} 

$select = pg_query($db_handle, "SELECT * FROM usuario");
$id = pg_numrows($select);
$id++;
pg_free_result($select);

if (file_exists($filename) && is_readable ($filename)) {
  $file_handle = fopen($filename, "r");
  while (!(feof($file_handle))) {
    $line = fgets($file_handle);
    $content = explode(",", $line);
    foreach ($content as $value) {
    $value = trim($value);
      if ($value != "") {
        $select = pg_query($db_handle, "SELECT email FROM usuario WHERE email='$value'");
	      if(pg_numrows($select) >= 1){
		      echo "<b>Erro. E-mail ".$value." ja esta cadastrado.</b><br>";
		      pg_free_result($select);	
          $msg = "Erro. Nao foi possivel cadastrar todos os e-mails";
	      }
	      else {
          $insert = pg_query($db_handle, "INSERT INTO usuario VALUES(
          '$id', NULL, '$value', NULL, '1', NULL)");
          $id++;
          if ($insert) {
            echo "E-mail ".$value." cadastrado com sucesso.<br>";
            $msg = "Ok. Operacao realizada com sucesso.";
          } else {
            $msg = "Erro. Nao foi possivel cadastrar todos os e-mails";
          }
        }
      }  
    }  
  } 
  fclose($file_handle);
  unlink("new_db.txt");
} else {
    $msg = "O arquivo new_db.txt nao existe ou nao esta com permissao de leitura.";
}
?>
<script language="JavaScript">
alert("<?=$msg;?>");
window.location = "javascript:history.go(-1);";
</script>
