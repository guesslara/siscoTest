<? 
include("../../conf/conectarbase.php");
$lista_campos=" id,id_prod,descripgral,especificacion,linea,marca,control_alm,ubicacion,uni_entrada,uni_salida,stock_min,stock_max,observa,unidad,cpromedio,status1,$cexi0,$ctra0 ";
$fecha = date('m-d-Y');

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=CATALOGO_DE_PRODUCTOS_$fecha.xls");
header("Pragma: no-cache");
header("Expires: 0");

if (isset($_GET["sql"]))
{
//str_replace("%","iqesisco",$where1);
$sql="SELECT $lista_campos FROM catprod ".str_replace("iqesisco","%",$_GET["sql"]);
$sql=stripslashes($sql);
	$result=mysql_db_query($sql_inv,$sql);
//echo "<br>$sql";

} 
//exit();
?>
<style type="text/css">
body { font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;}
.tabla{ border:#333333 2px solid;}
.tit{ background-color:#333333; color:#FFFFFF; font-size:18px; text-align:center;}
.campos{ background-color:#cccccc; color:#000000; font-size:12px; text-align:center; font-weight:bold;}
.td1{ border-top:#cccccc 1px solid; border-right:#cccccc 1px solid; padding:1px;}
</style>
<br>
<table width="auto" class="tabla" align="center" cellpadding="0" cellspacing="0">
<tr>
  <TD colspan="18" class="tit" >&nbsp;CAT&Aacute;LOGO DE PRODUCTOS </TD>
  </tr>
<tr>
<TD height="25" ALIGN=CENTER class="campos">ID</TD>
<TD ALIGN=CENTER class="campos">CLAVE DEL PRODUCTO </TD>
<TD ALIGN=CENTER class="campos">DESCRIPCI&Oacute;N</TD>
<TD ALIGN=CENTER class="campos">ESPECIFICACI&Oacute;N</TD>
<TD ALIGN=CENTER class="campos">L&Iacute;NEA</TD>
<TD ALIGN=CENTER class="campos">MARCA</TD>
<TD ALIGN=CENTER class="campos">CONTROL DE ALMACEN </TD>
<TD ALIGN=CENTER class="campos">UBICACI&Oacute;N</TD>
<TD ALIGN=CENTER class="campos">UNIDAD DE ENTRADA </TD>
<TD ALIGN=CENTER class="campos">UNIDAD DE SALIDA </TD>
<TD ALIGN=CENTER class="campos">STOCK M&Iacute;NIMO </TD>
<TD ALIGN=CENTER class="campos">STOCK M&Aacute;XIMO </TD>
<TD ALIGN=CENTER class="campos">UNIDAD</TD>
<TD ALIGN=CENTER class="campos">COSTO PROMEDIO </TD>
<TD ALIGN=CENTER class="campos">STATUS</TD>
<TD ALIGN=CENTER class="campos">EXISTENCIAS</TD>
<TD ALIGN=CENTER class="campos">TRANSFERENCIAS</TD>
<TD ALIGN=CENTER class="campos">OBSERVACIONES</TD>
</tr>
<?php while($registro=mysql_fetch_array($result))  {  ?>
<tr>
<TD class="td1" align=center><?=$registro["id"];?></TD>
<TD class="td1">&nbsp;<?=$registro["id_prod"];?></TD>
<TD class="td1">&nbsp;<?=$registro["descripgral"];?></TD>
<TD class="td1">&nbsp;<?=$registro["especificacion"];?></TD>
<TD class="td1">&nbsp;<?=$registro["linea"];?></TD>
<TD class="td1">&nbsp;<?=$registro["marca"];?></TD>
<TD class="td1">&nbsp;<?=$registro["control_alm"];?></TD>
<TD class="td1">&nbsp;<?=$registro["ubicacion"];?></TD>
<TD class="td1">&nbsp;<?=$registro["uni_entrada"];?></TD>
<TD class="td1">&nbsp;<?=$registro["uni_salida"];?></TD>
<TD class="td1">&nbsp;<?=$registro["stock_min"];?></TD>
<TD class="td1">&nbsp;<?=$registro["stock_max"];?></TD>
<TD class="td1">&nbsp;<?=$registro["unidad"];?></TD>
<TD class="td1" align="right"><?=$registro["cpromedio"];?></TD>
<TD class="td1" align="right"><?php
			if ($registro["status1"]==2)
			{
				echo "Obsoleto";	
			} else if($registro["status1"]==1) {
				echo "Lento Movimiento";
			} else {
				echo "Uso Constante";
			}
?></TD>
<TD class="td1" align="right"><?=$registro[$cexi0];?></TD>
<TD class="td1" align="right"><?=$registro[$ctra0];?></TD>
<TD style="border-top:#CCCCCC 1px solid;">&nbsp;<?=$registro["observa"];?></TD>
</tr>
<?php } ?>
</table>
