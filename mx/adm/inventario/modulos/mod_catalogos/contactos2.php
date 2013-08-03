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

		$sql_contacto="SELECT * FROM contactos ORDER BY id_contacto";

		$result_contacto=mysql_db_query($sql_inv,$sql_contacto);

		$ndr1=mysql_num_rows($result_contacto);

		if ($ndr1>0)

		{		

		?>

				<table width="800" align="center" cellpadding="1" cellspacing="0" style="border:#333333 1px solid;">

				  <tr style="font-weight:bold; text-align:center; background-color:#333333; color: #ffffff;">

				    <td height="20" colspan="7">CAT&Aacute;LOGO DE CONTACTOS </td>

			      </tr>

				  <tr style="font-weight:bold; text-align:center; background-color:#cccccc; color: #000000;">

				    <td width="2%" height="20">Id</td>

					<td width="44%">Contacto</td>

					<td width="15%">Tel. Oficina </td>

					<td width="7%">Fax</td>

					<td width="11%">Categor&iacute;a</td>

					<td width="14%">Activo</td>

					<td width="7%">Detalles</td>

				  </tr>

				  <?php while ($row_contacto=mysql_fetch_array($result_contacto)) { ?>

				  <tr bgcolor="<?=$color?>">

				    <td height="20" align="center"><?=$row_contacto["id_contacto"]?></td>

					<td class="td1">&nbsp;<?=$row_contacto["nombre"].' '.$row_contacto["apellidos"]?></td>

					<td>&nbsp;<?=$row_contacto["tel_oficina"]?></td>

					<td class="td1" align="center">&nbsp;<?=$row_contacto["fax"]?></td>

					<td align="center">&nbsp;<?=$row_contacto["categoria"]?></td>

					<td class="td1" align="center">&nbsp;<?PHP if ($row_contacto["activo"]==1) echo "SI"; else echo "NO";?></td>

					<td align="center"><a href="javascript:ver_contacto('<?=$row_contacto["id_contacto"]?>');" title="Ver detalles del Contacto <?=$row_contacto["id_contacto"]?>">Ver</a></td>

				  </tr>

				  <?php 

				  ($color=="#FFFFFF")? $color="#D9FFB3" : $color="#FFFFFF";

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

			<table width="600" align="center" cellspacing="0" style="border:#333333 2px solid;">

              <tr style="font-weight:bold; text-align:center; background-color:#333333; color: #ffffff;">

                <td colspan="4" height="20">NUEVO CONTACTO </td>

              </tr>

              <tr>

                <td width="165" class="cv">Id Contacto </td>

                <td width="144"><input type="text" name="id_contacto" id="id_contacto" value="Autonumerico" class="txtoc" readonly="1" /></td>

                <td width="135" class="cv"> Fecha de registro</td>

                <td width="144"><input type="text" name="f_alta" id="f_alta" value="<?=date("Y-m-d")?>" class="txtoc" readonly="1" /></td>

              </tr>

              

              <tr>

                <td class="cv">Activo</td>

                <td align="center"><input type="checkbox" checked="checked" name="activo" id="activo" value="1" /> S / N</td>

                <td class="cv">Categor&iacute;a</td>

                <td><input type="text" name="categoria" id="categoria" value="" class="txtoi" /></td>

              </tr>

              <tr>

                <td class="cv">Nombre(s)</td>

                <td><input type="text" name="nombre" id="nombre" value="" class="txtoi" /></td>

                <td class="cv">Apellidos (ambos) </td>

                <td><input type="text" name="apellidos" id="apellidos" value="" class="txtoi" /></td>

              </tr>

              <tr>

                <td class="cv">Tel. Oficina </td>

                <td><input type="text" name="tel_oficina" id="tel_oficina" value="" class="txtoi" /></td>

                <td class="cv">Tel. Particular </td>

                <td><input type="text" name="tel_particular" id="tel_particular" value="" class="txtoi" /></td>

              </tr>

              <tr>

                <td class="cv">Fax</td>

                <td><input type="text" name="fax" id="fax" value="" class="txtoi" /></td>

                <td class="cv">Correo Electr&oacute;nico </td>

                <td><input type="text" name="email" id="email" value="" class="txtoi" /></td>

              </tr>

              

              <tr>

                <td class="cv">Organizaci&oacute;n</td>

                <td><input type="text" name="organizacion" id="organizacion" value="" class="txtoi" /></td>

                <td class="cv">Obs</td>

                <td><input type="text" name="obs" id="obs" value="" class="txtoi" /></td>

              </tr>

              <tr>

                <td height="36" colspan="4" align="center">

					<input type="reset" value="Limpiar" />

					<input type="button" value="Guardar" onclick="validar_frm0()" />

					<!--<input type="submit" value="Guardar2" />-->				</td>

              </tr>

            </table>

			</form>

			<?php

	}

	

	if ($ac=="guardar_contacto")

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

		

		$sql_nuevo="INSERT INTO contactos($sql_campos) VALUES ($sql_valores)";

		if (!mysql_db_query($sql_inv,$sql_nuevo,$link))

		{

			echo "<br><center>Error SQL.</center>";

		} else {

			echo "<br><center>El Contacto se inserto correctamente.</center>";

		}		

	}	

	

	if ($ac=="ver_contacto")

	{

		$id_contacto=$_POST["id_contacto"];

		$sql_contacto="SELECT * FROM contactos WHERE id_contacto=$id_contacto";

		$result_contacto=mysql_db_query($sql_inv,$sql_contacto);

		while ($row_contacto=mysql_fetch_array($result_contacto)){ 

		?>	

			<table width="600" align="center" cellspacing="0" style="border:#333333 2px solid;">

              <tr style="font-weight:bold; text-align:center; background-color:#333333; color: #ffffff;">

                <td colspan="4" height="20">CONTACTO  <?=$id_contacto?> </td>

              </tr>

              <tr>

                <td width="165" class="cv">Id Contacto </td>

                <td width="144"><input type="text" name="id_contacto" id="id_contacto" value="<?=$id_contacto?>" class="txtoc" readonly="1" /></td>

                <td width="135" class="cv"> Fecha de registro</td>

                <td width="144"><input type="text" name="f_alta" id="f_alta" value="<?=$row_contacto["f_alta"]?>" class="txtoc" readonly="1" /></td>

              </tr>

              

              <tr>

                <td class="cv">Activo</td>

                <td align="center"><?php if ($row_contacto["activo"]==1) echo "SI"; else echo "NO"; ?></td>

                <td class="cv">Categor&iacute;a</td>

                <td><input type="text" name="categoria" id="categoria" value="<?=$row_contacto["categoria"]?>" class="txtoi" /></td>

              </tr>

              <tr>

                <td class="cv">Nombre(s)</td>

                <td><input type="text" name="nombre" id="nombre" value="<?=$row_contacto["nombre"]?>" class="txtoi" /></td>

                <td class="cv">Apellidos (ambos) </td>

                <td><input type="text" name="apellidos" id="apellidos" value="<?=$row_contacto["apellidos"]?>" class="txtoi" /></td>

              </tr>

              <tr>

                <td class="cv">Tel. Oficina </td>

                <td><input type="text" name="tel_oficina" id="tel_oficina" value="<?=$row_contacto["tel_oficina"]?>" class="txtoi" /></td>

                <td class="cv">Tel. Particular </td>

                <td><input type="text" name="tel_particular" id="tel_particular" value="<?=$row_contacto["tel_particular"]?>" class="txtoi" /></td>

              </tr>

              <tr>

                <td class="cv">Fax</td>

                <td><input type="text" name="fax" id="fax" value="<?=$row_contacto["fax"]?>" class="txtoi" /></td>

                <td class="cv">Correo Electr&oacute;nico </td>

                <td><input type="text" name="email" id="email" value="<?=$row_contacto["email"]?>" class="txtoi" /></td>

              </tr>

              

              <tr>

                <td class="cv">Organizaci&oacute;n</td>

                <td><input type="text" name="organizacion" id="organizacion" value="<?=$row_contacto["organizacion"]?>" class="txtoi" /></td>

                <td class="cv">Obs</td>

                <td><input type="text" name="obs" id="obs" value="<?=$row_contacto["obs"]?>" class="txtoi" /></td>

              </tr>

            </table>		

		<?php

		}

	}	

?>	





