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

session_start();
include "include/funcoes.php";
include "include/config.php";
// verifica se esta logado
logado();

// faz conexao
$db_handle = pg_connect("dbname = $db user=$user password=$pass host=$host");
if (!($db_handle)) {
  echo "\nYou're trying to establish a connection ";
  echo "to a database, but your connection attempt failed.<br>";
  echo pg_errormessage($db_handle);
  exit(1);
}
?>
<table width="96%" border="0" cellpadding="1" cellspacing="1" vspace="1">
  <tr> 
    <td width="29%"><font color="#990000" size="2" face="verdana"><strong>Hist&oacute;rico 
      de Newsletter</strong></font></td>
    <td width="27%" height="22"><div align="left"></div></td>
    <td width="44%">&nbsp;</td>
    <td width="44%">&nbsp;</td>
  </tr>
  <tr> 
    <td width="29%"><font size="2" face="verdana">Data:</font></td>
    <td height="22" width="27%"><font size="2" face="verdana">T&iacute;tulo:</font></td>
    <td width="44%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Mensagem</font></td>
    <td width="44%"><font size="2" face="verdana">Enviada por:</font></td>
  </tr>
  <?
  // pega o histórico
  $select = pg_query($db_handle, "SELECT * FROM newsletter ORDER BY id DESC");
  while($dados = pg_fetch_array($select, NULL, PGSQL_ASSOC)){
  	?>
    <tr> 
    	<td><font size="1" face="verdana"><?=$dados["data"];?></font></td>
    	<td height="22"><font size="1" face="verdana"><?=$dados["titulo"];?></font></td>
    	<td><font size="1" face="verdana">
    	  <?=$dados["mensagem"];?>
    	</font></td>
    	<td><font size="1" face="verdana"><?=$dados["enviadapor"];?></font></td>
    </tr>
   <?
}
pg_free_result($select);
pg_close();
?>
</table>
