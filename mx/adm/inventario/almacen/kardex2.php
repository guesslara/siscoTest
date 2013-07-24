<?php include ("../../conf/conectarbase.php");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("pagma: no-cache");
header("Content-Type: text/xml; charset=ISO-8859-1");
$lista_campos=" `id`,`id_prod`,`descripgral`,`especificacion`,`linea`,`marca`,`control_alm`,`ubicacion`,`uni_entrada`,`uni_salida`,`stock_min`,`stock_max`,`observa`,`unidad`,`tipo`,`kit`,`cpromedio`,`$calm0`,`$cexi0`,`$ctra0` ";
?>

<link href="../css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
	.gris{ background-color:#CCCCCC; font-weight:bold; text-align:right; padding-right:2px;}
	.valor1{ background-color:#ffffff; font-weight:normal; font-size:16px; text-align:left; padding-left:2px;
	border-bottom:#CCCCCC 1px solid; }
 .td1{ padding:1px; font-size:12px; /*border-top:#333333 1px solid;*/ border-right:#cccccc 1px solid;}
 .td2{ padding:1px; font-size:12px; /*border-top:#333333 1px solid;*/ } 
</style>
<?php 
//print_r($_GET);
$id=$_GET['id'];
$desc=$_GET['desc'];
$esp=$_GET['esp'];
	//echo "<br>".
	$sql_cpy="SELECT $lista_campos FROM catprod WHERE `id`='$id' ";
	$r_cpy=mysql_db_query($sql_inv,$sql_cpy);
	//echo "<br>NDR: ".mysql_num_rows($r_cpy);
		while($r1_cpy=mysql_fetch_array($r_cpy))
		{
			$id=$r1_cpy["id"];
			$de=$r1_cpy["descripgral"];
	  		$id_prod2=$r1_cpy['id_prod'];
		}

$sql_cardex="SELECT mov_almacen.id_mov, concepmov.id_concep, concepmov.concepto,concepmov.tipo,mov_almacen.asociado, mov_almacen.almacen, mov_almacen.fecha, prodxmov.cantidad, prodxmov.cu, catprod.id_prod, catprod.descripgral
FROM (mov_almacen INNER JOIN concepmov ON mov_almacen.tipo_mov = concepmov.id_concep) INNER JOIN (catprod INNER JOIN prodxmov ON catprod.id_prod = prodxmov.clave) ON mov_almacen.id_mov = prodxmov.nummov
WHERE (((catprod.id)='$id')) order by id_mov;";

$result2=mysql_db_query($sql_inv,$sql_cardex);
$ndrX=mysql_num_rows($result2);
if ($ndrX<=0){	?>
	<div style="font-size:18px; text-align:center; color:#FF0000; margin-top:20px;">El producto no presenta Movimientos.</div>
	<?php
	exit();
}
//echo '<br># Reg: ('.$ndrX.')<br>';

?>
<br />
<table width="95%" align="center" style="font-size:12px; border:#333333 2px solid;" cellpadding="0" cellspacing="0">
  <tr style="background-color:#333333; text-align:center; font-weight:bold; padding:2px; color:#FFFFFF;">
    <td colspan="7" height="20" valign="middle"><?=mysql_num_rows($result2);?> Movimiento(s) del Producto: <?=$id_prod2;?></td>
  </tr>
  <tr style="background-color:#cccccc; text-align:center; font-weight:bold; padding:2px; color:#000000;">
    <td width="24" height="auto">#  </td>
    <td width="193">MOVIMIENTO</td>
    <td width="316">ALMACEN</td>
    <td width="316">ASOCIADO</td>
    <td width="108">FECHA</td>
    <td width="75"><p>CANTIDAD<BR>
    </td>
    <td width="59">COSTO </td>
  </tr>
  <?php 
	  $color="#FFFFFF";
	  while ($row2=mysql_fetch_array($result2)) 
	  {
	  //print_r($row2); 		echo "<hr>";
	  
	  $id_concep=$row2['id_concep'];
	  $concep=$row2['concepto'];
	  $asociado=$row2['asociado'];
	  $aso2="";
	  if ($id_concep==1||$id_concep==3) // Compras o Dev / compras... Cat de proveedores ...
	  {
		$sql3="SELECT r_social FROM cat_clientes WHERE id_cliente='$asociado' ";
		$result3=mysql_db_query($sql_inv,$sql3);
		$row3=mysql_fetch_array($result3);
		$aso2="Cliente ".$asociado." ".$row3["r_social"];		  	
	  }
	  if ($id_concep==2) // Almacenes ...
	  {
			$sql_aso2="SELECT almacen FROM `tipoalmacen` WHERE `id_almacen`='$asociado'";
			$result_aso2=mysql_db_query($sql_inv,$sql_aso2);	
			while($row_aso2=mysql_fetch_array($result_aso2)){	
				$aso2="Almacen ".$asociado." ".$row_aso2["almacen"];
			}	  	
	  }
	  
	  //echo "<br>ID CONC ($id_concep - $concep) ASOCIADO ($asociado - $aso2)";
	  ?>
  <tr style="background-color:<?=$color;?>;">
    <td height="20" align="center" class="td1">
        <?=$row2["id_mov"];?></td>
    <td class="td1" align="left">&nbsp;
        <?=$row2["concepto"];?></td>
    <td align="left" class="td1"><?=$row2["almacen"];?></td>
    <td align="left" class="td1">&nbsp;<?=$aso2;?></td>
    <td align="right" class="td1"><?=$row2["fecha"];?>
      &nbsp;</td>
    <td align="right" class="td1" >
	<?php 
		if ($row2["tipo"]=="Ent")
		{
			echo "+".$row2["cantidad"];
			$total_entrada+=$row2["cantidad"];
		} elseif ($row2["tipo"]=="Sal") {
			echo "-".$row2["cantidad"];
			$total_salida+=$row2["cantidad"];
		} elseif ($row2["tipo"]=="Sal_Ent") { 
			echo "-+".$row2["cantidad"];
		}	
	?>&nbsp;	</td>
    <td align="right" class="td1i">
      $<?=$row2["cu"];?>&nbsp;</td>
  </tr>
  <?php 
	  ($color=="#D9FFB3")? $color="#FFFFFF": $color="#D9FFB3";
	  } ?>
  <tr style="background-color: #333333; color:#FFFFFF; font-weight:bold;">
    <td height="20">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="right" class="td1">TOTAL&nbsp;&nbsp;</td>
    <td align="right" class="td1" ><?=$total_entrada-$total_salida;?>&nbsp;</td>
    <td align="right" class="td1i">&nbsp;</td>
  </tr>	  
</table>
