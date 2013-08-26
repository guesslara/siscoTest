<?php 
	include ("../../conf/conectarbase.php");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	//print_r($_POST);
	//echo "<br>IDA=".$ialm;
	$id_almacen_por_defecto=$ialm;
$actual=$_SERVER['PHP_SELF'];
$color="#D9FFB3";

if ($_GET)
{
	//print_r($_GET);
// ==========================================================================
	(isset($_GET['almacen']))? $ialm=$_GET["almacen"] : $ialm=$id_almacen_por_defecto;
	(isset($_GET['campo']))? $campo=$_GET["campo"] : $campo='descripgral';
	(isset($_GET['cri']))? $cri=$_GET['cri'] : $cri='';
	(isset($_GET['orden']))? $orden=$_GET["orden"] : $orden='id';		
	(isset($_GET['ascdes']))? $ascdes=$_GET["ascdes"] : $ascdes='ASC';
	(isset($_GET['op']))? $op=$_GET["op"] : $op='LIKE';
	
	$sql_alm="SELECT id_almacen,almacen FROM tipoalmacen WHERE id_almacen=".$ialm;
	$result0=mysql_query($sql_alm,$link);
	while ($row0=mysql_fetch_array($result0))
	{ 
		//print_r($row0);
		$id_almacen=$row0["id_almacen"];
		$almacen=$row0["almacen"];
	}	
	$campo_almacen="a_".$ialm."_".$almacen;
	$campo_existencias="exist_".$ialm;	
	$campo_transferencias="trans_".$ialm;
	//$lista_campos=" `id`,`id_prod`,`descripgral`,`especificacion`,`control_alm`,`status1`,`$campo_existencias`,`exist_2`,`exist_3`,`exist_4`,`exist_5`,`exist_6`,`exist_7`,`exist_8`,`exist_9`,`exist_10`,`exist_11`,`exist_12`,`exist_13`,`exist_14`,`$campo_transferencias` ";
	$lista_campos=" `id`,`id_prod`,`descripgral`,`especificacion`,`control_alm`,`status1`,`$campo_existencias`,`exist_2`,`exist_3`,`exist_4`,`exist_5`,`$campo_transferencias` ";
	if ($op=='LIKE'){
		$where=" WHERE $campo LIKE '%" . $cri . "%' AND ".$campo_almacen."=1 "; 
	} else {
		$where=" WHERE $campo $op '" . $cri . "' AND ".$campo_almacen."=1 "; 
	}
	
	// ... Reviso # de resultados con el criterio introducido ............. 
	
	//echo "<br>".
	$sql_criterio="SELECT count(id) as total_registros FROM catprod ".$where;
	$result0=mysql_query($sql_criterio,$link);
	$row0=mysql_fetch_array($result0);
	$numeroRegistros=$row0['total_registros'];
	$tamPag=25; 
    //pagina actual si no esta definida y limites 
    	if(!isset($_GET["pagina"])){ 
       		$pagina=1; 
       		$inicio=1; 
       		$final=$tamPag; 
    	} else { 	
		(isset($_GET["pagina"]))? $pagina = $_GET["pagina"] : $pagina=1; 
	} 
    $limitInf=($pagina-1)*$tamPag; 
    $numPags=ceil($numeroRegistros/$tamPag); 
    
		if(!isset($pagina)) 
    	{ 
       		$pagina=1; 
       		$inicio=1; 
       		$final=$tamPag; 
    	}else{ 
       		$seccionActual=intval(($pagina-1)/$tamPag); 
       		$inicio=($seccionActual*$tamPag)+1; 
			if($pagina<$numPags) 
       			$final=$inicio+$tamPag-1; 
       		else 
          		$final=$numPags; 
       		
			if ($final>$numPags) $final=$numPags; 
	    }	
//echo "$sql_inv&nbsp;";
$sql="SELECT $lista_campos FROM catprod ".$where." ORDER BY ".$orden." ".$ascdes." LIMIT ".$limitInf.",".$tamPag; 
$result=mysql_query($sql,$link);
?>
<div class="buscador">
	<div class="form_buscador" style=" width:500px;float:right; margin-bottom:2px; font-size:12px;">
		<input type="hidden" name="ndr1" id="ndr1" value="<?=$numeroRegistros;?>" />
		<input type="hidden" name="where1" id="where1" value="<?=str_replace("%","iqesisco",$where);?>" />
		
		<input type="hidden" name="txt_almacen" id="txt_almacen" value="<?=$ialm?>" />	
		<input type="hidden" name="txt_campo" id="txt_campo" value="descripgral" />		
		<input type="hidden" name="txt_op" id="txt_op" value="LIKE" />				
		<input type="hidden" name="txt_orden" id="txt_orden" value="<?=$orden;?>" />
		<input type="hidden" name="txt_ascdes" id="txt_ascdes" value="<?=$ascdes;?>" />		
		<input type="text" name="cri" id="txt_buscar" value="<?=$cri;?>" size="30" style="font-size:12px; text-align:center;  margin-top:0px;" />&nbsp;
		<input type="button" value="Buscar" onClick="javascript:buscar();" style=" font-size:12px;" />
	</div>

	<?php if ($numeroRegistros>$tamPag) {?>
	<div class="paginas" style="clear:both; margin-bottom:4px; font-weight:normal;">P&aacute;ginas ( <?=$pagina."/".$numPags;?> )</div>
	<div class="paginador"> 
	<?php 
	if($pagina>1) 
		echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$ialm."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".($pagina-1)."');\"> <<&nbsp;</a> "; 		    	
    for($i=$inicio;$i<=$final;$i++) 
    { 
		if ($i<10) $i2='0'.$i; else $i2=$i;
		if($i==$pagina) 
       		echo "<a href='#'  class='pagact'>".$i2."</a>"; 
       	else 
        	echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$ialm."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".$i."');\"> ".$i2."&nbsp;</a> "; 
	} 
    if($pagina<$numPags) 
       	echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$ialm."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".($pagina+1)."');\"> >>&nbsp;</a> "; 		
	
	($ascdes=='ASC')? $ascdes2='Ascendente' : $ascdes2='Descendente';
	?>	
  	</div>
</div>
	<?php } ?>	
	<br><br><table align="center" style="border:#000000 1px solid; font-size:10px" width="99%" cellspacing="0">
	<!--<tr>
	<td height="20" colspan="20" align="left">| A1.Eq_Nuevo | A2.Eq_Terminado | A3.Eq_Convertido | A4.Eq_por_Revisar | A5.Eq_por_Reparar | A6.Consumible | A7.SCRAP |</td>
	</tr>
	<tr>
	<td height="20" colspan="20" align="left">| A8.Ingenieria | A9.Eq_next_match | A10.Best_buy | A11.Retorno_a_Origen | A12.Resguardo | A13.Cuarentena | A14.Archivo Muerto | </td>	
      </tr>-->
	<tr style="background-color:#333333; color:#FFFFFF; text-align:left; font-weight:bold; text-align:center;">
		<td height="20" colspan="20"><?=$numeroRegistros;?> Productos en el Almac&eacute;n <?=$almacen?> </td>
      </tr>
	<tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
	  <td width="2%">
	  		<a alt="Ordenar por Id" title="Ordenar por Id (<?=$ascdes2?>)" href="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','id','<?=$ascdes?>','<?=$pagina?>');">Id </a>	  </td>
		<td width="6%" height="20">
			<a alt="Ordenar por Id" title="Ordenar por Clave del producto (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','id_prod','<?=$ascdes?>','<?=$pagina?>');">Clave del Producto </a>		</td>
		<td width="16%">
	  <a alt="Ordenar por Descripci&oacute;n" title="Ordenar por Descripci&oacute;n (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','descripgral','<?=$ascdes?>','<?=$pagina?>');">Descripci&oacute;n</a></td>
		<td width="6%">
    <a alt="Ordenar por Especificaci&oacute;n" title="Ordenar por Especificaci&oacute;n (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','especificacion','<?=$ascdes?>','<?=$pagina?>');">Part.</a></td>
		<td width="6%">
		<a alt="Ordenar por Control de Almac&eacute;n" title="Ordenar por Control de Almac&eacute;n (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','control_alm','<?=$ascdes?>','<?=$pagina?>');">
	  Ctrl Alm</a></td>
		<td width="6%">
		<a alt="Ordenar por Status" title="Ordenar por Status (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','status1','<?=$ascdes?>','<?=$pagina?>');">
		Status</a></td>
		<td width="4%">
		<a alt="Ordenar por Control de Existencias" title="Ordenar por Existencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','<?=$campo_existencias?>','<?=$ascdes?>','<?=$pagina?>');">
		A1</a></td>
		<td width="4%">
		<a alt="Ordenar por Control de Existencias" title="Ordenar por Existencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','exist_2','<?=$ascdes?>','<?=$pagina?>');">
		A2</a></td>
		<td width="4%">
		<a alt="Ordenar por Control de Existencias" title="Ordenar por Existencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','exist_3','<?=$ascdes?>','<?=$pagina?>');">
		A3</a></td>
		<td width="4%">
		<a alt="Ordenar por Control de Existencias" title="Ordenar por Existencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','exist_4','<?=$ascdes?>','<?=$pagina?>');">
		A4</a></td>
		<td width="4%">
		<a alt="Ordenar por Control de Existencias" title="Ordenar por Existencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','exist_5','<?=$ascdes?>','<?=$pagina?>');">
		A5</a></td>
		<!--<td width="4%">
		<a alt="Ordenar por Control de Existencias" title="Ordenar por Existencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','exist_6','<?=$ascdes?>','<?=$pagina?>');">
		A6</a></td>
		<td width="4%">
		<a alt="Ordenar por Control de Existencias" title="Ordenar por Existencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','exist_7','<?=$ascdes?>','<?=$pagina?>');">
		A7</a></td>
		<td width="4%">
		<a alt="Ordenar por Control de Existencias" title="Ordenar por Existencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','exist_8','<?=$ascdes?>','<?=$pagina?>');">
		A8</a></td>
		<td width="4%">
		<a alt="Ordenar por Control de Existencias" title="Ordenar por Existencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','exist_9','<?=$ascdes?>','<?=$pagina?>');">
		A9</a></td>
		<td width="4%">
		<a alt="Ordenar por Control de Existencias" title="Ordenar por Existencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','exist_10','<?=$ascdes?>','<?=$pagina?>');">
		A10</a></td>
		<td width="4%">
		<a alt="Ordenar por Control de Existencias" title="Ordenar por Existencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','exist_11','<?=$ascdes?>','<?=$pagina?>');">
		A11</a></td>
		<td width="4%">
		<a alt="Ordenar por Control de Existencias" title="Ordenar por Existencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','exist_12','<?=$ascdes?>','<?=$pagina?>');">
		A12</a></td>
		<td width="4%">
		<a alt="Ordenar por Control de Existencias" title="Ordenar por Existencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','exist_13','<?=$ascdes?>','<?=$pagina?>');">
		A13</a></td>
		<td width="4%">
		<a alt="Ordenar por Control de Existencias" title="Ordenar por Existencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','exist_14','<?=$ascdes?>','<?=$pagina?>');">
		A14</a></td>-->

	  </tr>
<?php 
	while($row=mysql_fetch_array($result)){
?>	
	<tr id="<?=$row["id"]?>" class="m2" bgcolor="<? echo $color; ?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:ver_producto('<?=$row["id"];?>');" style="cursor:pointer;">
	  <td class="td1" height="20" align="center">&nbsp;<?=$row["id"]?></td>
		<td class="td1" align="left">&nbsp;<?=$row["id_prod"]?></td>
		<td class="td1" align="left">&nbsp;<?=$row["descripgral"]?></td>
		<td class="td1" align="left">&nbsp;<?=$row["especificacion"]?></td>
		<td class="td1" align="left">&nbsp;<?=$row["control_alm"]?></td>
		<td class="td1" align="left">
		<?php
			if ($row["status1"]==2)
			{
				echo "Obsoleto";	
			} else if($row["status1"]==1) {
				echo "Lento.Movimiento";
			} else {
				echo "Uso.Constante";
			}
			?></td>
		<td class="td1" align="right"><?=$row[$campo_existencias]?>&nbsp;</td>
		<td class="td1" align="right"><?=$row['exist_2']?>&nbsp;</td>
		<td class="td1" align="right"><?=$row['exist_3']?>&nbsp;</td>
		<td class="td1" align="right"><?=$row['exist_4']?>&nbsp;</td>		
		<td class="td1" align="right"><?=$row['exist_5']?>&nbsp;</td>
		<!--<td class="td1" align="right"><?=$row['exist_6']?>&nbsp;</td>
		<td class="td1" align="right"><?=$row['exist_7']?>&nbsp;</td>
		<td class="td1" align="right"><?=$row['exist_8']?>&nbsp;</td>
		<td class="td1" align="right"><?=$row['exist_9']?>&nbsp;</td>
		<td class="td1" align="right"><?=$row['exist_10']?>&nbsp;</td>
		<td class="td1" align="right"><?=$row['exist_11']?>&nbsp;</td>
		<td class="td1" align="right"><?=$row['exist_12']?>&nbsp;</td>
		<td class="td1" align="right"><?=$row['exist_13']?>&nbsp;</td>
		<td class="td1" align="right"><?=$row['exist_14']?>&nbsp;</td>-->
		
	  </tr>
<?php 
	($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3";
	}
?>	
	</table>
	<br />

	<?php if ($numeroRegistros>$tamPag) {?>
	<div class="paginador"> 
	<?php 
	if($pagina>1) 
		echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$ialm."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".($pagina-1)."');\"> <<&nbsp;</a> "; 		    	
    for($i=$inicio;$i<=$final;$i++) 
    { 
		if ($i<10) $i2='0'.$i; else $i2=$i;
		if($i==$pagina) 
       		echo "<a href='#'  class='pagact'>".$i2."</a>"; 
       	else 
        	echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$ialm."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".$i."');\"> ".$i2."&nbsp;</a> "; 
	} 
    if($pagina<$numPags) 
       	echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$ialm."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".($pagina+1)."');\"> >>&nbsp;</a> "; 		
	?>	
  	</div>
	<div class="paginas" style="clear:both; margin-top:4px; font-weight:normal;">P&aacute;ginas ( <?=$pagina."/".$numPags;?> )</div>
	</div>
	<?php } ?>	



	
	<?php
	exit();
}
?>
