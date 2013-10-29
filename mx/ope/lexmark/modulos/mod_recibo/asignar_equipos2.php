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
		//echo "<br>";	print_r($ids2);
		
		foreach ($ids2 as $ids2a){
			$sql_update="UPDATE ot SET status_cliente='REP', repara='$t', fecha_inicio='".date("Y-m-d H:i:s")."', status_proceso='DIAG' WHERE id=$ids2a";
			//if (!mysql_db_query($sql_ing,$sql_update)){
				$results=mysql_query($sql_update,$link);
						     if(!$results){
				echo "<br>&nbsp;Error SQL. El script se detuvo.";
				
			}
		}?>
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
			<table align="center" cellpadding="2" cellspacing="0" class="tabla1" width="800">
			  <tr>
				<th colspan="7" class="tabla_titulo">Equipos NO asignados. </th>
			  </tr>
			  <tr>
			    <td width="20" class="tabla_campos">&nbsp;</td>
				<td width="27" class="tabla_campos">Id</td>
				<td width="78" height="20" class="tabla_campos">OT</td>
				<td width="438" class="tabla_campos">No Serie</td>
				<td width="115" class="tabla_campos">Fecha Recibo </td>
				<td width="96" class="tabla_campos">Obs.</td>
			  </tr>
				<?php
				$col="#FFFFFF";
				while ($row0=mysql_fetch_array($result0)){ 
				 ?>
				<tr bgcolor="<?=$col?>">
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
			<div align="center"><br />Asignar a: 
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