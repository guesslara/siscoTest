<?php
class movimiento{
	
	
	function nuevo(){
		echo "<br>nuevo()";
		include ("../../conf/conectarbase.php");
		mysql_select_db($sql_inv);


		$sql="SELECT DISTINCT(especificacion),id FROM catprod WHERE activo='1' ORDER BY id; ";	
		if ($res=mysql_query($sql,$link)){ 
			$ndr=mysql_num_rows($res);
			if($ndr>0){	
				/*
				while($reg=mysql_fetch_array($res)){
					echo "<br>"; 	print_r($reg);
				}
				*/
			}else{ die("<h3>No se encontraron modelos</h3> "); }
		} else{ die("<br>Error SQL (".mysql_error($link).").");	}		
		
		$sql2="SELECT * FROM tipoalmacen WHERE activo='1' ORDER BY id_almacen; ";	
		if ($res2=mysql_query($sql2,$link)){ 
			$ndr2=mysql_num_rows($res2);
			if($ndr2>0){	
				/*
				while($reg2=mysql_fetch_array($res2)){
					echo "<br>"; 	print_r($reg2);
				}
				*/
			}else{ die("<h3>No se encontraron almacenes</h3> "); }
		} else{ die("<br>Error SQL (".mysql_error($link).").");	}	
		
		$sql3="SELECT id_cliente,r_social  FROM cat_clientes WHERE activo='1' ORDER BY id_cliente; ";	
		if ($res3=mysql_query($sql3,$link)){ 
			$ndr3=mysql_num_rows($res3);
			if($ndr3>0){	
				/*
				while($reg3=mysql_fetch_array($res3)){
					echo "<br>"; 	print_r($reg3);
				}
				*/
			}else{ die("<h3>No se encontraron clientes</h3> "); }
		} else{ die("<br>Error SQL (".mysql_error($link).").");	}				
		
		?>
		<h3>Movimiento de Recibo</h3>
		<div id="div_frm0">
			<table align="center" cellpadding="2" cellspacing="0" width="1000" id="tbl_00">
			<tr>
				<th>tipo</th>
				<th>fecha</th>
				<th>almacen</th>
				<th>asociado</th>
				<th>referencia</th>
				<th>observaciones</th>
			</tr>
			<tr align="center">
				<td><input type="text" class="" id="txt_0" value="RECIBO" readonly="1"></td>
				<td><input type="text" class="" id="txt_1" value="<?=date("Y-m-d")?>" onClick="fn_calendario('txt_1')" style="cursor:pointer;" readonly="1"></td>
				<td>
					<!--<input type="text" class="" id="txt_2">//-->
					<select id="sel_almacen">
						<option value="">...</option>
						<?php
						while($reg2=mysql_fetch_array($res2)){
							//echo "<br>"; 	print_r($reg);
							?><option value="<?=$reg2["id_almacen"]?>"><?=$reg2["id_almacen"].". ".$reg2["almacen"]?></option><?php
						}						
						?>						
					</select>						
				</td>
				<td>
					<select id="sel_asociado">
						<option value="">...</option>
						<?php
						while($reg3=mysql_fetch_array($res3)){
							//echo "<br>"; 	print_r($reg);
							?><option value="<?=$reg3["id_cliente"]?>"><?=$reg3["id_cliente"].". ".$reg3["r_social"]?></option><?php
						}						
						?>						
					</select>				
				</td>
				<td><input type="text" class="" id="txt_4"></td>
				<td><input type="text" class="" id="txt_5"></td>
			</tr>
			</table>
			<p align="center">
				<input type="button" value="Crear Movimiento" onClick="Crear_Movimiento()" id="btn_1">
			</p>
		</div>
		<div id="div_frm1">
			<table align="center" cellpadding="2" cellspacing="0" width="300" id="tbl_01">
			<tr>
				<th width="150">modelo</th>
				<th>cantidad</th>
			</tr>
			<tr align="center">
				<td>
					<select id="sel_modelo" onChange="muestra_grid()">
						<option value="">...</option>
						<?php
						while($reg=mysql_fetch_array($res)){
							//echo "<br>"; 	print_r($reg);
							?><option value="<?=$reg["id"]?>"><?=$reg["id"].". ".$reg["especificacion"]?></option><?php
						}						
						?>
					</select>
				</td>
				<td><input type="text" class="" id="txt_cantidad" readonly="1"></td>
			</tr>							
			</table>
			<p align="center">
				<input type="button" value="Aceptar" onClick="guardar_items()" id="btn_01" style="display:none;">
				<!--<input type="button" value="Guardar" onClick="dibujar_grid()" id="btn_01" style="display:none;">//-->
			</p>			
		</div>
		<div id="div_frm2">
			<h3>Numeros de Serie : </h3>
			<table align="center" cellpadding="3" cellspacing="0" width="300" id="tbl_02">
			<tr>
				<th>#</th>
				<th>no_serie</th>
			</tr>
			<tr align="center">
				<td>1</td>
				<td><input type="text" class="txt_ndsX" id="txt_nds_1" onKeyUp="teclaX(1985,1,this.value,event)"></td>
			</tr>			
			
			</table>
			<p align="center">
				<input type="button" value="Aceptar" id="btn_02" onClick="dame_cantidad()">
				<input type="button" value="Limpiar" id="btn_03" onClick="limpiar_grid()">
			</p>						
		</div>
		<div id="div_frm3"></div>
		<?php
	}
}
?>