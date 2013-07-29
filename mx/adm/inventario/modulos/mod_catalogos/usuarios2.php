<?php 
	session_start();	
	include("../../conf/conectarbase.php");
	
	
	if ($_POST["f_alta"])
	{
		//print_r($_POST);
		$sql_campos="";
		$sql_valores="";
		
		foreach($_POST as $c=>$v)
		{
			if ($c!=="password2")
			{
				//echo "<br>".$c." = ".$v;
				($sql_campos=="")? $sql_campos=$c : $sql_campos.=",".$c;
				
				if ($c=="password")	$v=md5($v);
				($sql_valores=="")? $sql_valores="'$v'" : $sql_valores.=",'".$v."'";
			}
		}
		$sql_valores=str_replace('\'Autonumerico\'','NULL',$sql_valores);
		//echo "<br><br>".
		$sql_nuevo="INSERT INTO usuarios($sql_campos) VALUES ($sql_valores)";
		if (!mysql_db_query($sql_inv,$sql_nuevo,$link))
		{
			echo "<br>Error SQL.";
		} else {
			echo "<br><center>El usuario se inserto correctamente.</center>";
			$u_id=mysql_insert_id($link);
		}
		//echo "<hr>$sql_campos<hr>$sql_valores";
				// ==========================================================================================
				if (isset($_FILES["foto"])) {
					$tot = count($_FILES["foto"]["name"]);
					 //este for recorre el arreglo
					 for ($i = 0; $i < $tot; $i++){
						$tmp_name = $_FILES["foto"]["tmp_name"][$i];
						$name = $_FILES["foto"]["name"][$i];
						//echo("<b>el nombre original:</b> "); //echo($name);
						$newfile = "fotos/".$u_id."_".$name;
							// Validar el archivo...
							//echo "<br>Nuevo archivo [$newfile]<br>";
								$extensiones_permitidos=array("gif","jpg","jpeg","png");
								$partes_ruta = pathinfo($newfile);
								$extension_archivo=strtolower($partes_ruta['extension']);
								if (!in_array($extension_archivo,$extensiones_permitidos)) 
								{ 
									echo "<br><div align=center>Error: La extension del archivo no coincide con los farmatos de imagen<br> permitidos por el sistema.</div>";
									exit();
								}	
						if (file_exists($newfile)){	
							echo "<br>El archivo ya existe"; 
						} else {
						
							if (is_uploaded_file($tmp_name)) {
								if (!move_uploaded_file($tmp_name,"$newfile")) {
									print "<br>Error en transferencia de archivo.";
									exit();
								} else {
									$sql_usuario_foto="UPDATE usuarios_rec SET foto='$newfile' WHERE id_usuario=$u_id";
									if (!mysql_db_query($sql_inv,$sql_usuario_foto))
									{
										echo "<br><center>Error: La foto no se subio correctamente al sistema.</center>";
										exit();
									}								
									
									?><script language="javascript">
										alert("El archivo subio correctamente.");
										
										//self.close();
									</script><?php
								} 			   
							} // if is_up...
						} // si existe o no	
					} // for ...
				}
				// ==========================================================================================================				
		
		
		
		
		
	} else {
	
	
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	

	$color="#FFFFFF";	
	//print_r($_POST);
	//exit();
	$ac=$_POST["accion"];
	$fecha=date("Y-m-d");	
	// -------------------------------------------------------------------------------------------------------
	
	if ($ac=="listar")
	{
		$sql_usuario1="SELECT * FROM usuarios WHERE activo=1 ORDER BY id_usuario";
		$result_usuario1=mysql_db_query($sql_inv,$sql_usuario1);
		$ndr1=mysql_num_rows($result_usuario1);
		if ($ndr1>0)
		{
			
			?>
				<form name="frm1" id="frm1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
				<table width="98%" align="center" cellpadding="1" cellspacing="0" style="border:#cccccc 1px solid;">
				  <tr style="font-weight:bold; text-align:center; background-color:#cccccc; color: #000033;">
				    <td height="20" colspan="8">CAT&Aacute;LOGO DE USUARIOS </td>
			      </tr>
				  <tr style="font-weight:bold; text-align:center; background-color:#EFEFEF; color: #666666;">
				    <td width="3%" height="20">&nbsp;</td>
					<td width="3%">Id</td>
					<td width="14%">Usuario</td>
					<td width="32%">Nombre</td>
					<td width="13%">Grupo</td>
					<td width="4%">Nivel</td>
					<td width="27%">Puesto</td>
					<td width="4%">Obs.</td>
				  </tr>
				  <?php while ($row_usuario1=mysql_fetch_array($result_usuario1)) { ?>
				  <tr bgcolor="<?=$color?>">
				    <td height="20" align="center"><input type="checkbox" name="chb<?=$row_usuario1["id_usuario"]?>" id="<?=$row_usuario1["id_usuario"]?>" value="<?=$row_usuario1["id_usuario"]?>" /></td>
					<td class="td1" align="center"><?=$row_usuario1["id_usuario"]?></td>
					<td>&nbsp;<a href="javascript:ver_usuario(<?=$row_usuario1["id_usuario"]?>);" title="Ver detalles del Usuario <?=$row_usuario1["usuario"]?>."><?=$row_usuario1["usuario"]?></a></td>
					<td class="td1">&nbsp;<?=$row_usuario1["dp_nombre"]." ".$row_usuario1["dp_apaterno"]." ".$row_usuario1["dp_amaterno"]?></td>
					<td>&nbsp;<?=$row_usuario1["grupo"]?></td>
					<td class="td1" align="center">&nbsp;<?=$row_usuario1["nivel_usuario"]?></td>
					<td>&nbsp;<?=$row_usuario1["de_puesto"]?></td>
					<td class="td1i" align="center"><a href="#" title="<?=$row_usuario1["obs"]?>">&laquo;&loz;&raquo;</a></td>
				  </tr>
				  <?php 
				  ($color=="#FFFFFF")? $color="#F8F8FF" : $color="#FFFFFF";
				  } ?>
				</table>
				</form>			
			<?php
		} else {
			?>
			<div style="text-align:center; border:#333333 2px solid; background-color:#FFFF99; margin:10px 20px 10px 20px; padding:5px 5px 5px 5px; font-size:18px; color:#000000;">
				No se encontraron resultados.			</div>			
			<?php		
		}	
	}
	
	
	if ($ac=="nuevo")
	{	
	?>			
            <div id="mensajeX" style="position:relative; width:700px; left:50%; margin-left:-350px; border:#F63 2px solid; padding:2px;">
            	<a href="javascript:c_m();" title="Cerrar este mensaje." style="float:right;">Cerrar mensaje</a>
                <p><b>Nota Importante:</b>
            	  
          	  </p>
           	  <p>Antes de dar de alta un usuario considere las siguientes recomendaciones:</p>
                <ol>
                	<li>Capture los campos obligatorios (borde obscuro y continuo), si desconoce el dato, capture un - o una letra (por ejemplo X). Los campos opcionales aparecen con borde punteado.</li>
                	<li>Clasifique los usuarios por grupos.</li>
                	<li>Organice los niveles de acceso: Almacen [1-10]  e Ingenier&iacute;a [11-20].</li>
                	<li>En el M&oacute;dulo de Ingenier&iacute;a, los niveles est&aacute;n distribuidos de la siguiente manera: Administrador de ingenier&iacute;a (11,12,13,14,15), Recibo (12), Reparaci&oacute;n (13), Calidad (14), Despacho (15).</li>
                </ol>
            </div>
            <form name="frm0" id="frm0" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
			<br /><table width="800" align="center" style="border:#cccccc 2px solid;" cellspacing="0">
              <tr>
                <td height="23" colspan="4"  style="font-weight:bold; text-align:center; background-color:#cccccc; color: #000033;">NUEVO USUARIO</td>
              </tr>
              <tr>
                <td width="146" class="cv">Id Usuario </td>
                <td width="212"><input type="text" name="id_usuario" id="id_usuario" readonly="1" value="Autonumerico" class="txtoc" /></td>
                <td width="180" class="cv">Fecha</td>
                <td width="242"><input type="text" name="f_alta" id="f_alta" value="<?=$fecha?>" class="txtoc" readonly="1" /></td>
              </tr>
              <tr>
                <td class="cv">Usuario</td>
                <td><input type="text" name="usuario" id="usuario" class="txtoi" /></td>
                <td class="cv">Password</td>
                <td><input type="password" name="password" id="password" class="txtoi"  /></td>
              </tr>
              <tr>
                <td class="cv">Repetir Password </td>
                <td><input type="password" name="password2" id="password2" class="txtoi"  /></td>
                <td class="cv">Activo</td>
                <td><input type="checkbox" name="activo" value="1" id="activo" checked="checked" /></td>
              </tr>
              <tr>
                <td class="cv">Grupo</td>
                <td><input type="text" name="grupo" id="grupo" class="txtoi"></td>
                <td class="cv">Nivel de Acceso </td>
                <td><input type="text" name="nivel_usuario" id="nivel_usuario" class="txtoi"></td>
              </tr>
              <tr>
                <td class="cv">Nombre</td>
                <td><input type="text" name="dp_nombre" id="dp_nombre" class="txtoi" /></td>
                <td class="cv">Primer Apellido </td>
                <td><input type="text" name="dp_apaterno" id="dp_apaterno" class="txtoi" /></td>
              </tr>
              <tr>
                <td class="cv">Segundo Apellido </td>
				<td><input type="text" name="dp_amaterno" id="dp_amaterno" class="txtoi" /></td>
                <td class="cv">Sexo</td>
                <td><label><input type="radio" name="dp_sexo" id="radio" value="M" />Masculino</label>
                    <label><input type="radio" name="dp_sexo" id="radio2" value="F" />Femenimo</label>				</td>
              </tr>
              <tr>
                <td class="cv"><!--Foto//-->&nbsp;No. empleadoIQ</td>
                <td><!--<input type="file" name="foto[]" id="foto" />//--><input type="text" name="de_noempleadoiq" id="de_noempleadoiq" class="txtoi" /></td>
                <td class="cv">IP</td>
                <td>
					<label>
					<input type="text" name="ip" id="ip" value="<?=$_SERVER['REMOTE_ADDR']?>"/>
					</label></td>
              </tr>
              <tr>
                <td class="cv">Correo Electr&oacute;nico</td>
                <td><input type="text" name="dp_email" id="dp_email" class="txtvi" /></td>
                <td class="cv">Tel. trabajo </td>
                <td><input type="text" name="de_tel_trabajo" id="de_tel_trabajo" class="txtvi" /></td>
              </tr>
              <tr>
                <td class="cv">Area / Proyecto</td>
                <td><input type="text" name="de_proyecto" id="de_proyecto" class="txtoi" /></td>
                <td class="cv">Puesto</td>
                <td><input type="text" name="de_puesto" id="de_puesto" class="txtoi" /></td>
              </tr>
              <tr>
                <td class="cv">Jefe inmediato </td>
                <td><input type="text" name="de_jefe_inmediato" id="de_jefe_inmediato" class="txtvi" /></td>
                <td class="cv">&nbsp;<!--Almacenes Asociados:--> </td>
                <td>&nbsp;<!--<input type="text" name="txt_almacenes" id="txt_almacenes" class="txtvi" onclick="muestra_almacenes()" readonly="1" />--></td>
              </tr>
              <tr>
                <td class="cv">Observaciones</td>
                <td><input type="text" name="obs" id="obs" class="txtvi" /></td>
                <td class="cv">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="33" colspan="4" align="center">
					<input type="reset" value="Limpiar" />
					<input type="button" value="Guardar" onclick="validar_frm0()" />
					<!--<input type="submit" value="Guardar" />//-->				</td>
              </tr>
              
            </table>
			</form>
<?php }

	}
	
	
	if ($ac=="eliminar")
	{
		$ids_recibidas=$_POST["ids"];
		$ids_split=split(',',$ids_recibidas);
		foreach ($ids_split as $id_eliminar)
		{
			//echo "<br>$id_eliminar";
			$sql_eliminar="UPDATE usuarios SET activo=0 WHERE id_usuario=$id_eliminar LIMIT 1";
			if (!mysql_db_query($sql_inv,$sql_eliminar))
			{
				echo "<br><center>Error del sistema. El usuario ($id_eliminar) no se elimino. Consulte el Administrador del Sistema.</center>";
			} else {
				echo "<br><center>El usuario ($id_eliminar) se elimino correctamente.</center>";
			}
		}
	
	}
	
	if ($ac=="ver_usuario")
	{
		$id_usuario=$_POST["id_usuario"];
		$sql_usuario="SELECT * FROM usuarios WHERE id_usuario=$id_usuario";
		$result_usuario=mysql_db_query($sql_inv,$sql_usuario);
		while ($row_usuario=mysql_fetch_array($result_usuario)){ 
			//print_r($row_usuario);
			?>
            <form name="frm1" id="frm1" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">			
			<br /><table width="800" align="center" style="border:#cccccc 2px solid;" cellspacing="0">
              <tr>
                <td height="23" colspan="4"  style="font-weight:bold; text-align:center; background-color:#cccccc; color: #000033;"> USUARIO <?=$id_usuario?>.</td>
              </tr>
              <tr>
                <td width="146" class="cv">Id Usuario </td>
                <td width="212"><input type="text" name="id_usuario" id="id_usuario" readonly="1" value="<?=$row_usuario["id_usuario"]?>" class="txtoc" /></td>
                <td width="180" class="cv">Fecha</td>
                <td width="242"><input type="text" name="f_alta" id="f_alta" value="<?=$row_usuario["f_alta"]?>" class="txtoc" readonly="1" /></td>
              </tr>
              <tr>
                <td class="cv">Usuario</td>
                <td><input type="text" name="usuario" id="usuario" class="txtoi"  value="<?=$row_usuario["usuario"]?>"  /></td>
                <td class="cv"><!--Password-->Activo</td>
                <td><!--<input type="password" name="password" id="password" class="txtoi" value="************************"   />-->
                <input type="checkbox" name="activo2" value="1" id="activo2"  <?php if($row_usuario["activo"]==1) echo 'checked="checked"'; ?>  /></td>
              </tr>
              
              <tr>
                <td class="cv">Grupo</td>
                <td><input type="text" name="grupo" id="grupo" class="txtoi" value="<?=$row_usuario["grupo"]?>"></td>
                <td class="cv">Nivel de Acceso </td>
                <td><input type="text" name="nivel_usuario" id="nivel_usuario" class="txtoi" value="<?=$row_usuario["nivel_usuario"]?>"></td>
              </tr>
              
              <tr>
                <td class="cv">Nombre</td>
                <td><input type="text" name="dp_nombre" id="dp_nombre" class="txtoi" value="<?=$row_usuario["dp_nombre"]?>" /></td>
                <td class="cv">Primer Apellido </td>
                <td><input type="text" name="dp_apaterno" id="dp_apaterno" class="txtoi" value="<?=$row_usuario["dp_apaterno"]?>" /></td>
              </tr>
              <tr>
                <td class="cv">Segundo Apellido </td>
				<td><input type="text" name="dp_amaterno2" id="dp_amaterno2" class="txtoi" value="<?=$row_usuario["dp_amaterno"]?>" /></td>
                <td class="cv">Sexo</td>
                <td>&nbsp;<?=$row_usuario["dp_sexo"]?></td>
              </tr>
              
              <?php if ($row_usuario["foto"]!=="") { ?>
			  <?php } ?>
              <tr>
                <td class="cv">Correo Electr&oacute;nico </td>
                <td><input type="text" name="dp_email2" id="dp_email2" class="txtvi" value="<?=$row_usuario["dp_email"]?>" /></td>
                <td class="cv">Tel. particular (Cel.) </td>
                <td><input type="text" name="dp_tel_particular" id="dp_tel_particular" class="txtvi" value="<?=$row_usuario["dp_tel_particular"]?>" /></td>
              </tr>
              <tr>
                <td class="cv">Area / Proyecto</td>
                <td><input type="text" name="de_proyecto2" id="de_proyecto2" class="txtoi"  value="<?=$row_usuario["de_proyecto"]?>" /></td>
                <td class="cv">IP</td>
                <td><input type="text" name="ip" id="ip" value="<?=$_SERVER['REMOTE_ADDR']?>"/></td>
              </tr>
              
              <tr>
                <td class="cv">Puesto</td>
                <td><input type="text" name="de_puesto2" id="de_puesto2" class="txtoi" value="<?=$row_usuario["de_puesto"]?>" /></td>
                <td class="cv">Jefe inmediato </td>
                <td><input type="text" name="de_jefe_inmediato2" id="de_jefe_inmediato2" class="txtvi" value="<?=$row_usuario["de_jefe_inmediato"]?>" /></td>
              </tr>
              <tr>
                <td class="cv">No. empleadoIQ</td>
                <td><input type="text" name="de_noempleadoiq2" id="de_noempleadoiq2" class="txtoi" value="<?=$row_usuario["de_noempleadoiq"]?>" /></td>
                <td class="cv">Tel. trabajo </td>
                <td><input type="text" name="de_tel_trabajo2" id="de_tel_trabajo2" class="txtvi" value="<?=$row_usuario["de_tel_trabajo"]?>" /></td>
              </tr>
              <tr>
                <td class="cv">&nbsp;<!--Almacenes Asociados:--></td>
                <td>&nbsp;<!--<input type="text" name="txt_almacenes2" id="txt_almacenes2" class="txtvi" value="<?//$row_usuario["cdc"]?>" />//--></td>
                <td class="cv">Observaciones</td>
                <td><input type="text" name="obs2" id="obs2" class="txtvi" value="<?=$row_usuario["obs"]?>" /></td>
              </tr>
              
              <tr>
                <td colspan="4" align="center">
					<!--
					<input type="reset" value="Limpiar" />
					<input type="button" value="Modificar" onclick="validar_frm0()" />
					<input type="submit" value="Modificar2" />
					//-->				</td>
              </tr>
            </table>
			</form>
		<?php	
		}		
	
	}	


	if ($ac=="ver_almacenes")
	{
		echo $sql_usuario1="SELECT * FROM tipoalmacen WHERE activo=1 ORDER BY id_almacen";
		$result_usuario1=mysql_db_query($sql_inv,$sql_usuario1);
		$ndr1=mysql_num_rows($result_usuario1);
		if ($ndr1>0)
		{
			
			?>
				<form name="frm4" id="frm4" method="post" action="<?=$_SERVER['PHP_SELF']?>">
				<table width="600" align="center" cellpadding="1" cellspacing="0" style="border:#cccccc 1px solid;">
				  <tr style="font-weight:bold; text-align:center; background-color:#cccccc; color: #000033;">
				    <td height="20" colspan="4">CAT&Aacute;LOGO DE CENTROS DE COSTO (ALMACENES) </td>
			      </tr>
				  <tr style="font-weight:bold; text-align:center; background-color:#EFEFEF; color: #666666;">
				    <td width="4%" height="20">&nbsp;</td>
					<td width="5%">Id</td>
					<td width="40%">Almac&eacute;n</td>
					<td width="51%">Observaciones</td>
				  </tr>
				  <?php while ($row_usuario1=mysql_fetch_array($result_usuario1)) { ?>
				  <tr bgcolor="<?=$color?>">
				    <td height="20" align="center"><input type="checkbox" name="chb<?=$row_usuario1["id_almacen"]?>" id="<?=$row_usuario1["id_almacen"]?>" value="<?=$row_usuario1["id_almacen"]?>" /></td>
					<td class="td1" align="center"><?=$row_usuario1["id_almacen"]?></td>
					<td>&nbsp;<?=$row_usuario1["almacen"]?></td>
					<td class="td1">&nbsp;<?=$row_usuario1["observ"]?></td>
				  </tr>
				  <?php 
				  ($color=="#FFFFFF")? $color="#F8F8FF" : $color="#FFFFFF";
				  } ?>
				</table>
				<br /><div align="center">
					<input type="button" onclick="obtener_almacenes()" value="Aceptar" />
				</div>
				</form>			
			<?php
		} else {
			?>
			<div style="text-align:center; border:#333333 2px solid; background-color:#FFFF99; margin:10px 20px 10px 20px; padding:5px 5px 5px 5px; font-size:18px; color:#000000;">
				No se encontraron resultados.			</div>			
			<?php		
		}	
	}

		
?>