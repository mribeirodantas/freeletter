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

// pega todos os usu�rios
$select = pg_query($db_handle, "SELECT id, nome, email, nivel FROM usuario ORDER BY nome");

// n�mero de usu�rios a serem exibidos
$lpp = 15; 
// total de usu�rios cadastrados
$total = pg_numrows($select);
// total de p�ginas que precis�o para exibir todos os dados
$paginas = ceil($total / $lpp); 
// se $pagina n�o tiver valor, coloca 0
if(!isset($pagina)) { $pagina = 0; } 
// determina a p�gina inicial
$inicio = $pagina * $lpp; 
// pega novamente os dados
$select = pg_query($db_handle, "SELECT id, nome, email, nivel FROM usuario ORDER BY nome");
if (!($select)) { echo "Erro. \n"; pg_errormessage($db_handle); }
?>
<table width="100%" border="0" cellpadding="1" cellspacing="1" vspace="1">
  <tr> 
    <td width="25%"><font color="#990000" size="2" face="verdana"><strong>Gerenciar 
      Usu&aacute;rios </strong></font></td>
    <td width="35%">&nbsp;</td>
    <td width="40%" height="22"><div align="left"> </div></td>
  </tr>
  <?

// faz o loop
while($dados = pg_fetch_array($select, NULL, PGSQL_ASSOC)) {
	if($dados["nivel"] == 3){
		$color = "990000";
	}
	else{
		$color = "000000";
	}

	?>
	<tr> 
    	<td><font size="1" face="Verdana" color="<?=$color;?>"><?=$dados["nome"];?></font></td>
	    <td><font size="1" face="Verdana" color="<?=$color;?>"><?=$dados["email"];?></font></td>
    	<td height="22"><font size="1" face="Verdana"><font size="1" face="verdana"><strong>[</strong> <a href="ModificarUser.php?id=<?=$dados["id"];?>" target="Meio">Modificar</a> 
      <strong>]</strong> <strong>[</strong> <a href="DeletarUser.php?id=<?=$dados["id"];?>" target="Meio">Deletar</a> 
      <strong>]</strong></font></font></td>
	</tr>
	<?
  }
echo "</table>";
?>
<script for='pag' event='onchange'>
	document.location = "GerenciarUser.php?pagina="+window.pagi.pag.value;
</script>
<?
echo "
<form action='#' method='get' name='pagi'>
	<select name='pag' onChange='MudarPagina();' style=\"font-family: Verdana; font-size: 8 pt; border-style: solid; border-width: 1; padding: 1\">
	";
for($i=0;$i<$paginas;$i++) { // Gera um loop com o link para as p?ginas
      $url = "$PHP_SELF?pagina=$i";
      echo "<option value='$i'"; if($pagina == $i){ echo "selected"; } echo">$i</option>
	";
}
echo "
	</select>
</form>";

pg_close();
?>
