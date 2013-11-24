<?php 
	session_start();
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	include ("../../conf/conectarbase.php");
	//print_r($_SESSION);
	$id_usuario=$_SESSION["usuario_id"];
	
	//print_r($_POST);
	$a=$_POST["action"];

	if ($a=="listar"){
		$id_usuario=$_SESSION["usuario_id"];
		$nivel_usuario=$_SESSION["usuario_nivel"];		
		//AND repara=$id_usuario
		if ($nivel_usuario==14){ $sql_where=" WHERE status_cliente='CC' "; } else { $sql_where=" WHERE status_cliente='CC' "; }
		
		
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
		<table width="800" align="center" class="tabla1" cellpadding="2" cellspacing="0" id="tbl_calidad">
		<tr>
		  <td colspan="7" class="titulo_tabla1" height="23" align="center">Productos en Control de Calidad(<?=$ndr1?> Resultados) </td>
		  </tr>
		<tr>
		  <td height="23" width="17" class="campos_tabla1">Id</td>
		  <td width="60" class="campos_tabla1">OT</td>
		  <td width="107" class="campos_tabla1">Fecha Recibo </td>
		  <td width="270" class="campos_tabla1">No. Serie. </td>
		  <td width="269" class="campos_tabla1">Repar&oacute;</td>
		  <td width="55" class="campos_tabla1">Status</td>
		  <td width="96" class="campos_tabla1">Acciones</td>
		  </tr>
		<?php $col="#FFFFFF";	while($registro1=mysql_fetch_array($resultado1)){?>
		<tr bgcolor="<?=$col?>">
		  <td height="23" align="center"><?=$registro1["id"]?></td>
		  <td class="tda_tabla1" align="center"><?=$registro1["ot"]?></td>
		  <td align="center"><?=$registro1["f_recibo"]?></td>
			<td class="tda_tabla1">&nbsp;<?=$registro1["nserie"]?></td>
			<td><?php
            	echo ' '.$id_repara=$registro1["repara"];
				$sql_tecnico="SELECT dp_nombre,dp_apaterno FROM usuarios WHERE id_usuario='$id_repara' LIMIT 1; ";
				if ($resultado_tecnico=mysql_query($sql_tecnico,$link)){
					//echo "<div align=center>OK</div>";
					$reg_tecnico=mysql_fetch_array($resultado_tecnico);
					echo ". ".$reg_tecnico["dp_nombre"]." ".$reg_tecnico["dp_apaterno"];
				} else {
					die ("<div align=center>Error SQL (".mysql_error($link)."). La consulta a la Base de Datos no se ejecuto.</div>");
					//exit();
				}				
			?></td>
			<td align="center" class="tda_tabla1" <?php if($registro1["status_proceso"]=='PDC'){ ?> bgcolor="#FFFF00" <?php } ?>><?=$registro1["status_proceso"]?></td>
			<td align="center"><a href="javascript:revisar('<?=$registro1["id"]?>');" title="Realizar pruebas de Control de Calidad a este Producto.">Revisar OT</a>
            </td>
		  </tr>
		<?php ($col=="#FFFFFF")? $col="#EFEFEF" : $col="#FFFFFF"; }	mysql_free_result($resultado1); ?>  
		</table>        
        <?php	
	}
	if ($a=="revisar"){
		$id_ot=$_POST["id_ot"];
		//echo "<br>BD [$sql_ing] SQL=".
		$sql1="SELECT * FROM ot WHERE id=$id_ot";
		if ($resultado1=mysql_query($sql1,$link)){
			//echo "<div align=center>OK</div>";
			$ndr1=mysql_num_rows($resultado1);
			$registro1=mysql_fetch_array($resultado1);
			//echo "<br><br>"; print_r($registro1);
			$idp=$registro1["idp"];
			?>
            <div id="datos_producto">
                <table width="790">
                    <tr>
                                  <td height="24" colspan="4" style="font-size:18px; text-align:center; border-bottom:#000 1px solid;">Datos del producto.</td>
                  </tr>
                    <tr>
                      <td width="22%" class="campos_negritas">Id OT</td>
                      <td width="28%">&nbsp;<?=$id_ot_XXX=$registro1["id"]?></td>
                      <td width="22%" class="campos_negritas">Diagn&oacute;stico</td>
                      <td width="28%">&nbsp;<?=$diag2=$registro1["cod_diag"];
		      $sql_diagnostico="SELECT diagnostico FROM cat_diagnosticos WHERE id=$diag2 ";
			             $resultado_diagnostico=mysql_query($sql_diagnostico,$link);
				     $registro_diagnostico=mysql_fetch_array($resultado_diagnostico);
				echo strtoupper(". ".$registro_diagnostico["diagnostico"]); 		?></td>
                  </tr>
                    <tr>
                      <td class="campos_negritas">Fecha de Recibo</td>
                      <td>&nbsp;<?=$registro1["f_recibo"]?></td>
                      <td class="campos_negritas">Recibe</td>
                      <td>&nbsp;<?php
                        echo $id_urecibe=$registro1["u_recibe"];
                        $sql_usuario="SELECT dp_nombre,dp_apaterno,dp_amaterno FROM usuarios WHERE id_usuario=$id_urecibe ";
                        $resultado_usuario=mysql_query($sql_usuario,$link);
                            $registro_usuario=mysql_fetch_array($resultado_usuario);
                            echo ". ".$registro_usuario["dp_nombre"]." ".$registro_usuario["dp_apaterno"]." ".$registro_usuario["dp_amaterno"];
                        ?>
                      </td>
                  </tr>
                    <tr>
                      <td class="campos_negritas">Fecha de Inicio Reparaci&oacute;n</td>
                      <td>&nbsp;<?=$registro1["fecha_inicio"]?></td>
                      <td class="campos_negritas">Fecha de Fin Reparaci&oacute;n</td>
                      <td>&nbsp;<?=$registro1["fecha_fin_rep"]?></td>
                  </tr>
                    <tr>
                      <td class="campos_negritas">Repara</td>
                      <td>&nbsp;<?php
                        echo $id_repara=$registro1["repara"];
                        $sql_usuario2="SELECT dp_nombre,dp_apaterno,dp_amaterno FROM usuarios WHERE id_usuario=$id_repara ";
                        $resultado_usuario2=mysql_query($sql_usuario2,$link);
                            $registro_usuario2=mysql_fetch_array($resultado_usuario2);
                            echo ". ".$registro_usuario2["dp_nombre"]." ".$registro_usuario2["dp_apaterno"]." ".$registro_usuario2["dp_amaterno"];
                        ?>          
                      </td>
                      <td class="campos_negritas">No de Reparaciones</td>
                      <td>&nbsp;<?=$registro1["num_no_ok"]?></td>
                  </tr>
                    <tr>
                      <td class="campos_negritas">Status</td>
                      <td>&nbsp;<?=$statusX=$registro1["status_proceso"]?></td>
                      <td class="campos_negritas">Observaciones</td>
                      <td>&nbsp;<?=$registro1["obs"]?></td>
                  </tr>
                </table>
              </div>
            <div id="p_funcionales">
            	<div style="text-align:center; font-size:18px;">Pruebas Funcionales</div>
                <div id="div_pruebas_f_contenido">
                	<?php
					$ndr3=0;
					//echo "<br>BD [$sql_ing] SQL=".
					$sql_pfuncionales="SELECT * FROM cat_pruebas_funcionales WHERE productos LIKE '%$idp%' ORDER BY id";
					if ($resultado_pfuncionales=mysql_query($sql_pfuncionales,$link)){
						//echo "<div align=center>OK</div>";
						//echo "<br>NDR=".
						$ndr_pfuncionales=mysql_num_rows($resultado_pfuncionales);
					} else {
						echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
						exit();
					}		
					
					
					
					
					//echo "<hr>".$statusX;
					if($statusX=='PDC'){
						$m_pf_registradas=array();
						$m_pc_registradas=array();
						
						//echo "<br>".
						$sql_pfuncionales_ya_seleccionadas="SELECT tipo_prueba,id_prueba FROM evaluacion_pruebas WHERE id_ot = '$id_ot_XXX' AND valor='1' ORDER BY id";
						if ($resultado_pfuncionales_ya_seleccionadas=mysql_query($sql_pfuncionales_ya_seleccionadas,$link)){
							//echo "<div align=center>OK</div>";
							//echo "<br>NDR=".
							$ndr_pfuncionales_ya_seleccionadas=mysql_num_rows($resultado_pfuncionales_ya_seleccionadas);
							while($reg_pfuncionales_ya_seleccionadas=mysql_fetch_array($resultado_pfuncionales_ya_seleccionadas)){
								//echo "<br>";	print_r($reg_pfuncionales_ya_seleccionadas);
								if($reg_pfuncionales_ya_seleccionadas["tipo_prueba"]=='FUNCIONAL') array_push($m_pf_registradas,$reg_pfuncionales_ya_seleccionadas["id_prueba"]);
								if($reg_pfuncionales_ya_seleccionadas["tipo_prueba"]=='COSMETICA') array_push($m_pc_registradas,$reg_pfuncionales_ya_seleccionadas["id_prueba"]);
							}
						} else {
							echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
							exit();
						}
						/*
						echo "<br>PF=";	print_r($m_pf_registradas);		
						echo "<br>PC=";	print_r($m_pc_registradas);						
						*/
					}
					
					?>
					<form name="frm_pfuncionales">
                    <br /><table width="95%" align="left" class="tabla1" cellpadding="2" cellspacing="0">
					<tr>
					  <td colspan="3" class="titulo_tabla1" height="20"> Pruebas Funcionales asignadas al Producto <?=$idp?></td>
					  </tr>
					<tr>
					  <td width="20" class="campos_tabla1" height="20">&nbsp;</td>
					  <td width="78" class="campos_tabla1">Id</td>
					  <td width="1084" class="campos_tabla1">Descripci&oacute;n</td>
					  </tr>
					<?php 
						$col="#FFFFFF";	
						while($registro_pfuncionales=mysql_fetch_array($resultado_pfuncionales)){
							$maplica_productos_pfuncionales=explode(',',$registro_pfuncionales["productos"]);
							foreach ($maplica_productos_pfuncionales as $aplica_producto){
								if ($aplica_producto==$idp){ 
									//echo "Encontrado idp[$idp] en la Falla [$aplica_producto]"; 
									++$ndr3;
									?>
									<tr bgcolor="<?=$col?>">
									  <td height="20"><input type="checkbox" id="chk_pf_<?=$registro_pfuncionales["id"]?>" value="<?=$registro_pfuncionales["id"]?>" /></td>
									  <td class="tda_tabla1" align="center">&nbsp;<?=$registro_pfuncionales["id"]?></td>
									  <td>&nbsp;<?=$registro_pfuncionales["descripcion"]?></td>
									  </tr>							
									<?php
									($col=="#FFFFFF")? $col="#EFEFEF" : $col="#FFFFFF";
								}
							}
						}	
					?>  
					</table>
					<?php
					if(count($m_pf_registradas)>0){
						foreach($m_pf_registradas as $PFx){
							//echo "<br>".$PFx;
							?>
							<script language="javascript">
							$("#chk_pf_<?=$PFx?>").attr('checked','checked');
							</script>
							<?php
						}
					}					
					?>
                    <div style="clear:both; text-align:center; margin-top:5px; color:#03F; font-size:11px;">
						<?=$ndr3?> Resultado(s).
                       	<?php if($ndr3==0){ echo "<br>La OT actual no tiene asignada ninguna Prueba Funcional. Si desea evaluar esta OT, vaya al Catalogo de Pruebas Funcionales. "; }	?>
                    </div>
                    </form>
                </div>
            </div>
            <div id="p_esteticas">
            	<div style="text-align:center; font-size:18px;">Pruebas Cosm&eacute;ticas.</div>
                <div id="div_pruebas_e_contenido">
                
                	<?php
					$ndr3=0;
					//echo "<br>BD [$sql_ing] SQL=".
					$sql_pesteticas="SELECT * FROM cat_pruebas_esteticas WHERE productos LIKE '%$idp%' ORDER BY id";
					if ($resultado_pesteticas=mysql_query($sql_pesteticas,$link)){
						//echo "<div align=center>OK</div>";
						//echo "<br>NDR=".
						$ndr_pesteticas=mysql_num_rows($resultado_pesteticas);
					} else {
						echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
						exit();
					}		
					?>
					<form name="frm_pesteticas">
                    <br /><table width="95%" align="left" class="tabla1" cellpadding="2" cellspacing="0">
					<tr>
					  <td colspan="3" class="titulo_tabla1" height="20"> Pruebas Cosm&eacute;ticas asignadas al Producto <?=$idp?></td>
					  </tr>
					<tr>
					  <td width="20" class="campos_tabla1" height="20">&nbsp;</td>
					  <td width="78" class="campos_tabla1">Id</td>
					  <td width="1084" class="campos_tabla1">Descripci&oacute;n</td>
					  </tr>
					<?php 
						$col="#FFFFFF";	
						while($registro_pesteticas=mysql_fetch_array($resultado_pesteticas)){
							$maplica_productos_pesteticas=explode(',',$registro_pesteticas["productos"]);
							foreach ($maplica_productos_pesteticas as $aplica_producto){
								if ($aplica_producto==$idp){ 
									//echo "Encontrado idp[$idp] en la Falla [$aplica_producto]"; 
									++$ndr3;
									?>
									<tr bgcolor="<?=$col?>">
									  <td height="20"><input type="checkbox" id="chk_pc_<?=$registro_pesteticas["id"]?>" value="<?=$registro_pesteticas["id"]?>" /></td>
									  <td class="tda_tabla1" align="center">&nbsp;<?=$registro_pesteticas["id"]?></td>
									  <td>&nbsp;<?=$registro_pesteticas["descripcion"]?></td>
									  </tr>							
									<?php
									($col=="#FFFFFF")? $col="#EFEFEF" : $col="#FFFFFF";
								}
							}
							
						}
					?>  
					</table>
					<?php
					if(count($m_pc_registradas)>0){
						foreach($m_pc_registradas as $PCx){
							//echo "<br>".$PFx;
							?>
							<script language="javascript">
							$("#chk_pc_<?=$PCx?>").attr('checked','checked');
							</script>
							<?php
						}
					}					
					?>                     
					 
					  
                    <div style="clear:both; text-align:center; margin-top:5px; color:#03F; font-size:11px;">
						<?=$ndr3?> Resultado(s).
                    	<?php if($ndr3==0){ echo "<br>La OT actual no tiene asignada ninguna Prueba Estetica. Si desea evaluar esta OT, vaya al Catalogo de Pruebas Esteticas. "; }	?>
                    </div>
                    </form>
                
                
                </div>            
            </div>
			<div id="div_botones_cc">
            	<form name="frm_botones">
                    <?php //echo "<br><br>"; print_r($registro1); ?>
                    <input type="hidden" id="hdn_idot" value="<?=$registro1["id"]?>" />
                    <input type="hidden" id="hdn_idp" value="<?=$registro1["idp"]?>" />
                    
                    Status: &nbsp;
                    <select name="statusCalidad" id="statusCalidad">
                              <option value="">Seleccione Status</option>
                              <option value="OK">OK</option>
                              <option value="NOK">NOK</option>
                              <option value="OKF">OKF</option>
                              <option value="PDC">PDC</option>
                     </select>&nbsp;
                    <input type="button" value="Guardar" onclick="guardar_control_calidad()" />
                </form>
            </div>           
            <?php
			
			
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}
	}
	
	if ($a=="guardar_oc"){
		$idot=$_POST["idot"];
		$idp=$_POST["idp"];
		$status=$_POST["nvo_status"];
		$ids_pf=explode(",",trim($_POST["ids_pf"]));
			$n_pf=count($ids_pf);
			//echo "<br>NDF=$n_pf   ";	print_r($ids_pf);
		$ids_pc=explode(",",trim($_POST["ids_pe"]));
			$n_pc=count($ids_pc);
			//echo "<br>NDC=$n_pc   ";	print_r($ids_pc);		
			
		
		
		if ($status=="OK"){
			if ($n_pf==0||$_POST["ids_pf"]==""){
				echo "<br>&nbsp;Error: No hay Pruebas Funcionales para evaluar. ";	exit;
			}
			if ($n_pc==0||$_POST["ids_pe"]==""){
				echo "<br>&nbsp;Error: No hay Pruebas Cosmeticas para evaluar. ";	exit;
			}			
			
			
			// Obtener las pruebas funcionales asociadas al producto en curso.
			//echo "<br>&nbsp;".
			$sql_pfuncionales="SELECT * FROM cat_pruebas_funcionales WHERE productos LIKE '%$idp%' ORDER BY id";
				if ($resultado_pfuncionales=mysql_query($sql_pfuncionales,$link)){
					//echo "<div align=center>OK</div>";
					//echo "<br>NDR=".
					$ndr_pfuncionales=mysql_num_rows($resultado_pfuncionales);
				} else {
					echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
					exit();
				}			
				while($registro_pfuncionales=mysql_fetch_array($resultado_pfuncionales)){
					$maplica_productos_pfuncionales=explode(',',$registro_pfuncionales["productos"]);
					foreach ($maplica_productos_pfuncionales as $aplica_producto){
						if ($aplica_producto==$idp){ 
							//echo "<hr>"; print_r($registro_pfuncionales);
							if (in_array($registro_pfuncionales["id"],$ids_pf)){ 
								//echo "<br> ".$registro_pfuncionales["id"]." SI esta en el array (ids_pf). "; 
								//echo "<br><br>".
								$sql_registro_cc_pf="INSERT INTO evaluacion_pruebas(id,fecha,hora,id_usuario,id_ot,tipo_prueba,id_prueba,valor) 
									VALUES(NULL,'".date("Y-m-d")."','".date("H:i:s")."','$id_usuario','$idot','FUNCIONAL','".$registro_pfuncionales["id"]."','1')";
								if (!mysql_query($sql_registro_cc_pf,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Funcional ($id_pf).";	exit;}									
							
							} else { 
								//echo "<br> ".$registro_pfuncionales["id"]." NO esta en el array (ids_pf). ";
								//echo "<br><br>".
								$sql_registro_cc_pf="INSERT INTO evaluacion_pruebas(id,fecha,hora,id_usuario,id_ot,tipo_prueba,id_prueba,valor) 
									VALUES(NULL,'".date("Y-m-d")."','".date("H:i:s")."','$id_usuario','$idot','FUNCIONAL','".$registro_pfuncionales["id"]."','0')";
								if (!mysql_query($sql_registro_cc_pf,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Funcional ($id_pf).";	exit;}								
							}
						}
					}
				}
			// ------------------------------------------------------------------------------------
			
			// Obtener las pruebas cosmeticas asociadas al producto en curso.
			$sql_pesteticas="SELECT * FROM cat_pruebas_esteticas WHERE productos LIKE '%$idp%' ORDER BY id";
			if ($resultado_pesteticas=mysql_query($sql_pesteticas,$link)){
				//echo "<div align=center>OK</div>";
				//echo "<br>NDR=".
				$ndr_pesteticas=mysql_num_rows($resultado_pesteticas);
			} else {
				echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
				exit();
			}
			while($registro_pesteticas=mysql_fetch_array($resultado_pesteticas)){
				$maplica_productos_pesteticas=explode(',',$registro_pesteticas["productos"]);
				foreach ($maplica_productos_pesteticas as $aplica_producto){
					if ($aplica_producto==$idp){ 
						if (in_array($registro_pesteticas["id"],$ids_pc)){ 
							//echo "<br> ".$registro_pesteticas["id"]." SI esta en el array (ids_pc). "; 
							//echo "<br><br>".
							$sql_registro_cc_pc="INSERT INTO evaluacion_pruebas(id,fecha,hora,id_usuario,id_ot,tipo_prueba,id_prueba,valor) 
								VALUES(NULL,'".date("Y-m-d")."','".date("H:i:s")."','$id_usuario','$idot','COSMETICA','".$registro_pesteticas["id"]."','1')";
							if (!mysql_query($sql_registro_cc_pc,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Cosmetica ($id_pc).";	exit; }									
						
						} else { 
							//echo "<br> ".$registro_pesteticas["id"]." NO esta en el array (ids_pc). ";
							//echo "<br><br>".
							$sql_registro_cc_pc="INSERT INTO evaluacion_pruebas(id,fecha,hora,id_usuario,id_ot,tipo_prueba,id_prueba,valor) 
								VALUES(NULL,'".date("Y-m-d")."','".date("H:i:s")."','$id_usuario','$idot','COSMETICA','".$registro_pesteticas["id"]."','0')";
							if (!mysql_query($sql_registro_cc_pc,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Cosmetica ($id_pc).";	exit; }								
						}
					}
				}
				
			}			
			// ------------------------------------------------------------------------------------			
			//echo "<br><br>OK ".
			$sql_actualiza_ot="UPDATE ot SET status_cliente='DES', status_proceso='$status',fecha_fin='".date("Y-m-d H:i:s")."' WHERE id=$idot ";
			if (!mysql_query($sql_actualiza_ot,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Cosmetica ($id_pc).";	exit;}
			?>
			<script type="text/javascript">
			                        alert("La OT <?=$idot?> se guardó correctamente.");
		                        </script><?php
		} elseif ($status=="NOK"){
			
			// Obtener las pruebas funcionales asociadas al producto en curso.
			//echo "<br>&nbsp;".
			$sql_pfuncionales="SELECT * FROM cat_pruebas_funcionales WHERE productos LIKE '%$idp%' ORDER BY id";
				if ($resultado_pfuncionales=mysql_query($sql_pfuncionales,$link)){
					//echo "<div align=center>OK</div>";
					//echo "<br>NDR=".
					$ndr_pfuncionales=mysql_num_rows($resultado_pfuncionales);
				} else {
					echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
					exit();
				}			
				while($registro_pfuncionales=mysql_fetch_array($resultado_pfuncionales)){
					$maplica_productos_pfuncionales=explode(',',$registro_pfuncionales["productos"]);
					foreach ($maplica_productos_pfuncionales as $aplica_producto){
						if ($aplica_producto==$idp){ 
							//echo "<hr>"; print_r($registro_pfuncionales);
							if (in_array($registro_pfuncionales["id"],$ids_pf)){ 
								//echo "<br> ".$registro_pfuncionales["id"]." SI esta en el array (ids_pf). "; 
								//echo "<br><br>".
								$sql_registro_cc_pf="INSERT INTO evaluacion_pruebas(id,fecha,hora,id_usuario,id_ot,tipo_prueba,id_prueba,valor) 
									VALUES(NULL,'".date("Y-m-d")."','".date("H:i:s")."','$id_usuario','$idot','FUNCIONAL','".$registro_pfuncionales["id"]."','1')";
								if (!mysql_query($sql_registro_cc_pf,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Funcional ($id_pf).";	exit;}									
							
							} else { 
								//echo "<br> ".$registro_pfuncionales["id"]." NO esta en el array (ids_pf). ";
								//echo "<br><br>".
								$sql_registro_cc_pf="INSERT INTO evaluacion_pruebas(id,fecha,hora,id_usuario,id_ot,tipo_prueba,id_prueba,valor) 
									VALUES(NULL,'".date("Y-m-d")."','".date("H:i:s")."','$id_usuario','$idot','FUNCIONAL','".$registro_pfuncionales["id"]."','0')";
								if (!mysql_query($sql_registro_cc_pf,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Funcional ($id_pf).";	exit;}								
							}
						}
					}
				}
			// ------------------------------------------------------------------------------------
			
			// Obtener las pruebas cosmeticas asociadas al producto en curso.
			$sql_pesteticas="SELECT * FROM cat_pruebas_esteticas WHERE productos LIKE '%$idp%' ORDER BY id";
			if ($resultado_pesteticas=mysql_query($sql_pesteticas,$link)){
				//echo "<div align=center>OK</div>";
				//echo "<br>NDR=".
				$ndr_pesteticas=mysql_num_rows($resultado_pesteticas);
			} else {
				echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
				exit();
			}
			while($registro_pesteticas=mysql_fetch_array($resultado_pesteticas)){
				$maplica_productos_pesteticas=explode(',',$registro_pesteticas["productos"]);
				foreach ($maplica_productos_pesteticas as $aplica_producto){
					if ($aplica_producto==$idp){ 
						if (in_array($registro_pesteticas["id"],$ids_pc)){ 
							//echo "<br> ".$registro_pesteticas["id"]." SI esta en el array (ids_pc). "; 
							//echo "<br><br>".
							$sql_registro_cc_pc="INSERT INTO evaluacion_pruebas(id,fecha,hora,id_usuario,id_ot,tipo_prueba,id_prueba,valor) 
								VALUES(NULL,'".date("Y-m-d")."','".date("H:i:s")."','$id_usuario','$idot','COSMETICA','".$registro_pesteticas["id"]."','1')";
							if (!mysql_query($sql_registro_cc_pc,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Cosmetica ($id_pc).";	exit; }									
						
						} else { 
							//echo "<br> ".$registro_pesteticas["id"]." NO esta en el array (ids_pc). ";
							//echo "<br><br>".
							$sql_registro_cc_pc="INSERT INTO evaluacion_pruebas(id,fecha,hora,id_usuario,id_ot,tipo_prueba,id_prueba,valor) 
								VALUES(NULL,'".date("Y-m-d")."','".date("H:i:s")."','$id_usuario','$idot','COSMETICA','".$registro_pesteticas["id"]."','0')";
							if (!mysql_query($sql_registro_cc_pc,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Cosmetica ($id_pc).";	exit; }								
						}
					}
				}
				
			}
			
			// ------------------------------------------------------------------------------------			
			//echo "<br>NOK".
			$sql_actualiza_ot="UPDATE ot SET status_cliente='REP', status_proceso='$status',num_no_ok=num_no_ok+1 WHERE id=$idot ";
			if (!mysql_query($sql_actualiza_ot,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Cosmetica ($id_pc).";	exit;}
			?>
			<script type="text/javascript">
			                        alert("La OT (<?=$idot?>) se guardo correctamente.");
		                        </script><?php
		} elseif($status=="OKF"){
			// Obtener las pruebas funcionales asociadas al producto en curso.
			//echo "<br>&nbsp;".
			$sql_pfuncionales="SELECT * FROM cat_pruebas_funcionales WHERE productos LIKE '%$idp%' ORDER BY id";
				if ($resultado_pfuncionales=mysql_query($sql_pfuncionales,$link)){
					//echo "<div align=center>OK</div>";
					//echo "<br>NDR=".
					$ndr_pfuncionales=mysql_num_rows($resultado_pfuncionales);
				} else {
					echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
					exit();
				}			
				while($registro_pfuncionales=mysql_fetch_array($resultado_pfuncionales)){
					$maplica_productos_pfuncionales=explode(',',$registro_pfuncionales["productos"]);
					foreach ($maplica_productos_pfuncionales as $aplica_producto){
						if ($aplica_producto==$idp){ 
							//echo "<hr>"; print_r($registro_pfuncionales);
							if (in_array($registro_pfuncionales["id"],$ids_pf)){ 
								//echo "<br> ".$registro_pfuncionales["id"]." SI esta en el array (ids_pf). "; 
								//echo "<br><br>".
								$sql_registro_cc_pf="INSERT INTO evaluacion_pruebas(id,fecha,hora,id_usuario,id_ot,tipo_prueba,id_prueba,valor) 
									VALUES(NULL,'".date("Y-m-d")."','".date("H:i:s")."','$id_usuario','$idot','FUNCIONAL','".$registro_pfuncionales["id"]."','1')";
								if (!mysql_query($sql_registro_cc_pf,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Funcional ($id_pf).";	exit;}									
							
							} else { 
								//echo "<br> ".$registro_pfuncionales["id"]." NO esta en el array (ids_pf). ";
								//echo "<br><br>".
								$sql_registro_cc_pf="INSERT INTO evaluacion_pruebas(id,fecha,hora,id_usuario,id_ot,tipo_prueba,id_prueba,valor) 
									VALUES(NULL,'".date("Y-m-d")."','".date("H:i:s")."','$id_usuario','$idot','FUNCIONAL','".$registro_pfuncionales["id"]."','0')";
								if (!mysql_query($sql_registro_cc_pf,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Funcional ($id_pf).";	exit;}								
							}
						}
					}
				}
			// ------------------------------------------------------------------------------------
			
			// Obtener las pruebas cosmeticas asociadas al producto en curso.
			$sql_pesteticas="SELECT * FROM cat_pruebas_esteticas WHERE productos LIKE '%$idp%' ORDER BY id";
			if ($resultado_pesteticas=mysql_query($sql_pesteticas,$link)){
				//echo "<div align=center>OK</div>";
				//echo "<br>NDR=".
				$ndr_pesteticas=mysql_num_rows($resultado_pesteticas);
			} else {
				echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
				exit();
			}
			while($registro_pesteticas=mysql_fetch_array($resultado_pesteticas)){
				$maplica_productos_pesteticas=explode(',',$registro_pesteticas["productos"]);
				foreach ($maplica_productos_pesteticas as $aplica_producto){
					if ($aplica_producto==$idp){ 
						if (in_array($registro_pesteticas["id"],$ids_pc)){ 
							//echo "<br> ".$registro_pesteticas["id"]." SI esta en el array (ids_pc). "; 
							//echo "<br><br>".
							$sql_registro_cc_pc="INSERT INTO evaluacion_pruebas(id,fecha,hora,id_usuario,id_ot,tipo_prueba,id_prueba,valor) 
								VALUES(NULL,'".date("Y-m-d")."','".date("H:i:s")."','$id_usuario','$idot','COSMETICA','".$registro_pesteticas["id"]."','1')";
							if (!mysql_query($sql_registro_cc_pc,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Cosmetica ($id_pc).";	exit; }									
						
						} else { 
							//echo "<br> ".$registro_pesteticas["id"]." NO esta en el array (ids_pc). ";
							//echo "<br><br>".
							$sql_registro_cc_pc="INSERT INTO evaluacion_pruebas(id,fecha,hora,id_usuario,id_ot,tipo_prueba,id_prueba,valor) 
								VALUES(NULL,'".date("Y-m-d")."','".date("H:i:s")."','$id_usuario','$idot','COSMETICA','".$registro_pesteticas["id"]."','0')";
							if (!mysql_query($sql_registro_cc_pc,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Cosmetica ($id_pc).";	exit; }								
						}
					}
				}
				
			}			
			// ------------------------------------------------------------------------------------				
			//echo "<br>$status".
			$sql_actualiza_ot="UPDATE ot SET status_cliente='DES', status_proceso='$status',fecha_fin='".date("Y-m-d H:i:s")."'  WHERE id=$idot ";
			if (!mysql_query($sql_actualiza_ot,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Cosmetica ($id_pc).";	exit;}
			?>
			                <script type="text/javascript">
			                        alert("La OT (<?=$idot?>) se guardo correctamente.");
		                        </script><?php				
		} elseif($status=="PDC"){
			
			
			
			
			
			
			
			// Obtener las pruebas funcionales asociadas al producto en curso.
			//echo "<br>&nbsp;".
			$sql_pfuncionales="SELECT * FROM cat_pruebas_funcionales WHERE productos LIKE '%$idp%' ORDER BY id";
				if ($resultado_pfuncionales=mysql_query($sql_pfuncionales,$link)){
					//echo "<div align=center>OK</div>";
					//echo "<br>NDR=".
					$ndr_pfuncionales=mysql_num_rows($resultado_pfuncionales);
				} else {
					echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
					exit();
				}			
				while($registro_pfuncionales=mysql_fetch_array($resultado_pfuncionales)){
					$maplica_productos_pfuncionales=explode(',',$registro_pfuncionales["productos"]);
					foreach ($maplica_productos_pfuncionales as $aplica_producto){
						if ($aplica_producto==$idp){ 
							//echo "<hr>"; print_r($registro_pfuncionales);
							if (in_array($registro_pfuncionales["id"],$ids_pf)){ 
								//echo "<br> ".$registro_pfuncionales["id"]." SI esta en el array (ids_pf). "; 
								//echo "<br><br>".
								$sql_registro_cc_pf="INSERT INTO evaluacion_pruebas(id,fecha,hora,id_usuario,id_ot,tipo_prueba,id_prueba,valor) 
									VALUES(NULL,'".date("Y-m-d")."','".date("H:i:s")."','$id_usuario','$idot','FUNCIONAL','".$registro_pfuncionales["id"]."','1')";
								if (!mysql_query($sql_registro_cc_pf,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Funcional ($id_pf).";	exit;}									
							
							} else { 
								//echo "<br> ".$registro_pfuncionales["id"]." NO esta en el array (ids_pf). ";
								//echo "<br><br>".
								
								$sql_registro_cc_pf="INSERT INTO evaluacion_pruebas(id,fecha,hora,id_usuario,id_ot,tipo_prueba,id_prueba,valor) 
									VALUES(NULL,'".date("Y-m-d")."','".date("H:i:s")."','$id_usuario','$idot','FUNCIONAL','".$registro_pfuncionales["id"]."','0')";
								if (!mysql_query($sql_registro_cc_pf,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Funcional ($id_pf).";	exit;}								
								
							}
						}
					}
				}
			// ------------------------------------------------------------------------------------			
			// Obtener las pruebas cosmeticas asociadas al producto en curso.
			$sql_pesteticas="SELECT * FROM cat_pruebas_esteticas WHERE productos LIKE '%$idp%' ORDER BY id";
			if ($resultado_pesteticas=mysql_query($sql_pesteticas,$link)){
				//echo "<div align=center>OK</div>";
				//echo "<br>NDR=".
				$ndr_pesteticas=mysql_num_rows($resultado_pesteticas);
			} else {
				echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
				exit();
			}
			while($registro_pesteticas=mysql_fetch_array($resultado_pesteticas)){
				$maplica_productos_pesteticas=explode(',',$registro_pesteticas["productos"]);
				foreach ($maplica_productos_pesteticas as $aplica_producto){
					if ($aplica_producto==$idp){ 
						if (in_array($registro_pesteticas["id"],$ids_pc)){ 
							//echo "<br> ".$registro_pesteticas["id"]." SI esta en el array (ids_pc). "; 
							//echo "<br><br>".
							$sql_registro_cc_pc="INSERT INTO evaluacion_pruebas(id,fecha,hora,id_usuario,id_ot,tipo_prueba,id_prueba,valor) 
								VALUES(NULL,'".date("Y-m-d")."','".date("H:i:s")."','$id_usuario','$idot','COSMETICA','".$registro_pesteticas["id"]."','1')";
							if (!mysql_query($sql_registro_cc_pc,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Cosmetica ($id_pc).";	exit; }									
						
						} else { 
							//echo "<br> ".$registro_pesteticas["id"]." NO esta en el array (ids_pc). ";
							//echo "<br><br>".
							$sql_registro_cc_pc="INSERT INTO evaluacion_pruebas(id,fecha,hora,id_usuario,id_ot,tipo_prueba,id_prueba,valor) 
								VALUES(NULL,'".date("Y-m-d")."','".date("H:i:s")."','$id_usuario','$idot','COSMETICA','".$registro_pesteticas["id"]."','0')";
							if (!mysql_query($sql_registro_cc_pc,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Cosmetica ($id_pc).";	exit; }								
						}
					}
				}
				
			}			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			//echo "<br>$status".
			$sql_actualiza_ot="UPDATE ot SET status_cliente='CC', status_proceso='$status'  WHERE id=$idot ";
			
			if (!mysql_query($sql_actualiza_ot,$link)){ echo "<br>&nbsp;Error SQL: No se registro la Prueba Cosmetica ($id_pc).";	exit;}
			?><div style="text-align:center; color:#090; font-weight:bold; font-size:14px;">La OT <?=$idot?> se guard&oacute; correctamente.</div><?php					
			
			
		} else{
			echo "<br>OTRO";	
		}
	}
?>