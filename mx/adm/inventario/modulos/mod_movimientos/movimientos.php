<?php 
	include ("../../conf/conectarbase.php");
	include ("clase_movimientos.php");
	include ("catalogo_errores.php");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	
	$actual=$_SERVER['PHP_SELF'];
	$color="#F0F0F0";
	print_r($_POST);
	$ac=$_POST["accion"];
	
	if ($ac=="ver_asociados"){
		$asociadoX=$_POST["a"];
?>
		<div id="div_asociados2">
			<div class="tit1">
				<span class="tit_mov">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ASOCIADOS&nbsp;</span>
				<span class="cer_mov"><a href="javascript:cerrar('div_asociados2');">CERRAR</a>&nbsp;</span>
			</div>
			<br />			
<?php
			$color="#F0F0F0";
			if($asociadoX=="Cliente" || $asociadoX=="Ninguno"){
				//echo "<br>BD=[$sql_inv] SQL=".
				$sql="SELECT id_cliente,n_comercial FROM cat_clientes";
				$result=mysql_query($sql,$link);
?>
				<br /><table align="center" width="98%" cellspacing="0" style="border:#333333 1px solid;">
				<tr>
					<td colspan="2" height="20" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;">Cat&aacute;logo de Clientes.</td>
				</tr>		
				<tr style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">
					<td width="10%" height="20">ID</td>
					<td width="90%">Cliente</td>
				</tr>
				<?php while($row=mysql_fetch_array($result)){ ?>
				<tr bgcolor="<?=$color;?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:coloca_proveedor1('<?=$row["id_cliente"];?>','<?=$row["n_comercial"];?>');" style="cursor:pointer;">
					<td align="center" style="border-right:#CCCCCC 1px solid; text-align:center;" height="20">&nbsp;<?=$row["id_cliente"];?></td>
					<td>&nbsp;<?=$row["n_comercial"];?></td>
				</tr>
				<?php 
					($color=="#F0F0F0")? $color="#FFFFFF" : $color="#F0F0F0";
				} ?>		
				</table><br />
				  <?php 			
			} elseif($asociadoX=="Almacen"){
			$conceptoX=$_POST["conceptoX"];
			$color="#F0F0F0";
			$sql="SELECT * FROM tipoalmacen";
			$result=mysql_query($sql,$link);
			?>
			  <table width="100%" border="0" align="center" cellspacing="0" style="font-size: 12px;font-family: Verdana;">
				<tr style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;">
				  <td colspan="2" height="23">Cat&aacute;logo de  Almacenes </td>
				</tr>
				<tr style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">
				  <td width="93">ID</td>
				  <td width="820">Almac&eacute;n</td>
				</tr>
				<? while($row=mysql_fetch_array($result)) { ?>
				<tr bgcolor="<?=$color?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:coloca_proveedor1('<?= $row["id_almacen"]; ?>','<?= $row["almacen"]; ?>');" style="cursor:pointer;">
				<td align="center" style="border-right:#CCCCCC 1px solid; text-align:center;" height="20"><?= $row["id_almacen"]; ?></td>
				<td>&nbsp;<?= $row["almacen"]." - ".$row["observ"];?></td>
				</tr>
				<?
				($color=="#F0F0F0")? $color="#FFFFFF": $color="#F0F0F0";
				}
				?>
			  </table>
			  <?php
		
			}
		  ?>
		</div>		
		<?php
	}	
	if ($ac=="crear_movimiento"){
		$t=$_POST["t"];		$f=$_POST["f"];		$al=$_POST["al"];		$as=$_POST["as"];		$r=$_POST["r"];		$o=$_POST["o"];		$fr=date("Y-m-d H:i:s");
		$sql_nuevo_mov="INSERT INTO mov_almacen (id_mov,fecha,fecha_real,tipo_mov,almacen,referencia,asociado,observ,seriesGen) VALUES (NULL,'$f','$fr','$t','$al','$r','$as','$o','No Generado')";
		if (mysql_query($sql_nuevo_mov,$link)){
			$u_id=mysql_insert_id($link);
			echo "<div align='center'>Se ha creado el Movimiento: $u_id.</div>";
			//exit();
?>
			<br><br><div id="div_items_movs1">
				<div class="tit1">
					<span class="tit_mov">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MOVIMIENTO <?=$u_id?> <input type="hidden" name="hdn_ndm1" id="hdn_ndm1" value="<?=$u_id?>" />.&nbsp;</span>
					<!--<span class="cer_mov"><a href="javascript:cerrar('div_items_movs1');">CERRAR</a>&nbsp;</span>//-->
				</div>
				<br>
				<form id="frm1" name="frm1" method="post" action="">
				  <table width="98%" align="center" cellspacing="0"  style="border:#000000 1px solid;font-weight:bold;font-size: 12px;">
					<tr style="text-align:center; font-weight:bold; background-color:#333333; color:#FFFFFF;">
					  <td width="29">&nbsp;</td>
					  <td width="70" height="25">Cantidad</td>
					  <td width="55">ID</td>
					  <td width="317">Clave Producto </td>
					  <td width="362">Descripci&oacute;n</td>
					  <td width="273">Especificaci&oacute;n</td>
					  <td width="60">Posici&oacute;n</td>
					  <!--<td width="60">C.U.</td>-->
				    </tr>
<?php 
					$color="#EFEFEF";
				for ($a=1;$a<=10;$a++){
?>
					<tr style="background-color:<?=$color?>; text-align:center;">
					  <td><input type="checkbox" name="chk_<?=$a?>" id="chk_<?=$a?>" value="<?=$a?>" /></td>
					  <td class="td1"><input name="ca<?=$a?>" type="text" id="ca<?=$a?>" size="5" class="txtNC" style="width: 100px;text-align:right;" /></td>
					  <td><input name="idp<?=$a?>" type="text" id="idp<?=$a?>" size="5" /></td>
					  <td align="left" >
						<input name="clave<?=$a?>" type="text" size="15" id="clave<?=$a?>" style="cursor:hand; width: 100px;" />
						<input name="btn_tipo<?=$a?>" id="btn_tipo<?=$a?>" type="button" value="..." class="btn2" onclick="javascript:elegir_producto1('<?=$a?>');" />					  </td>
					  <td><input name="ds<?=$a?>" type="text" id="ds<?=$a?>" />					  </td>
					  <td><input name="es<?=$a?>" type="text" id="es<?=$a?>" style="width: 100px;" /></td>
					  <td><input name="po<?=$a?>" type="text" id="po<?=$a?>" size="5" style="text-align:right;" /></td>
					  <!--<td><input name="cu<?=$a?>" type="text" id="cu<?=$a?>" size="5" value="0" readonly="1" style="text-align:right;" /></td>-->
					</tr>
					<?
					($color=="#EFEFEF")? $color="#FFFFFF": $color="#EFEFEF";
					}
					?>
					<tr>
					  <td colspan="7" style="text-align:right; padding:2px; border-top:#000000 2px solid0; background-color:#CCCCCC;">
							<input type="reset" name="reset2" value="Limpiar" class="Estilo60" />&nbsp;
							<input type="button" name="Submit8" class="Estilo60" value="Guardar Producto" onclick="guarda_producto()" />					  </td>
					</tr>
				  </table>
				</form>
				
									
			</div>
			
			<?php
			exit();
		} else {
			echo "<div align='center'>Error del Sistema: El movimiento no se genero.</div>";
			exit();
		}
	}		
	if ($ac=="mostrar_productos")
	{
		$cdm=$_POST["cdm"];
		$tdm=$_POST["tdm"];		$alm=$_POST["alm"];		$aso=$_POST["aso"];		$ias=$_POST["ias"];		$n=$_POST["n"];
		$ceX="exist_$alm";		$desceX="Existencias del Almacen $alm";
		$ctX="trans_$alm";		$desctX="Transferencias del Almacen $alm";
		//$ias=5000000;	
		
		// OBTENER EL NOMBRE DEL CAMPO ASOCIADO ...
		echo "<br>".$sql2="SELECT `almacen` FROM `tipoalmacen` WHERE id_almacen=$alm ";
		$r2=mysql_query($sql2,$link);
		while ($ro2=mysql_fetch_array($r2))
		{
			$nalm=$ro2["almacen"];
			$ncalm="a_".$alm."_$nalm";
			//echo "<br>NCA=($ncalm)<BR>";
		}	
//echo $aso;  exit();
		if ($aso=="Cliente" || $aso=="Ninguno") {
			$m_productos=array();
			//echo "<br>Cat de Clientes ($ias)";
			//echo "<BR>".
			$sql0="SELECT `id`,`id_clientes` FROM `catprod` WHERE $ncalm=1 AND id_clientes LIKE '%$ias%' ORDER BY `id`";
			$r0=mysql_query($sql0,$link);
			?>
			<br><br><div id="div_proveedores1">
			<span class="cer_mov"><a href="javascript:cerrar2('div_proveedores1');">CERRAR</a>&nbsp;</span>
			<br /><br /><table width="98%" cellspacing="0" cellpadding="0" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid; background-color:#FFFFFF;">
			  <tr>
				<td colspan="6" height="23" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;"><?=$ndrp;?>
				 Productos asociados al Cliente <?=$ias?></td>
			  </tr>
			  <tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
				<td width="17" height="20">Id</td>
				<td width="176">No Parte</td>
				<td width="481">Descripci&oacute;n</td>
				<td width="377">Especificaci&oacute;n</td>
				<td width="65"><a href="#" title="<?=$desceX?>" style="color:#000000;">Exist.</a></td>
				<td width="64"><a href="#" title="<?=$desctX?>" style="color:#000000;">Trans.</a></td>
			  </tr>
			<?php
			$color="#F0F0F0";
			while ($ro0=mysql_fetch_array($r0))
			{
				$idx0=$ro0["id"];
				$idprooX0=trim($ro0["id_clientes"]);
				
				//echo "<br>COINCIDEN 1: [$idx0] [$idprooX0]";
				$idprooX0_split=explode(',',$idprooX0);
				//print_r($idprooX0_split);
				foreach ($idprooX0_split as $idprooX0_splitX)
				{
					//echo "<br>COINCIDEN 1: [$idx0] [$idprooX0]";	
					if ($idprooX0_splitX==$ias) {	array_push($m_productos,$idx0); }
				}
			}				
			//echo "<BR>Productos asociados con el Cliente ($ias).<br>";
			//print_r($m_productos);
			if (count($m_productos)>0)
			{
				//echo "<br>Muestra tabla<br>";

						foreach($m_productos as $idp_matriz)
						{
							//echo "<br>&nbsp;".
							$sql_p_clientes="SELECT `id`,`id_prod`, `descripgral`, `especificacion`, `$ceX`, `$ctX`, `cpromedio`,noParte FROM catprod WHERE id=$idp_matriz AND $ncalm=1 LIMIT 1";
							if ($r1=mysql_query($sql_p_clientes,$link))
							{
								while ($ro1=mysql_fetch_array($r1))
								{
									if ($cdm=="Ventas")
									{
										$cpX=$ro1["cpromedio"];
									} else {
										$cpX="";
									}
									?>
									<tr bgcolor="<?=$color;?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:coloca_producto1('<?=$ro1["id"]?>','<?=$ro1["id_prod"]?>','<?=$ro1["descripgral"]?>','<?=$ro1["especificacion"]?>','<?=$cpX?>','<?=$n?>');" style="cursor:pointer;">
									  <td height="20" align="center"><?=$ro1["id"]?></td>
										<td style="border-right:#CCCCCC 1px solid;border-left: #CCCCCC 1px solid;">&nbsp;<?=$ro1["noParte"]?></td>
										<td>&nbsp;<?=$ro1["descripgral"]?></td>
										<td style="border-left:#CCCCCC 1px solid; border-right:#CCCCCC 1px solid;">&nbsp;<?=$ro1["especificacion"]?></td>
										<td align="right"><?=$ro1["$ceX"]?>&nbsp;</td>
										<td style="border-left:#CCCCCC 1px solid; " align="right"><?=$ro1["$ctX"]?>&nbsp;</td>
									</tr>
									<?php
									($color=="#F0F0F0")?$color="#FFFFFF" : $color="#F0F0F0";
									//print_r($ro1);
								}	
							} else {
								errorX(1);
							}
						}
			} else {
				errorX(0);
			}
		?>
		</table>
		<br>
		</div>
		<?php		
		}elseif($aso=="Almacen"){
			if ($cdm=="Traspaso"){ 
				//echo "<br><hr>Salida x Traspaso<hr><br>";
				
					// OBTENER EL NOMBRE DEL CAMPO DEL ALMACEN ASOCIADO...
					echo "<br>".$sql9="SELECT `id_almacen`,`almacen` FROM `tipoalmacen` WHERE id_almacen=$ias ";
					$r9=mysql_query($sql9,$link);
					while ($ro9=mysql_fetch_array($r9))
					{
						$ialm3=$ro9["id_almacen"];
						$nalm3=$ro9["almacen"];
						$ncalm3="a_".$ialm3."_$nalm3";
						//echo "<br>NCA DESTINO=($ncalm2)<BR>";
					}
				if($ncalm==$ncalm3){
					
					echo "<br>".
					$sql0="SELECT `id`,`id_prod`, `descripgral`, `especificacion`, `cpromedio`, `$ceX`, `$ctX` FROM `catprod` WHERE $ncalm=1 AND $ncalm3=1 AND trans_$ialm3>0 ORDER BY `id`";
				}else{
					echo "<br>".
					$sql0="SELECT `id`,`id_prod`, `descripgral`, `especificacion`, `cpromedio`, `$ceX`, `$ctX` FROM `catprod` WHERE $ncalm=1 AND $ncalm3=1 AND $ceX>0 ORDER BY `id`";	
				}
				
				//exit();
				$r0=mysql_query($sql0,$link);
				$ndrp=mysql_num_rows($r0);
				if (!$ndrp>0)
				{
					mensaje(0);
				}
				?>
				<br><br><div id="div_proveedores1">
				<span class="cer_mov"><a href="javascript:cerrar2('div_proveedores1');">CERRAR</a>&nbsp;</span>
				<br /><br /><table width="98%" cellspacing="0" cellpadding="0" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid; background-color:#FFFFFF;">
				  <tr>
					<td colspan="6" height="23" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;"><?=$ndrp;?>
					 Productos asociados al Almac&eacute;n <?=$alm?> y <?=$ias?></td>
				  </tr>
				  <tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
					<td width="17" height="20">Id</td>
					<td width="176">Clave del Producto </td>
					<td width="481">Descripci&oacute;n</td>
					<td width="377">Especificaci&oacute;n</td>
					<td width="65"><a href="#" title="<?=$desceX?>" style="color:#000000;">Exist.</a></td>
					<td width="64"><a href="#" title="<?=$desctX?>" style="color:#000000;">Trans.</a></td>
				  </tr>
				<?php
				while ($ro0=mysql_fetch_array($r0))
				{
					$id_prod2=$ro0["id_prod"];
					$esp=$ro0["especificacion"];
					$des=$ro0["descripgral"];
					$cpr=$ro0["cpromedio"];
					$exi=$ro0["$ceX"];
					$tra=$ro0["$ctX"];
					
					$des2=str_replace("\""," PULGADAS ",$des);
					//echo "<br> $id_prod2    $des       $esp ";
					?>
					<tr bgcolor="<?=$color;?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:coloca_producto1('<?=$ro0["id"]?>','<?=$id_prod2?>','<?=$des2?>','<?=$esp?>','<?=$cpr?>','<?=$n?>');" style="cursor:pointer;">
					  <td height="20" align="center"><?=$ro0["id"]?></td>
						<td style="border-right:#CCCCCC 1px solid;border-left: #CCCCCC 1px solid;">&nbsp;<?=$id_prod2;?></td>
						<td>&nbsp;<?=$des?></td>
						<td style="border-left:#CCCCCC 1px solid; border-right:#CCCCCC 1px solid;">&nbsp;<?=$esp;?></td>
						<td align="right"><?=$exi;?>&nbsp;</td>
						<td style="border-left:#CCCCCC 1px solid; " align="right"><?=$tra;?>&nbsp;</td>
					</tr>
					<?php
					($color=="#F0F0F0")?$color="#FFFFFF" : $color="#F0F0F0";
				}
				?></table>
				<br>
				</div>
				<?php		
				exit();
			} // TERMINA S X T ...

			
			//echo "<BR>".
			$sql0="SELECT `id`,`id_prod`, `descripgral`, `especificacion`, `cpromedio`, `$ceX`, `$ctX` FROM `catprod` WHERE $ncalm=1 ORDER BY `id`";
			$r0=mysql_db_query($sql_inv,$sql0);
			$ndrp=mysql_num_rows($r0);
			if (!$ndrp>0)
			{
				mensaje(0);
			}
			?>
			<br><br><div id="div_proveedores1">
			<span class="cer_mov"><a href="javascript:cerrar('div_proveedores1');">CERRAR</a>&nbsp;</span>
			<br /><br /><table width="98%" cellspacing="0" cellpadding="0" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid; background-color:#FFFFFF;">
			  <tr>
				<td colspan="6" height="23" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;"><?=$ndrp;?>
				 Productos asociados al Almac&eacute;n <?=$alm?></td>
			  </tr>
			  <tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
				<td width="17" height="20">Id</td>
				<td width="176">Clave del Producto </td>
				<td width="481">Descripci&oacute;n</td>
				<td width="377">Especificaci&oacute;n</td>
				<td width="65"><a href="#" title="<?=$desceX?>" style="color:#000000;">Exist.</a></td>
				<td width="64"><a href="#" title="<?=$desctX?>" style="color:#000000;">Trans.</a></td>
			  </tr>
			<?php
			while ($ro0=mysql_fetch_array($r0))
			{
				$id_prod2=$ro0["id_prod"];
				$esp=$ro0["especificacion"];
				$des=$ro0["descripgral"];
				$exi=$ro0["$ceX"];
				$tra=$ro0["$ctX"];
				$des2=str_replace("\""," PULGADAS ",$des);
				//echo "<br> $id_prod2    $des       $esp ";
				if ($cdm=="Merma") { $cpr=$ro0["cpromedio"]; } else { $cpr="";}				
				?>
				<tr bgcolor="<?=$color;?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:coloca_producto1('<?=$ro0["id"]?>','<?=$id_prod2?>','<?=$des2?>','<?=$esp?>','<?=$cpr?>','<?=$n?>');" style="cursor:pointer;">
				  <td height="20" align="center"><?=$ro0["id"]?></td>
					<td style="border-right:#CCCCCC 1px solid;border-left: #CCCCCC 1px solid;">&nbsp;<?=$id_prod2;?></td>
					<td>&nbsp;<?=$des?></td>
					<td style="border-left:#CCCCCC 1px solid; border-right:#CCCCCC 1px solid;">&nbsp;<?=$esp;?></td>
					<td align="right"><?=$exi;?>&nbsp;</td>
					<td style="border-left:#CCCCCC 1px solid; " align="right"><?=$tra;?>&nbsp;</td>
				</tr>
				<?php
				($color=="#F0F0F0")?$color="#FFFFFF" : $color="#F0F0F0";
			}
			?></table>
			<br>
			</div>
				<?php		

		
		
		}
	}
	
	
	
	
	
	
	
	if ($ac=="insertar_productos"){
		$m=$_POST["idm"];		$v=$_POST["valores"];
		$productos=explode(',',$v);		
		echo "<br>";
		echo "<br><div id='acciones_proceso'>
				<div class='tit1'>
					<span class='cer_mov'><a href='javascript:cerrar(\"acciones_proceso\");'>CERRAR</a>&nbsp;</span>
				</div>
		&nbsp;&nbsp;&nbsp;<b>ACCIONES DEL PROCESO:</b><br>";
		?>
		<ul>
			
			<li><b>Obtener y Validar la Informaci&oacute;n.</b></li><br />
<?php		
		foreach ($productos as $p){
			//echo "<br>$p";
			if ($p!==''){
				//$sql_insertar="INSERT INTO prodxmov(nummov,id_prod,cantidad,existen,clave,cu,id,ubicacion) VALUES ('$m',";
				$sql_insertar="INSERT INTO prodxmov(nummov,id_prod,cantidad,existen,clave,ubicacion,id) VALUES ('$m',";
				
				$valores0=str_replace('?',',',$p);
				$valores=explode(',',$valores0);
				
				if ($sistema_costeoX=="CP"){
					// VERIFICAR SI YA EXISTE EL PRODUCTO EN EL MOVIMENTO ...
					//echo "<br>".
					$sql_existe="SELECT id FROM prodxmov WHERE id_prod='".$valores[0]."' AND nummov='$m' "; 
					$r_existe=mysql_query($sql_existe,$link);
					if (mysql_num_rows($r_existe)>0)
					{
						echo "<br><br><div class='mensajeX'><font color='#ff0000'>ERROR:</font> El producto ".$valores[0]." ya esta en el movimiento $m.<br> Evite colocar productos duplicados en un solo Movimiento. El proceso en el sistema se detuvo.";
						exit();
					}
				}
				//errorX(0);			
				
				foreach ($valores as $vp){
					//echo "'$vp',";
					$sql_insertar.="'$vp',";
				}
				$sql_insertar.="NULL)";
				//$sql_insertar.=")";
				
				//echo "<br><br>*** SQL ANTES DE INSTANCIAR $sql_insertar<br><br>";
				//exit();
					/*echo "<pre>";
					print_r($valores);
					echo "</pre>";
					exit();*/
					$nuevo_movimiento=new movimientos($m,$valores[0],$valores[1],$valores[3],$valores[4]);
					$nuevo_movimiento->mueve_producto($sql_insertar);
					unset($nuevo_movimiento);
			}
		}
		?>
		</ul>
		<?php
		
		ver_movimiento($m);
		echo "</div>";
	}		



	function ver_movimiento($idm)
	{
		include ("../../conf/conectarbase.php");
		//echo "<br>Ver Movimiento ($idm)<br>";
		$sql_prod_m="SELECT * FROM prodxmov WHERE nummov='$idm' ORDER BY id";
		$r1=mysql_query($sql_prod_m,$link);

		$ndr_pem=mysql_num_rows($r1);
		if (!$ndr_pem>0)
		{
			mensaje(0);
		}
		?>
			<div id="div_pem1">
			<br /><table width="98%" cellspacing="0" cellpadding="0" align="center" style="font-size:12px; border:#000000 1px solid; background-color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;">
			  <tr>
				<td colspan="5" height="23" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;"><?=$ndrp;?>
				Productos en el Movimiento : <?=$idm?> </td>
			  </tr>
			  <tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
			    <td width="85">#</td>
				<td width="145" height="20">Id Mov </td>
				<td width="478">Clave del Producto </td>
				<td width="267">Cantidad</td>
				<td width="205">C.U.</td>
			  </tr>
			<?php
			while ($ro1=mysql_fetch_array($r1))
			{
				?>
				<tr bgcolor="<?=$color;?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" >
				  <td style="border-right:#CCCCCC 1px solid; text-align:center;"><?=$ro1["id"]?></td>
				  <td height="20" align="center"><?=$ro1["id_prod"]?></td>
					<td style="border-right:#CCCCCC 1px solid;border-left: #CCCCCC 1px solid;">&nbsp;<?=$ro1["clave"]?></td>
					<td align="right"><?=$ro1["cantidad"]?>&nbsp;</td>
					<td style="border-left:#CCCCCC 1px solid; text-align:right">$<?=number_format($ro1["cu"],2,'.',',')?>&nbsp;</td>
				</tr>
				<?php
				($color=="#D9FFB3")?$color="#FFFFFF" : $color="#D9FFB3";
			}
			?></table>
			<br>
			</div>
		<?php
	}
?>