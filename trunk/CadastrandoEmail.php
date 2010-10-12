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

$db_handle = pg_connect("dbname = $db user=$user password=$pass host=$host");
if (!($db_handle)) {
  echo "\nYou're trying to establish a connection ";
  echo "to a database, but your connection attempt failed.<br>";
  echo pg_errormessage($db_handle);
  exit(1);
}

$verifica = true;

if($_POST[email] == ""){
	$msg = "Erro. Você deve colocar um e-mail.";
	$verifica = false;
}

if(!eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$", trim($_POST[email]))){
	$msg = "Erro. Você deve colocar um e-mail válido";
	$verifica = false;
}

$select = pg_query($db_handle, "SELECT email FROM usuario WHERE email='{$_POST[email]}'");
if(pg_numrows($select) >= 1){
	$msg = "Erro. Este e-mail já está cadastrado.";
	$verifica = false;
}
pg_free_result($select);

$select = pg_query($db_handle, "SELECT * FROM usuario");
$id = pg_numrows($select);
$id++;
pg_free_result($select);

if($_POST[opcao] == 1){ // adicionar
	if($verifica){
		$insert = pg_query($db_handle, "INSERT INTO usuario VALUES('$id', '{$_POST[nome]}', '{$_POST[email]}', '{$_POST[telefone]}', '1', NULL)");
		if($insert){
			$msg = "Ok. Seu e-mail foi cadastrado com sucesso.";
		}
		else{
			$msg = "Erro. Não foi possível cadastrar seu e-mail. Entre em contato com o administrador do site.";
		}
	}
}
else{ // deletar
	$select = pg_query($db_handle, "SELECT id FROM usuario WHERE nome='{$_POST[nome]}' AND email='{$_POST[email]}' AND telefone='{$_POST[telefone]}' AND nivel=1");
	if(pg_numrows($select) == 0){
		$msg = "Erro. O nome, e-mail e telefone não foram encontrado. Digite o nome e e-mail iguais ao do cadastro.";
	}
	else{
		$delete = pg_query($db_handle, "DELETE FROM usuario WHERE nome='{$_POST[nome]}' AND email='{$_POST[email]}' AND telefone='{$_POST[telefone]}' AND nivel=1");
		if($delete){
			$msg = "Ok. Seu email foi deletado com sucesso. Nome: {$_POST[nome]}. E-mail: {$_POST[email]}. Telefone: {$_POST[telefone]}";
		}
		else{
			$msg = "Erro. Não foi possível deletar seu e-mail. Entre em contato com o administrador do site.";
		}
	}
}
?>
<script language="JavaScript">
alert("<?=$msg;?>");
window.location = "javascript:history.go(-1);";
</script>
