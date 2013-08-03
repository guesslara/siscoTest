<?php 
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,2,3,11);
	
include("../../conf/conectarbase.php");
$actual=$_SERVER['PHP_SELF'];
$lista_campos=" `id`,`id_prod`,`descripgral`,`especificacion`,`linea`,`marca`,`control_alm`,`ubicacion`,`uni_entrada`,`uni_salida`,`stock_min`,`stock_max`,`observa`,`unidad`,`tipo`,`kit`,`cpromedio`,`$calm0`,`$cexi0`,`$ctra0` ";

if (isset($_GET['accion']))
{
	$id_prod=$_GET['id_prod'];
	$accion=$_GET['accion'];
} else {	
 
	if (isset($_GET['orden'])) 
		$orden=$_GET["orden"];
	else 
		$orden='id_prod';
	if (isset($_GET['cri']))
	{
		$cri=$_GET['cri'];
		$orden=$_GET['orden'];
	} else { $cri=''; }
	
	// ... Reviso # de resultados con el criterio introducido ............. 
	$sql_criterio="SELECT count(id) as total_registros FROM catprod where descripgral like '%" . $cri . "%' ";
	$result0=mysql_db_query($sql_inv,$sql_criterio);
	$row0=mysql_fetch_array($result0);
	$numeroRegistros=$row0['total_registros'];

	$tamPag=30; 
    //pagina actual si no esta definida y limites 
    	if(!isset($_GET["pagina"])) 
    	{ 
       		$pagina=1; 
       		$inicio=1; 
       		$final=$tamPag; 
    	} else { 	
			if (is_numeric($_GET["pagina"]))
				{ $pagina = $_GET["pagina"];  } else { $pagina=1; }
		} 
	
    //calculo del limite inferior 
    $limitInf=($pagina-1)*$tamPag; 
    //calculo del numero de paginas 
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
       		
			if ($final>$numPags)
				$final=$numPags; 
	    } 
} // no recibo accion ...
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<link href="../../css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
	.gris{ background-color:#CCCCCC; font-weight:bold; text-align:right; padding-right:2px;}
	.valor1{ background-color:#ffffff; font-weight:normal; font-size:16px; text-align:left; padding-left:2px;
	border-bottom:#CCCCCC 1px solid; }
 .td1{ padding:1px; font-size:12px; /*border-top:#333333 1px solid;*/ border-right:#cccccc 1px solid;}
 .td2{ padding:1px; font-size:12px; /*border-top:#333333 1px solid;*/ } 
</style>
</head>
<body>
<?php include("../menu/menu.php"); ?>
<p>
<center>

<?php if (isset($_GET['accion'])) { 
//print_r($_GET);
$id_prod=$_GET['id'];
$desc=$_GET['desc'];
$esp=$_GET['esp'];
	$sql_cpy="SELECT cpromedio FROM catprod WHERE `id_prod`='$id_prod' ";
	$r_cpy=mysql_db_query($sql_inv,$sql_cpy);
	//echo "<br>NDR: ".mysql_num_rows($r_cpy);
	if($r_cpy)
	{
		while($r1_cpy=mysql_fetch_array($r_cpy))
		{
			$cpy=$r1_cpy["cpromedio"];
		}
	} else {
		echo "<br>Error SQL [$sql_cpy]<br>";
	}
?>
    <table width="400" align="center" cellspacing="0" style="border:#000000 2px solid;">
      <tr >
        <td width="157" class="gris">Id Producto </td>
        <td width="235" class="valor1">&nbsp;<?=$id_prod;?></td>
      </tr>
      <tr>
        <td class="gris">Descripci&oacute;n</td>
        <td class="valor1" >&nbsp;<?=$desc;?></td>
      </tr>
      <tr>
        <td class="gris">Especificaci&oacute;n</td>
        <td class="valor1">&nbsp;<?=$esp;?></td>
      </tr>
      <tr>
        <td class="gris">Costo Promedio </td>
        <td class="valor1">&nbsp;$ <?=$cpy;?></td>
      </tr>
    </table>
<br />

<?php 
echo $sql_cardex="SELECT mov_almacen.id_mov, concepmov.id_concep, concepmov.concepto,mov_almacen.asociado, mov_almacen.fecha, prodxmov.cantidad, prodxmov.cu, catprod.id_prod, catprod.descripgral
FROM (mov_almacen INNER JOIN concepmov ON mov_almacen.tipo_mov = concepmov.id_concep) INNER JOIN (catprod INNER JOIN prodxmov ON catprod.id_prod = prodxmov.clave) ON mov_almacen.id_mov = prodxmov.nummov
WHERE (((catprod.id_prod)='$id_prod')) order by fecha;";

$result2=mysql_db_query($sql_inv,$sql_cardex);
//echo '<br># Reg: ('.mysql_num_rows($result2).')<br>';

?>
<table width="949" align="center" style="font-size:12px; border:#333333 2px solid;" cellpadding="0" cellspacing="0">
  <tr style="background-color:#333333; text-align:center; font-weight:bold; padding:2px; color:#FFFFFF;">
    <td colspan="6" height="20" valign="middle">Kardex :: Resultados [
      <?=mysql_num_rows($result2);?>
      ]</td>
  </tr>
  <tr style="background-color:#cccccc; text-align:center; font-weight:bold; padding:2px; color:#000000;">
    <td width="154" height="20"># Mov </td>
    <td width="158">Movimiento</td>
    <td width="388">Asociado</td>
    <td width="99">Fecha</td>
    <td width="69">Cantidad</td>
    <td width="77">Costo Unitario </td>
  </tr>
  <?php 
	  $color="#FFFFFF";
	  while ($row2=mysql_fetch_array($result2)) 
	  {
	  //print_r($row2); 
	  $id_concep=$row2['id_concep'];
	  $concep=$row2['concepto'];
	  $asociado=$row2['asociado'];
	  if ($id_concep==1||$id_concep==6) // Compras o Dev / compras... Cat de proveedores ...
	  {
		$sql3="SELECT id_prov,nr FROM catprovee WHERE id_prov='$asociado' ";
		$result3=mysql_db_query($dbcompras,$sql3);
		$row3=mysql_fetch_array($result3);
		$aso2=$row3["nr"];		  	
	  }
	  if ($id_concep==4||$id_concep==7||$id_concep==9) // Almacenes ...
	  {
			$sql_aso2="SELECT almacen FROM `tipoalmacen` WHERE `id_almacen`='$asociado'";
			$result_aso2=mysql_db_query($sql_inv,$sql_aso2);	
			while($row_aso2=mysql_fetch_array($result_aso2)){	
				$aso2=$row_aso2["almacen"];
			}	  	
	  }
	  
	  //echo "<br>ID CONC ($id_concep - $concep) ASOCIADO ($asociado - $aso2)";
	  ?>
  <tr style="background-color:<?=$color;?>;">
    <td height="20" align="center" class="td1">&nbsp;
        <?=$row2["id_mov"];?></td>
    <td class="td1" align="left">&nbsp;
        <?=$row2["concepto"];?></td>
    <td align="left" class="td1">&nbsp;
        <?=$aso2;?></td>
    <td align="right" class="td1"><?=$row2["fecha"];?>
      &nbsp;</td>
    <td align="right" class="td1" ><?=$row2["cantidad"];?>
      &nbsp;</td>
    <td align="right" class="td2">$
      <?=$row2["cu"];?>
      &nbsp;</td>
  </tr>
  <?php 
	  ($color=="#D9FFB3")? $color="#FFFFFF": $color="#D9FFB3";
	  } ?>
</table>
<?php } else { ?>
<div class="buscador">
	<div class="paginas">P&aacute;ginas</div>
	<div class="paginador"> 
<?php 
	// ...... Codigo de la Paginacion ..................................... 
	if($pagina>1) 
	{ 
    	echo "<a alt='Anterior' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&cri=".$cri."'> "; 
       	echo "<strong> << </strong></a> "; 
    } 

    for($i=$inicio;$i<=$final;$i++) 
    { 
		if($i==$pagina) 
       	{ 
       		echo "<strong><font color='#ff0000'> [".$i."] </font></strong>"; 
       	} else { 
        	echo "<a class='' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&cri=".$cri."'>"; 
          	echo $i."&nbsp;</a> "; 
	   	} 
    } 
    if($pagina<$numPags) 
  	{
		echo "<a class='small' alt='Siguiente' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&cri=".$cri."'>";   
		echo "<strong> >> </strong></a>"; 
	}	

// sentencia SQL ...
	$sql="SELECT * FROM catprod where descripgral like '%" . $cri . "%' order by ".$orden." LIMIT ".$limitInf.",".$tamPag; 
	$result=mysql_db_query($sql_inv,$sql);
?>	
    </div>
	
	<div class="div_resultados">
		<u>Resultados</u> (<strong> <?=$numeroRegistros;?> </strong>) P&aacute;ginas (<strong><?=$pagina."/".$numPags;?></strong>)
		&nbsp;&nbsp;<u>Ordenar por:</u></strong> 
		<?php 
//echo "<a class='small' alt='Siguiente' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&cri=".$cri."'><strong> Id</strong></a>";   

echo "&nbsp;<a alt='Ordenar por No. de Parte' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=id_prod&cri=".$cri."'> No. de Parte </a>";   
echo "&nbsp;<a alt='Ordenar por Descripcion' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=descripgral&cri=".$cri."'> Descripcion </a>";   
echo "&nbsp;<a alt='Ordenar por Especificacion' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=especificacion&cri=".$cri."'> Especificacion </a>";   
		?>
	</div>
	<div class="form_buscador">
		<form name="frm_buscador" action="<?=$_SERVER['PHP_SELF'];?>" method="get">
		<input type="hidden" name="orden" value="<?=$orden;?>" />
		<input type="text" name="cri" id="txt_buscar" value="<?=$cri;?>" />&nbsp;
		<input type="submit" value="Buscar" />
		</form>
	</div>
</div>
<div align="center" style=" width:803px; padding:0px; clear:both;">
<table width="800" border="0" align="center" cellspacing="0" style="border:#333333 1px solid;">
    <tr>
      <td colspan="4" bgcolor="#333333" height="20" class="style6"><div align="center"><strong>Selecciona producto para ver el Kardex</strong></div></td>
    </tr>
    <tr style="background-color:#CCCCCC; color:#000000; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold; padding:1px; text-align:center;">
      <td width="124" class="" height="20">Clave del Producto </td>
      <td width="370"  class="">Descripci&oacute;n</td>
      <td width="221" class="">Especificaci&oacute;n</td>
      <td width="72" class="">Kardex</td>
    </tr>
<?
			$color=="#D9FFB3";
			while($row=mysql_fetch_array($result)){
?>
    <tr style=" font-size:11px; padding:1px; font-family:Verdana, Arial, Helvetica, sans-serif;">
      <td height="20" bgcolor="<? echo $color; ?>" class="td1" align="center"><?=$row["id_prod"]; ?></td>
      <td bgcolor="<? echo $color; ?>" class="td1" align="left";>&nbsp;<?= $row["descripgral"]; ?></td>
      <td bgcolor="<? echo $color; ?>" class="td1" align="left">&nbsp;<?= $row["especificacion"]; ?></td>
      <td bgcolor="<? echo $color; ?>" align="center">
<a class="small" href="<?=$actual;?>?accion=ver_kardex&id=<?=$row["id_prod"];?>&desc=<?=$row["descripgral"];?>&esp=<?= $row["especificacion"]; ?>">Ver</a>	  </td>
    </tr>
<?
				($color=="#D9FFB3")? $color="#FFFFFF": $color="#D9FFB3";
			}	
?>
  </table>
</div>
<br>

<div class="buscador">
	<div class="paginador"> 
<?php 
	// ...... Codigo de la Paginacion ..................................... 
	if($pagina>1) 
	{ 
    	echo "<a alt='Anterior' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&cri=".$cri."'> "; 
       	echo "<strong> << </strong></a> "; 
    } 

    for($i=$inicio;$i<=$final;$i++) 
    { 
		if($i==$pagina) 
       	{ 
       		echo "<strong><font color='#ff0000'> [".$i."] </font></strong>"; 
       	} else { 
        	echo "<a class='' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&cri=".$cri."'>"; 
          	echo $i."&nbsp;</a> "; 
	   	} 
    } 
    if($pagina<$numPags) 
  	{
		echo "<a class='small' alt='Siguiente' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&cri=".$cri."'>";   
		echo "<strong> >> </strong></a>"; 
	}	
?>	
    </div>
	<div class="paginas">P&aacute;ginas</div>
</div>
<?php } ?>
</center>	
  
<?	include("../../f.php");	?>
</body>
</html>