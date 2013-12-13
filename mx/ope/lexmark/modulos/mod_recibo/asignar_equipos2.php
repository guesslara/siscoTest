<?php 
	session_start();
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	//echo "<br>";	print_r($_SESSION);
	//echo "<br>";	print_r($_POST);

	include("../../conf/conectarbase.php"); 
	
	if ($_POST["accion"]=="asignar")
	{
		$t=$_POST["tecnico"];
		$ids=$_POST["ids"];
		$ids2=explode(',',$ids);
		$fr=date("Y-m-d");
		$hr=date("H:i:s");
		$id_usu=$_SESSION['idUsuarioLX'];

		//echo "<br>";	print_r($ids2);
		
		foreach ($ids2 as $ids2a){
			$sql_update="UPDATE ot SET status_cliente='REP', repara='$t', fecha_inicio='".date("Y-m-d H:i:s")."', status_proceso='DIAG' WHERE id=$ids2a";
			//if (!mysql_db_query($sql_ing,$sql_update)){
				$results=mysql_query($sql_update,$link);
						     if(!$results){
				echo "<br>&nbsp;Error SQL. El script se detuvo.";
				
			}
			$id="SELECT nserie FROM `ot` WHERE id = '$ids'";
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
		        (NULL,'$idd','$fr','$hr','$id_usu','Producto Asignado a Tecnico')";
		        $res1=mysql_query($history,$link);
		}
		?>
		<script type="text/javascript">
			alert("Los equipos fueron asignados correctamente.");
		       </script>
		<?PHP
	}
	if ($_POST["accion"]=="listar")
	{
		$sql_0="SELECT * FROM ot WHERE status_cliente='REC' AND status_proceso='REC'";
		$result0=mysql_query($sql_0,$link);

		$sql_1="SELECT * FROM usuarios WHERE nivel_usuario=13";
		$result1=mysql_query($sql_1,$link);		
		?>
			<form id="frm1" name="frm1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
			<table align="center" cellpadding="2" cellspacing="0" class="tabla1" width="800" style=" border-radius: 10px;-moz-box-shadow: 3px 3px 4px #111; -webkit-box-shadow: 3px 3px 4px #111; box-shadow: 3px 3px 4px #111; -ms-filter: 'progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color=#111111)'; filter: progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#111111');">
			  <tr>
				<th colspan="7" class="tabla_titulo" style=" text-shadow: 2px 2px 2px gray;">Equipos NO asignados. </th>
			  </tr>
			  <tr>
			    <td width="20" class="tabla_campos">&nbsp;</td>
				<td width="27" class="tabla_campos" style=" text-shadow: 2px 2px 2px gray;">Id</td>
				<td width="78" height="20" class="tabla_campos" style=" text-shadow: 2px 2px 2px gray;">OT</td>
				<td width="438" class="tabla_campos" style=" text-shadow: 2px 2px 2px gray;">No Serie</td>
				<td width="115" class="tabla_campos" style=" text-shadow: 2px 2px 2px gray;">Fecha Recibo </td>
				<td width="96" class="tabla_campos" style=" text-shadow: 2px 2px 2px gray;">Obs.</td>
			  </tr>
				<?php
				$col="#FFFFFF";
				while ($row0=mysql_fetch_array($result0)){ 
				 ?>
				<tr bgcolor="<?=$col?>" onmouseover='this.style.background="#819FF7"' onmouseout='this.style.background="white"'>
				  <td align="center"><input type="checkbox" name="chk_<?=$row0['id']?>" id="chk_<?=$row0['id']?>" value="<?=$row0['id']?>" /></td>
				  <td height="20" align="center"><?=$row0['id']?></td>
					<input name="fechainirep" type="hidden" id="fechainirep" value="<?=date('Y-m-d H:i:s');?>" />
					<td class="td1"><?=$row0['ot'];?><input type="hidden" name="ot" value="<?=$row0['ot'];?>" /></td>
					<td><?=$row0['nserie'];?></td>
					<td class="td1" align="right"><?=$row0['f_recibo'];?>&nbsp;</th>
					<td align="center">--&nbsp;</td>
				  </tr>
				<?php ($col=="#FFFFFF")? $col="#EFEFEF" : $col="#FFFFFF"; } ?>
			</table>
			<div align="center" style=" text-shadow: 2px 2px 2px gray;"><br />Asignar a: 
				<select name="tecnico" id="tecnico">
				<option value="">...</option>
				<?php 
					while ($row1=mysql_fetch_array($result1)){ 
						?>
						<option value="<?=$row1["id_usuario"]?>"><?=$row1["id_usuario"].". ".$row1["dp_nombre"]." ".$row1["dp_apaterno"]." ".$row1["dp_amaterno"]." "?></option>
						<?php
					}
				?>
				</select> 
				los equipos selecionados.
				<br /><br />
				<input type="reset" value="Limpiar" />&nbsp;
				<input type="button" value="Guardar" onclick="asignar()" />
			</div>
			</form>	
		<?php
	}	
	exit();	
?>