<?php 
header("Content-Type: text/xml; charset=ISO-8859-1");
include("../php/conectarbase.php");
echo "&nbsp;";
//print_r($_POST);
	$action=$_POST["action"];		$mov=$_POST["mov"];				$alm=$_POST["alm"];
	$ndm=$_POST["ndm"];				$con=$_POST["con"];				$ida=$_POST["ida"];
	$itm=$_POST["itm"];				$ial=$_POST["ial"];				$aso=$_POST["aso"];
	$tmo=$_POST["tmo"];	

	$n_alm='a_'.$ial.'_'.$alm;
	$color="#D9FFB3"; ?>
	<style type="text/css">
		.tabla2x{font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid; background-color:#FFFFFF;}
		.titulo{ background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;}
		.campos{ background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;}
	</style>	
<?php
	if ($tmo=='Proveedor')
	{
		//echo "<br><br>a) Realizar <b>$con</b> al Proveeedor: $aso [$ida] y agregar al Almacen : $n_alm";	
		//echo "<br>b) Mostrar los productos  del Almacen: $n_alm asociados al Proveedor: $aso [$ida]<br>";			
		
		$sql0="SELECT * FROM  `prodxprov` WHERE `id_prov`='$ida' order by id_prod ";
		$r0=mysql_db_query($sql_db,$sql0);
		$ndrp=mysql_num_rows($r0);
		?>
				<br /><table width="98%" cellspacing="0" cellpadding="0" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid; background-color:#FFFFFF;">
                  <tr>
                    <td colspan="4" height="23" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;"><?=$ndrp;?>
                    Productos asociados al Proveedor: <?=$aso;?> </td>
                  </tr>
                  <tr class="campos">
                    <td width="18" style="border-right:#333333 1px solid; border-bottom:#333333 1px solid;">Id</td>
                    <td width="150" height="20" style="border-right:#333333 1px solid; border-bottom:#333333 1px solid;">Clave del Producto </td>
                    <td width="439" style="border-right:#333333 1px solid; border-bottom:#333333 1px solid;">Descripci&oacute;n</td>
                    <td width="247" style="border-right:#333333 1px solid; border-bottom:#333333 1px solid;">Especificaci&oacute;n</td>
                  </tr>
				<?php
				while ($ro0=mysql_fetch_array($r0))
				{
					$id_prov=$ro0["id_prov"];
					$id_prod=$ro0["id_prod"];			
					//echo "<br>IPROV =$id_prov, IPROD=$id_prod";

					$sql1="SELECT `id`,`id_prod`, `descripgral`, `especificacion` FROM `catprod` WHERE `id_prod`='$id_prod'  ORDER BY `especificacion`";
					$r1=mysql_db_query($sql_db,$sql1);
					//echo '<br>NDR: '.mysql_num_rows($r1);
					while ($ro1=mysql_fetch_array($r1))
					{
						$id_prod2=$ro1["id_prod"];
						$esp=$ro1["especificacion"];
						$des=$ro1["descripgral"];
						$des2=str_replace("\""," PULGADAS ",$des);
						//echo "<br> $id_prod2    $des       $esp ";
						?>
                	  	<tr bgcolor="<?=$color;?>">
                	  	  <td style="border-right:#333333 1px solid;border-bottom: #999999 1px solid; text-align:center;"><?=$ro1["id"]?></td>
                    		<td style="border-right:#333333 1px solid;border-bottom: #999999 1px solid;">&nbsp;<?=$id_prod2;?></td>
                    		<td style="border-right:#333333 1px solid;border-bottom:#999999 1px solid;">&nbsp;
								<a href="javascript:coloca_datosx('<?=$id_prod2;?>','<?=$des2;?>');"><?=$des;?></a>							</td>
                    		<td style="border-right:#333333 1px solid;border-bottom:#999999 1px solid;">&nbsp;<?=$esp;?></td>
                  		</tr>
				 		<?php
						($color=="#D9FFB3")?$color="#FFFFFF" : $color="#D9FFB3";
					}
				}
				?></table>
				<?php		
	} elseif($tmo=='Almacenes'){
		// VARIABLES DE TRASPASOS ...
		$alm_ori="a_".$ial."_".$alm;		$exi_ori="exist_".$ial;		$tra_ori="trans_".$ial;
		$alm_des="a_".$ida."_".$aso;		$exi_des="exist_".$ida;		$tra_des="trans_".$ida;

		$sql1="SELECT `id`,`id_prod`, `descripgral`, `especificacion`, `cpromedio`,`$exi_ori`, `$tra_ori` FROM `catprod` WHERE `$alm_ori`=1 AND `$alm_des`=1 ORDER BY `id`";
		$r1=mysql_db_query($sql_db,$sql1);
		$ndrp=mysql_num_rows($r1);
							
		//echo "<br><br>a) Realizar la <b>$con</b> del almacen: $alm_ori de los productos asociados al almacen: $alm_des <br><br>";	
		?>
				<br />
				<table width="98%" cellspacing="0" cellpadding="0" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid; background-color:#FFFFFF;">
	              <tr>
                    <td colspan="7" height="23" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;"><?=$ndrp;?> Productos asociados al Almacen: <?=$alm_ori;?> y <?=$alm_des;?></td>
                  </tr>
                  <tr class="campos">
                    <td width="20" style="border-right:#333333 1px solid; border-bottom:#333333 1px solid;">Id</td>
                    <td width="117" height="20" style="border-right:#333333 1px solid; border-bottom:#333333 1px solid;">Clave del Producto </td>
                    <td width="434" style="border-right:#333333 1px solid; border-bottom:#333333 1px solid;">Descripci&oacute;n</td>
                    <td width="256" style="border-right:#333333 1px solid; border-bottom:#333333 1px solid;">Especificaci&oacute;n</td>
                    <td width="67" style="border-right:#333333 1px solid; border-bottom:#333333 1px solid;">Costo</td>
                    <td width="37" style="border-right:#333333 1px solid; border-bottom:#333333 1px solid;">Exist.</td>
                    <td width="45" style="border-right:#333333 1px solid; border-bottom:#333333 1px solid;">Trans.</td>
                  </tr>
				<?php
					while ($ro1=mysql_fetch_array($r1))
					{
						$id_prod2=$ro1["id_prod"];
						$esp=$ro1["especificacion"];
						$des=$ro1["descripgral"];
						$des2=str_replace("\""," PULGADAS ",$des);
					
						$cpr=$ro1["cpromedio"];
						//echo "<br> $id_prod2    $des       $esp ";
						?>
                	  	<tr bgcolor="<?=$color;?>">
                	  	  <td style="border-right:#333333 1px solid;border-bottom:#999999 1px solid; text-align:center;"><?=$ro1["id"]?></td>
                    		<td style="border-right:#333333 1px solid;border-bottom:#999999 1px solid;">&nbsp;<?=$id_prod2;?></td>
                    		<td style="border-right:#333333 1px solid;border-bottom:#999999 1px solid;">&nbsp;
								<a href="javascript:coloca_datos2x('<?=$id_prod2;?>','<?=$des2;?>','<?=$cpr;?>');">
								<?php
									echo $des;
								?></a>							</td>
                    		<td style="border-right:#333333 1px solid;border-bottom:#999999 1px solid;">&nbsp;<?=$esp;?></td>
                	  	    <td style="text-align:right;border-bottom:#999999 1px solid; border-right:#000000 1px solid;"><?=$cpr;?>&nbsp;</td>
                	  	    <td style="text-align:right;border-bottom:#999999 1px solid; border-right:#000000 1px solid;"><?=$ro1["$exi_ori"]?>&nbsp;</td>
               	  	      <td style="text-align:right;border-bottom:#999999 1px solid;"><?=$ro1["$tra_ori"]?>&nbsp;</td>
                  		</tr>
				 		<?php
						($color=="#D9FFB3")?$color="#FFFFFF" : $color="#D9FFB3";
					}
				?></table>
				<?php		



		
		
		
				
	} elseif($tmo=='Ninguno'){ //	INVENTARIO INICIAL, AJUSTE...
		
		$sql1="SELECT `id`,`id_prod`, `descripgral`, `especificacion`, `cpromedio` FROM `catprod` ORDER BY `descripgral`";
		$r1=mysql_db_query($sql_db,$sql1);
		$ndrp=mysql_num_rows($r1);
		?>
				<br /><table width="98%" cellspacing="0" cellpadding="0" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid; background-color:#FFFFFF;">
                  <tr>
                    <td colspan="4" height="23" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;"><?=$ndrp;?> Productos asociados al Almacen: <?=$alm;?> </td>
                  </tr>
                  <tr class="campos">
                    <td width="23" style="border-right:#333333 1px solid; border-bottom:#333333 1px solid;">Id</td>
                    <td width="141" height="20" style="border-right:#333333 1px solid; border-bottom:#333333 1px solid;">Clave del Producto </td>
                    <td width="447" style="border-right:#333333 1px solid; border-bottom:#333333 1px solid;">Descripci&oacute;n</td>
                    <td width="243" style="border-right:#333333 1px solid; border-bottom:#333333 1px solid;">Especificaci&oacute;n</td>
                  </tr>
				<?php
					while ($ro1=mysql_fetch_array($r1))
					{
						$id_prod2=$ro1["id_prod"];
						$esp=$ro1["especificacion"];
						$des=$ro1["descripgral"];
						$des2=str_replace("\""," PULGADAS ",$des);
					
						$cpr=$ro1["cpromedio"];
						//echo "<br> $id_prod2    $des       $esp ";
						?>
                	  	<tr bgcolor="<?=$color;?>">
                	  	  <td style="border-right:#333333 1px solid;border-bottom:#999999 1px solid;"><?=$ro1["id"]?></td>
                    		<td style="border-right:#333333 1px solid;border-bottom:#999999 1px solid;">&nbsp;<?=$id_prod2;?></td>
                    		<td style="border-right:#333333 1px solid;border-bottom:#999999 1px solid;">&nbsp;
								<a href="javascript:coloca_datos2x('<?=$id_prod2;?>','<?=$des2;?>','<?=$cpr;?>');">
								<?php
									echo $des;
								?></a>							</td>
                    		<td style="border-right:#333333 1px solid;border-bottom:#999999 1px solid;"><?=$esp;?></td>
                   		</tr>
				 		<?php
						($color=="#D9FFB3")?$color="#FFFFFF" : $color="#D9FFB3";
					}
				?></table>
				<?php		


	
	
	
	} else {
		echo "<br>Otro...";
	}
	
			
	
	
?>