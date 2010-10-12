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
<form action="EnviandoNews.php" method="post">
  <table width="100%" border="0" cellpadding="1" cellspacing="1" vspace="1">
    <tr> 
      <td width="29%"><font color="#990000" size="2" face="verdana"><strong>Enviar 
        Newsletter </strong></font></td>
      <td width="49%" height="22"><div align="left"> </div></td>
    </tr>
    <tr> 
      <td valign="top"><font size="1" face="Verdana">Nome do site ou do respons&aacute;vel: </font></td>
      <td height="22"><input name="site" type="text" id="site" style="font-family: Verdana; font-size: 8 pt; border-style: solid; border-width: 1; padding: 1"></td>
    </tr>
    <tr> 
      <td valign="top"><font size="1" face="Verdana">T&iacute;tulo da Newsletter:</font></td>
      <td height="22"><input name="titulo" type="text" id="titulo" style="font-family: Verdana; font-size: 8 pt; border-style: solid; border-width: 1; padding: 1"></td>
    </tr>
    <tr> 
      <td valign="top"><p><font size="1" face="Verdana">Newsletter:<br>
          <br>
          <strong>Ajuda:</strong> <br>
          - Voc&ecirc; pode utilizar c&oacute;digos HTML em sua mensagem.<br>
          <br>
          - Algumas TAGS &uacute;teis:<br>
          %NOME% = substitui pelo nome do usu&aacute;rio<br>
          %EMAIL% = substitui pelo email do usu&aacute;rio<br>
          <br>
          - Coloque o endere&ccedil;o completo de links e imagens.<br>
          (ex: http://www.site.com/img.gif)<br>
          </font></p>
        </td>
      <td height="22" valign="top"><textarea name="mensagem" cols="60" rows="20" id="mensagem" style="font-family: Verdana; font-size: 8 pt; border-style: solid; border-width: 1; padding: 1"></textarea></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td height="22"><input type="submit" name="Submit" value="Enviar Newsletter" style="font-family: Verdana; font-size: 8 pt; border-style: solid; border-width: 1; padding: 1"></td>
    </tr>
  </table>
</form>
</body>
</html>
