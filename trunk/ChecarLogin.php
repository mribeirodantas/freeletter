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

$db_handle = pg_connect("dbname = $db user=$user password=$pass host=$host");
if (!($db_handle)) {
  echo "\nYou're trying to establish a connection ";
  echo "to a database, but your connection attempt failed.<br>";
  echo pg_errormessage($db_handle);
  exit(1);
}

// vai verificar se o login e senha "batem"
if(!eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$", trim($_POST[email]))) {

  echo "\nYou're trying to insert an invalid e-mail adress.";

  exit(1);

}
$query = "SELECT id, nome, email, nivel, senha FROM usuario WHERE email='{$_POST['email']}' AND senha='{$_POST['senha']}' AND nivel=3";
$result = pg_exec($db_handle, $query);
if (!($result)) {
  $msg = "Erro. Houve um erro ao tentar logar.";
  $msg .= "\n";
  $msg .= pg_errormessage($db_handle);
}
$nivel = pg_fetch_array($result, NULL, PGSQL_ASSOC);

// verifica o resultado
if(pg_numrows($result) > 0) { 
	$_SESSION[login] = $nivel["nome"];
	$_SESSION[email] = $nivel["email"];
	$_SESSION[id] = $nivel["id"];
	$_SESSION[nivel] = $nivel["nivel"]; 
	$msg = "Login efetuado com sucesso.";
} else {
  $msg = "Usuario ou senha errado.";
}

// fecha a conexao com o pgsql
pg_close($db_handle);
?>
<html>
<head>
<meta http-equiv="refresh" content="5; URL=Principal.php">
<font color="#990000" size="2" face="verdana"><strong> <?=$msg ?> </strong></font>
</head>
</html>
