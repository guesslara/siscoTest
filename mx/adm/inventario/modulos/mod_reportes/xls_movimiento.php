<? 
$fecha = date('Y-m-d H:i:s');

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=MOVIMIENTOS_IQ_$fecha.xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../../conf/conectarbase.php");
$lista_campos=" id,`id_prod`,`descripgral`,`especificacion`";

		$totArticulos=0;
		$idmov=$_GET['idmov'];
		/*consulta*/
		$sqlMOV="SELECT * FROM prodxmov WHERE nummov='$idmov' ORDER BY id_prod ASC";
		$resultado=mysql_db_query($sql_inv,$sqlMOV);
		$trows=mysql_num_rows($resultado);
		if($trows==0){
			echo "<center><span class='Estilo51'>No hay productos asociados a este movimiento.</span></center>";
		}else{ 
			$id_movimiento_recibido=$idmov;
			$sql_detalle_movimiento="SELECT mov_almacen.id_mov,mov_almacen.fecha,mov_almacen.tipo_mov,mov_almacen.almacen,mov_almacen.referencia,mov_almacen.asociado, tipoalmacen.almacen,tipoalmacen.id_almacen, concepmov.id_concep,concepmov.concepto,concepmov.asociado AS dasociado FROM mov_almacen,tipoalmacen,concepmov WHERE mov_almacen.tipo_mov=concepmov.id_concep AND mov_almacen.almacen=tipoalmacen.id_almacen AND mov_almacen.id_mov=$id_movimiento_recibido";
			if ($result_detalle_movimiento=mysql_db_query($sql_inv,$sql_detalle_movimiento))
			{
				while ($row_detalle_movimiento=mysql_fetch_array($result_detalle_movimiento))
				{
					// ========================================================================================================================
					// PROVEEDOR ...
					if ($row_detalle_movimiento["dasociado"]=="Proveedor")
					{
						$sql_proveedor="SELECT nr FROM catprovee WHERE id_prov=".$row_detalle_movimiento["asociado"];
						$result_proveedor=mysql_db_query($dbcompras,$sql_proveedor);
						$row_proveedor=mysql_fetch_array($result_proveedor);
						$xasociado=$row_proveedor["nr"];	
					}
					// ALMACENES
					if ($row_detalle_movimiento["dasociado"]=="Almacenes")
					{
						$sql_almacen_asociado="SELECT almacen FROM `tipoalmacen` WHERE `id_almacen`=".$row_detalle_movimiento["asociado"];
						$result_almacen_asociado=mysql_db_query($sql_inv,$sql_almacen_asociado);	
						while($row_almacen_asociado=mysql_fetch_array($result_almacen_asociado)){	
							$xasociado=$row_almacen_asociado["almacen"];
						}
					}		
?>
<style type="text/css">
.td1{ border-right:#CCCCCC 1px solid; padding:1px; }
.tablax{ border:#333333 1px solid; }
#detalle{ position:absolute; display:none; border:#333333 3px solid; background-color:#ffffff; 
width:800px; height:500px; left:50%; top:50%; margin-left:-400px; margin-top:-250px; z-index:3;}
#d_tit{width:710px; height:20px; float:left; background-color:#333333; color:#FFFFFF;}
#d_cer{width:90px; height:20px; float:right; text-align:right; background-color:#333333;}
#d_con{ clear:both; margin:2px; margin-top:3px; padding:2px; height:470px; /*border:#333333 1px solid;*/ overflow:auto;}

.tdx{ background-color:#CCCCCC; font-weight:bold; text-align:left; padding-left:2px;}


/*==========================================================================================*/
 .paginador1:link{ border:#CCCCCC 1px solid; background-color:#efefef; color:#000000; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:10px; margin:1px;}
 .paginador1:visited{ border:#CCCCCC 1px solid; background-color:#efefef; color:#000000; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:10px; margin:1px;}
 .paginador1:hover{ border:#CCCCCC 1px solid; background-color:#efefef; color:#333333; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:15px; margin:1px;}
 .pagact:link{ border:#CCCCCC 1px solid; border-bottom:#CCCCCC 2px solid; border-right:#CCCCCC 2px solid; background-color:#efefef; color:#333333; font-weight:normal; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:15px; margin:1px; margin-right:4px;}
 .pagact:visited{ border:#CCCCCC 1px solid; background-color:#efefef; color:#333333; font-weight:bold; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:15px; margin:1px; margin-right:4px;}
/*==========================================================================================*/


</style>
<table width="95%" align="center" cellspacing="0" style="border:#333333 1px solid;">
  <tr>
    <td colspan="4" height="20" style=" background-color:#333333;text-align:center; font-weight:bold; color:#FFFFFF;">Movimiento <?=$id_movimiento_recibido?></td>
  </tr>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.background='#D9FFB3';" onMouseOut="this.style.background='#FFFFFF'">
    <td class="tdx">Id_Movimiento </td>
    <td>&nbsp;<?=$id_movimiento_recibido?></td>
    <td class="tdx">Fecha</td>
    <td>&nbsp;<?=$row_detalle_movimiento["fecha"]?></td>
  </tr>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.background='#D9FFB3';" onMouseOut="this.style.background='#FFFFFF'">
    <td width="19%" class="tdx">Tipo</td>
    <td width="32%">&nbsp;<?=$row_detalle_movimiento["concepto"]?></td>
    <td width="14%" class="tdx">Referencia</td>
    <td width="35%">&nbsp;<?=$row_detalle_movimiento["referencia"]?></td>
  </tr>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.background='#D9FFB3';" onMouseOut="this.style.background='#FFFFFF'">
    <td class="tdx">Almac&eacute;n</td>
    <td>&nbsp;<?=$row_detalle_movimiento["almacen"]?></td>
    <td class="tdx">Asociado </td>
    <td>&nbsp;<?=$row_detalle_movimiento["dasociado"]." (".$xasociado.")"?></td>
  </tr>
</table>		
		<?php	
		// ========================================================================================================================	
	}
} else {
	echo "<br>Error SQL: ($sql_detalle_movimiento)<br>Los detalles del Movimiento no se pueden mostrar.";
}			
			?>
			<br />
			<table width="95%" align="center" cellpadding="0" cellspacing="0" class="tablax">
            <tr>
                <td colspan="7" bgcolor="#333333" height="20" class="style9" style=" color:#FFFFFF; text-align:center; font-weight:bold;"><?=$trows?> Productos registrados en el Movimiento</td>
            </tr>
            <tr style="text-align:center; font-weight:bold;">
                <td width="41"  height="23" bgcolor="#CCCCCC" class="style17">ID</td>
                <td width="118"  bgcolor="#CCCCCC" class="style17">Clave Producto</td>
                <td  bgcolor="#CCCCCC" class="style17">Descripci&oacute;n</td>
                <td  bgcolor="#CCCCCC" class="style17">Especificaci&oacute;n</td>
                <td  bgcolor="#CCCCCC" class="style17">Cantidad</td>
                <td width="65"  bgcolor="#CCCCCC" class="style17">C.U. </td>
                <td width="72"  bgcolor="#CCCCCC" class="style17">Subtotal</td>
              </tr>
            <?
			$color="#D9FFB3"; $total_cantidad=0; $total_subtotal=0;
			while($row=mysql_fetch_array($resultado)){
				$sqlInfoProd="select $lista_campos from catprod where id='".$row['id_prod']."' ORDER BY id";
				$resultado1=mysql_db_query($sql_inv,$sqlInfoProd);
				$des_prod=mysql_fetch_array($resultado1);
			?>
            <tr bgcolor="<?=$color?>" onMouseOver="this.style.background='#cccccc';" onMouseOut="this.style.background='<?=$color; ?>'">
                <td align="center" class="td1" height="20"><?=$row['id_prod'];?></td>
                <td class="td1"><?=$row['clave'];?></td>
                <td width="245"  align="left" class="td1" >&nbsp;<?=$des_prod['descripgral'];?></td>
                <td width="206"  align="left" class="td1" >&nbsp;<?=$des_prod['especificacion'];?></td>
                <td width="73"  align="right" class="td1"><?php echo $row['cantidad']; $total_cantidad+=$row['cantidad']; ?></td>
                <td class="td1" align="right"><?php if($row['cu']!==''||$row['cu']!==' ') echo $row['cu']; ?></td>
                <td class="td1" align="right"><?php echo $row['cantidad']*$row['cu']; $total_subtotal+=($row['cantidad']*$row['cu']); ?></td>
            </tr>
			<?
				($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3";
				$totArticulos=$totArticulos+$row['cantidad'];	
			}
			?>
            <tr bgcolor="#cccccc" style="text-align:right; font-weight:bold;">
              <td height="20" colspan="4" >Total&nbsp;&nbsp;</td>
              <td  align="right" class="td1" ><?=$total_cantidad?></td>
              <td class="td1" align="right">&nbsp;</td>
              <td class="td1" align="right"><?=$total_subtotal?></td>
            </tr>
			</table>
		<?	
		}		
		exit();
		?>