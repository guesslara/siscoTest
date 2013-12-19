<?php 
	session_start();
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	include ("../../conf/conectarbase2.php");
	//print_r($_SESSION);
	//print_r($_POST);
	$fr=date("Y-m-d");
	$hr=date("H:i:s");
	$id_usu=$_SESSION['idUsuarioLX'];
	$a=$_POST["action"];
	$mmodulos=array("REC"=>"RECIBO","REP"=>"REPARACION","CC"=>"CALIDAD","DES"=>"DESPACHO","ENV"=>"ENVIADOS",""=>"TODOS",);
	if ($a=="listar"){
		$id_usuario=$_SESSION["usuario_id"];
		$nivel_usuario=$_SESSION["usuario_nivel"];		
		if ($nivel_usuario==14){ $sql_where=" WHERE status_cliente='DES' AND repara=$id_usuario"; } else { $sql_where=" WHERE status_cliente='DES' "; }
		
		
		//echo "<br>BD [$sql_ing] SQL=".
		$sql1="SELECT * FROM ot $sql_where ORDER BY id";
		if ($resultado1=mysql_query($sql1,$link)){
			//echo "<div align=center>OK</div>";
			$ndr1=mysql_num_rows($resultado1);
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}		
		
		?>
		
		<form name="frm1">
			
        <br /><table width="100%" align="center" class="tabla1" cellpadding="2" cellspacing="0" style=" border-radius: 10px;-moz-box-shadow: 3px 3px 4px #111; -webkit-box-shadow: 3px 3px 4px #111; box-shadow: 3px 3px 4px #111; -ms-filter: 'progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color=#111111)'; filter: progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#111111');">
		<tr>
		  <td colspan="8" class="titulo_tabla1" align="center" height="23" style=" text-shadow: 2px 2px 2px gray;">Productos en Despacho (<?=$ndr1?> Resultados) </td>
		  </tr>
		<tr>
		  <td height="23" width="17" class="campos_tabla1" style=" text-shadow: 2px 2px 2px gray;">Id</td>
		  <td width="63" class="campos_tabla1" style=" text-shadow: 2px 2px 2px gray;">OT</td>
		  <td width="197" class="campos_tabla1" style=" text-shadow: 2px 2px 2px gray;">Fecha Recibo </td>
		  <td width="322" class="campos_tabla1" style=" text-shadow: 2px 2px 2px gray;">Fecha Fin</td>
		  <td width="363" class="campos_tabla1" style=" text-shadow: 2px 2px 2px gray;">No. Serie. </td>
		  <td width="109" class="campos_tabla1" style=" text-shadow: 2px 2px 2px gray;">M&oacute;dulo</td>
		  <td width="82" class="campos_tabla1" style=" text-shadow: 2px 2px 2px gray;">Status</td>
		  <td width="56" class="campos_tabla1" style=" text-shadow: 2px 2px 2px gray;">Acciones</td>
		  </tr>
		<?php $col="#FFFFFF";	while($registro1=mysql_fetch_array($resultado1)){ 
			//echo "<hr>"; print_r($registro1); ?>
		<tr bgcolor="<?=$col?>" onmouseover='this.style.background="#819FF7"' onmouseout='this.style.background="white"'>
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
        <div align="center" style=" text-shadow: 2px 2px 2px gray;">
        	<br />
            Enviar los productos seleccionados al almac&eacute;n: <br />
            <?php
			//$sql_almacenes="SELECT * FROM  `tipoalmacen` ORDER BY id_almacen";
			$sql_almacenes="SELECT tipoalmacen.id_almacen AS id_almacen,almacen FROM tipoalmacen INNER JOIN almacenCliente ON tipoalmacen.id_almacen=almacenCliente.id_almacen WHERE id_cliente=1";
			$resultado_almacenes=mysql_query($sql_almacenes,$link);
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
			
			$resultado_datos_producto=mysql_query($sql_datos_producto,$link);
			$reg_datos_producto=mysql_fetch_array($resultado_datos_producto);
			//print_r($reg_datos_producto);
			$id_producto=$reg_datos_producto["idp"];
			
			//echo "<br>".
			$sql_almacen_resta="UPDATE catprod SET $campo_existencias_origen=$campo_existencias_origen-1 WHERE id='$id_producto'"; echo "<br>";
			//echo "<br>".
			$sql_almacen_suma="UPDATE catprod SET $campo_trasnferencias_destino=$campo_trasnferencias_destino+1 WHERE id='$id_producto'"; echo "<br>";
			//echo "<br>".
			$sql_actualiza_ot="UPDATE ot SET status_cliente='ENV',status_proceso='ALM',shipdate='".date("Y-m-d")."',id_almacen_destino=$id_almacen WHERE id='$idot'";
			//exit();
			if (!mysql_query($sql_almacen_resta,$link)){ echo "<br>&nbsp;Error SQL (Paso 2)."; exit; }
			if (!mysql_query($sql_almacen_suma,$link)){ echo "<br>&nbsp;Error SQL (Paso 3)."; exit; }
			if (!mysql_query($sql_actualiza_ot,$link)){ echo "<br>&nbsp;Error SQL (Paso 4)."; exit; }
			
			$id="SELECT nserie FROM `ot` WHERE id = '$idot'";
		        $resultid=mysql_query($id,$link);
		        $registro1=mysql_fetch_array($resultid);
		        $idd2=$registro1['nserie'];
		
		        $id="SELECT id FROM `num_series` WHERE serie = '$idd2'";
		        $resultid=mysql_query($id,$link);
		        $registro1=mysql_fetch_array($resultid);
		        $idd=$registro1['id'];
		
		        $history="INSERT INTO historial_numSeries
		        (id,id_serie,fecha,hora,id_usuario,accion)
		         VALUES
		        (NULL,'$idd','$fr','$hr','$id_usu','En despacho enviada a almacen $id_almacen')";
		        $res1=mysql_query($history,$link);
			
			?>
            
	    <script type="text/javascript">
	    alert("El proceso de Envio de la OT (<?=$idot?>) se realizo correctamente.");
	    </script>
            <?php
			
		}
	}
?>	