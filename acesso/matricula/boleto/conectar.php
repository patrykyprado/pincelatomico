<?php
/*
*Nome: Sistema de Cadastro 1.0
*Autor: Caio C�sar
*Descri��o: Verifica se e poss�vel conectar ao banco de dado
*/
//nome do servidor
$host = "177.70.22.184";
//nome de usu�rio
$user = "underweb_pincel";
//senha de usu�rio
$senha = "CEDTEC2014Pincel";
//nome do banco de dados
$dbname = "underweb_pincel";

//conectar ao banco de dados
mysql_connect($host, $user, $senha) or die("N�o foi poss�vel conectar-se com o banco de dados.");
//seleciona o banco de dados
mysql_select_db($dbname) or die("N�o foi poss�vel selecionar o banco de dados.");

?>