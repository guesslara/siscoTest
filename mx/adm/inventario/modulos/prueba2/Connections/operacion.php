<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_operacion = "localhost";
$database_operacion = "2013_iqe_operacion";
$username_operacion = "root";
$password_operacion = "xampp";
$operacion = mysql_pconnect($hostname_operacion, $username_operacion, $password_operacion) or trigger_error(mysql_error(),E_USER_ERROR); 
?>