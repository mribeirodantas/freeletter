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

// pega os dados do usu�rio
$select = pg_query($db_handle, "SELECT id, nome, email, nivel, senha FROM usuario WHERE id='{$_GET[id]}'");
$dados = pg_fetch_array($select, NULL, PGSQL_ASSOC);
pg_free_result($select);
pg_close();
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF8">
</head>

<body>
<form action="ModificandoUser.php" method="post">
  <table width="58%" border="0" cellpadding="1" cellspacing="1" vspace="1">
    <tr> 
      <td height="22"><div align="left"><font color="#990000" size="2" face="verdana"><strong>Modificar 
          User </strong></font></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td width="33%" height="22"> <div align="left"><font size="1" face="verdana">Nome 
          do usu&aacute;rio:</font></div></td>
      <td width="67%"><input name="nome" type="text" id="nome" style="font-family: Verdana; font-size: 8 pt; border-style: solid; border-width: 1; padding: 1" value="<?=$dados["nome"];?>"></td>
    </tr>
    <tr> 
      <td height="22"><font size="1" face="verdana">E-mail do usu&aacute;rio:</font></td>
      <td><input disabled name="email" type="text" id="email" style="font-family: Verdana; font-size: 8 pt; border-style: solid; border-width: 1; padding: 1" value="<?=$dados["email"];?>"></td>
    </tr>
    <tr> 
      <td height="22"><font size="1" face="verdana">N&iacute;vel do usu&aacute;rio:</font></td>
      <td><select name="nivel" size="1" id="nivel" style="font-family: Verdana; font-size: 8 pt; border-style: solid; border-width: 1; padding: 1">
          <option value="1" <? if($dados["nivel"] == 1){ echo "selected"; }?>>User Comum</option>
          <option value="3" <? if($dados["nivel"] == 3){ echo "selected"; }?>>Administrador</option>
        </select></td>
    </tr>
    <tr> 
      <td height="21"><font size="1" face="verdana">*Senha do usu&aacute;rio:</font></td>
      <td><input name="senha" type="password" id="senha" style="font-family: Verdana; font-size: 8 pt; border-style: solid; border-width: 1; padding: 1" value="<?=$dados["senha"];?>"></td>
    </tr>
    <tr> 
      <td height="22">&nbsp;</td>
	  <input type="hidden" name="id" value="<?=$_GET[id];?>">
      <td><input type="submit" name="Submit" value="Modificar"></td>
    </tr>
    <tr> 
      <td height="22">&nbsp;</td>
      <td><font size="1" face="verdana">* utilizado somente se for Administrador.</font></td>
    </tr>
    <tr>
      <td height="22">&nbsp;</td>
      <td><a href="Principal.php"><font color="#990000" size="1" face="verdana">&lt;&lt; 
        P&aacute;gina Inicial</font></a></td>
    </tr>
  </table>
</form>
</body>
</html>
