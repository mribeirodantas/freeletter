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

// pega os dados do usu�rio a ser deletado
$select = pg_query($db_handle, "SELECT nome FROM usuario WHERE id='{$_GET[id]}'");
$dados = pg_fetch_array($select, NULL, PGSQL_ASSOC);
pg_free_result($select);

// da valor verdadeiro para $verifica
$verifica = true;

// verifica se o usu�rio que est� sendo deletado n�o � "ele" mesmo
if($_GET[id] == $_SESSION[id]){
	$msg = "Erro. Voc� n�o pode deletar sua pr�pria conta.";
	$verifica = false;
}
if($verifica == true AND "{$_GET[certeza]}" == "sim"){
	$delete = pg_query($db_handle, "DELETE FROM usuario WHERE id='{$_GET[id]}'");
	if($delete){
		$msg = "Ok. O usu�rio ".$dados["nome"]." foi deletado com sucesso.";
	}
	else{
		$msg = "Erro. O usu�rio ".$dados["nome"]." n�o pode ser deletado. Contate o administrador.";
	}
}

if($certeza == "" AND $msg == ""){
	echo "
	<center><font face='verdana' size='2'>Voc� tem certeza de que deseja deletar o usu�rio ".$dados["nome"]."?<br>
	<a href='DeletarUser.php?id={$_GET[id]}&certeza=sim'><strong>Sim</strong></a> | <a href='Principal.php'>N�o</a>
	";
}

if($certeza == "sim" or $msg != ""){
	?>
	<script language="JavaScript">
	alert("<?=$msg;?>");
	window.location = "Principal.php";
	</script>
	<?
}

pg_close();
?>
