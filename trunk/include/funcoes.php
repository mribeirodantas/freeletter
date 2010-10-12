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

include "config.php";
// função que verifica se o admin está logado ou não
function logado(){
	if($_SESSION[login] == ""){
		$msg = "Você deve estar logado no sistema para acessar esta área.";
		$url = "login.php";
		?>
		<script language="JavaScript">
		alert("<?=$msg;?>");
		window.location = "<?=$url;?>";
		</script>
		<?
	}
}   
?>
