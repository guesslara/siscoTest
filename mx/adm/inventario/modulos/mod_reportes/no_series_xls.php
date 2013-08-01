<?php 
	header("Content-type: application/vnd.ms-excel;charset=latin");
	header("Content-Disposition: attachment; filename=Hoja1.xls");
	header("Pragma: no-cache");
	header("Expires: 0");	
/*
	header('Content-type: application/vnd.ms-word');
	header("Content-Disposition: attachment; filename=archivo.doc");	
*/

	include ("../../conf/conectarbase.php");
	
	//print_r($_GET); 
	$id_movimiento=$_GET["idm"];
	$clave_producto=$_GET["clavep"];
	//echo "<br>".
	$sql_mov_series="SELECT * FROM  `num_series` WHERE mov='$id_movimiento' AND clave_prod='$clave_producto' ORDER BY id";
	$result_mov_series=mysql_db_query($sql_inv,$sql_mov_series);
	//exit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
	<table>
      <tr style="text-align:center; font-weight:bold;">
	      <td>#</td>
	      <td>No. de Serie.</td>
      </tr>
	  	<?php 
		$c=1;
		while ($row_mov_series=mysql_fetch_array($result_mov_series))
		{ 
			//echo "<hr>";
			//print_r($row_mov_series);
			?>
      <tr>
		<td width="66"><?=$c?></td>
		<td width="422"><?=$row_mov_series["serie"]?></td>
	  </tr>
	  	<?php ++$c; } ?>
    </table>
</body>
</html>
