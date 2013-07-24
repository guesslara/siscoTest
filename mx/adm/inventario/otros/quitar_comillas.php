<?php 
	include("../../conf/conectarbase.php"); 
	$lista_campos=" `id`,`id_prod`,`descripgral`,`especificacion`,`control_alm`";	
	echo $sql="SELECT $lista_campos FROM catprod WHERE descripgral LIKE '%\"%' OR especificacion LIKE '%\"%' ORDER BY id "; 
	$result=mysql_db_query($sql_inv,$sql);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
Sustituir comillas en cat&aacute;logos.

	<br><table align="center" style="border:#000000 1px solid; font-size:12px" width="100%" cellspacing="0">

	<tr style="background-color:#333333; color:#FFFFFF; text-align:left; font-weight:bold; text-align:center;">
		<td height="20" colspan="4"><?=$numeroRegistros;?>
         Productos con comillas	      <?=$almacen?> </td>
      </tr>
	<tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
	  <td width="3%" height="20">
	  		<a alt="Ordenar por Id" title="Ordenar por Id (<?=$ascdes2?>)" href="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','id','<?=$ascdes?>','<?=$pagina?>');">Id </a>	  </td>
		<td width="42%">
		<a alt="Ordenar por Descripci&oacute;n" title="Ordenar por Descripci&oacute;n (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','descripgral','<?=$ascdes?>','<?=$pagina?>');">Descripci&oacute;n</a></td>
		<td width="14%">
		<a alt="Ordenar por Especificaci&oacute;n" title="Ordenar por Especificaci&oacute;n (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','especificacion','<?=$ascdes?>','<?=$pagina?>');">Especificaci&oacute;n</a></td>
		<td width="41%">
		<a alt="Ordenar por Control de Almac&eacute;n" title="Ordenar por Control de Almac&eacute;n (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','control_alm','<?=$ascdes?>','<?=$pagina?>');">
		SQL</a></td>
	  </tr>
<?php 
	while($row=mysql_fetch_array($result)){
?>	
	<tr id="<?=$idpX=$row["id"]?>" class="m2" bgcolor="<? echo $color; ?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'">
	  <td class="td1" height="20" align="center">&nbsp;<?=$row["id"]?></td>
		<td class="td1" align="left">&nbsp;<?=$row["descripgral"]?></td>
		<td class="td1" align="left">&nbsp;<?=$row["especificacion"]?></td>
		<td class="td1" align="left">&nbsp;
			<?php
			$descX=str_replace('"',' PULGADAS',$row["descripgral"]);
			echo $sql_act="UPDATE catprod SET descripgral='$descX' WHERE id=$idpX ";
			if (mysql_db_query($sql_inv,$sql_act)){
				echo "El producto $idpX se modifico correctamente.";
			} else {
				echo "Error: El producto $idpX No se modifico.";
			}
			?></td>
	  </tr>
<?php 
	($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3";
	}
?>	
	</table>
	<br />



</body>
</html>
