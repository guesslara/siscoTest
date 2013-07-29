<?php 

	session_start();

	header("Cache-Control: no-store, no-cache, must-revalidate");

	header("Content-Type: text/xml; charset=ISO-8859-1");	

	include ("../../conf/conectarbase.php");

	//print_r($_POST);
	$color="#FFFFFF";	

	$ac=$_POST["accion"];



	if ($ac=="listar")

	{

		$sql_cliente="SELECT * FROM cat_clientes ORDER BY id_cliente";

		$result_cliente=mysql_db_query($sql_inv,$sql_cliente);

		$ndr1=mysql_num_rows($result_cliente);

		if ($ndr1>0)

		{		

		?>

				<table width="800" align="center" cellpadding="1" cellspacing="0" style="border:#cccccc 1px solid;">

				  <tr style="font-weight:bold; text-align:center; background-color:#333333; color: #ffffff;">

				    <td height="20" colspan="7">CAT&Aacute;LOGO DE CLIENTES </td>

			      </tr>

				  <tr style="font-weight:bold; text-align:center; background-color:#cccccc; color: #000000;">

				    <td width="2%" height="20">Id</td>

					<td width="14%">Fecha de Alta </td>

					<td width="8%">Clave</td>

					<td width="59%">Cliente</td>

					<td width="6%">Activo</td>

					<td width="4%">Obs</td>

					<td width="7%">Detalles</td>

				  </tr>

				  <?php while ($row_cliente=mysql_fetch_array($result_cliente)) { ?>

				  <tr bgcolor="<?=$color?>">

				    <td height="20" align="center"><?=$row_cliente["id_cliente"]?></td>

					<td align="center" class="td1">&nbsp;<?=$row_cliente["fecha_alta"]?></td>

					<td>&nbsp;<?=$row_cliente["cve_cliente"]?></td>

					<td class="td1">&nbsp;<?=$row_cliente["n_comercial"]?></td>

					<td align="center">&nbsp;<?php if($row_cliente["activo"]==1) echo "SI"; else echo "NO";?></td>

					<td class="td1" align="center"><a href="#" title="<?=$row_cliente["obs"]?>">&raquo;</a></td>

					<td align="center"><a href="javascript:ver_cliente('<?=$row_cliente["id_cliente"]?>');" title="Ver detalles del cliente <?=$row_cliente["id_cliente"]?>">Ver</a></td>

				  </tr>

				  <?php 

				  ($color=="#FFFFFF")? $color="#F8F8FF" : $color="#FFFFFF";

				  } ?>

				</table>

			<?php

		} else {

			?>

			<div style="text-align:center; border:#333333 2px solid; background-color:#FFFF99; margin:10px 100px 10px 100px; padding:5px 5px 5px 5px; font-size:18px; color:#000000;">

				No se encontraron resultados.			</div>			

			<?php		

		}			

	}

	

	if ($ac=="nuevo")

	{	

		?>

            <form name="frm0" id="frm0" method="post" action="<?=$_SERVER['PHP_SELF']?>">			

			<table width="600" align="center" cellspacing="0" style="border:#CCCCCC 2px solid;">

              <tr style="font-weight:bold; text-align:center; background-color:#333333; color: #ffffff;">

                <td colspan="4" height="20">NUEVO CLIENTE </td>

              </tr>

              <tr>

                <td width="165" class="cv">Id cliente </td>

                <td width="144"><input type="text" name="id_cliente" id="id_cliente" value="Autonumerico" class="txtoc" readonly="1" /></td>

                <td width="135" class="cv"> Fecha de registro</td>

                <td width="144"><input type="text" name="fecha_alta" id="fecha_alta" value="<?=date("Y-m-d")?>" class="txtoc" readonly="1" /></td>

              </tr>

              

              <tr>

                <td class="cv">Activo</td>

                <td align="center"><input type="checkbox" checked="checked" name="activo" id="activo" value="1" /> S / N</td>

                <td class="cv">Clave del Cliente </td>

                <td><input type="text" name="cve_cliente" id="cve_cliente" value="" class="txtoc" /></td>

              </tr>

              <tr>

                <td class="cv">Raz&oacute;n Social </td>

                <td><input type="text" name="r_social" id="r_social" value="" class="txtoi" /></td>

                <td class="cv">Nombre Comercial </td>

                <td><input type="text" name="n_comercial" id="n_comercial" value="" class="txtoi" /></td>

              </tr>

              <tr>

                <td class="cv">RFC</td>

                <td><input type="text" name="rfc" id="rfc" value="" class="txtoi" /></td>

                <td class="cv">Direcci&oacute;n Web </td>

                <td><input type="text" name="direccion_web" id="direccion_web" value="" class="txtoi" /></td>

              </tr>

              <tr>

                <td class="cv">Calle / N&uacute;mero </td>

                <td><input type="text" name="calle_numero" id="calle_numero" value="" class="txtoi" /></td>

                <td class="cv">Colonia </td>

                <td><input type="text" name="colonia" id="colonia" value="" class="txtoi" /></td>

              </tr>

              

              <tr>

                <td class="cv">Del / Municipio </td>

                <td><input type="text" name="del_mun" id="del_mun" value="" class="txtoi" /></td>

                <td class="cv">Entidad</td>

                <td><input type="text" name="entidad" id="entidad" value="" class="txtoi" /></td>

              </tr>

              <tr>

                <td class="cv">C&oacute;digo Postal (CP) </td>

                <td><input type="text" name="cp" id="cp" value="" class="txtoi" /></td>

                <td class="cv">Pa&iacute;s</td>

                <td><input type="text" name="pais" id="pais" value="" class="txtoi" /></td>

              </tr>

              <tr>

                <td class="cv">Contactos</td>

                <td><input type="text" name="contactos" id="contactos" value="" class="txtoi" readonly="1"  onclick="elegir_contacto()" /></td>

                <td class="cv">Observaciones</td>

                <td><input type="text" name="obs" id="obs" value="--" class="txtoi" /></td>

              </tr>

              

              <tr>

                <td height="36" colspan="4" align="center">

					<input type="reset" value="Limpiar" />

					<input type="button" value="Guardar" onClick="validar_frm0()" />

					<!--<input type="submit" value="Guardar2" />-->				</td>

              </tr>

            </table>

			</form>

			<?php

	}

	

	if ($ac=="guardar_cliente")

	{		

		$sql_campos="";

		$sql_valores="";

		//echo "<br><br>";

		foreach($_POST as $c=>$v)

		{

			if ($c!=="accion")

			{

				//echo "<br>".$c." = ".$v;

				($sql_campos=="")? $sql_campos=$c : $sql_campos.=",".$c;

				($sql_valores=="")? $sql_valores="'$v'" : $sql_valores.=",'".$v."'";

			}

		}

		$sql_valores=str_replace('\'Autonumerico\'','NULL',$sql_valores);		

		//echo "<hr>$sql_campos<hr>$sql_valores";

		

		$sql_nuevo="INSERT INTO cat_clientes($sql_campos) VALUES ($sql_valores)";

		

		if (!mysql_db_query($sql_inv,$sql_nuevo,$link))

		{

			echo "<br><center>Error SQL.</center>";

		} else {

			echo "<br><center>El cliente se inserto correctamente.</center>";

		}

	}	

	

	if ($ac=="ver_cliente")

	{

		$id_cliente=$_POST["id_cliente"];

		$sql_cliente="SELECT * FROM cat_clientes WHERE id_cliente=$id_cliente";

		$result_cliente=mysql_db_query($sql_inv,$sql_cliente);

		while ($row_cliente=mysql_fetch_array($result_cliente)){ 

		?>	

			<table width="600" align="center" cellspacing="0" style="border:#CCCCCC 2px solid;">

              <tr style="font-weight:bold; text-align:center; background-color:#333333; color: #ffffff;">

                <td colspan="4" height="20"> CLIENTE <?=$id_cliente?></td>

              </tr>

              <tr>

                <td width="165" class="cv">Id cliente </td>

                <td width="144"><input type="text" name="id_cliente" id="id_cliente" value="<?=$row_cliente["id_cliente"]?>" class="txtoc" readonly="1" /></td>

                <td width="135" class="cv"> Fecha de registro</td>

                <td width="144"><input type="text" name="fecha_alta" id="fecha_alta" value="<?=$row_cliente["fecha_alta"]?>" class="txtoc" readonly="1" /></td>

              </tr>

              

              <tr>

                <td class="cv">Activo</td>

                <td align="center"><input type="text" name="activo" id="activo" value="<?php if ($row_cliente["activo"]==1) echo "SI"; else echo "NO"; ?>" class="txtoc" /></td>

                <td class="cv">Clave del Cliente </td>

                <td><input type="text" name="cve_cliente" id="cve_cliente" value="<?=$row_cliente["cve_cliente"]?>" class="txtoc" /></td>

              </tr>

              <tr>

                <td class="cv">Raz&oacute;n Social </td>

                <td><input type="text" name="r_social" id="r_social" value="<?=$row_cliente["r_social"]?>" class="txtoi" /></td>

                <td class="cv">Nombre Comercial </td>

                <td><input type="text" name="n_comercial" id="n_comercial" value="<?=$row_cliente["n_comercial"]?>" class="txtoi" /></td>

              </tr>

              <tr>

                <td class="cv">RFC</td>

                <td><input type="text" name="rfc" id="rfc" value="<?=$row_cliente["rfc"]?>" class="txtoi" /></td>

                <td class="cv">Direcci&oacute;n Web </td>

                <td><input type="text" name="direccion_web" id="direccion_web" value="<?=$row_cliente["direccion_web"]?>" class="txtoi" /></td>

              </tr>

              <tr>

                <td class="cv">Calle / N&uacute;mero </td>

                <td><input type="text" name="calle_numero" id="calle_numero" value="<?=$row_cliente["calle_numero"]?>" class="txtoi" /></td>

                <td class="cv">Colonia </td>

                <td><input type="text" name="colonia" id="colonia" value="<?=$row_cliente["colonia"]?>" class="txtoi" /></td>

              </tr>

              

              <tr>

                <td class="cv">Del / Municipio </td>

                <td><input type="text" name="del_mun" id="del_mun" value="<?=$row_cliente["del_mun"]?>" class="txtoi" /></td>

                <td class="cv">Entidad</td>

                <td><input type="text" name="entidad" id="entidad" value="<?=$row_cliente["entidad"]?>" class="txtoi" /></td>

              </tr>

              <tr>

                <td class="cv">C&oacute;digo Postal (CP) </td>

                <td><input type="text" name="cp" id="cp" value="<?=$row_cliente["cp"]?>" class="txtoi" /></td>

                <td class="cv">Pa&iacute;s</td>

                <td><input type="text" name="pais" id="pais" value="<?=$row_cliente["pais"]?>" class="txtoi" /></td>

              </tr>

              <tr>

                <td class="cv">Contactos</td>

                <td><input type="text" name="contactos" id="contactos" value="<?=$row_cliente["contactos"]?>" class="txtoi" /></td>

                <td class="cv">Observaciones</td>

                <td><input type="text" name="obs" id="obs" value="<?=$row_cliente["obs"]?>" class="txtoi" /></td>

              </tr>

            </table>

		<?php

		}

	}

	

	if ($ac=="ver_contactos")

	{

		$sql_contacto="SELECT * FROM contactos ORDER BY id_contacto";

		$result_contacto=mysql_db_query($sql_inv,$sql_contacto);

		$ndr1=mysql_num_rows($result_contacto);

		if ($ndr1>0)

		{		

		?>

            <form name="frm1" id="frm1" method="post" action="<?=$_SERVER['PHP_SELF']?>">					

				<br /><table width="800" align="center" cellpadding="1" cellspacing="0" style="border:#cccccc 1px solid;">

				  <tr style="font-weight:bold; text-align:center; background-color:#333333; color: #ffffff;">

				    <td height="20" colspan="7">CAT&Aacute;LOGO DE CONTACTOS </td>

			      </tr>

				  <tr style="font-weight:bold; text-align:center; background-color:#cccccc; color: #000000;">

				    <td width="2%">&nbsp;</td>

				    <td width="2%" height="20">Id</td>

					<td width="44%">Contacto</td>

					<td width="15%">Tel. Oficina </td>

					<td width="7%">Fax</td>

					<td width="11%">Categor&iacute;a</td>

					<td width="14%">Activo</td>

				  </tr>

				  <?php while ($row_contacto=mysql_fetch_array($result_contacto)) { ?>

				  <tr bgcolor="<?=$color?>">

				    <td height="20" align="center"><input type="checkbox" name="chb_<?=$row_contacto["id_contacto"]?>" id="<?=$row_contacto["id_contacto"]?>" value="<?=$row_contacto["id_contacto"]?>" /></td>

				    <td align="center" class="td1"><?=$row_contacto["id_contacto"]?></td>

					<td class="td1">&nbsp;<?=$row_contacto["nombre"].' '.$row_contacto["apellidos"]?></td>

					<td>&nbsp;<?=$row_contacto["tel_oficina"]?></td>

					<td class="td1" align="center">&nbsp;<?=$row_contacto["fax"]?></td>

					<td align="center">&nbsp;<?=$row_contacto["categoria"]?></td>

					<td class="td1" align="center">&nbsp;<?=$row_contacto["activo"]?></td>

				  </tr>

				  <?php 

				  ($color=="#FFFFFF")? $color="#F8F8FF" : $color="#FFFFFF";

				  } ?>

				</table>

				<br /><div align="center">

					<input type="reset" value="Limpiar" />

					<input type="button" value="Colocar Contacto(s)" onclick="colocar_contactos()" />

				</div>

			</form>	

			<?php

		} else {

			?>

			<div style="text-align:center; border:#333333 2px solid; background-color:#FFFF99; margin:10px 100px 10px 100px; padding:5px 5px 5px 5px; font-size:18px; color:#000000;">

				No se encontraron resultados.			</div>			

			<?php		

		}			

	}	

?>	