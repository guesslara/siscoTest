<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_prueba2 = "localhost";
$database_prueba2 = "prueba";
$username_prueba2 = "root";
$password_prueba2 = "xampp";
$prueba2 = mysql_pconnect($hostname_prueba2, $username_prueba2, $password_prueba2) or trigger_error(mysql_error(),E_USER_ERROR); 
?>