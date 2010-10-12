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
#  or in the COPYING file which should follow with this		   #
#  source file one.						   #	
#                                                                  #  
####################################################################
*/

include "include/config.php";
include "include/funcoes.php";

$db_handle = pg_connect("dbname = $db user=$user password=$pass host=$host");
if (!($db_handle)) {
  echo "\nYou're trying to establish a connection ";
  echo "to a database, but your connection attempt failed.<br>";
  echo pg_errormessage($db_handle);
  exit(1);
}
$query =  "CREATE TABLE newsletter (
  id int,
  data varchar(30) ,
  titulo varchar(50) ,
  mensagem text ,
  EnviadaPor varchar(50) ,
  PRIMARY KEY (id)
)";
$result = pg_exec($db_handle, $query);
if (!($result)) {
  echo "The query failed with the following error:<br>\n";
  echo pg_errormessage($db_handle);
  exit(1);
}
$msg = "Tabela newsletter criada.. <br>";

$query =  "CREATE TABLE usuario (
  id int,
  nome varchar(50) ,
  email varchar(150) ,
  telefone varchar(50) ,
  nivel int ,
  senha varchar(40) ,
  PRIMARY KEY (id)
)";
$result = pg_exec($db_handle, $query);
if (!($result)) {
  echo "The query failed with the following error:<br>\n";
  echo pg_errormessage($db_handle);
  exit(1);
}
$msg .= "Tabela usuario criada..<br>";

$query = "INSERT INTO usuario VALUES('1','{$_POST[nome]}','{$_POST[email]}','{$_POST[telefone]}','3','{$_POST[senha]}')" ;
$result = pg_exec($db_handle, $query);
if (!($result)) {
  echo "The query failed with the following error:<br>\n";
  echo pg_errormessage($db_handle);
  exit(1);
}
$msg .= "Usuario administrador criado..<br>";
?>

<html>
<head>
<meta http-equiv="refresh" content="5; URL=index.php">
<font color="#990000" size="2" face="verdana"><strong> <?=$msg ?> </strong></font>
</head>
</html>
