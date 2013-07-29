<?php
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--


-->
</style>
</head>
<body>
<?php include("../menu/menu.php");
	if(!$_POST)
		{				 
?>
  <form id="form1" name="form1" method="post" action="tipo_alm.php">
    <p><table width="346" border="0" align="center" cellspacing="1">
      <tr>
        <td colspan="2" style="background-color:#333333; font-weight:bold; text-align:center; color:#FFFFFF;">Tipo de Almac&eacute;n</td>
      </tr>
      <tr>
        <td width="195" bgcolor="#CCCCCC"><span class="Estilo3">
         <label>Almac&eacute;n</label>
          </span></td>
        <td width="154"><label>
        <input name="almacen" type="text" id="almacen" />
        </label></td>
      </tr>
      <tr>
        <td bgcolor="#CCCCCC" class="Estilo3">Observaciones</td>
        <td><input name="observ" type="text" id="observ" /></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#333333">
          <div align="right">
            <input type="submit" name="Submit" value="Enviar" />
        </div></td>
      </tr>
    </table>
</form>
<?
	}
		else
		{
		include ("../../conf/conectarbase.php");
				$almacen=$_POST["almacen"];
				$almacen=str_replace(" ","_",$almacen);
				
				$observ=$_POST["observ"];
				$sql="INSERT INTO tipoalmacen (almacen, observ) values ('".$almacen."','".$observ."')";
				//echo "<br>$sql";
				//exit();
				mysql_db_query($sql_inv,$sql);
				/* creando almacen para dispersion de productos*/
				//Obteniendo id de almacen
				//$Alm="alm_".$almacen;
				$indice="SELECT LAST_INSERT_ID()";
				//echo $creatabla;
				$result=mysql_db_query($sql_inv,$indice);
				$row=mysql_fetch_array($result);
				$i=$row[0];
				//+++++++++++++++++++++++++++++++++++++++++++++++++++
				$creacampo="ALTER TABLE `catprod` ADD `a_".$i."_".$almacen."` INT NOT NULL DEFAULT '0',ADD `exist_".$i."` FLOAT(1) NOT NULL DEFAULT '0',ADD `trans_".$i."` FLOAT(1) NOT NULL DEFAULT '0'";
				mysql_db_query($sql_inv,$creacampo);
				//echo $creacampo;
				echo "<br><center>Ha sido creado con exito el Almacen.</center>";  
		}
include("../../f.php");	?>
</body> 
</html>