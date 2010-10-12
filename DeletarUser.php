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

// verifica se está logado
logado();

// faz conexao
$db_handle = pg_connect("dbname = $db user=$user password=$pass host=$host");
if (!($db_handle)) {
  echo "\nYou're trying to establish a connection ";
  echo "to a database, but your connection attempt failed.<br>";
  echo pg_errormessage($db_handle);
  exit(1);
}

// pega os dados do usuário a ser deletado
$select = pg_query($db_handle, "SELECT nome FROM usuario WHERE id='{$_GET[id]}'");
$dados = pg_fetch_array($select, NULL, PGSQL_ASSOC);
pg_free_result($select);

// da valor verdadeiro para $verifica
$verifica = true;

// verifica se o usuário que está sendo deletado não é "ele" mesmo
if($_GET[id] == $_SESSION[id]){
	$msg = "Erro. Você não pode deletar sua própria conta.";
	$verifica = false;
}
if($verifica == true AND "{$_GET[certeza]}" == "sim"){
	$delete = pg_query($db_handle, "DELETE FROM usuario WHERE id='{$_GET[id]}'");
	if($delete){
		$msg = "Ok. O usuário ".$dados["nome"]." foi deletado com sucesso.";
	}
	else{
		$msg = "Erro. O usuário ".$dados["nome"]." não pode ser deletado. Contate o administrador.";
	}
}

if($certeza == "" AND $msg == ""){
	echo "
	<center><font face='verdana' size='2'>Você tem certeza de que deseja deletar o usuário ".$dados["nome"]."?<br>
	<a href='DeletarUser.php?id={$_GET[id]}&certeza=sim'><strong>Sim</strong></a> | <a href='Principal.php'>Não</a>
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
