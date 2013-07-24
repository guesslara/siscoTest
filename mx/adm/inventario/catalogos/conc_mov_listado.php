<?
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,2,3,11);
	
	include("../../conf/conectarbase.php");
	$sql="SELECT * FROM concepmov";
	$result=mysql_db_query($sql_inv,$sql);
	$ndr=mysql_num_rows($result);
	$color="#D9FFB3";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-size: 9px;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #CCCCCC;
}
.style6 {font-size: 12px; color: #FFFFFF; font-family: Geneva, Arial, Helvetica, sans-serif;}
.style7 {color: #333333}
.Estilo6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.Estilo4 {color: #FFFFFF}
body {
	margin-top: 0px;
	margin-left: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo8 {font-size: 12px; color: #FFFFFF; font-family: Geneva, Arial, Helvetica, sans-serif; font-weight: bold; }

-->
</style>
</head>

<body>
<?php include("../menu/menu.php"); ?>
<br /><br />
<table width="486" align="center" cellspacing="0" style="border:#333333 2px solid; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
    <tr style="background-color:#333333; font-weight:bold; text-align:center; color:#FFFFFF;">
      <td colspan="6" height="20" > Conceptos de Entrada y Salida (E/S) </td>
    </tr>
    <tr style="background-color:#CCCCCC; text-align:center; font-weight:bold; color:#000000;">
      <td height="20">Id</td>
      <td>Concepto</td>
      <td width="104">Cuenta</td>
      <td width="154">Asociado a</td>
      <td width="84">Tipo</td>
    </tr>
    <?
		$sql="SELECT * FROM concepmov";
		$result=mysql_db_query($sql_inv,$sql);
		$color=="#D9FFB3";
		while($row=mysql_fetch_array($result)){
	?>
    <tr bgcolor="<?=$color?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" style="cursor:pointer;">
      <td width="68" style="border-right:#CCCCCC 1px solid;text-align:center;">
        &nbsp;<?= $row["id_concep"]; ?>
      </td>
      <td width="226" style="border-right:#CCCCCC 1px solid;">
        &nbsp;<?= $row["concepto"]; ?>
      </td>
      <td style="border-right:#CCCCCC 1px solid;">
        &nbsp;--<?= $row["cuenta"]; ?>
      </td>
      <td align="left" style="border-right:#CCCCCC 1px solid;">
        &nbsp;<?= $row["asociado"]; ?>
      </td>
      <td style="border-right:#CCCCCC 1px solid;">
        &nbsp;<?= $row["tipo"]; ?>
      </td>
    </tr>
    <?
  			($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3";
		}
	?>
  </table>
<?	include("../../f.php");	?>
</body>
</html>