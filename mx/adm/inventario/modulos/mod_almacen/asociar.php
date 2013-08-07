<?php 
	if ($_POST){	
		include ("../../conf/conectarbase.php");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Content-Type: text/xml; charset=ISO-8859-1");
		//print_r($_POST);
		$a=$_POST["action"];
		$x=$_POST["x"];
		
		if ($a=="asociar"){
			if ($x=="a"){
				echo "<br>Asociar Almacenes.";
				$sql1="SELECT * FROM tipoalmacen ORDER BY id_almacen";
				$res1=mysql_query($sql1,$link);
				?>
				<form name="form1" method="post" action="">
				  <table width="500" cellspacing="0" cellpadding="2" align="center">
					<tr>
					  <td colspan="3"><b>ALMACENES DEL SISTEMA</b> </td>
					</tr>
					<tr style="text-align:center; font-weight:bold;">
					  <td width="20">&nbsp;</td>
					  <td width="25">Id</td>
					  <td width="447">Almac&eacute;n</td>
					</tr>			
				<?php
				while ($row1=mysql_fetch_array($res1)){
					//echo "<br>"; print_r($row1);
					?>
					<tr>
					  <td><input type="checkbox" name="chk_<?=$row1["id_almacen"]?>" value="<?=$row1["id_almacen"]?>"></td>
					  <td><?=$row1["id_almacen"]?></td>
					  <td align="left">&nbsp;<?=$row1["almacen"]?></td>
					</tr>				
					<?php
				}
				?>
				</table>
				<div align="center">
					<input type="button" value="Asociar" onClick="asociar_a_almacen()">
				</div>
				</form>
				<?php
				exit();			
			} elseif ($x=="c"){
				echo "<br>Asociar Clientes.";
				
				
				
				
				
				
				$sql1="SELECT * FROM cat_clientes ORDER BY id_cliente";
				$res1=mysql_query($sql1,$link);
				?>
				<form name="form1" method="post" action="">
				  <table width="500" cellspacing="0" cellpadding="2" align="center">
					<tr>
					  <td colspan="3"><b>CAT&Aacute;LOGO DE CLIENTES</b> </td>
					</tr>
					<tr style="text-align:center; font-weight:bold;">
					  <td width="20">&nbsp;</td>
					  <td width="25">Id</td>
					  <td width="447">Cliente</td>
					</tr>			
				<?php
				while ($row1=mysql_fetch_array($res1)){
					//echo "<br>"; print_r($row1);
					?>
					<tr>
					  <td><input type="checkbox" name="chk_<?=$row1["id_cliente"]?>" value="<?=$row1["id_cliente"]?>"></td>
					  <td><?=$row1["id_cliente"]?></td>
					  <td align="left">&nbsp;<?=$row1["n_comercial"]?></td>
					</tr>				
					<?php
				}
				?>
				</table>
				<div align="center">
					<input type="button" value="Asociar" onClick="asociar_a_cliente()">
				</div>
				</form>
				<?php				
				
				
				
				
				
				
				
				
				
				
				
				
				exit();
			}
		}
	}
	if($a=="asociar_a_almacen"){
		//echo "<br>Asociar a Almacen";
		$idp=$_POST["idp"];
		$ida=$_POST["idsa"];
		$alms=split(",",$ida);
		foreach ($alms as $ida2){
			//echo "<br>$ida2";
			$sql1="SELECT * FROM tipoalmacen WHERE id_almacen=$ida2";
			$res1=mysql_db_query($sql_inv,$sql1);
			$row1=mysql_fetch_array($res1);
			$nca="a_".$ida2."_".$row1["almacen"];
			$sql2="UPDATE catprod SET $nca=1 WHERE id=$idp";
			if (!mysql_db_query($sql_inv,$sql2)){
				echo "<br>Error: No se asocio el producto $idp al Almacen $ida2.";
				exit();
			}
		}
		echo "<br>El producto $idp se asocio a los Almacenes correctamente.";		
		exit;
	}
	if($a=="asociar_a_cliente"){
		//echo "<br>Asociar a Cliente<br>";
		$idp=$_POST["idp"];
		$idc=$_POST["idsc"];
			$sql2="UPDATE catprod SET id_clientes='$idc' WHERE id=$idp";
			if (!mysql_query($sql2,$link)){
				echo "<br>Error: No se asocio el producto $idp al Cliente $idc.";
				exit();
			}
		echo "<br>El producto $idp se asocio a los Clientes correctamente.";		
		exit;
	}	
		
?>