<?php 
if ($_POST)
{
	include ("../../conf/conectarbase.php");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	//print_r($_POST);
	$action=$_POST["action"];


	if ($action=="seleccionar_movimiento")
	{ 
		$color=="#D9FFB3";
		$divcoloca=$_POST["div"];
		//echo "<br>Coloca en la mover_productos_$divcoloca <br>";
	
		// sentencia SQL ...
		$sql7="SELECT mov_almacen.*,concepmov.*,tipoalmacen.* FROM mov_almacen,concepmov,tipoalmacen 
		WHERE 
		mov_almacen.almacen=tipoalmacen.id_almacen AND mov_almacen.tipo_mov=concepmov.id_concep"; 
		//limit 0,50
		$result=mysql_query($sql7,$link);  	
		$numeroRegistros=mysql_num_rows($result);
	?>
<table width="95%" border="0" align="center" cellspacing="0" class="tablax">
  <tr>
    <td colspan="6" height="23" style="background-color:#333333; text-align:center; color:#FFFFFF; font-weight:bold;"><?=$numeroRegistros?> MOVIMIENTOS EN EL ALMAC&Eacute;N </td>
  </tr>
  <tr class="campos">
    <td >ID</td>
    <td><a href="<?=$_SERVER["PHP_SELF"]?>?pagina=<?=$pagina?>&orden=concepmov.concepto,mov_almacen.fecha&cri=<?=$cri?>" title="Ordenar por Tipo Movimiento">Tipo Movimiento</a></td>
    <td>Almacen Operado.</td>
    <td>Asociado a: </td>
    <td><a href="<?=$_SERVER["PHP_SELF"]?>?pagina=<?=$pagina?>&orden=mov_almacen.referencia&cri=<?=$cri?>" title="Ordenar por Referencia">Referencia</a></td>
    <td><a href="<?=$_SERVER["PHP_SELF"]?>?pagina=<?=$pagina?>&orden=concepmov.concepto,mov_almacen.fecha&cri=<?=$cri?>" title="Ordenar por Fecha">Fecha</a></td>
  </tr>
<?
		while($row=mysql_fetch_array($result)){	
$id_mov=$row[0];
$tip_mov_id=$row["id_concep"];
$tip_mov=$row["concepto"];
$asoc=$row["asociado"];
$aso2='';
	
	$sql_aso="SELECT asociado FROM mov_almacen WHERE id_mov='$id_mov'";
	$result_aso=mysql_query($sql_aso,$link);	
	while($row_aso=mysql_fetch_array($result_aso)){	
		$id_aso=$row_aso["asociado"];
	}

	if ($asoc=='Almacenes')
	{
			$sql_aso2="SELECT almacen FROM `tipoalmacen` WHERE `id_almacen`='$id_aso'";
			$result_aso2=mysql_db_query($sql_inv,$sql_aso2);	
			while($row_aso2=mysql_fetch_array($result_aso2)){	
				$aso2=$row_aso2["almacen"];
			}
	}
	if ($asoc=='Proveedor'){
		$sql3="SELECT id_prov,nr FROM catprovee WHERE id_prov='$id_aso' ";
		$result3=mysql_db_query($dbcompras,$sql3);
		$row3=mysql_fetch_array($result3);
		$aso2=$row3["nr"];	
	}		
?>
  <tr bgcolor="<?=$color?>" onMouseOver="this.style.background='#cccccc';" onMouseOut="this.style.background='<?=$color; ?>'" style="font-size:11px; padding:1px; font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; cursor:pointer;" onclick="javascript:coloca_movimiento('<?=$divcoloca?>','<?=$id_mov?>','<?=$row["id_concep"]?>','<?=$tip_mov; ?>','<?= $row["id_almacen"] ?>','<?=$id_aso?>','<?=$row["referencia"]?>');">

    <td width="62" height="23" align="center" class="td1">&nbsp;<?=$id_mov?></td>
    <td width="217" class="td1">&nbsp;<?=$tip_mov; ?></td>
    <td width="283" class="td1"><?= $row["almacen"] ?></td>
    <td width="355" align="left" class="td1" style="padding:1px;">&nbsp;<? if ($aso2=='')	echo $row["asociado"]; else echo $aso2; ?></td>
    <td width="158" class="td1">&nbsp;<?=$row["referencia"]?></td>
    <td width="119" class="td1">&nbsp;<?= $row["fecha"]; ?></td>
  </tr>
  <?
  	($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3";
	} 
  ?>
</table>
	
	
	
	
	
	<?php
	}

	if ($action=="ver_movimiento")
	{ 
		$movimiento=$_POST["id"];
		$contenedor=$_POST["contenedor"];
			($contenedor==0)? $cont="a" : $cont="b";
	
			$color="#FFFFFF";
			$sqlMOV="SELECT * FROM prodxmov WHERE nummov='$movimiento' ORDER BY id";
			$resultado=mysql_query($sqlMOV,$link);
			$trows=mysql_num_rows($resultado);	
	?>
<form name="frm_<?=$contenedor?>" id="<?=$contenedor?>" style="margin:0px 0px 0px 0px;">
<table width="95%" cellspacing="0" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; border:#333333 1px solid;">
  <tr>
    <td colspan="6" height="20" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;"> <?=$trows?> PRODUCTOS EN EL MOVIMIENTO <?=$movimiento?></td>
  </tr>
  <tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
    <td width="10%">ID </td>
    <td width="24%">CLAVE PRODUCTO </td>
    <td width="33%">CANTIDAD</td>
    <td width="12%">C.U.</td>
    <td width="16%">SUBTOTAL</td>
    <td width="16%">Sel.</td>
  </tr>
            <?
			while($row=mysql_fetch_array($resultado)){
				//$sqlInfoProd="select $lista_campos from catprod where id='".$row['id_prod']."' ORDER BY id";
				//$resultado1=mysql_db_query($sql_inv,$sqlInfoProd);
				//$des_prod=mysql_fetch_array($resultado1);
			?>
    <tr bgcolor="<?=$color?>" onMouseOver="this.style.background='#cccccc';" onMouseOut="this.style.background='<?=$color; ?>'">
    <td align="center" style="border-left:#CCCCCC 1px solid;border-right:#CCCCCC 1px solid;"><a href="javascript:popUp('fichaprod.php?id=<?=$row["id_prod"]?>')"><?=$row['id_prod']?></a></td>
    <td align="left">&nbsp;<?=$row['clave'];?></td>
    <td align="right" style="border-left:#CCCCCC 1px solid;border-right:#CCCCCC 1px solid;"><?=$row['cantidad']?>&nbsp;</td>
    <td align="right">$<?=number_format($row['cu'],2,'.',',')?>&nbsp;</td>
    <td align="right" style="border-left:#CCCCCC 1px solid;">$<?=number_format($subtotal=$row['cantidad']*$row['cu'],2,'.',',')?></td>
    <td align="center" style="border-left:#CCCCCC 1px solid;"><input type="checkbox" id="<?=$cont."[".$row["id"]."]"?>" value="<?=$row["id"]?>"></td>
  </tr>
  <?php 
  ($color=="#FFFFFF")? $color="#D9FFB3" : $color="#FFFFFF";
  $total_cantidad+=$row['cantidad'];
  $total_precio+=$row['cu'];
  $total_subtotal+=$subtotal;
  
  } ?>
            <tr style="background-color:#efefef; font-weight:bold;" >
              <td align="center" height="20" style="border-left:#CCCCCC 1px solid;border-right:#CCCCCC 1px solid;">&nbsp;</td>
              <td align="left">TOTAL</td>
              <td align="right" style="border-left:#CCCCCC 1px solid;border-right:#CCCCCC 1px solid;"><?=$total_cantidad?>&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right" style="border-left:#CCCCCC 1px solid;">$<?=number_format($total_subtotal,2,'.',',')?>&nbsp;</td>
              <td align="center" style="border-left:#CCCCCC 1px solid;">&nbsp;</td>
            </tr>
</table>		
</form>
	<?php }



	if ($action=="agregar_productos_movimiento")
	{
		$mov_destino=$_POST["mov_destino"];
		$ids=$_POST["ids"];
		$errores=0;
		
		//echo "<br>Pasar los productos ($ids) al Movimiento ($mov_destino)...";
		$m_ids=split(",",trim($ids));
		//print_r($m_ids);
		foreach ($m_ids as $id_prodxmov)
		{
			$sql_cambiar="UPDATE prodxmov SET nummov='$mov_destino' WHERE id='$id_prodxmov' LIMIT 1 ";;
			if (!$result_cambiar=mysql_query($sql_cambiar,$link))
			{
				++$errores;
				echo "<br>Error SQL ($sql_cambiar) El registro no se modifico. ";
				//exit();
			}	
		}
		if ($errores>0)	echo "Se registraron errores durante el proceso. Es posible que no todos los productos se cambiaran de movimiento.";
		else	echo "Los productos se cambiaron de movimiento correctamente.";
	}








} // TERMINA $_POST ...
?>
