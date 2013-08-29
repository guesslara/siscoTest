<?php 
	session_start();
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	include ("../../conf/conectarbase.php");
	//print_r($_SESSION);
	//print_r($_POST);
	$a=$_POST["action"];
	$mmodulos=array("REC"=>"RECIBO","REP"=>"REPARACION","CC"=>"CALIDAD","DES"=>"DESPACHO","ENV"=>"ENVIADOS",""=>"TODOS",);
	if ($a=="listar"){
		$id_usuario=$_SESSION["usuario_id"];
		$nivel_usuario=$_SESSION["usuario_nivel"];		
		if ($nivel_usuario==14){ $sql_where=" WHERE status_cliente='DES' AND repara=$id_usuario"; } else { $sql_where=" WHERE status_cliente='DES' "; }
		
		
		//echo "<br>BD [$sql_ing] SQL=".
		$sql1="SELECT * FROM ot $sql_where ORDER BY id";
		if ($resultado1=mysql_db_query($sql_ing,$sql1)){
			//echo "<div align=center>OK</div>";
			$ndr1=mysql_num_rows($resultado1);
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}		
		
		?>
		<form name="frm1">
        <br /><table width="100%" align="center" class="tabla1" cellpadding="2" cellspacing="0">
		<tr>
		  <td colspan="8" class="titulo_tabla1" height="23">Productos en Despacho (<?=$ndr1?> Resultados) </td>
		  </tr>
		<tr>
		  <td height="23" width="17" class="campos_tabla1">Id</td>
		  <td width="63" class="campos_tabla1">OT</td>
		  <td width="197" class="campos_tabla1">Fecha Recibo </td>
		  <td width="322" class="campos_tabla1">Fecha Fin</td>
		  <td width="363" class="campos_tabla1">No. Serie. </td>
		  <td width="109" class="campos_tabla1">M&oacute;dulo</td>
		  <td width="82" class="campos_tabla1">Status</td>
		  <td width="56" class="campos_tabla1">Acciones</td>
		  </tr>
		<?php $col="#FFFFFF";	while($registro1=mysql_fetch_array($resultado1)){ 
			//echo "<hr>"; print_r($registro1); ?>
		<tr bgcolor="<?=$col?>">
		  <td height="23" align="center"><?=$registro1["id"]?></td>
		  <td class="tda_tabla1" align="center"><?=$registro1["ot"]?></td>
		  <td align="center"><?=$registro1["f_recibo"]?></td>
		  <td class="tda_tabla1">&nbsp;<?=substr($registro1["fecha_fin"],0,10)?></td>
			<td class="tda_tabla1">&nbsp;<?=$registro1["nserie"]?></td>
			<td><?=$mmodulos[$registro1["status_cliente"]]?></td>
			<td align="center" class="tda_tabla1" <?php if($registro1["status_proceso"]=='OK'){ ?> bgcolor="#009933" <?php } ?> ><?=$registro1["status_proceso"]?></td>
			<td align="center">
            	<input type="checkbox" name="chk_<?=$registro1["id"]?>" id="<?=$registro1["id"]?>" value="<?=$registro1["id"]?>" />
                <a href="#" title="Seleccionar este Producto.">?</a>
            </td>
		  </tr>
		<?php ($col=="#FFFFFF")? $col="#EFEFEF" : $col="#FFFFFF"; }	mysql_free_result($resultado1); ?>  
		</table>
        <div align="center">
        	<br />
            Enviar los productos seleccionados al almac&eacute;n: <br />
            <?php
			$sql_almacenes="SELECT * FROM  `tipoalmacen` ORDER BY id_almacen";
			$resultado_almacenes=mysql_db_query($sql_inv,$sql_almacenes);
			?>
            <select id="sel_almacen" style="margin-top:5px; margin-bottom:5px;">
				<option value="">...</option><?php 
                while($registro_almacenes=mysql_fetch_array($resultado_almacenes)){	?>
					<option value="<?=$registro_almacenes["id_almacen"]?>"><?=$registro_almacenes["id_almacen"].".".$registro_almacenes["almacen"]?></option>
					<?php
				}
				?>            
            </select>
            
            &nbsp;<input type="button" value="Enviar" onclick="enviar()" />
        </div>
        </form>        
        <?php	
	}
	if ($a=="enviar"){
		$id_almacen=$_POST["ida"];
		$id_productos=explode(',',trim($_POST["idps"]));
		foreach ($id_productos as $idot){
			$campo_existencias_origen="exist_".$id_almacen_ingenieria;
			$campo_trasnferencias_destino="trans_".$id_almacen;
			
			//echo "<hr><br>OT=$idot";
			/* PROCEDIMIENTO:
				1. Obtener los datos del producto.
				2. Realizar Transferencia (+1).
				3. realizar Disminucion de existencias (-1).
				4. Modificar status y colocar la hora de envio.
			*/
			$id_producto=0;
			//echo "<br>".
			$sql_datos_producto="SELECT idp FROM  ot WHERE id=$idot";
			$resultado_datos_producto=mysql_db_query($sql_ing,$sql_datos_producto);
			$reg_datos_producto=mysql_fetch_array($resultado_datos_producto);
			//print_r($reg_datos_producto);
			$id_producto=$reg_datos_producto["idp"];
			
			//echo "<br>".
			$sql_almacen_resta="UPDATE catprod SET $campo_existencias_origen=$campo_existencias_origen-1 WHERE id='$id_producto'";
			$sql_almacen_suma="UPDATE catprod SET $campo_trasnferencias_destino=$campo_trasnferencias_destino+1 WHERE id='$id_producto'";
			$sql_actualiza_ot="UPDATE ot SET status_cliente='ENV',status_proceso='ALM',shipdate='".date("Y-m-d")."',id_almacen_destino=$id_almacen WHERE id='$idot'";
			if (!mysql_db_query($sql_inv,$sql_almacen_resta)){ echo "<br>&nbsp;Error SQL (Paso 2)."; exit; }
			if (!mysql_db_query($sql_inv,$sql_almacen_suma)){ echo "<br>&nbsp;Error SQL (Paso 3)."; exit; }
			if (!mysql_db_query($sql_ing,$sql_actualiza_ot)){ echo "<br>&nbsp;Error SQL (Paso 4)."; exit; }
			?>
            <div style=" margin-top:5px; text-align:center; font-size:16px; font-weight:bold; color:#063;"> El proceso de Envio de la OT (<?=$idot?>) se realizo correctamente.</div>
            <?php
			
		}
	}
?>	