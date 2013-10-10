<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_prueba2 = "localhost";
$database_prueba2 = "2013_iqe_operacion";
$username_prueba2 = "desarrollo";
$password_prueba2 = "desarrollo";
$prueba2 = mysql_pconnect($hostname_prueba2, $username_prueba2, $password_prueba2) or trigger_error(mysql_error(),E_USER_ERROR); 
?>