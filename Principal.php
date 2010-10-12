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

// verifica se est� logado
logado();

// faz conexao
$db_handle = pg_connect("dbname = $db user=$user password=$pass host=$host");
if (!($db_handle)) {
  echo "\nYou're trying to establish a connection ";
  echo "to a database, but your connection attempt failed.<br>";
  echo pg_errormessage($db_handle);
  exit(1);
}

// pega o n�mero total de cadastrados
$select = pg_query($db_handle, "SELECT id FROM usuario WHERE nivel=1");
$TCadastrados = pg_numrows($select);
pg_free_result($select);

// pega o total de administradores
$select = pg_query($db_handle, "SELECT id FROM usuario WHERE nivel=3");
$TAdmin = pg_numrows($select);
pg_free_result($select);

// pega o total de newsletter enviadas
$select = pg_query($db_handle, "SELECT id FROM newsletter");
$TNews = pg_numrows($select);
pg_free_result($select);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF8">
</head>

<body>
<font size="2" face="verdana"><strong>Bem vindo <u> 
<?=$_SESSION[login];?>
</u>.</strong> [ <a href="Logout.php" target="Meio"><font color="#990000">Logout</font></a> 
]<br>
<br>
<br>
</font> 
<table width="43%" border="0" cellpadding="1" cellspacing="1" vspace="1">
  <tr> 
    <td height="22"><div align="left"><font color="#990000" size="2" face="verdana"><strong>Estat&iacute;sticas 
        Gerais</strong></font></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td width="77%" height="22"> <div align="left"><font size="1" face="verdana">N&uacute;mero 
        de Usu&aacute;rios:</font></div></td>
    <td width="23%"><font size="1" face="verdana">
      <?=$TCadastrados;?>
      </font></td>
  </tr>
  <tr> 
    <td height="22"><div align="left"><font size="1" face="verdana">N&uacute;mero 
        de Administradores:</font></div></td>
    <td><font size="1" face="verdana">
      <?=$TAdmin;?>
      </font></td>
  </tr>
  <tr>
    <td height="22"><font size="1" face="verdana">Total:</font></td>
    <td><font face="verdana" size="1"><? echo $TTotal = $TCadastrados + $TAdmin; ?></font></td>
  </tr>
  <tr> 
    <td height="22"><div align="left"><font size="1" face="verdana">N&uacute;mero 
        de Newsletters enviadas:</font></div></td>
    <td><font size="1" face="verdana">
      <?=$TNews;?>
      </font></td>
  </tr>
  <tr> 
    <td height="22"><div align="left"></div></td>
    <td><font size="1" face="verdana">&nbsp;
      </font></td>
  </tr>
  
<tr>
    <td height="22"><div align="left"></div></td>
    <td><font size="1" face="verdana">&nbsp;
      </font></td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td height="22"><font color="#990000" size="2" face="verdana"><strong>Ultimos cadastrados</strong></font></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?
  // pega os �ltimos usu�rios cadastrados
  $select = pg_query($db_handle, "SELECT id, nome, email FROM usuario ORDER BY id DESC");
  while($dados = pg_fetch_array($select, NULL, PGSQL_ASSOC)){
  	?>
  	<tr> 
    	<td width="27%" height="22"><font size="1" face="verdana"><?=$dados["nome"];?></font></td>
    	<td width="34%"><font size="1" face="verdana"><?=$dados["email"];?></font></td>
    	
    <td width="39%"><font size="1" face="verdana"><strong>[</strong> <a href="ModificarUser.php?id=<?=$dados["id"];?>" target="Meio">Modificar</a> 
      <strong>]</strong> <strong>[</strong> <a href="DeletarUser.php?id=<?=$dados["id"];?>" target="Meio">Deletar</a> 
      <strong>]</strong></font></td>
  	</tr>
	<?
   	}
	pg_free_result($select);
	pg_close();
   ?>
  <tr> 
    <td height="22">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td height="22">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
