<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Impresi&oacute;n de Movimientos</title>
<style type="text/css">
<!--
.style6 {
	font-size: 12px;
	color: #FFFFFF;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
body { margin:1px 1px 1px 1px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; }
.style8 {
	/*
	font-family: Geneva, Arial, Helvetica, sans-serif;
	*/
	font-size: 10px;
}
.style9 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.style12 {color: #003366}
.style21 {font-size: 10px; font-weight: bold; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style29 {color: #000099; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.Estilo62 {font-size: 11px; font-weight: bold; font-family:Arial, Helvetica, sans-serif; color:#000000; }
.Estilo64 {font-size: 11px}
.Estilo65 {
	font-size: 8px;
	color: #000000;
}
.celda1{ font-weight:bold; font-size:10px;}
.celda2{ font-weight:normal; font-size:10px;}
-->
</style>
</head>

<body>
<?
	$mov=$_GET['mov'];
	//se extraen los datos del movimiento
	include("../../conf/conectarbase.php");
	
	/*echo $sql="SELECT tipo_mov AS tipo, concepto, mov_almacen.almacen AS almacen, tipoalmacen.almacen AS conceptoalmacen,mov_almacen.referencia,mov_almacen.asociado,mov_almacen.observ,mov_almacen.fecha,catprovee.nr
	from mov_almacen,concepmov,tipoalmacen,catprovee
	WHERE mov_almacen.id_mov = '$mov'
	GROUP BY id_mov";*/
	$sql="SELECT mov_almacen.*,concepmov.*,tipoalmacen.* FROM mov_almacen,concepmov,tipoalmacen WHERE (mov_almacen.almacen=tipoalmacen.id_almacen AND mov_almacen.tipo_mov=concepmov.id_concep) AND mov_almacen.id_mov='".$mov."'";
	
	$result=mysql_db_query($sql_inv,$sql);
	while($row=mysql_fetch_array($result)){
		/*$tipo_mov=$row['tipo'];
		$concepto=$row['concepto'];
		$almacen=$row['almacen'];
		$referencia=$row['referencia'];
		$asociado=$row['asociado'];
		$obs=$row['observ'];
		$conceptoalm=$row['conceptoalmacen'];
		$fecha=$row['fecha'];
		$nr=$row['nr'];*/
		/**/
		$id_mov=$row['id_mov'];
		$fecha=$row['fecha'];
		$tipo_mov=$row['tipo_mov'];
		$almacen=$row['almacen'];
		$referencia=$row['referencia'];
		$asociado=$row['asociado'];
		$observ=$row['observ'];
		$id_concep=$row['id_concep'];
		$concepto=$row['concepto'];
		$cuenta=$row['cuenta'];
		$asociado=$row['asociado'];
		$tipo=$row['tipo'];
		$id_almacen=$row['id_almacen'];
		$almacen=$row['almacen'];
		$observ=$row['observ'];
	}





















?>
<br /><table width="98%" border="1" align="center" cellspacing="0" cellpadding="1" style="font-size:10px;">
  <tr style="text-align:center; font-weight:bold; background-color:#666666; color:#FFFFFF;">
    <td colspan="7">VISTA DE IMPRESI&Oacute;N DEL MOVIMIENTO 
        <?=$mov;?>
    </div></td>
  </tr>
  <tr>
    <td colspan="2" >&nbsp;</td>
    <td width="206" class="celda1">Fecha:</td>
    <td class="celda2">&nbsp;<?= $fecha;?></td>
  </tr> 
  <tr>
    <td width="169" class="celda1">Tipo de movimiento</td>
    <td width="292" class="celda2">
      &nbsp;<?= $tipo_mov.".-".$concepto;?>    </td>
    <td class="celda1">Almacen Operado</td>
    <td width="322" class="celda2">&nbsp;<?=$id_almacen." - ".$almacen;?></td>
  </tr>
  <tr>
    <td class="celda1" >Referencia:</td>
    <td class="celda2">
      &nbsp;<?=$referencia ;?>    </td>
    <td class="celda1">Asociado a:</td>
    <td class="celda2">&nbsp;<?=$asociado;?></td>
  </tr>
  <tr>
    <td class="celda1">Observaciones:</td>
    <td colspan="3" class="celda2" >&nbsp;<?=$obser;?></td>
  </tr>
</table>
<p class="Estilo62">&nbsp;</p>
<?
	$sql1="select * from prodxmov where nummov='".$mov."'";
	$result1=mysql_db_query($sql_inv,$sql1);
	
?>
			<div align="left">
			<table width="98%" border="1" cellpadding="2" cellspacing="0" align="center" style="font-size:10px;">
              <tr>
                <td colspan="7" style="text-align:center; font-weight:bold; background-color:#666666; color:#FFFFFF;">PRODUCTOS EN EL MOVIMIENTO <?=$mov;?></td>
              </tr>
              <tr style="text-align:center; font-weight:bold; background-color:#CCCCCC;">
                <td width="18" align="center">ID</td>
                <td width="117" align="center">Clave Producto</td>
                <td width="406" align="center">Producto</td>
                <td width="280" align="center">Especificaci&oacute;n</td>
                <td width="36" align="center">Costo</td>
                <td width="57" align="center">Cantidad</td>
                <td width="54" align="center">Subtotal</td>
              </tr>
              <?
				$total_cantidad=0;
				$total_subtotal=0;
				while($row1=mysql_fetch_array($result1)){
					$sqlInfoProd="select * from catprod where id_prod='".$row1['clave']."'";
					$resultado1=mysql_db_query($sql_inv,$sqlInfoProd);
					$des_prod=mysql_fetch_array($resultado1);
					$i=$i+1;
			  ?>
			  
			  <tr>
                <td align="center"><?=$row1['id_prod'];?></td>
                <td><?=$row1['clave'];?></td>
                <td><?=$des_prod['descripgral'];?></td>
                <td>&nbsp;<?=$des_prod['especificacion'];?></td>
                <td align="right">&nbsp;$<?=number_format($row1['cu'],2,'.',','); ?>&nbsp;</td>
                <td align="right">&nbsp;<?php
					$total_cantidad+=$row1['cantidad'];
					echo $row1['cantidad'];
				?>&nbsp;</td>
                <td align="right">&nbsp;$<?php
					echo number_format($row1['cantidad']*$row1['cu'],2,'.',','); 
					$total_subtotal+=$row1['cantidad']*$row1['cu'];
				?>&nbsp;</td>
              </tr>
              <?
					}
			   ?>
				<tr style="text-align:right; font-weight:bold;">
					<td colspan="5">TOTAL&nbsp;</td>
					<td>&nbsp;<?=$total_cantidad?>&nbsp;</td>
					<td>&nbsp;$<?=number_format($total_subtotal,2,'.',',');?>&nbsp;</td>
				</tr>
			</table>
		</div>	
</body>
</html>
