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

session_start();
include "include/funcoes.php";
include "include/config.php";

// verifica se esta logado
logado();

$db_handle = pg_connect("dbname = $db user=$user password=$pass host=$host");
if (!($db_handle)) {
  echo "\nYou're trying to establish a connection ";
  echo "to a database, but your connection attempt failed.<br>";
  echo pg_errormessage($db_handle);
  exit(1);
}


// da valor verdadeiro para $verifica
$verifica = true;

// verifica se todos os campos foram preenchidos
if($_POST[site] == "" OR $_POST[titulo] == "" OR $_POST[mensagem] == ""){
  $msg = "Erro. Todos os campos devem ser preenchidos para o envio da newsletter.";
  $verifica = false;
}

$select = pg_query($db_handle, "SELECT * FROM newsletter");
$id = pg_numrows($select);
$id++;
pg_free_result($select);

if($verifica){
  // guarda no historico
  $data = date("d/m/Y - H:i:s");
  // modifica o %NOME pelo nome do usu�rio
  $mensagem = str_replace("%NOME%", $dados["nome"], $_POST[mensagem]);
  $mensagem = str_replace("%EMAIL%", $dados["email"], $mensagem);
  $mensagem = wordwrap($mensagem, 130);
  $mensagem = nl2br($mensagem);	   
  $insert = pg_query($db_handle, "INSERT INTO newsletter VALUES ('$id', '$data', '{$_POST[titulo]}', '$mensagem', '{$_SESSION[login]}')"); 
  if ($insert) { echo "Salvo no hist�rico.. \n<br>"; }
  else { echo "Problema na inser��o no hist�rico. \n"; }
  // pega todos os usu�rios para quem vai enviar
  $select = pg_query($db_handle, "SELECT nome, email FROM usuario");
  $contador = 0;
  $min = 0;
  set_time_limit(25);

  while($dados = pg_fetch_array($select, NULL, PGSQL_ASSOC)){
    if ($contador == 20) {
      echo "Dormindo por três minutos... <br>";
      sleep(180); /* Durma por 3 minutos */
      $contador = 0;
      $min++;

      echo "Já se dormiu " . $min*3 . " minutos..<br>";
    }    
    $headers = "MIME-Version: 1.0\n";
/*  $headers .= "From:  {$_POST[site]} <{$_SESSION["email"]}>\n"; */
    $headers .= "From:  {$_POST[site]} <imprensa@novasconquistasufrn.com.br>\n"; 
    $headers .= "Return-Path: {$_POST[site]} <imprensa@novasconquistasufrn.com.br>\n";
    $headers .= "Content-Type: text/html; charset=\"UTF8\"; \n";

    // envia a newsletter              
    $enviar = mail($dados["email"], $_POST[titulo], $mensagem, $headers);
    if($enviar){
      echo "<font face='verdana' size='1'>Ok. Newsletter enviada com sucesso para {$dados["email"]}</font><br>";
      $contador++;
    }
    else{
      echo "<font face='verdana' size='1' color='#990000'>Erro. N�o foi poss�vel enviar a Newsletter para {$dados["email"]}</font><br>";
    }
  }
  echo "<a href='Enviar.php'><font face='verdana' size='1'><< Voltar</font></a>";
}

if($msg != ""){
  ?>
  <script language="JavaScript">
  alert("<?=$msg;?>");
  window.location = "Enviar.php";
  </script>	
  <?
}
?>
