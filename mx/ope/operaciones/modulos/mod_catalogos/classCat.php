<?php
class catalogo{
	var $exepciones_tablas=array("");
	var $exepciones_campos=array("");
        
        public function conectarBd(){
		include("../../includes/config.inc.php");
		$link=mysql_connect($host,$usuario,$pass);
		if($link==false){
			echo "Error en la conexion a la base de datos";
		}else{
			mysql_select_db($db);
			return $link;
		}
            
	}        
	
	public function catalogo_listar($c,$prefijo){
		$ta=str_replace($prefijo,"",$c);
		$sql_orden="";
		$Sql2 ="DESCRIBE ".$c;
		$result2 = mysql_query($Sql2,$this->conectarBd())or die("No se puede ejecutar la consulta: ".mysql_error());
		$sql3="SELECT * FROM $c $sql_orden";
		if ($res3=mysql_query($sql3,$this->conectarBd())){
			 $ndr3=mysql_num_rows($res3);
			 
			 if ($ndr3>0){
				echo '<br><div class="subtitulos2">CATALOGO "'.strtoupper(str_replace($prefijo,"",$c)).'"</div><table align="left" class="tabla1" cellspacing="0"><tr class="tabla_campos">';
		while($Rs2 = mysql_fetch_array($result2)) {
			echo "<td>".$Rs2["Field"];
			if ($Rs2['Key']=='PRI'){
				$sql_orden=" ORDER BY ".$Rs2['Field'];
			}
			echo "</td>";
		}
		echo "</tr>";
				 $clase_css="tabla_zebra0";
				 while($reg3=mysql_fetch_array($res3)){
					$ndc_respuesta=count($reg3)/2;
					
					if ($ndc_respuesta>0){
						echo "<tr class='$clase_css'>";
						for ($i=0;$i<$ndc_respuesta;$i++){
							echo "<td>".utf8_encode($reg3[$i])."</td>";
						}
						echo "</tr>";
						($clase_css=="tabla_zebra0")? $clase_css="tabla_zebra1" : $clase_css="tabla_zebra0";	
					}

				 }
				 
			 }
			 else{
				$res3=mysql_query($sql3,$this->conectarBd());
				$ndr3=mysql_num_rows($res3);
				echo '<br> CATALOGO: '.strtoupper(str_replace($prefijo,"",$c)).' SE ENCUENTRA VACIO';
			 }
		} else {
			echo "<br>Error SQL [".mysql_error($link)."].";
			exit;			
		}		
		echo '</table>';			
	}
	public function catalogos_agregar($c,$prefijo){
		$ta=str_replace($prefijo,"",$c);
		$sql_orden="";
		$Sql2 ="DESCRIBE ".$c;  
		$result2 = mysql_query($Sql2,$this->conectarBd()) or die("No se puede ejecutar la consulta: ".mysql_error());
		?>
		<div class="subtitulos2"><?=strtoupper(str_replace($prefijo,"",$c));?></div>
		<form name="frm_catalogo_nuevo_<?=$c?>" id="frm_catalogo_nuevo_<?=$c?>">
		<font color="red" style="font-size: 14px;font-weight: bold;">*Nota: El campo NULL es asignado por el sistema</font>
		<table align="center" class="tabla1" cellspacing="0">
		<tr><td colspan="2" class="tabla_campos">Insertar nuevo registro</td></tr>
		<?php
		$clase_css="tabla_zebra0";
		//print_r($clase_css);
		//exit;
		while($Rs2 = mysql_fetch_array($result2)) {
			$field=$Rs2["Field"];
			$type=$Rs2["Type"];
			$null=$Rs2["Null"];
			$key=$Rs2["Key"];
			$default=$Rs2["Default"];
			$extra=$Rs2["Extra"];
			$texto="";
			$sol="";
			if (!$default==""){ $texto=$default; $sol=" readonly='1' "; } 
			if ($extra=="auto_increment"){$texto="NULL"; $sol=" readonly='1' "; } 
			if ($null=="NO"){ $clase_obligaria="campo_obligatorio"; } else { $clase_obligaria="campo_opcional"; }
			?>
			<tr class="campo_vertical,<?=$clase_css?>">
			<? if($extra=='auto_increment'){
				?>
				<td><font color="red">*<?=$Rs2["Field"]?></td>
				<td>&nbsp;<label><input type="text" name="txt_<?=$Rs2["Field"]?>" id="txt_<?=$Rs2["Field"]?>" value="<?=$texto?>" 				<?=$sol?> class="<?=$clase_obligaria?>" /></label></td></font>
				<?
			}
			?>
			<? if($extra!='auto_increment'){
				if($Rs2["Field"]=="id_proyecto"){
					
				}else{
			?>
				<td><?=$Rs2["Field"]?></td>
				<td>&nbsp;<label><input type="text" name="txt_<?=$Rs2["Field"]?>" id="txt_<?=$Rs2["Field"]?>" value="<?=$texto?>" <?=$sol?> class="<?=$clase_obligaria?>" /></label></td>
			</tr>
			
			<?}}
			($clase_css=="tabla_zebra0")? $clase_css="tabla_zebra1" : $clase_css="tabla_zebra0";
		}
		?></table>
		<div class="subtitulos2"><a href="#" onclick="validar_catalogo_formulario('<?=$c?>')" class="boton">&nbsp;&nbsp;Guardar&nbsp;&nbsp;</a></div>
		</form>
		<div id="catalogo_insertar_resultado">
			
		</div>
		<?php			
	}
	public function catalogo_insertar($t,$cv){
	
		$sql_campos="";
		$sql_valores="";
		$prefijo2='HP_';
		
		$separar_campos=explode("@@@",trim($cv));
		foreach ($separar_campos as $cam){
			$separar_campos2=explode("|||",trim($cam));
			$campoX=str_replace("txt_","",trim($separar_campos2[0]));
			$valorX=trim($separar_campos2[1]);
			($sql_campos=="")? $sql_campos=$campoX : $sql_campos.=",".$campoX;
			($sql_valores=="")? $sql_valores=$valorX : $sql_valores.=",'".$valorX."'";
		}
		$sql_insertar="INSERT INTO $t($sql_campos) VALUES ($sql_valores);";
		//print_r($sql_insertar); exit;
		$consulta=mysql_query($sql_insertar,$this->conectarBd());
		if ($consulta){
			echo "<br><b>&nbsp;Registro Insertado Correctamente.</b>";
			$idL=mysql_insert_id($this->conectarBd());
			//print_r($idL);
			//exit;
			?>
			<font style="font-size:18px;"><br><a href="#" onclick="formProyecto('<?=$idL?>','<?=$t?>')" style="color:blue;text-decoration: none;" title="Proyecto">Seleccionar el proyecto al que pertenece</a></font>
			<?
			 
		} else {
			echo "<br>&nbsp; Error SQL (".mysql_error($link).")<br><br><b>&nbsp;El Registro NO se Inserto.</b>";
		}
		//}//fin try

	}
	public function catalogo_update($c,$prefijo){
		$ta=str_replace($prefijo,"",$c);
		$sql_orden="";

		
		$Sql2 ="DESCRIBE ".$c;
		$result2 = mysql_query($Sql2,$this->conectarBd())or die("No se puede ejecutar la consulta: ".mysql_error());		
		$sql3="SELECT * FROM $c $sql_orden";
		if ($res3=mysql_query($sql3,$this->conectarBd())){
			 $ndr3=mysql_num_rows($res3);
			 if ($ndr3>0){
				echo '<br><div class="subtitulos2">CATALOGO "'.strtoupper(str_replace($prefijo,"",$c)).'"</div><table align="left" class="tabla1" cellspacing="0"><tr class="tabla_campos">';
		while($Rs2 = mysql_fetch_array($result2)) {
			
			echo "<td>".$Rs2["Field"];
			if ($Rs2['Key']=='PRI'){ $sql_orden=" ORDER BY ".$Rs2['Field']; }
			echo "$Rs2";
			echo "</td>";
			$PrefijoCampo="Id_";
			$CA="Select ";
			echo "";
		}
		echo "</tr>";
				 $clase_css="tabla_zebra0";
				 while($reg3=mysql_fetch_array($res3)){
					$ndc_respuesta=count($reg3)/2;
					
					if ($ndc_respuesta>0){
						echo "<tr class='$clase_css'>";
						for ($i=0;$i<$ndc_respuesta;$i++){
							if($i==0){
							?>
							<td><a href="#" onclick="actualiza('<?=$c;?>','<?=$prefijo;?>','<?=$reg3[$i];?>')" title="'<?=$reg3[$i];?>'"><?=$reg3[$i];?></a></td>
							<?
							}
							else{
							echo "<td>".utf8_encode($reg3[$i])."</td>";
							}
						}
						echo "</tr>";
						($clase_css=="tabla_zebra0")? $clase_css="tabla_zebra1" : $clase_css="tabla_zebra0";	
					}

				 }
				 
			 }
			 else{
				$res3=mysql_query($sql3,$this->conectarBd());
				$ndr3=mysql_num_rows($res3);
				echo '<br> CATALOGO: '.strtoupper(str_replace($prefijo,"",$c)).' SE ENCUENTRA VACIO';
			 }
		} else {
			echo "<br>Error SQL [".mysql_error($link)."].";
			exit;			
		}		
		//echo "<tr></tr>";
		echo '</table>';		
	}
	
	public function catalogo_actualiza($c,$prefijo,$id){

		$ta=str_replace($prefijo,"",$c);
		$cuatro="id_".$ta;
		$recuperaValor="SELECT * FROM $c WHERE $cuatro='$id'";//PARA CADA UNO DE LOS CATALOGOS ES IMPORTANTE COLOCAR EL CAMPO DE ID COMO id_NOMBRE_DE_LA_TABLA
		$modi= mysql_query($recuperaValor,$this->conectarBd()) or die("No se puede ejecutar la consulta: ".mysql_error());
		$row=mysql_fetch_array($modi);
		$sql_orden="";	
		$Sql2 ="DESCRIBE ".$c;  
		$result2 = mysql_query($Sql2,$this->conectarBd()) or die("No se puede ejecutar la consulta: ".mysql_error());
		$uno="select * from proyecto";
		$dos=mysql_query($uno,$this->conectarBd());
		
		?>
		
		<div class="subtitulos2"><?=strtoupper(str_replace($prefijo,"",$c));?></div>
		<form name="frm_catalogo_nuevo_<?=$c?>" id="frm_catalogo_nuevo_<?=$c?>">
		<table align="center" class="tabla1" cellspacing="0" >
		<tr><td colspan="2" class="tabla_campos">Actualizar registro # <?=$id;?></td></tr>
		<?php
		$clase_css="tabla_zebra0";
		$i=0;
		while($Rs2 = mysql_fetch_array($result2)) {

			$field=$Rs2["Field"];
			$type=$Rs2["Type"];
			$null=$Rs2["Null"];
			$key=$Rs2["Key"];
			$default=$Rs2["Default"];
			$extra=$Rs2["Extra"];
			$texto="";
			$sol="";
			$idN=$id;
			if (!$default==""){ $texto=$default; $sol=" readonly='1' "; } 
			if ($extra=="auto_increment"){ $texto="$id"; $sol=" readonly='1' "; } 
			if ($null=="NO"){ $clase_obligaria="campo_obligatorio"; } else { $clase_obligaria="campo_opcional"; }
			if ($extra!="auto_increment"){
				if($Rs2["Field"]=="id_proyecto"){
					if($row[$i]==""||$row[$i]=="NULL"){
						$t=$c;
						$idL=$id;
						?>
						<tr class="campo_vertical,<?=$clase_css?>"><td colspan="2" align="center" style="font-size: 14px; font:bold;">El proyecto no tiene registrado a que catalogo pertenece<br><a href="#" onclick="formProyecto('<?=$idL?>','<?=$t?>')" style="color:blue;text-decoration: none;" title="Proyecto">Seleccionar el proyecto al que pertenece</a></td></tr>
						<?
					}
					else{
						?>
						<tr class="campo_vertical,<?=$clase_css?>">
				<td><font color="blue">*<?=$Rs2["Field"]?></font></td> 
				<td>&nbsp;<label><input type="text" name="txt_<?=$Rs2["Field"]?>" id="txt_<?=$Rs2["Field"]?>" value="<?=$row[$i]?>" <?=$sol?>" class="<?=$clase_obligaria?>"  /></label></td>
				<input type="hidden" name="campo_<?=$Rs2["Field"]?>" id="campo_<?=$Rs2["Field"]?>" value="<?=$row[$i]?>">
			</tr>
						
						<tr><td colspan="2"><table align="center" >
							<?
							?>
							<tr align="center"><?
							while($rowProyecto=mysql_fetch_array($dos)){
								?>
								
									<td style="font-size: 11px; font:bold;"><font color="blue"><?=$rowProyecto["id_proyecto"];?>=
									<?=$rowProyecto["nombre_proyecto"];?></font></td>
								
								<?
							}
							
							?>
						</tr></table></td></tr>
						<?
					}
					
					
				}
				else{?>
				<tr class="campo_vertical,<?=$clase_css?>">
				<td><?=$Rs2["Field"]?></td> 
				<td>&nbsp;<label><input type="text" name="txt_<?=$Rs2["Field"]?>" id="txt_<?=$Rs2["Field"]?>" value="<?=utf8_encode($row[$i])?>" <?=$sol?>" class="<?=$clase_obligaria?>"  /></label></td>
				<input type="hidden" name="campo_<?=$Rs2["Field"]?>" id="campo_<?=$Rs2["Field"]?>" value="<?=$row[$i]?>">
			</tr>
					<?
				}
			
			}
			?>
			
			<?php
			($clase_css=="tabla_zebra0")? $clase_css="tabla_zebra1" : $clase_css="tabla_zebra0";
			$i++;
		}
		?></table>
		<div class="subtitulos2"><a href="#" onclick="actualizate('<?=$c;?>','<?=$idN;?>')" class="boton" style="font-size: 14px;">&nbsp;&nbsp;Actualizar&nbsp;&nbsp;</a></div>
		</form>
		<div id="catalogo_insertar_resultado">
			
		</div>
		<?php			
		
	}
	
	public function actualizate($t,$cv,$id){
		$sql_campos="";
		$sql_valores="";
		$prefijo2='HP_';
		$tres=str_replace($prefijo2,"",$t);
		$cuatro="id_".$tres;

		$separar_campos=explode("@@@",trim($cv));
		foreach ($separar_campos as $cam){
			$separar_campos2=explode("|||",trim($cam));
			$campoX=str_replace("txt_","",trim($separar_campos2[0]));
			$valorX=trim($separar_campos2[1]);			
			
			($sql_campos=="")? $sql_campos=$campoX : $sql_campos.=",".$campoX;
			($sql_valores=="")? $sql_valores=$valorX : $sql_valores.=",'".$valorX."'";
		}
		$pruba=explode(',',$sql_campos);
		$pruba2=explode(',',$sql_valores);
		$cuenta=count($pruba);
		$b= array ();
		for($j=2;$j<$cuenta-2;$j++){
		$a=$i+$j;
		if($pruba[$a]==""){
			unset($b[$i]);
		}
		else{
		$b[$i]=$pruba[$a]."=".$pruba2[$a];
		}
		$i++;
		}
		
		$dos=implode(",",$b);
		//try{
		$sql_actualizar="UPDATE $t SET $dos where $cuatro=$id";
		if (mysql_query($sql_actualizar,$this->conectarBd())){
			echo "<font style='font-size:14px;'><br><b>&nbsp;Registro Actualizado Correctamente.</b></font>";
		} else {
			echo "<font style='font-size:14px;'><br>&nbsp;Error SQL <br><br><b>&nbsp;El Registro NO se Actualizo.</b></font>";
		}

	}
	
	public function formProyecto($id,$t){
		$pro="Select id_proyecto,nombre_proyecto from proyecto";
		//print_r($pro);
		//exit;
		$sqlPro=mysql_query($pro,$this->conectarBd());
		?>
		<form name="check" id="check">
		<table border="0" cellpadding="1" cellspacing="1" width=20% align='center' style="margin: 5px;background: #FFF;border: 1px solid #666;font-size: 12px;" width="100">
		
			<tr align="center">
				<th colspan="2" style="border: 1px solid #CCC;background: #f0f0f0;height: 10px;padding: 5px;">Proyectos HP</th>
			</tr>
			<tr align="center">
				<th style="border: 1px solid #CCC;background: #f0f0f0;height: 3px;padding: 5px;">#</th>
				<th style="border: 1px solid #CCC;background: #f0f0f0;height: 7px;padding: 5px;">Nombre del proyecto</th>
			</tr>
		<?
		$color="#FFF";
		$i=1;
		while($rowPro=mysql_fetch_array($sqlPro)){
			 $idCheck="chk_".$i;
	?>
		
			<tr align="center">
				<td style="background: <?=$color;?>;height: 3px;padding: 5px;border-bottom: 1px solid #666;text-align: center;"><input type="checkbox" name="<?=$idCheck?>" id="<?=$idCheck?>" value="<?=$rowPro["id_proyecto"];?>"></td>
				<td style="background: <?=$color;?>;height: 7px;padding: 5px;border-bottom: 1px solid #666;text-align: center;"><?=$rowPro["nombre_proyecto"]?></td>
			</tr>
	<?
		}
	?>
			<tr align="center">
				<td colspan="2"><input type="button" name="aceptar" id="aceptar" value="Guardar" onclick="guardadatos('<?=$t?>','<?=$id?>')"></td>
			</tr>
		</table></form>	
	<?
	
	
	}
	public function recupera($check,$id,$t){
		$prefijo2='HP_';
		$tres=str_replace($prefijo2,"",$t);
		$cuatro="id_".$tres;
		$add="update $t set id_proyecto= '".$check."' where $cuatro='".$id."'";
	     mysql_query($add,$this->conectarBd());
		    if(!$add){
		        
		    }
		    else{
			echo "Su registro ha finalizado";
	    	    }
	}
	
	
	
	
}
?>
