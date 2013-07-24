<?php 
	include ("../../conf/conectarbase.php");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	//print_r($_POST);
	$color="#D9FFB3";
	$a=trim($_POST["accion"]);
	
	if ($a=="mostrar_conceptos") {
		$tes=trim($_POST["tes"]);
		if ($tes=="ENTRADAS") { $t="Ent"; } elseif ($tes=="SALIDAS") { $t="Sal"; }
		$sql0="SELECT * FROM concepmov WHERE tipo='$t' ";
		$result0=mysql_db_query($sql_inv,$sql0);
		$ndr0=mysql_num_rows($result0);
		?>
		<form name="frm1" id="frm1">
		<table width="600" align="center" cellspacing="0" style="border:#333333 2px solid; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
			<tr style="background-color:#333333; font-weight:bold; text-align:center; color:#FFFFFF;">
			  <td colspan="5" height="20" > Conceptos de Entrada y Salida (E/S) </td>
			</tr>
			<tr style="background-color:#CCCCCC; text-align:center; font-weight:bold; color:#000000;">
			  <td>&nbsp;</td>
			  <td height="20">Id</td>
			  <td>Concepto</td>
			  <td width="125">Asociado a</td>
			  <td width="69">Tipo</td>
			</tr>
			<?	while($row0=mysql_fetch_array($result0)){ ?>
			<tr bgcolor="<?=$color?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" style="cursor:pointer;">
			  <td width="20">
			  <input type="checkbox" name="chb_con_<?=$row0["id_concep"]?>" id="chb_con_<?=$row0["id_concep"]?>" value="<?=$row0["id_concep"]?>" /></td>
			  <td width="28" class="tda" align="center">&nbsp;<?= $row0["id_concep"]; ?></td>
			  <td width="230">&nbsp;<?= $row0["concepto"]; ?></td>
			  <td align="left" class="tda">&nbsp;<?= $row0["asociado"]; ?></td>
			  <td>&nbsp;<?= $row0["tipo"]; ?></td>
			</tr>
			<?	($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3"; 	} ?>
		  </table>
		  <br /><div align="center"><input type="button" value="Aceptar" onclick="coloca_conceptos()" /></div>
		</form> 		
		<?php
	} elseif ($a=="ejecutar") {
		$v1=$_POST["v1"];		$v4=$_POST["v4"];		$v6=$_POST["v6"];		$v10=trim($_POST["v10"]);
		$v2=$_POST["v2"];		$v5=$_POST["v5"];		$v7=$_POST["v7"];
		$v3=$_POST["v3"];		$v8=$_POST["v8"];		$v9=$_POST["v9"];
		
		$v10_split=split(',',$v10);
		if (($ndc3=count($v10_split))>1){
			$sql_asociado=" AND ( mov_almacen.asociado=".$v10_split[0];
			for ($i3=1;$i3<$ndc3;$i3++){ 
				(is_numeric(trim($v10_split[$i3])))? $sql_asociado.=" OR mov_almacen.asociado=".trim($v10_split[$i3]) : $sql_asociado.=""; 
			}
			$sql_asociado.=" )";	
		} else {
			(is_numeric(trim($v10)))? $sql_asociado=" AND mov_almacen.asociado=".trim($v10) : $sql_asociado="";
		}
		
		//echo "<br>ASOCIADOS=$sql_asociado.";	
		//echo "<br>Realizar la Consulta SQL:<br><br>";
		//echo "<hr>Conceptos: ";
		$tipo_movs=split(',',$v2);
		//print_r($tipo_movs);
		if (($ndc1=count($tipo_movs))>1){
			$sql_con=" (mov_almacen.tipo_mov=".$tipo_movs[0];
			for ($i=1;$i<$ndc1;$i++)
			{
				$sql_con.="	OR mov_almacen.tipo_mov=".$tipo_movs[$i];	
			}
			$sql_con.=")";
		} else {
			$sql_con="mov_almacen.tipo_mov=$v2";
		}	
		//echo "<br>SQL conceptos= $sql_con";

		//echo "<hr>Almacenes: ";
		$alms=split(',',$v6);
		//print_r($alms);		
		if (($ndc2=count($alms))>1){
			$sql_con2=" (mov_almacen.almacen=".$alms[0];
			for ($i2=1;$i2<$ndc2;$i2++)
			{
				$sql_con2.=" OR mov_almacen.almacen=".$alms[$i2];	
			}
			$sql_con2.=")";
		} else {
			$sql_con2="mov_almacen.almacen=$v6";
		}	
		//echo "<br>SQL almacenes= $sql_con2";		
		
		
		//echo "<br><br>".
		$sql8="
SELECT mov_almacen.id_mov, mov_almacen.fecha, mov_almacen.tipo_mov, mov_almacen.asociado, concepmov.concepto, concepmov.asociado as asociado0, tipoalmacen.almacen as nalmacen, mov_almacen.almacen, prodxmov.id, prodxmov.id_prod, prodxmov.clave, prodxmov.cantidad, prodxmov.cu, prodxmov.cantidad*prodxmov.cu as subtotal
FROM mov_almacen, prodxmov, concepmov, tipoalmacen
WHERE mov_almacen.id_mov = prodxmov.nummov AND concepmov.id_concep=mov_almacen.tipo_mov AND tipoalmacen.id_almacen=mov_almacen.almacen
AND mov_almacen.fecha BETWEEN '$v3' AND '$v4'
AND $sql_con
AND $sql_con2 $sql_asociado ORDER BY $v8 $v9
";
		if ($result8=mysql_db_query($sql_inv,$sql8))
		{
			$ndr8=mysql_num_rows($result8);
			//echo "<br>La consulta se realizo con exito. Se registraron $ndr8 resultados.";
			?>
		<br /><table width="auto" align="center" cellspacing="0" style="border:#333333 2px solid; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
			<tr style="background-color:#333333; font-weight:bold; text-align:center; color:#FFFFFF;">
			  <td colspan="12" height="20" > <?=$ndr8?> Resultados</td>
			</tr>
			<tr style="background-color:#CCCCCC; text-align:center; font-weight:bold; color:#000000;">
			  <td width="44">#</td>
			  <td width="95" height="20">Fecha</td>
			  <td width="63">Id Mov</td>
			  <td width="197">Tipo de Mov </td>
			  <td width="145">Almac&eacute;n</td>
			  <td width="97">Asociado</td>
			  <td width="97">Id Producto </td>
			  <td width="83">Clave P. </td>
			  <td width="69">Cantidad</td>
			  <td width="69">C.U.</td>
			  <td width="69">Subtotal $ </td>
			</tr>
			<?php while($row8=mysql_fetch_array($result8)){ ?>
			<tr bgcolor="<?=$color?>">
			  <td height="20" align="center"><?=$row8["id"]?></td>
			  <td class="tda"><?=$row8["fecha"]?></td>
			  <td align="center"><?=$row8["id_mov"]?></td>
			  <td class="tda"><?=$row8["tipo_mov"].".".$row8["concepto"]?></td>
			  <td><?=$row8["almacen"].".".$row8["nalmacen"]?></td>
			  <td class="tdai" ><?=$row8["asociado0"]." ".$row8["asociado"]?></td>
			  <td class="tda"><?=$row8["id_prod"]?></td>
			  <td><?=$row8["clave"]?></td>
			  <td class="tda" align="right"><?php $tcantidad+=$row8["cantidad"]; echo $row8["cantidad"]; ?></td>
			  <td align="right"><?=number_format($row8["cu"],2,'.',',')?></td>
			  <td class="tdai" align="right"><?php $total+=$row8["subtotal"]; echo number_format($row8["subtotal"],2,'.',','); ?></td>
		    </tr>
			<?php ($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3"; } ?>
			<tr style="background-color:#CCCCCC; text-align:center; font-weight:bold; color:#000000;">
			  <td>&nbsp;</td>
			  <td height="20">&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>TOTAL</td>
			  <td align="right"><?=$tcantidad?></td>
			  <td>&nbsp;</td>
			  <td align="right">$<?=number_format($total,4,'.',',')?></td>
		    </tr>			
		</table>				
			<?
			/*
			while($row8=mysql_fetch_array($result8)){
				echo "<br><br>";
				print_r($row8);
			
			}
			*/
		}

	}
	

?>