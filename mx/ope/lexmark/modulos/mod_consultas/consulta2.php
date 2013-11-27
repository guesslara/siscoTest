<?php 	
	//include ("../conf/conexion.php");
	include ("../../conf/conectarbase.php");
	include('../../../../../clases/clase_fecha.php');
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	//print_r($_POST);

$actual=$_SERVER['PHP_SELF'];
$color="#FFFFFF";
$mmodulos=array("REC"=>"RECIBO","REP"=>"REPARACION","CC"=>"CALIDAD","DES"=>"DESPACHO","ENV"=>"ENVIADOS",""=>"TODOS",);
//foreach($mmodulos as $c=>$v){	echo "<br>$c -> $v";	}			
if ($_GET)
{
	//echo "<hr>";	print_r($_GET);
	(isset($_GET['modulo']))? $modulo=$_GET["modulo"] : $modulo="";
	(isset($_GET['campo']))? $campo=$_GET["campo"] : $campo='ot.ot';
	(isset($_GET['cri']))? $cri=$_GET['cri'] : $cri='';
	(isset($_GET['orden']))? $orden=$_GET["orden"] : $orden='ot.id';		
	(isset($_GET['ascdes']))? $ascdes=$_GET["ascdes"] : $ascdes='ASC';
	(isset($_GET['op']))? $op=$_GET["op"] : $op='LIKE';	
	// =======================================================================================================
	//echo "<hr>";	print_r($mmodulos);
	//echo "<hr>Modulo Recibido=[$modulo]";
	//echo "<br>Modulo seleccionado=".
	$modulo_seleccionado=$mmodulos[$modulo];
	$status_cliente_seleccionado=$status_clienteM[$modulo];
	if ($modulo=="")
		$modulo_sql=" ";
	else 
		$modulo_sql=" AND status_cliente='".$modulo."'";
	// DEFINIR OPERADOR Y CRITERIO ...
	($op=="LIKE")? $sql_criterio=" LIKE '%$cri%'" : $sql_criterio=$op."'".$cri."'";

	//echo "<br>BD [$sql_ing]".
	$s_sql0="SELECT ot.* FROM ot WHERE $campo$sql_criterio $modulo_sql ORDER BY $orden";
	//echo "<hr>";
	
	if ($resultado0=mysql_query($s_sql0,$link)){
		$ndr0=mysql_num_rows($resultado0);
		while($registro0=mysql_fetch_array($resultado0)){
			//echo "<br><br>";	print_r($registro0);
		}
	} else {	echo "<br>&nbsp;Error SQL[0]."; exit;	}
	// =======================================================================================================
	// PAGINACION >>
		$tamPag=25; 
    	//pagina actual si no esta definida y limites 
    	if(!isset($_GET["pagina"])) 
    	{ 
       		$pagina=1; 
       		$inicio=1; 
       		$final=$tamPag; 
    	} else { 	
			(isset($_GET["pagina"]))? $pagina = $_GET["pagina"] : $pagina=1; 
		} 
    	$limitInf=($pagina-1)*$tamPag; 
    	$numPags=ceil($ndr0/$tamPag); 
    
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
	// << PAGINACION 
	// =======================================================================================================
	// SQL CON LIMITES >>
	//echo "<br><br>".
	$s_sql1="SELECT ot.* FROM ot WHERE $campo$sql_criterio $modulo_sql ORDER BY $orden $ascdes LIMIT $limitInf,$tamPag ";
	if ($resultado1=mysql_query($s_sql1,$link)){
		$ndr1=mysql_num_rows($resultado1);
	} else {	echo "<br>&nbsp;Error SQL[1]."; exit;	}	
	?>
	
	
	<?php if ($ndr0>$tamPag) {?>
		<div class="buscador">
			<div class="paginas" style="clear:both; margin-bottom:5px; font-weight:normal;">P&aacute;ginas ( <?=$pagina."/".$numPags;?> )</div>
			<div class="paginador"> 
			<?php 
				if($pagina>1) 
					echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$modulo."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".($pagina-1)."');\"> <<&nbsp;</a> "; 		    	
    			for($i=$inicio;$i<=$final;$i++) 
    			{ 
					if ($i<10) $i2='0'.$i; else $i2=$i;
					if($i==$pagina) 
       					echo "<a href='#'  class='pagact'>".$i2."</a>"; 
       				else 
        				echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$modulo."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".$i."');\"> ".$i2."&nbsp;</a> "; 
				} 
   				if($pagina<$numPags) 
       				echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$modulo."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".($pagina+1)."');\"> >>&nbsp;</a> "; 		
	
				($ascdes=='ASC')? $ascdes2='Ascendente' : $ascdes2='Descendente';
			?>	
  			</div>
		</div>
	<?php } ?>
	
	<BR /><table cellspacing="0" align="center" class="tabla1" width="1000">
	<tr class="titulo_tabla1">
		<td colspan="7" height="23" align="center"><?=$ndr0?> EQUIPOS EN <?php if($modulo_seleccionado=="TODOS") echo "INGENIERIA"; else echo $modulo_seleccionado; ?> </td>
	</tr>
	<tr>
		<!--<td width="17" height="23" class="campos_tabla1"><a href="javascript:paginar('<?=$modulo?>','<?=$campo?>','<?=$op?>','<?=$cri?>','<?='ot.id'?>','<?=$ascdes?>','<?=$pagina?>');" title="Ordenar por ID">ID</a></td>-->
		<td width="258" class="campos_tabla1"><a href="javascript:paginar('<?=$modulo?>','<?=$campo?>','<?=$op?>','<?=$cri?>','<?='ot.ot'?>','<?=$ascdes?>','<?=$pagina?>');" title="Ordenar por ORDEN DE TRABAJO">ORDEN DE TRABAJO</a> </td>
		<td width="258" class="campos_tabla1"><a href="javascript:paginar('<?=$modulo?>','<?=$campo?>','<?=$op?>','<?=$cri?>','<?='ot.f_recibo'?>','<?=$ascdes?>','<?=$pagina?>');" title="Ordenar por FECHA RECIBO">FECHA RECIBO</a></td>
		<td width="258" class="campos_tabla1"><a href="javascript:paginar('<?=$modulo?>','<?=$campo?>','<?=$op?>','<?=$cri?>','<?='ot.idp'?>','<?=$ascdes?>','<?=$pagina?>');" title="Ordenar por TIPO DE PRODUCTO (id)">TIPO DE PRODUCTO</a> </td>
		<td width="159" class="campos_tabla1"><a href="javascript:paginar('<?=$modulo?>','<?=$campo?>','<?=$op?>','<?=$cri?>','<?='ot.nserie'?>','<?=$ascdes?>','<?=$pagina?>');" title="Ordenar por NO. SERIE">NO. SERIE</a>  </td>
		<td width="69" class="campos_tabla1"><a href="javascript:paginar('<?=$modulo?>','<?=$campo?>','<?=$op?>','<?=$cri?>','<?='ot.status_cliente'?>','<?=$ascdes?>','<?=$pagina?>');" title="Ordenar por MODULO">M&Oacute;DULO</a></td>
		<td width="58" class="campos_tabla1"><a href="javascript:paginar('<?=$modulo?>','<?=$campo?>','<?=$op?>','<?=$cri?>','<?='ot.status_proceso'?>','<?=$ascdes?>','<?=$pagina?>');" title="Ordenar por STATUS">STATUS</a></td>
	</tr>					
	<?php
	while($registro1=mysql_fetch_array($resultado1)){
		//echo "<br><br>";	print_r($registro1);
		//echo "<br>BD ($sql_inv)".
		$sql2="SELECT descripgral,especificacion FROM catprod WHERE id='".$registro1["idp"]."'";
		if ($resultado2=mysql_query($sql2,$link)){
			$ndr2=mysql_num_rows($resultado2);
			while($registro2=mysql_fetch_array($resultado2)){
				//echo "<br><br>";	print_r($registro2);
				$desc_prod2=$registro2["descripgral"];
				$especific2=$registro2["especificacion"];
			}
		} else {	echo "<br>&nbsp;Error SQL[2]."; exit;	}		
		?>
		<tr>
			<td height="23" align="center" onmouseover='this.style.background="#819FF7"' onmouseout='this.style.background="white"'>&nbsp;<?=$registro1["id"]?></td>
			<!--<td class="tda_tabla1">&nbsp;<?=$registro1["ot"]?></td>-->
			<td onmouseover='this.style.background="#819FF7"' onmouseout='this.style.background="white"'>&nbsp;
			<?php 
				$fecha=new fecha($registro1['f_recibo']);
				echo $fecha->dame_fecha();
			?></td>
			
			<td class="tda_tabla1" bgcolor="<?=$color?>" onclick="ver_equipo('<?=$registro1["id"]?>');" onmouseover='this.style.background="#819FF7"' onmouseout='this.style.background="white"'><a href="#" title="<?=$registro1["idp"].".".$desc_prod2." (".$especific2.")"?>">&nbsp;<?=substr($registro1["idp"].".".$desc_prod2,0,25)?></a></td>
			
			<td onmouseover='this.style.background="#819FF7"' onmouseout='this.style.background="white"'>&nbsp;<?=$registro1["nserie"]?></td>	
			<td class="tda_tabla1" onmouseover='this.style.background="#819FF7"' onmouseout='this.style.background="white"'>&nbsp;<?php
            	$st_cliente=$registro1["status_cliente"];
				echo $mmodulos["$st_cliente"];
			?></td>
			<td onmouseover='this.style.background="#819FF7"' onmouseout='this.style.background="white"'>&nbsp;<?=$registro1["status_proceso"]?></td>
	</tr>	
	<?php ($color=="#FFFFFF")? $color="#EFEFEF" : $color="#FFFFFF"; } ?>
	</table>
	<input type="hidden" id="sql_xlsx" value="<?=$sql_xls?>" size="200" /><BR />
	
	<?php $sql_xls=str_replace("%","iqemex",$s_sql0); ?>
	<?php if ($ndr0>$tamPag) {?>
		<div class="buscador">
			<div class="paginador"> 
			<?php 
				if($pagina>1) 
					echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$modulo."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".($pagina-1)."');\"> <<&nbsp;</a> "; 		    	
    			for($i=$inicio;$i<=$final;$i++) 
    			{ 
					if ($i<10) $i2='0'.$i; else $i2=$i;
					if($i==$pagina) 
       					echo "<a href='#'  class='pagact'>".$i2."</a>"; 
       				else 
        				echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$modulo."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".$i."');\"> ".$i2."&nbsp;</a> "; 
				} 
   				if($pagina<$numPags) 
       				echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$modulo."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".($pagina+1)."');\"> >>&nbsp;</a> "; 		
	
				($ascdes=='ASC')? $ascdes2='Ascendente' : $ascdes2='Descendente';
			?>	
  			</div>
			<div class="paginas" style="clear:both; margin-top:4px; font-weight:normal;">P&aacute;ginas ( <?=$pagina."/".$numPags;?> )</div>		
		</div>
	<?php } ?>
	<!--
	<BR /><div align="center"><a href="../admin/xls.php?sql=<?$sql_xls?>" onmouseover="window.status='';return true;">Exportar a Excel</a></div>
	//-->
<?php
}


if ($_POST["action"]=="ver_equipo"){
	$id=$_POST["id"];
	$sql1="SELECT * FROM ot WHERE id='$id'";	
	if ($result1=mysql_query($sql1,$link)){
		if ($ndr1=mysql_num_rows($result1)>0){
			while($registro1=mysql_fetch_array($result1)){
				?><pre><?php
                                //echo "<br>"; print_r($registro1);
                                 ?></pre><?php
				$idp=$registro1["idp"];		$nds=$registro1["nserie"];		$fdr=$registro1["f_recibo"];		$dig=$registro1["cod_diag"];
				$ure=$registro1["u_recibe"];		$urp=$registro1["repara"];		$fio=$registro1["fecha_inicio"];		$ffr=$registro1["fecha_fin_rep"];
				$ffn=$registro1["fecha_fin"];		$stp=$registro1["status_proceso"];		$stc=$registro1["status_cliente"];		$obr=$registro1["obs_rep"];
				$obs=$registro1["obs"];				$gar=$registro1["garantia"];
				
				$fen=$registro1["shipdate"];		$ade=$registro1["id_almacen_destino"];		
				
				
			
				$sql2="SELECT descripgral,especificacion FROM catprod WHERE id='".$registro1["idp"]."'";
				if ($resultado2=mysql_query($sql2,$link)){
					$ndr2=mysql_num_rows($resultado2);
					while($registro2=mysql_fetch_array($resultado2)){
						//echo "<br><br>";	print_r($registro2);
						$desc_prod2=$registro2["descripgral"];
						$especific2=$registro2["especificacion"];
					}
				} else {	echo "<br>&nbsp;Error SQL[2]."; exit;	}			
			
			}	
		} else {
			echo "<div align=center>&nbsp;Error. No se encontro la OT ($id).</div>";
			exit();
		}
	} else {
		echo "<div align=center>&nbsp;Error SQL. La consulta no se ejecuto.</div>";
	}	
	?>
<!------------------------------------------VENTANA EMERGENTE------------------------------------------>

    <table width="100%" align="left" cellpadding="0" id="t0" cellspacing="0" style="font-size:18px;" >
	  <tr>
		<td width="33%" height="20" class="campos_verticales_n">OT</td>
		<td width="67%" class="campos_verticales_d">&nbsp;<b><?= "#".$id; ?></b></td>
	  </tr>
	  <tr>
		<td height="20" class="campos_verticales_n">ID DEL PRODUCTO </td>
		<td class="campos_verticales_d">&nbsp;<u><?=$idp?></u></td>
	  </tr>
	  <tr>
		<td height="20" class="campos_verticales_n">DESCRIPCION</td>
		<td class="campos_verticales_d">&nbsp;<u><?="$desc_prod2"?></u></td>
	  </tr>
	  <tr>
		<td height="20" class="campos_verticales_n">ESPECIFICACION</td>
		<td class="campos_verticales_d">&nbsp;<u><?=$especific2?></u></td>
	  </tr>
	  <tr>
		<td height="20" class="campos_verticales_n">NO. SERIE </td>
		<td class="campos_verticales_d">&nbsp;<?=$nds?></td>
	  </tr>
	  
	  <tr>
		<td height="20" class="campos_verticales_n">FECHA RECIBO </td>
		<td class="campos_verticales_d">
		&nbsp;<?php 
			$fecha=new fecha($fdr);
			echo $fecha->dame_fecha();
		?>	</td>
	  </tr>
	  
	  <tr>
		<td height="20" class="campos_verticales_n">DIAGN&Oacute;STICO</td>
		<td class="campos_verticales_d">&nbsp;<?php
			 echo $id_diag=$dig;
			 $sql_diagnostico="SELECT diagnostico FROM cat_diagnosticos WHERE id=$id_diag ";
			 $resultado_diagnostico=mysql_query($sql_diagnostico,$link);
				$registro_diagnostico=mysql_fetch_array($resultado_diagnostico);
				echo strtoupper(". ".$registro_diagnostico["diagnostico"]); 			
		?></td>
	  </tr>
	  
	  <tr>
		<td height="20" class="campos_verticales_n">RECIBE</td>
		<td class="campos_verticales_d">&nbsp;<?php 
			echo $id_recibe=$ure;
			if (!$id_recibe==""){
				$sql_usuario1="SELECT dp_nombre,dp_apaterno,dp_amaterno FROM usuarios WHERE id_usuario=$id_recibe ";
				$resultado_usuario1=mysql_query($sql_usuario1,$link);
					$registro_usuario1=mysql_fetch_array($resultado_usuario1);
					echo strtoupper(". ".$registro_usuario1["dp_nombre"]." ".$registro_usuario1["dp_apaterno"]." ".$registro_usuario1["dp_amaterno"]);        
			}
		?></td>
	  </tr>
	  <tr>
		<td height="20" class="campos_verticales_n">REPARA</td>
		
		<td class="campos_verticales_d">&nbsp;<?php
			 //$id_repara=$registro1["repara"];
			 $id_repara=$urp;
			 if($id_repara==""){
				?><span style="color:#FF0000;">AUN NO SE HA ASIGNADO UN TECNICO.</span><?php
			 }else{			
				$sql_usuario2="SELECT dp_nombre,dp_apaterno,dp_amaterno FROM usuarios WHERE id_usuario=$id_repara ";
				$resultado_usuario2=mysql_query($sql_usuario2,$link);
					$registro_usuario2=mysql_fetch_array($resultado_usuario2);
					echo strtoupper("$id_repara. ".$registro_usuario2["dp_nombre"]." ".$registro_usuario2["dp_apaterno"]." ".$registro_usuario2["dp_amaterno"]);        
			 }
		?></td>
	  </tr>
	  <tr>
		<td height="20" class="campos_verticales_n">FECHA INICIO </td>
		<td class="campos_verticales_d">&nbsp;<?php 
			$fecha2=new fecha(substr($fio,0,10));
			echo $fecha2->dame_fecha();
		?>	</td>
	  </tr>
	  <tr>
		<td height="20" class="campos_verticales_n">FECHA FIN REPARACION </td>
		<td class="campos_verticales_d">&nbsp;<?php 
			echo $fechafin=$ffr;

				
		?>	</td>
	  </tr>
	  <tr>
		<td height="20" class="campos_verticales_n">FECHA FIN </td>
		<td class="campos_verticales_d">&nbsp;<?php 
			//echo $ffn;
			if ($ffn=="0000-00-00 00:00:00"){
				?><span style="color:#FF0000;">EN PROCESO.</span><?php
			} else {		
				$fecha4=new fecha($ffn);
				echo $fecha4->dame_fecha();
			}	
		?>	</td>
	  </tr>
	  <tr>
		<td height="20" class="campos_verticales_n">M&Oacute;DULO</td>
		<td class="campos_verticales_d">&nbsp;<?php
			if (!($stc=="")){
				echo $mmodulos[$stc];
			} else
				echo "&nbsp;";
		
		?></td>
	  </tr>
	  <tr>
		<td height="20" class="campos_verticales_n">STATUS PROCESO </td>
		<td class="campos_verticales_d">&nbsp;<?php
			echo $stp;
			if ($stp=="DIAG") echo " (DIAGNOSTICO).";
		?></td>
	  </tr>
	  <?php if ($gar==1) { ?>
	  <tr>
		<td height="20" class="campos_verticales_n">GARANT&Iacute;A (REINGRESO) </td>
		<td class="campos_verticales_d">&nbsp;<?php if ($gar==1){ ?>
			 <div style="color:#FF0000;">LA OT RESIDE COMO GARANTIA.</div>
		<?php } ?></td>
	  </tr>
	  <?php } 
		if (!($ade==0||$ade=="")) {
			?>
			<tr>
			<td height="20" class="campos_verticales_n">FECHA ENVIO A ALMAC&Eacute;N </td>
			<td class="campos_verticales_d">&nbsp;<?php 
				//echo $fen;
				$fecha_envio=new fecha($fen);
				echo $fecha_envio->dame_fecha();
			?>	
			</td>
			</tr>
			<tr>
			<td height="20" class="campos_verticales_n">ALMAC&Eacute;N DESTINO </td>
			<td class="campos_verticales_d">&nbsp;<?php 
				//echo "<br>BD[$sql_inv] ".
				$sql_3="SELECT id_almacen,almacen FROM `tipoalmacen` WHERE id_almacen=".$ade;
				if ($resultado3=mysql_query($sql_3,$link)){
					$ndr3=mysql_num_rows($resultado3);
					while($registro3=mysql_fetch_array($resultado3)){
						//echo "<br><br>";	print_r($registro3);
						echo strtoupper($registro3["id_almacen"].". ".$registro3["almacen"]);
					}
				} else {	echo "<br>&nbsp;Error SQL[3]."; exit;	}				
			?>
			</td>
			</tr><?php 
		} ?>
	  <tr>
		<td height="20" class="campos_verticales_n">OBS REPARACION </td>
		<td class="campos_verticales_d">&nbsp;<?=$obr?></td>
	  </tr>
	  <tr>
		<td height="20" class="campos_verticales_n">OBSERVACIONES&nbsp;</td>
		<td class="campos_verticales_d">&nbsp;<?=$obs?></td>
	  </tr>
	</table>
	<?php
}

?>