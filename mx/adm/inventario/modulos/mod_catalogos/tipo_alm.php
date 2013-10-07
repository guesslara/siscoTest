<?php
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1);
	include ("../../conf/conectarbase.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">

</style>
</head>
<body>
<?php 
	if(!$_POST){
		//se extrae la informacion de los clientes
		$sqlC="SELECT id_cliente,r_social,n_comercial FROM cat_clientes WHERE activo=1";
		$resC=mysql_query($sqlC,$link);
		
?>
	<form id="form1" name="form1" method="post" action="tipo_alm.php">
		<table width="346" border="0" align="center" cellspacing="1">
			<tr>
				<td colspan="2" style="height: 15px;padding: 5px;border: 1px solid #CCC;background: #F0F0F0;font-size: 12px;">Creaci&oacute;n de Nuevo Almac&eacute;n</td>
			</tr>
			<tr>
				<td width="195" style="height: 15px;padding: 5px;border: 1px solid #CCC;background: #F0F0F0;font-size: 12px;">Almac&eacute;n</td>
				<td width="154"><input name="almacen" type="text" id="almacen" /></td>
			</tr>
			<tr>
				<td width="195" style="height: 15px;padding: 5px;border: 1px solid #CCC;background: #F0F0F0;font-size: 12px;">Cliente</td>
				<td width="154">
					<select name="cboCliente" id="cboCliente" style="height: 25px;padding: 5px;width: 180px;">
						<option value="Seleccionar">Seleccionar...</option>
<?
					while($rowC=mysql_fetch_array($resC)){
?>
						<option value="<?=$rowC["id_cliente"];?>"><?=$rowC["r_social"];?></option>
<?
					}
?>
					</select>
				</td>
			</tr>
			<tr>
				<td style="height: 15px;padding: 5px;border: 1px solid #CCC;background: #F0F0F0;font-size: 12px;">Observaciones</td>
				<td><input name="observ" type="text" id="observ" /></td>
			</tr>
			<tr>
				<td colspan="2"><hr style="background: #666;"></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: right;"><input type="submit" name="Submit" value="Guardar Informaci&oacute;n" /></td>
			</tr>
		</table>
	</form>
<?
	}else{
		
		$almacen=$_POST["almacen"];
		$almacen=str_replace(" ","_",$almacen);
		//modificacion realizada para obtener el nombre del cliente
		$cliente=$_POST["cboCliente"];
		
		$observ=$_POST["observ"];
		$sql="INSERT INTO tipoalmacen (almacen, observ) values ('".$almacen."','".$observ."')";
		//echo "<br>$sql";
		//exit();
		mysql_query($sql,$link);
		/* creando almacen para dispersion de productos*/
		//Obteniendo id de almacen
		//$Alm="alm_".$almacen;
		$indice="SELECT LAST_INSERT_ID()";
		//echo $creatabla;
		$result=mysql_query($indice,$link);
		$row=mysql_fetch_array($result);
		$i=$row[0];
		//modificacion para insertar la relacion del almacen con el cliente
		$sqlC="INSERT INTO almacenCliente(id_almacen,id_cliente) VALUES ('".$row[0]."','".$cliente."')";
		$resC=mysql_query($sqlC,$link);
		if($resC){
			echo "<br>Asociaci&oacute;n Realizada";
		}else{
			echo "<br>Error al Asociar el Almac&eacute;n con el Cliente";
		}
		//+++++++++++++++++++++++++++++++++++++++++++
		$creacampo="ALTER TABLE `catprod` ADD `a_".$i."_".$almacen."` INT NOT NULL DEFAULT '0',ADD `exist_".$i."` FLOAT(1) NOT NULL DEFAULT '0',ADD `trans_".$i."` FLOAT(1) NOT NULL DEFAULT '0'";
		mysql_query($creacampo,$link);
		//echo $creacampo;
		echo "<br>Almac&eacute;n creado con &eacute;xito.";  
	}
?>
</body> 
</html>