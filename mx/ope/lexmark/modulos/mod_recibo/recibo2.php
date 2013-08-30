<?php 
	session_start();
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	include ("../../conf/conectarbase.php");
	//print_r($_SESSION);
	//echo "<br><br>";	print_r($_POST);
	
	$a=$_POST["action"];
	if ($a=="buscar"){
		$nds=$_POST["nds"];
	
		//echo "<br>BD [$sql_inv] <br>SQL=".
		echo "<br>".$sql1="SELECT catprod.id,catprod.id_prod,catprod.descripgral,catprod.especificacion,catprod.control_alm,catprod.exist_".$id_almacen_ingenieria.", num_series.serie,mov 
			FROM catprod,num_series 
			WHERE catprod.id_prod=num_series.clave_prod AND num_series.serie LIKE '%$nds%'";
		if ($resultado1=mysql_query($sql1,$link)){
			//echo "<div align=center>OK</div>";		echo "<br>NDR=".
			$ndr1=mysql_num_rows($resultado1);
			if ($ndr1>0){
				while ($registro1=mysql_fetch_array($resultado1)){
					//echo "<br>"; print_r($registro1);
					?>
					<br><br><table border="0" cellpadding="2" cellspacing="0" width="500" class="tabla0" style="margin-top:1px; background-color:#FFFFFF;">
					<tr>
					  <td width="192" style="border-top:#000000 solid 2px;">&nbsp;NO. MOVIMIENTO </td>
					  <td width="300" style="border-top:#000000 solid 2px;" colspan="2"><br><input type="text" class="tex0" size="50" name="txt0" id="txt0" value="<?=$registro1['mov'];?>" readonly="1" /></td>
					</tr>
					<tr>
					  <td width="192" style="border-top:#000000 solid 2px;">&nbsp;NO. SERIE </td>
					  <td width="300" style="border-top:#000000 solid 2px;" colspan="2"><br><input type="text" class="tex0" size="50" name="txt0" id="txt0" value="<?=$nds?>" readonly="1" /></td>
					</tr>
					<tr>
					  <td class="campos_verticales">&nbsp;ID PRODUCTO </td>
					  <td colspan="2"><input class="tex0" type="text" size="35" name="txt1" id="txt1" value="<?=$idp=$registro1['id'];?>" readonly="1" /></td>
					</tr>
					<tr>
						<td class="campos_verticales">&nbsp;CLAVE PRODUCTO </td>
						<td colspan="2">
							<input type="text" class="tex0" size="35" name="txt2" id="txt2" value="<?=$registro1['id_prod'];?>" readonly="1" />	</td>
					</tr>
					<tr id="txt_descripciongral">
						<td class="campos_verticales">&nbsp;DESCRIPCI&Oacute;N</td>
						<td colspan="2">
						<input type="text" class="tex0" size="50" name="txt3" id="txt3" value="<?=$registro1['descripgral'];?>" readonly="1" />
						</td>
					</tr>
					<tr id="especificacion">
						<td class="campos_verticales">&nbsp;ESPECIFICACI&Oacute;N </td>
						<td colspan="2">
						<input type="text" class="tex0" size="50" name="txt4" id="txt4" value="<?=$registro1['especificacion'];?>" readonly="1" />
						</td>
					</tr>
					<tr id="descripcion">
					  <td class="campos_verticales">&nbsp;</td>
					  <td colspan="2">&nbsp;</td>
					</tr>
					<tr id="descripcion">
					  <td class="campos_verticales">&nbsp;DIAGN&Oacute;STICO </td>
					  <td colspan="2"><? echo $sql2="SELECT * FROM cat_diagnosticos WHERE aplica_productos LIKE '%$idp%' ORDER BY id";?>
					  <br><select name="txt5" id="txt5" class="tex0">
					  <option value="">...</option>
					  <? 
							//$claveProd=intval($claveProd);
							$sql2="SELECT * FROM cat_diagnosticos WHERE aplica_productos LIKE '%$idp%' ORDER BY id";
							if ($resultado2=mysql_query($sql2,$link)){
								//echo "<div align=center>OK</div>";	echo "<br>NDR=".
								$ndr2=mysql_num_rows($resultado2);
								if ($ndr2>0){
									//$ids_que_corresponden=array();
									while ($registro2=mysql_fetch_array($resultado2)){
										//echo "<br><br>"; print_r($registro2);		
										$idd=$registro2["id"];
										$tdp=$registro2["aplica_productos"];
										$tdp2=explode(',',$tdp);
										//echo "<br>["; print_r($tdp2);
										foreach ($tdp2 as $tdp3){
											if($idp==$tdp3){ ?>
												<option value="<?=$idd?>"><?=$idd.". ".$registro2["diagnostico"]?></option><?php
											}
										}
									}
								}
							}			
					  ?>		
					  </select>
					  </td>
					</tr>
					<tr id="descripcion">
					  <td class="campos_verticales">&nbsp;GARANT&Iacute;A</td>
					  <td colspan="2"><input type="checkbox" id="chk1" name="chk1" value="1"></td>
					</tr>
					<tr id="descripcion">
					  <td height="40" class="campos_verticales">&nbsp;OBSERVACIONES</td>
						<td colspan="2">
						<input type="text" class="tex0" size="50" name="txt6" id="txt6" value="<?=$observaciones;?>" />	</td>
					</tr>
					<tr id="Guardar" align="right">
						<td colspan="3" style="border-top:#000000 solid 2px; padding:5px;">
						<input type="button" value="Guardar" onClick="guardar_ot()"/>&nbsp;	</td>
					</tr>
					</table>					
					<?php
				}
			} else {
				echo "<div align=center>&nbsp;No se encontraron Resultados.";
			}
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}			
	}
	
	if ($a=="guardar"){
			/*--------------- ALGORITMO -------------------
				1. Recibir variables.
				2. Comprobar si el no. de serie ya existe, en este caso registrar como garantia.
				3. Insertar la OT.
				4. Generar el campo OT.
				5. Avisos.
			  --------------- ALGORITMO -------------------*/
		
		$a=$_POST["a"];				$b=$_POST["b"];				$c=$_POST["c"];			$g=$_POST["g"];	
		$d=$_POST["d"];				$e=$_POST["e"];				$f=$_POST["f"];			$x=$_POST["x"];				

		$y=date("y");
		$m=date("m");
		$id_usuario=$_SESSION["usuario_id"];
		$fr=date("Y-m-d");

		// paso 2
		if ($x==0){
			//echo "<br><br>".
			$sql5="SELECT id FROM ot WHERE nserie='$a'";	
			if ($result5=mysql_db_query($sql_ing,$sql5)){
				if (mysql_num_rows($result5)>0){
					?>
					<br>
					<div style="font-size:18px; color:#FF0000;">&nbsp;El n&uacute;mero de serie ya existe. Por lo tanto,<br> debe ser capturado como garant&iacute;a.</div>
					<?php
					exit();
				}
			} else {
				echo "<div align=center>&nbsp;Error SQL. La consulta no se ejecuto.</div>";
			}		
		} elseif($x==1){
			//echo "<br><br>".
			$sql5="SELECT id FROM ot WHERE nserie='$a'";	
			if ($result5=mysql_db_query($sql_ing,$sql5)){
				if (mysql_num_rows($result5)<=0){
					//Error. Se reporta como garantia pero no existe regsitrado en el sistema.
					//echo "<br>&nbsp;El numero de serie no se encuentra en el sistema, por lo tanto no puede ser capturado como garantia.";
					?>
					<br><div style="font-size:18px; color:#FF0000;">&nbsp;El n&uacute;mero de serie no se encuentra en el sistema, <br>
					  por lo tanto no puede ser capturado como garant&iacute;a.</div>
					<?php					
					exit();
				}
			} else {
				echo "<div align=center>&nbsp;Error SQL. La consulta no se ejecuto.</div>";
			}		
		}
		//echo "<br><br>".
		$sql3="INSERT INTO ot 
		(id,ot,idp,nserie,u_recibe,f_recibo,cod_refac,cod_diag,cod_rep,obs_rep,garantia,fecha_inicio,fecha_fin,repara,num_no_ok,status_proceso,status_cliente,obs) 
		VALUES 
		(NULL,'BD','$b','$a','$id_usuario','$fr','','$f','','','$x','','','','1','REC','REC','$g')";	
		if (mysql_db_query($sql_ing,$sql3,$link)){
			echo "<div align=center>&nbsp;La OT se guardo correctamente.</div>";
			$id_insertado=mysql_insert_id($link);
			$idc=sprintf('%06s',$id_insertado);		
			$ot="BD".date("y").date("m").$idc;
			//echo "<br><br>".
			$sql4="UPDATE ot SET ot='$ot' WHERE id=$id_insertado";
			mysql_db_query($sql_ing,$sql4);
		} else {
			echo "<div align=center>&nbsp;Error SQL. La OT NO se guardo.</div>";
		}
	}
?>	