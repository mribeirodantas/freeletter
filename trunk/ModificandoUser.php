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

// dá valor verdadeiro para $verifica
$verifica = true;

// verifica se nome está branco
if($_POST[nome] == ""){
	$msg = "Erro. Você deve colocar um nome.";
	$verifica = false;
}

// se a variável $verifica for verdadeira (true)
if($verifica){
	// modifica os dados
	$update = pg_query($db_handle, "UPDATE usuario SET nome='{$_POST[nome]}', nivel='{$_POST[nivel]}', senha='{$_POST[senha]}' WHERE id='{$_POST[id]}'");
	if($update){
		$msg = "Ok. Usuário ".$_POST[nome]." modificado com sucesso.";
	}
	else{
		$msg = "Erro. Não foi possível modificar o usuário ".$_POST[nome].". Contate o administrador.";
	}
}

pg_close();
?>
<script language="JavaScript">
alert("<?=$msg;?>");
window.location = "ModificarUser.php?id=<?=$_POST[id];?>";
</script>
