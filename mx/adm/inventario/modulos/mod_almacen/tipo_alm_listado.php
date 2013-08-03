<?php 
	include ("../../conf/conectarbase.php");
	$sql="SELECT * FROM tipoalmacen";
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
/*.Estilo1 {
	font-size: 9px;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #CCCCCC;
}
.style6 {font-size: 12px; color: #FFFFFF; font-family: Geneva, Arial, Helvetica, sans-serif;}
.style7 {color: #333333}
.Estilo6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.Estilo4 {color: #FFFFFF}
.Estilo2 {	color: #FFFFFF;
	font-weight: bold;
	font-size: 14px;
}
body {
	margin-top: 0px;
}
.style11 {font-size: 12px; color: #FFFFFF; font-family: Geneva, Arial, Helvetica, sans-serif; font-weight: bold; }
*/
-->
</style>
</head>

<body>
<?php include("../menu/menu.php"); ?>
<br />
<table width="652" align="center" cellspacing="0" style="border:#333333 2px solid; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
    <tr style="background-color:#333333; text-align:center; color:#FFFFFF; font-weight:bold;">
      <td colspan="4" height="20"><?=$ndr?> Almacenes</td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC" class="style17" height="20"><center>
          <strong>Id </strong></center></td>
      <td bgcolor="#CCCCCC" class="style17"><center>
        Almac&eacute;n
      </center></td>
      <td width="182" bgcolor="#CCCCCC" class="style17"><center>
          <strong>Obsevaciones</strong>
      </center></td>
    </tr>
<? 	while($row=mysql_fetch_array($result)){ ?>
    <tr bgcolor="<?=$color?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'">
      <td align="center" width="32" height="20" style=" border-right:#CCCCCC 1px solid;">
        <?= $row["id_almacen"]; ?>      </td>
      <td width="428" style=" border-right:#CCCCCC 1px solid;">
	  &nbsp;<?= $row["almacen"]; ?>      </td>
      <td width="182">
        <?= $row["observ"]; ?>
      </td>
    </tr>
    <?
  		($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3";
		}
	?>
  </table>
  <p>&nbsp;</p>
	<? include("../f.php"); ?>
</body>
</html>