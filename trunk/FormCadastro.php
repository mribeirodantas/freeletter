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
session_start();

// verifica se est� logado
logado();
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF8">
</head>

<body>
<form action="CadastrandoEmail.php" method="post">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr> 
      <td width="12%"><font size="1" face="Verdana">Seu Nome:</font></td>
      <td width="88%"><font size="1" face="Verdana"> 
        <input name="nome" type="text" id="nome" style="font-family: Verdana; font-size: 8 pt; border-style: solid; border-width: 1; padding: 1">
        </font></td>
    </tr>
    <tr> 
      <td><font size="1" face="Verdana">Seu E-mail:</font></td>
      <td><font size="1" face="Verdana"> 
        <input name="email" type="text" id="email" style="font-family: Verdana; font-size: 8 pt; border-style: solid; border-width: 1; padding: 1">
        </font></td>
    </tr>
    <tr> 
      <td><font size="1" face="Verdana">Seu Telefone: </font></td>
      <td><font size="1" face="Verdana">
        <input name="telefone" type="text" id="telefone" size="30"> 
        </font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>        <font size="1" face="Verdana">
        <input name="opcao" type="radio" value="1" checked>
Cadastrar
<input name="opcao" type="radio" value="2">
Deletar 
<input type="submit" name="Submit" value="Submit">
      </font></td>
    </tr>
  </table>
</form>
</body>
</html>
