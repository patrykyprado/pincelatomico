<?php 
$host = '177.70.22.184'; // endere�o do seu mysql
$user = 'underweb_pincel'; // usu�rio
$pass = 'CEDTEC2014Pincel'; // senha
$con = mysql_connect($host,$user,$pass); // fun��o de conex�o
$db = 'underweb_pincel'; // nome do banco de dados
mysql_select_db($db,$con) or print mysql_error(); // sele��o do banco de dados
//DELETA TODAS AS CONEX�ES ABERTAS
    $result = mysql_query("SHOW FULL PROCESSLIST");
    $conexoesAbertas = mysql_num_rows($result);
    if ($conexoesAbertas > 20) {
        while ($row=mysql_fetch_array($result)) {
        $process_id=$row["Id"];
            if ($row["Time"] > 200 ) {
                $sql="KILL $process_id";
                mysql_query($sql);
            }
        }
    }
?>