<?php 
	session_start();
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	include ("../../conf/conectarbase.php");
	//print_r($_SESSION);
	//print_r($_POST);
	$a=$_POST["action"];

	if ($a=="listar"){	
		$id_usuario=$_SESSION["usuario_id"];
		$nivel_usuario=$_SESSION["usuario_nivel"];		
		if ($nivel_usuario==13){ $sql_where=" WHERE status_cliente='REP' AND repara=$id_usuario"; } else { $sql_where=" WHERE status_cliente='REP' "; }
		
		
		//echo "<br>BD [$sql_ing] SQL=".
		$sql1="SELECT * FROM ot $sql_where ORDER BY id";
		if ($resultado1=mysql_query($sql1,$link)){
			//echo "<div align=center>OK</div>";
			$ndr1=mysql_num_rows($resultado1);
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}
		//echo "<br>".$sql1;	
		?>
		<table width="800" align="center" class="tabla1" cellpadding="2" cellspacing="0">
		<tr>
		  <td colspan="7" class="titulo_tabla1" height="23" align="center">Productos en Reparaci&oacute;n  (<?=$ndr1?> Resultados) </td>
		  </tr>
		<tr>
		  <td height="23" width="17" class="campos_tabla1">Id</td>
		  <td width="60" class="campos_tabla1">OT</td>
		  <td width="107" class="campos_tabla1">Fecha Recibo </td>
		  <td width="270" class="campos_tabla1">No. Serie. </td>
		  <td width="269" class="campos_tabla1">Repara</td>
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
            	echo $id_recibe=$registro1["repara"];
				if (!$id_recibe==""){
					$sql_usuario1="SELECT dp_nombre,dp_apaterno,dp_amaterno FROM usuarios WHERE id_usuario=$id_recibe ";
					$resultado_usuario1=mysql_query($sql_usuario1,$link);
						$registro_usuario1=mysql_fetch_array($resultado_usuario1);
						echo strtoupper(". ".$registro_usuario1["dp_nombre"]." ".$registro_usuario1["dp_apaterno"]);        
				}			
			?></td>
			<td align="center" class="tda_tabla1"><?=$registro1["status_proceso"]?></td>
			<td align="center"><a href="javascript:reparar('<?=$registro1["id"]?>');" title="Iniciar Reparacion de este Producto.">Reparar OT</a></td>
		  </tr>
		<?php ($col=="#FFFFFF")? $col="#EFEFEF" : $col="#FFFFFF"; }	mysql_free_result($resultado1); ?>  
		</table>	
	<?php	
	}
	if ($a=="reparar"){	
		$id_ot=$_POST["id_ot"];
		
		//echo "<br>".
		$sql1="SELECT * FROM ot WHERE id='$id_ot'";	
		if ($result1=mysql_query($sql1,$link)){
			if ($ndr1=mysql_num_rows($result1)>0){
				while($registro1=mysql_fetch_array($result1)){
					//echo "<br>"; print_r($registro1);
					$idp=$registro1["idp"];				$nds=$registro1["nserie"];		$fdr=$registro1["f_recibo"];		$dig=$registro1["cod_diag"];
					$ure=$registro1["u_recibe"];		$urp=$registro1["repara"];		$fio=$registro1["fecha_inicio"];		$ffr=$registro1["fecha_fin_rep"];
					$ffn=$registro1["fecha_fin"];		$stp=$registro1["status_proceso"];		$stc=$registro1["status_cliente"];		$obr=$registro1["obs_rep"];
					$obs=$registro1["obs"];				$gar=$registro1["garantia"];		$ot=$registro1["ot"];
					$obsr=$registro1["obs_rep"];		$dia=$registro1["cod_diag"];	$tec=$registro1["repara"];
					
					$nno=$registro1["num_no_ok"];		$dia=$registro1["cod_diag"];	//$tec=$registro1["respara"];
					if ($nno>1){
						//echo "<br>NDNOK=$nno";
						?>
                        <script language="javascript">
                        	//llenar_campos();
                        </script>
                        <?php
					}
				}	
			} else {
				echo "<div align=center>&nbsp;Error. No se encontro la OT ($ot).</div>";
				exit();
			}
		} else {
			echo "<div align=center>&nbsp;Error SQL. La consulta no se ejecuto.</div>";
		}		
		
		?>
		<br><br>
		<!--<div style="text-align:center; margin: 0px 50px 5px 183px;"><center><input type="button" value="Guardar" onClick="guardar_reparacion()" style="width:100px; margin-top:3px;" style="width:100%; height:100%;"></center></div>-->
		<div id="div_reparacion">
			<div id="div_rep0">
				Reparaci&oacute;n de la OT <?=$id_ot?> 
					<input type="hidden" id="hdn_idot" value="<?=$id_ot?>" />
					<input type="hidden" id="hdn_idp" value="<?=$idp?>" />
				.</div>
			<div id="div_rep1">
			  <table align="center" cellspacing="0" cellpadding="2" width="95%" class="tabla2">
				<tr>
				  <td colspan="2" height="23" class="tabla_titulo2">Datos del equipo.</td>
				</tr>
				<tr>
				  <td width="124"  class="tabla_campo2" height="23"> OT</td>
				  <td width="231" class="td1" >&nbsp;<?=$ot;?></td>
				  </tr>
				<tr>
				  <td  height="23" class="tabla_campo2">No. Serie</td>
				  <td>&nbsp;<?=$nds;?></td>
				</tr>
				<tr>
				  <td  height="23" class="tabla_campo2">Diagn&oacute;stico</td>
				  <td>&nbsp;<?=$dia?><input type="hidden" id="hdn_st_anterior" value="<?=$dia?>" />
				  <? $sql_diagnostico="SELECT diagnostico FROM cat_diagnosticos WHERE id=$dia ";
			             $resultado_diagnostico=mysql_query($sql_diagnostico,$link);
				     $registro_diagnostico=mysql_fetch_array($resultado_diagnostico);
				echo strtoupper(". ".$registro_diagnostico["diagnostico"]); ?>			</td>
				</tr>
				<tr>
				  <td  height="23" class="tabla_campo2">Observaciones</td>
				  <td>&nbsp;<?=$obs;?></td>				  
				</tr>
			
			  </table>
			  <center><input type="button" value="Guardar" onClick="guardar_reparacion()" style=" margin-top:3px; width:230px; height:86px"></center>
			
			</div>
			<div id="div_rep2">
			  <table align="center" cellspacing="0" cellpadding="2" width="98%" class="tabla2">
				<tr>
				  <td colspan="2" height="23" class="tabla_titulo2">Datos de Reparaci&oacute;n</td>
				</tr>
				<tr>
				  <td width="320"  class="tabla_campo2" height="23"> T&eacute;cnico</td>
				  <td width="540" class="td1" >&nbsp;<?=$tec;
				  $tecnico="SELECT dp_nombre,dp_apaterno,dp_amaterno FROM usuarios WHERE id_usuario=$tec ";
				$resultado_usuario22=mysql_query($tecnico,$link);
					$registro_usuario22=mysql_fetch_array($resultado_usuario22);
					echo strtoupper($registro_usuario22["dp_nombre"]." ".$registro_usuario22["dp_apaterno"]." ".$registro_usuario22["dp_amaterno"]);        
				  ?></td>
			    </tr>
				<tr>
				  <td  height="23" class="tabla_campo2">Fecha de Inicio </td>
				  <td>&nbsp;<?=$fio;?></td>
				</tr>
				<tr>
				  <td  height="23" class="tabla_campo2">Fecha Fin </td>
				  <td>&nbsp;<?=$ffn?></td>
				</tr>
				<tr>
				  <td  height="23" class="tabla_campo2">Reparaciones </td>
				  <td>&nbsp;<?=$nno?></td>
			    </tr>
				<tr>
				  <td  height="23" class="tabla_campo2">Status</td>
				  <td>&nbsp;<?=$stp?></td>
			    </tr>
				<tr>
				  <td  height="23" class="tabla_campo2">Observaciones</td>
				  <td>&nbsp;<?=$obs?></td>
				</tr>
			  </table>				
			</div>
			<div id="div_rep5">
				<div id="div_rep5a" style="width:100px; height:218px; margin-top:3px; margin-left:5px; float:left; border:#CCCCCC 1px solid;">
					<div id="div_rep5b1" style="text-align:center; font-weight:bold;">Reparacion #</div> 
					<div id="div_rep5b2" style="text-align:center; font-size:72px; font-weight:bold; margin-top:20px;"><?=$nno?></div> 
				</div>
			  <div id="div_rep5b" style="width:280px; height:218px; margin-top:3px; margin-left:3px; float:left; background-color:#FFFFFF; border:#EFEFEF 1px solid;">
			   
				<div style="margin:5px;">
					<b>Nuevo Status:</b><br>
					<select name="nvo_status" id="nvo_status" style="width:250px;">
						<option value="">...</option>
						<option value="WIP"> WIP</option>
						<option value="REP"> REP</option>
						<option value="NOREP"> NOREP</option>
						<option value="SCRAP"> SCRAP</option>						
					</select>
					<br><br><b>Observaciones:</b><br>
					<textarea id="txt_obs_rep" rows="7" style="width:250px;"></textarea>
					<!--<div style="text-align:center;"><input type="button" value="Guardar" onClick="guardar_reparacion()" style="width:100px; margin-top:3px;"></div>-->
				</div>			   
			   
			   
			  </div>
			</div>
			<div id="div_rep6">
				<table cellspacing="0" cellpadding="0" align="center" width="95%" class="tabla0">
					<tr>
					  <td colspan="2" class="tabla_titulo2" height="23">Fallas T&eacute;cnicas </td>
					</tr>
					  <?php 
					  	if ($nno>1){
							//echo "<br>NDNOK=$nno";
							// Fallas Tecnicas.
							$sql_ft="SELECT reg_fallas_tecnicas.id_falla_tecnica,reg_fallas_tecnicas.id_ot,reg_fallas_tecnicas.posicion,cat_fallas_tecnicas.descripcion 
								FROM reg_fallas_tecnicas,cat_fallas_tecnicas 
								WHERE cat_fallas_tecnicas.id=reg_fallas_tecnicas.id_falla_tecnica AND reg_fallas_tecnicas.id_ot=$id_ot ORDER BY reg_fallas_tecnicas.posicion DESC LIMIT 0,5";
							if(!$resultado_ft=mysql_query($sql_ft,$link)){ echo "<br>ERROR SQL: NO SE PUDO CONSULTAR LAS FALLAS TECNICAS PARA ESTA OT."; exit(); }
							//echo "<br>NDR FT=".
							$ndr_ft=mysql_num_rows($resultado_ft);
							while($registro_ft=mysql_fetch_array($resultado_ft)){
								//echo "<hr>";	print_r($registro_ft);
								//echo "<br>".$registro_ft["id_falla_tecnica"].$registro_ft["descripcion"];
								?><script language="javascript"> 
									var nvo_height=parseInt($("#div_rep6").css("height"))+30;
									$("#div_rep6").css("height",nvo_height+"px");
									$("#div_rep5").css("height",nvo_height+"px");
                                </script>
                                <tr align="left" >
                                <td class="tabla_campo2" height="24" valign="bottom" width="4%">&nbsp;</td>
                                <td class="td1" valign="bottom">
                                    <input type="text" size="5" readonly="1" value="<?=$registro_ft["id_falla_tecnica"]?>" class="txt_ya_registrados"/>
                                    <input type="text" size="40" readonly="1" value="<?=$registro_ft["descripcion"]?>" class="txt_ya_registrados"/>
                                    <a href="#" title="Falla Tecnica Registrada.">?</a>
                                </td>
                                </tr>
								<?php
							}
							
						}
					  ?>
					<tr align="left" >
					  <td width="4%" class="tabla_campo2" height="27" valign="bottom">1</td>
					  <td width="96%" class="td1" valign="bottom">
						<a href="#" onclick="seleccionar('a','1','fallas')">
						<input type="text" id="a1" size="5" readonly="1"/>
						<input type="text" id="aa1" size="40" readonly="1"/>
					  </a>			  </td>
					</tr>
					<tr>
					  <td class="tabla_campo2" height="25">2</td>
					  <td class="td1">
					  <a href="#" onclick="seleccionar('b','1','fallas')">
					  <input type="text" id="b1" size="5" value="<?=$clave1[1];?>"  readonly="1"/>
					  <input type="text" id="bb1" size="40" value="<?=$des1[1];?>" readonly="1"/>
					  </a>			  </td>
					</tr>
					<tr align="left" >
					  <td class="tabla_campo2" height="24">3</td>
					  <td class="td1"><a href="#" onclick="seleccionar('c','1','fallas')">
						<input type="text" id="c1" size="5" value="<?=$clave1[2];?>"  readonly="1"/>
						<input type="text" id="cc1" size="40"  value="<?=$des1[2];?>" readonly="1"/>
					  </a></td>
					</tr>
					<tr align="left" >
					  <td class="tabla_campo2" height="24">4</td>
					  <td class="td1"><a href="#" onclick="seleccionar('d','1','fallas')">
						<input type="text" id="d1" size="5" value="<?=$clave1[3];?>" readonly="1" />
						<input type="text" id="dd1" size="40"  value="<?=$des1[3];?>" readonly="1"/>
					  </a></td>
					</tr>
					<tr align="left" >
					  <td class="tabla_campo2" height="24">5</td>
					  <td class="td1"><a href="#" onclick="seleccionar('e','1','fallas')">
						<input type="text" id="e1" size="5" value="<?=$clave1[4];?>"  readonly="1"/>
						<input type="text" id="ee1" size="40"  value="<?=$des1[4];?>" readonly="1"/>
					  </a></td>
					</tr>
				  </table>			
			
      </div>
			
			<div id="div_rep3">
				<table cellspacing="0" cellpadding="0" align="center" width="95%" class="tabla0">
					<tr>
					  <td colspan="2" class="tabla_titulo2" height="23">Refacciones Utilizadas </td>
					</tr>
<?php 
if ($nno>1){
	// Refacciones Utilizadas.
	//echo "<br>".
	$sql_ru="SELECT reg_consumo_prods.id,reg_consumo_prods.id_ot,reg_consumo_prods.id_refaccion,cat_refacciones.descripcion 
		FROM reg_consumo_prods,cat_refacciones 
		WHERE cat_refacciones.id_ref=reg_consumo_prods.id_refaccion AND reg_consumo_prods.id_ot=$id_ot ORDER BY reg_consumo_prods.id DESC LIMIT 0,5";
	if(!$resultado_ru=mysql_query($sql_ru,$link)){ echo "<br>ERROR SQL: NO SE PUDO CONSULTAR LAS REFACCIONES UTILIZADAS PARA ESTA OT."; exit(); }
	//echo "<br>NDR ru=".
	$ndr_ru=mysql_num_rows($resultado_ru);
	if ($ndr_ru>5){ echo "<br>Parece que este producto tiene varias Refacciones utilizadas, sin embargo se mostraran las ultimas 5 registradas."; }
	
	while($registro_ru=mysql_fetch_array($resultado_ru)){
		//echo "<hr>";	print_r($registro_ru);
		?>
		<script language="javascript"> var nvo_height=parseInt($("#div_rep3").css("height"))+30;
		$("#div_rep3").css("height",nvo_height+"px");</script>
        <tr align="left" >
		<td class="tabla_campo2" height="24" valign="bottom" width="4%">&nbsp;</td>
		<td class="td1" valign="bottom">
			<input type="text" size="5" readonly="1" value="<?=$registro_ru["id_refaccion"]?>" class="txt_ya_registrados"/>
			<input type="text" size="40" readonly="1" value="<?=$registro_ru["descripcion"]?>" class="txt_ya_registrados"/>
			<a href="#" title="Refaccion Registrada.">?</a>
		</td>
		</tr>
		<?php		
	}
	
}
?>

					<tr align="left" >
					  <td width="4%" class="tabla_campo2" height="27" valign="bottom">1</td>
					  <td width="96%" class="td1" valign="bottom">
						<a href="#" onclick="seleccionar('f','1','refacciones')">
						<input type="text" id="f1" size="5" value="<?=$clave1[0];?>"  readonly="1"/>
						<input type="text" id="ff1" size="40"  value="<?=$des1[0];?>" readonly="1"/>
					  </a></td>
					</tr>
					<tr>
					  <td class="tabla_campo2" height="25">2</td>
					  <td class="td1">
					  <a href="#" onclick="seleccionar('g','1','refacciones')">
					  <input type="text" id="g1" size="5" value="<?=$clave1[1];?>"  readonly="1"/>
					  <input type="text" id="gg1" size="40"  value="<?=$des1[1];?>" readonly="1"/>
					  </a>			  </td>
					</tr>
					<tr align="left" >
					  <td class="tabla_campo2" height="24">3</td>
					  <td class="td1">
					  	<a href="#" onclick="seleccionar('h','1','refacciones')">
						<input type="text" id="h1" size="5" value="<?=$clave1[2];?>"  readonly="1"/>
						<input type="text" id="hh1" size="40"  value="<?=$des1[2];?>" readonly="1"/>
					  </a></td>
					</tr>
					<tr align="left" >
					  <td class="tabla_campo2" height="24">4</td>
					  <td class="td1">
					  	<a href="#" onclick="seleccionar('i','1','refacciones')">
						<input type="text" id="i1" size="5" value="<?=$clave1[3];?>" readonly="1" />
						<input type="text" id="ii1" size="40"  value="<?=$des1[3];?>" readonly="1"/>
					  </a></td>
					</tr>
					<tr align="left" >
					  <td class="tabla_campo2" height="24">5</td>
					  <td class="td1">
					  <a href="#" onclick="seleccionar('j','1','refacciones')">
						<input type="text" id="j1" size="5" value="<?=$clave1[4];?>"  readonly="1"/>
						<input type="text" id="jj1" size="40"  value="<?=$des1[4];?>" readonly="1"/>
					  </a></td>
					</tr>
				  </table>			
      </div>
			<div id="div_rep4">
				<table cellspacing="0" cellpadding="0" align="center" width="95%" class="tabla0">
					<tr>
					  <td colspan="2" class="tabla_titulo2" height="23">Reparaciones Efectuadas. </td>
					</tr>
        <?php            
		// Reparaciones Efectuadas.
		//echo "<br>".AQUI ESTA LA CONSULTA
		$sql_rep_efe="SELECT reg_rep_efectuadas.id, reg_rep_efectuadas.id_ot, reg_rep_efectuadas.id_rep_efectuada, reg_rep_efectuadas.posicion, cat_reparaciones.descripcion 
			FROM reg_rep_efectuadas,cat_reparaciones 
			WHERE cat_reparaciones.id=reg_rep_efectuadas.id_rep_efectuada AND reg_rep_efectuadas.id_ot=$id_ot ORDER BY reg_rep_efectuadas.id DESC LIMIT 0,5";
		if($resultado_rep_efe=mysql_query($sql_rep_efe,$link)){
			$ndr_rep_efe=mysql_num_rows($resultado_rep_efe);
	                                                               }else{
			 "<br>ERROR SQL: NO SE PUDO CONSULTAR LAS REFACCIONES UTILIZADAS PARA ESTA OT."; exit();
	                                                                 }
		
		
		if ($ndr_rep_efe>5){ echo "<br>Parece que este producto tiene varias Reparaciones Efectuadas, sin embargo se mostraran las ultimas 5 registradas."; }
		
		while($registro_rep_efe=mysql_fetch_array($resultado_rep_efe)){
			//echo "<hr>";	print_r($registro_rep_efe);
		?>
		<script language="javascript"> 
			var nvo_height=parseInt($("#div_rep4").css("height"))+30;
			//alert("Nuevo alto="+nvo_height);
			$("#div_rep4").css("height",nvo_height+"px");
        </script>		
        <tr align="left" >
		<td class="tabla_campo2" height="24" valign="bottom" width="4%">&nbsp;</td>
		<td class="td1" valign="bottom">
			<input type="text" size="5" readonly="1" value="<?=$registro_rep_efe["id_rep_efectuada"]?>" class="txt_ya_registrados"/>
			<input type="text" size="40" readonly="1" value="<?=$registro_rep_efe["descripcion"]?>" class="txt_ya_registrados"/>
			<a href="#" title="Reparacion Efectuada Registrada.">?</a>
		</td>
		</tr>
		<?php
}	?>
					
                    <tr align="left" >
					  <td width="4%" class="tabla_campo2" height="27" valign="bottom">1</td>
					  <td width="96%" class="td1" valign="bottom">
						<a href="#" onclick="seleccionar('k','1','reparaciones')">
						<input type="text" id="k1" size="5" value="<?=$clave1[0];?>"  readonly="1"/>
						<input type="text" id="kk1" size="40"  value="<?=$des1[0];?>" readonly="1"/>
					  </a>			  </td>
					</tr>
					<tr>
					  <td class="tabla_campo2" height="25">2</td>
					  <td class="td1">
					  <a href="#" onclick="seleccionar('l','1','reparaciones')">
					  <input type="text" id="l1" size="5" value="<?=$clave1[1];?>"  readonly="1"/>
					  <input type="text" id="ll1" size="40"  value="<?=$des1[1];?>" readonly="1"/>
					  </a>			  </td>
					</tr>
					<tr align="left" >
					  <td class="tabla_campo2" height="24">3</td>
					  <td class="td1">
					  <a href="#" onclick="seleccionar('m','1','reparaciones')">
						<input type="text" id="m1" size="5" value="<?=$clave1[2];?>"  readonly="1"/>
						<input type="text" id="mm1" size="40"  value="<?=$des1[2];?>" readonly="1"/>
					  </a></td>
					</tr>
					<tr align="left" >
					  <td class="tabla_campo2" height="24">4</td>
					  <td class="td1">
					  <a href="#" onclick="seleccionar('n','1','reparaciones')">
						<input type="text" id="n1" size="5" value="<?=$clave1[3];?>" readonly="1" />
						<input type="text" id="nn1" size="40"  value="<?=$des1[3];?>" readonly="1"/>
					  </a></td>
					</tr>
					<tr align="left" >
					  <td class="tabla_campo2" height="24">5</td>
					  <td class="td1">
					  <a href="#" onclick="seleccionar('o','1','reparaciones')">
						<input type="text" id="o1" size="5" value="<?=$clave1[4];?>"  readonly="1"/>
						<input type="text" id="oo1" size="40"  value="<?=$des1[4];?>" readonly="1"/>
					  </a></td>
					</tr>
				  </table>			
			
			</div>
		</div>
		
		<?php
	
	}		
	if ($a=="seleccionar"){	
		$t=$_POST["tipo"];
		$id_ot=$_POST["idot"];
		$idp=$_POST["idp"];
		$l=$_POST["l"];
		$n=$_POST["n"];
		
		if ($t=="fallas"){
			$ndr3=0;
			//echo "<br><hr>Muestro el catalogo de fallas que coinciden con el producto $idp y colocarlo en $l$n<br>";
			
			//echo "<br>BD [$sql_ing] SQL=".
			$sql1="SELECT * FROM cat_fallas_tecnicas WHERE aplica_productos LIKE '%$idp%' ORDER BY id";
			if ($resultado1=mysql_query($sql1,$link)){
				//echo "<div align=center>OK</div>";
				$ndr1=mysql_num_rows($resultado1);
			} else {
				echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
				exit();
			}		
			?>
			<table width="853" align="center" class="tabla1" cellpadding="2" cellspacing="0">
			<tr>
			  <td colspan="6" class="titulo_tabla1"> Fallas T&eacute;cnicas asignadas al Producto <?=$idp?></td>
			  </tr>
			<tr>
			  <td width="30" class="campos_tabla1">Id</td>
			  <td width="47" class="campos_tabla1">Clave</td>
			  <td width="404" class="campos_tabla1">Descripci&oacute;n</td>
			  <td width="150" class="campos_tabla1">Aplica a Productos </td>
			  <td width="123" class="campos_tabla1">Obs</td>
			  <td width="73" class="campos_tabla1">Acciones</td>
			  </tr>
			<?php 
				$col="#FFFFFF";	
				while($registro1=mysql_fetch_array($resultado1)){
					$maplica_productos=explode(',',$registro1["aplica_productos"]);
					foreach ($maplica_productos as $aplica_producto){
						if ($aplica_producto==$idp){ 
							//echo "Encontrado idp[$idp] en la Falla [$aplica_producto]"; 
							++$ndr3;
							?>
							<tr bgcolor="<?=$col?>">
							  <td>&nbsp;<?=$registro1["id"]?></td>
							  <td class="tda_tabla1">&nbsp;<?=$registro1["clave"]?></td>
							  <td>&nbsp;<?=$registro1["descripcion"]?></td>
								<td class="tda_tabla1" align="center"><a href="#" title="<?=$registro1["aplica_productos"]?>">Ver</a></td>
								<td><?=$registro1["obs"]?></td>
								<td class="tdi_tabla1"><a href="javascript:coloca_datos('<?=$registro1["id"]?>','<?=$registro1["descripcion"]?>','<?=$l?>','<?=$n?>');">Seleccionar</a></td>
							  </tr>							
							<?php
							($col=="#FFFFFF")? $col="#EFEFEF" : $col="#FFFFFF";
						}
					}
					
			?>
			<?php }	mysql_free_result($resultado1); ?>  
			</table>
			<?php
			echo "<div align=center><br>$ndr3 Resultados.</div>";
			exit;
		}
		if ($t=="refacciones"){
			$ndr3=0;
			//echo "<br><hr>Muestro el catalogo de refacciones que coinciden con el producto $idp y colocarlo en $l$n<br>";
			
			//echo "<br>BD [$sql_ing] SQL=".
			$sql1="SELECT * FROM cat_refacciones WHERE productos LIKE '%$idp%' ORDER BY id_ref";
			if ($resultado1=mysql_query($sql1,$link)){
				//echo "<div align=center>OK</div>";
				$ndr1=mysql_num_rows($resultado1);
			} else {
				echo "<div align=center>Error SQL. La consulta a la BAse de Datos no se ejecuto.</div>";
				exit();
			}		
			?>
			<table width="853" align="center" class="tabla1" cellpadding="2" cellspacing="0">
			<tr>
			  <td colspan="6" class="titulo_tabla1"> Refacciones asignadas al Producto			    <?=$idp?></td>
			  </tr>
			<tr>
			  <td width="30" class="campos_tabla1">Id</td>
			  <td width="47" class="campos_tabla1">Clave</td>
			  <td width="404" class="campos_tabla1">Descripci&oacute;n</td>
			  <td width="150" class="campos_tabla1">Aplica a Productos </td>
			  <td width="123" class="campos_tabla1">Obs</td>
			  <td width="73" class="campos_tabla1">Acciones</td>
			  </tr>
			<?php 
				$col="#FFFFFF";	
				while($registro1=mysql_fetch_array($resultado1)){
					$maplica_productos=explode(',',$registro1["productos"]);
					foreach ($maplica_productos as $aplica_producto){
						if ($aplica_producto==$idp){ 
							//echo "Encontrado idp[$idp] en la Falla [$aplica_producto]"; 
							++$ndr3;
							?>
							<tr bgcolor="<?=$col?>">
							  <td>&nbsp;<?=$registro1["id_ref"]?></td>
							  <td class="tda_tabla1">&nbsp;<?=$registro1["cod_ref"]?></td>
							  <td>&nbsp;<?=$registro1["descripcion"]?></td>
								<td class="tda_tabla1" align="center"><a href="#" title="<?=$registro1["productos"]?>">Ver</a></td>
								<td><?=$registro1["obs"]?></td>
								<td class="tdi_tabla1"><a href="javascript:coloca_datos('<?=$registro1["id_ref"]?>','<?=$registro1["descripcion"]?>','<?=$l?>','<?=$n?>');">Seleccionar</a></td>
							  </tr>							
							<?php
							($col=="#FFFFFF")? $col="#EFEFEF" : $col="#FFFFFF";
						}
					}
					
			?>
			<?php }	mysql_free_result($resultado1); ?>  
			</table>
			<?php
			echo "<div align=center><br>$ndr3 Resultados.</div>";
			exit;
		}
		if ($t=="reparaciones"){
			$ndr3=0;
			//echo "<br><hr>Muestro el catalogo de reparaciones que coinciden con el producto $idp y colocarlo en $l$n<br>";
			
			//echo "<br>BD [$sql_ing] SQL=".
			$sql1="SELECT * FROM cat_reparaciones WHERE tipos_productos LIKE '%$idp%' ORDER BY id";
			if ($resultado1=mysql_query($sql1,$link)){
				//echo "<div align=center>OK</div>";
				$ndr1=mysql_num_rows($resultado1);
			} else {
				echo "<div align=center>Error SQL. La consulta a la BAse de Datos no se ejecuto.</div>";
				exit();
			}		
			?>
			<table width="853" align="center" class="tabla1" cellpadding="2" cellspacing="0">
			<tr>
			  <td colspan="6" class="titulo_tabla1"> Reparaciones asignadas al Producto <?=$idp?></td>
			  </tr>
			<tr>
			  <td width="30" class="campos_tabla1">Id</td>
			  <td width="47" class="campos_tabla1">Clave</td>
			  <td width="404" class="campos_tabla1">Descripci&oacute;n</td>
			  <td width="151" class="campos_tabla1">Aplica a Productos </td>
			  <td width="122" class="campos_tabla1">Obs</td>
			  <td width="73" class="campos_tabla1">Acciones</td>
			  </tr>
			<?php 
				$col="#FFFFFF";	
				while($registro1=mysql_fetch_array($resultado1)){
					$maplica_productos=explode(',',$registro1["tipos_productos"]);
					foreach ($maplica_productos as $aplica_producto){
						if ($aplica_producto==$idp){ 
							//echo "Encontrado idp[$idp] en la Falla [$aplica_producto]"; 
							++$ndr3;
							?>
							<tr bgcolor="<?=$col?>">
							  <td>&nbsp;<?=$registro1["id"]?></td>
							  <td class="tda_tabla1">&nbsp;<?=$registro1["cod_rep"]?></td>
							  <td>&nbsp;<?=$registro1["descripcion"]?></td>
								<td class="tda_tabla1" align="center"><a href="#" title="<?=$registro1["tipos_productos"]?>">Ver</a></td>
								<td><?=$registro1["obs"]?></td>
								<td class="tdi_tabla1"><a href="javascript:coloca_datos('<?=$registro1["id"]?>','<?=$registro1["descripcion"]?>','<?=$l?>','<?=$n?>');">Seleccionar</a></td>
							  </tr>							
							<?php
							($col=="#FFFFFF")? $col="#EFEFEF" : $col="#FFFFFF";
						}
					}
					
			?>
			<?php }	mysql_free_result($resultado1); ?>  
			</table>
			<?php
			echo "<div align=center><br>$ndr3 Resultados.</div>";
			exit;
		}
		?><div align="center"><br /><input type="button" onclick="cancelar3()" value="Cancelar"><br />	</div><?php
	}
	
	if ($a=="guardar_reparacion"){	
		foreach($_POST as $nombre_campo=>$valor){
			$asignacion="\$".$nombre_campo."='".$valor."';"; 	eval($asignacion);
			//echo $asignacion."<br>";
		}		
		//echo "<br><br>Guardar la OT $idot. <br>La variable a1=$a1 <br>La variable k1=$k1";
		$letras_fal=array('a1','b1','c1','d1','e1');
		$letras_ref=array('f1','g1','h1','i1','j1');
		$letras_rep=array('k1','l1','m1','n1','o1');
		
		/* PROCEDIMIENTO:
			1. Recibir variables.
			2. Comprobar las existencias de las refacciones, registrarlas y descontarlas.
			3. Registrar las Fallas tecnicas.
			4. Registrar las reparaciones efectuadas.
			5. Guardar la OT y cambiar el status.
			6. Aviso del resultado del proceso y notificacion de errores. 
		*/

		// PASO 2.
		//echo "<hr>REFACCIONES: <br>";
		foreach($letras_ref as $ndref){
			//echo "<br>N de Ref=$ndref";
				/* PROCEDIMIENTO:
					a. Consulta la refaccion, Producto y cantidad.
					b. Revisa si hay existencias del producto en el almacen de Ingenieria.
					c. Si tiene existencias, las resta y guarda el registro; de lo contario muestra un mensaje de error y cancela el proceso.
				*/
			
			// a)
			//echo "<br>".
			$sqlre="SELECT id_ref,id_producto,cantidad FROM cat_refacciones WHERE id_ref='".$$ndref."'";
			//exit;
			$resultado_ref=mysql_query($sqlre,$link);
			if ($ndr_ref=mysql_num_rows($resultado_ref)>0){
				
				while($row_ref=mysql_fetch_array($resultado_ref)){
					//echo "<br>"; print_r($row_ref);
					//b)´
					$campo_existencias="exist_".$id_almacen_ingenieria;
					 "<br>&nbsp;&nbsp;".
					$sql_ex_p="SELECT ".$campo_existencias." FROM catprod WHERE id=".$row_ref["id_producto"]." LIMIT 1";
					
					$resultado_ex_p=mysql_query($sql_ex_p,$link);
					$row_ex_p=mysql_fetch_array($resultado_ex_p);
						//echo "<br>"; print_r($row_ex_p);
						//echo "<br>EDP=".
						$existencias_producto=$row_ex_p[$campo_existencias];
					
					
					/*
					if ($existencias_producto>0){
						//echo "<br>&nbsp;&nbsp;Existencias > 0";
						
						// c)
						//echo "<br>BD [$sql_inv] ".
						$sql_consumo="UPDATE catprod SET $campo_existencias=$campo_existencias-".$row_ref["cantidad"]." WHERE id=".$row_ref["id_producto"]." LIMIT 1";
						if(!mysql_db_query($sql_inv,$sql_consumo)){ echo "<br>ERROR SQL: NO SE RESTO LA CANTIDAD (".$row_ref["cantidad"].") AL PRODUCTO (".$row_ref["id_producto"].") DE LA REFACCION (".$row_ref["id_ref"].") EN EL ALMACEN DE INGENIERIA."; exit(); }
					*/	
						
						//echo "<br>".
						 $sql_consumo="INSERT INTO reg_consumo_prods(id,fecha,id_ot,id_refaccion,id_producto,cantidad,concepto) 
							VALUES (NULL,'".date("Y-m-d")."','$idot','".$row_ref["id_ref"]."','".$row_ref["id_producto"]."','".$row_ref["cantidad"]."','CONSUMO DE REFACCIONES')";	
						if(!mysql_query($sql_consumo,$link)){ echo "<br>ERROR SQL: NO SE REGISTRO EL CONSUMO DE LA REFACCION (".$row_ref["id_ref"].")."; exit(); }
					/*	
					} else{
						echo "<br>&nbsp;&nbsp;Error: las existencias del producto en el almacen de Ingenieria es 0. El sistema de detuvo.";
						exit();
					}
					*/
				}
				
				
			} else { 
				//echo "<br><br>NDR=0";
			}
		}
		//echo "<br><hr>";


		// PASO 3.
		//echo "<hr>FALLAS TECNICAS: <br>";
		$posicion3=1;
		foreach($letras_fal as $ndfal){
			//echo "<br>N de F T=$ndfal";
			//echo "<br>".
		 $sql="INSERT INTO reg_fallas_tecnicas (id,fecha,id_falla_tecnica,id_ot,descripcion,posicion)
							  VALUES (NULL,'".date("Y-m-d")."','".$$ndfal."','$idot','','$posicion3')";
			if(!mysql_query($sql,$link)){ echo "<br>ERROR SQL: NO SE REGISTRO LA FALLA TECNICA (".$$ndfal.")."; exit(); }
			++$posicion3;
		}
		//echo "<br><hr>";





		// PASO 4.
		$posicion4=1;
		//echo "<hr>REPARACIONES EFECTUADAS: <br>";
		foreach($letras_rep as $ndrep){
			//echo "<br>N de R E=$ndrep";
			//echo "<br>".
			 $sql="INSERT INTO reg_rep_efectuadas (id,fecha,id_ot,id_rep_efectuada,posicion)
							  VALUES (NULL,'".date("Y-m-d")."','$idot','".$$ndrep."','$posicion4')";
			if(!mysql_query($sql,$link)){ echo "<br>ERROR SQL: NO SE REGISTRO LA REPARACION EFECTUADA (".$$ndrep.")."; exit(); }
			++$posicion4;			
			
		}
		//echo "<br><hr>";

		// PASO 5.
		if ($nvo_status=="REP"){
			//echo "<br>ST=".
			$nvo_status." -- ".$sql5="UPDATE ot SET status_proceso='".$nvo_status."',status_cliente='CC',fecha_fin_rep='".date("Y-m-d")."',obs='".$obs_rep."' WHERE id=$idot";
			if(!mysql_query($sql5,$link)){ echo "<br>ERROR SQL: NO SE REGISTRO LA REPARACION EFECTUADA (".$$ndrep.")."; exit(); }
		}elseif($nvo_status=="WIP"){
			//echo "<br>ST=".
			$nvo_status." -- ".$sql5="UPDATE ot SET status_proceso='".$nvo_status."',status_cliente='REP',fecha_fin_rep='".date("Y-m-d")."',obs='".$obs_rep."' WHERE id=$idot";
			if(!mysql_query($sql5,$link)){ echo "<br>ERROR SQL: NO SE REGISTRO LA REPARACION EFECTUADA (".$$ndrep.")."; exit(); }		
		}elseif($nvo_status=="NOREP"){
			echo "<br>ST=".$nvo_status." -- ".$sql5="UPDATE ot SET status_proceso='".$nvo_status."',status_cliente='DES',fecha_fin_rep='".date("Y-m-d")."',obs='".$obs_rep."' WHERE id=$idot";
			if(!mysql_query($sql5,$link)){ echo "<br>ERROR SQL: NO SE REGISTRO LA REPARACION EFECTUADA (".$$ndrep.")."; exit(); }		
		}elseif($nvo_status=="SCRAP"){
			//echo "<br>ST=".
			$nvo_status." -- ".$sql5="UPDATE ot SET status_proceso='".$nvo_status."',status_cliente='DES',fecha_fin_rep='".date("Y-m-d")."',obs='".$obs_rep."' WHERE id=$idot";
			if(!mysql_query($sql5,$link)){ echo "<br>ERROR SQL: NO SE REGISTRO LA REPARACION EFECTUADA (".$$ndrep.")."; exit(); }					
		}
		//echo "<br><hr>";	


		// PASO 6.
		?>
					<script type="text/javascript">
			                        alert("El proceso de Reparacion concluyo correctamente para la OT (<?=$idot?>).");
		                        </script>
        
        <?php
	}	
	
	
	if ($a=="buscar_datos"){
		$idot=$_POST["ot"];
		//echo "<br>Buscar $idot.";
		// Fallas Tecnicas.
		//echo "<br>".
		$sql_ft="SELECT reg_fallas_tecnicas.id_falla_tecnica,reg_fallas_tecnicas.id_ot,reg_fallas_tecnicas.posicion,cat_fallas_tecnicas.descripcion 
			FROM reg_fallas_tecnicas,cat_fallas_tecnicas 
			WHERE cat_fallas_tecnicas.id=reg_fallas_tecnicas.id_falla_tecnica AND reg_fallas_tecnicas.id_ot=$idot ORDER BY reg_fallas_tecnicas.posicion DESC LIMIT 0,5";
		if(!$resultado_ft=mysql_query($sql_ft,$link)){ echo "<br>ERROR SQL: NO SE PUDO CONSULTAR LAS FALLAS TECNICAS PARA ESTA OT."; exit(); }
		//echo "<br>NDR FT=".
		$ndr_ft=mysql_num_rows($resultado_ft);
		if ($ndr_ft>5){ echo "<br>Parece que este producto tiene varias Fallas Tecnicas, sin embargo se mostraran las ultimas 5 registradas."; }
		while($registro_ft=mysql_fetch_array($resultado_ft)){
			//echo "<hr>";	print_r($registro_ft);
			if ($registro_ft["posicion"]==1){ ?><script language="javascript"> 
				$("#a1").attr("value","<?=$registro_ft["id_falla_tecnica"]?>"); 	$("#aa1").attr("value","<?=$registro_ft["descripcion"]?>"); 
            </script><?php }
			if ($registro_ft["posicion"]==2){ ?><script language="javascript"> 
				$("#b1").attr("value","<?=$registro_ft["id_falla_tecnica"]?>"); 	$("#bb1").attr("value","<?=$registro_ft["descripcion"]?>"); 
            </script><?php }
			if ($registro_ft["posicion"]==3){ ?><script language="javascript"> 
				$("#c1").attr("value","<?=$registro_ft["id_falla_tecnica"]?>"); 	$("#cc1").attr("value","<?=$registro_ft["descripcion"]?>"); 
            </script><?php }
			if ($registro_ft["posicion"]==4){ ?><script language="javascript"> 
				$("#d1").attr("value","<?=$registro_ft["id_falla_tecnica"]?>"); 	$("#dd1").attr("value","<?=$registro_ft["descripcion"]?>"); 
            </script><?php }
			if ($registro_ft["posicion"]==5){ ?><script language="javascript"> 
				$("#e1").attr("value","<?=$registro_ft["id_falla_tecnica"]?>"); 	$("#ee1").attr("value","<?=$registro_ft["descripcion"]?>"); 
            </script><?php }
		}
		
		// Refacciones Utilizadas.
		//echo "<br>".
		$sql_ru="SELECT reg_consumo_prods.id,reg_consumo_prods.id_ot,reg_consumo_prods.id_refaccion,cat_refacciones.descripcion 
			FROM reg_consumo_prods,cat_refacciones 
			WHERE cat_refacciones.id_ref=reg_consumo_prods.id_refaccion AND reg_consumo_prods.id_ot=$idot ORDER BY reg_consumo_prods.id DESC LIMIT 0,5";
		if(!$resultado_ru=mysql_query($sql_ru,$link)){ echo "<br>ERROR SQL: NO SE PUDO CONSULTAR LAS REFACCIONES UTILIZADAS PARA ESTA OT."; exit(); }
		//echo "<br>NDR ru=".
		$ndr_ru=mysql_num_rows($resultado_ru);
		if ($ndr_ru>5){ echo "<br>Parece que este producto tiene varias Refacciones utilizadas, sin embargo se mostraran las ultimas 5 registradas."; }
		
		$letras_ru=array('f','g','h','i','j');
		while($registro_ru=mysql_fetch_array($resultado_ru)){
			//echo "<hr>";	print_r($registro_ru);
			//echo "<br>Contador=$contador LETRA EXTRAIDA=".
			$letraX = array_shift($letras_ru);
			?><script language="javascript"> 
				$("#<?=$letraX?>1").attr("value","<?=$registro_ru["id_refaccion"]?>"); 	$("#<?=$letraX.$letraX?>1").attr("value","<?=$registro_ru["descripcion"]?>"); 
            </script><?php
			//echo "<br><hr>"; 	print_r($letras_ru);
		}	
		
		// Reparaciones Efectuadas.
		//echo "<br>".
		$sql_rep_efe="SELECT reg_rep_efectuadas.id, reg_rep_efectuadas.id_ot, reg_rep_efectuadas.id_rep_efectuada, reg_rep_efectuadas.posicion, cat_reparaciones.descripcion 
			FROM reg_rep_efectuadas,cat_reparaciones 
			WHERE cat_reparaciones.id=reg_rep_efectuadas.id_rep_efectuada AND reg_rep_efectuadas.id_ot=$idot ORDER BY reg_rep_efectuadas.id DESC LIMIT 0,5";
		if(!$resultado_rep_efe=mysql_query($sql_rep_efe,$link)){ echo "<br>ERROR SQL: NO SE PUDO CONSULTAR LAS REFACCIONES UTILIZADAS PARA ESTA OT."; exit(); }
		//echo "<br>NDR ru=".
		$ndr_rep_efe=mysql_num_rows($resultado_rep_efe);
		if ($ndr_rep_efe>5){ echo "<br>Parece que este producto tiene varias Reparaciones Efectuadas, sin embargo se mostraran las ultimas 5 registradas."; }
		
		$letras_rep_efe=array('k','l','m','n','o');
		while($registro_rep_efe=mysql_fetch_array($resultado_rep_efe)){
			//echo "<hr>";	print_r($registro_rep_efe);
			//echo "<br>Contador=$contador LETRA EXTRAIDA=".
			$letraX = array_shift($letras_rep_efe);
			
			?><script language="javascript"> 
				$("#<?=$letraX?>1").attr("value","<?=$registro_rep_efe["id_rep_efectuada"]?>"); 	$("#<?=$letraX.$letraX?>1").attr("value","<?=$registro_rep_efe["descripcion"]?>"); 
            </script><?php
			
			//echo "<br><hr>"; 	print_r($letras_rep_efe);
		}			
	}
?>