<?php require_once('Connections/operacion.php'); ?>
<?php


$colname_Recordset1 = "-1";
if (isset($_POST['idbusc'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['idbusc'] : addslashes($_POST['idbusc']);
}
mysql_select_db($database_operacion, $operacion);
//$query_Recordset1 = sprintf("SELECT id, id_prod, descripgral, especificacion, linea, marca, control_alm, ubicacion, uni_entrada, uni_salida, stock_min, stock_max, observa, existencias, unidad, tipo, kit, cpromedio, activo, status1 FROM catprod WHERE id = %s ORDER BY id ASC", $colname_Recordset1);
$query_Recordset1 = "SELECT id, id_prod, descripgral, especificacion, linea, marca, control_alm, ubicacion, uni_entrada, uni_salida, stock_min, stock_max, observa, existencias, unidad, tipo, kit, cpromedio, activo, status1, noParte FROM catprod WHERE descripgral LIKE '%".$colname_Recordset1."%' OR especificacion LIKE '%".$colname_Recordset1."%' ORDER BY id ASC";
$Recordset1 = mysql_query($query_Recordset1, $operacion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);




?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
 <style type="text/css">
table.hovertable {
 font-family: verdana,arial,sans-serif;
 font-size:11px;
 color:#F4FA58;
 border-width: 1px;
 border-color: #999999;
 border-collapse: collapse;
 }
 table.hovertable th {
 background-color:#c3dde0;
 border-width: 1px;
 padding: 1px;
 border-style: solid;
 border-color: #E6E6E6;
 }
 table.hovertable tr {
 background-color:transparent;
 }
 table.hovertable td {
 border-width: 1px;
 padding: 1px;
 border-style: solid;
 border-color: #E6E6E6;
 }
 
 table.hovertable2 {
 font-family: verdana,arial,sans-serif;
 font-size:11px;
 color:#F4FA58;
 border-width: 1px;
 border-color: #999999;
 border-collapse: collapse;
 }
 table.hovertable2 th {
 background-color:#c3dde0;
 border-width: 1px;
 padding: 1px;
 border-style: solid;
 border-color: #E6E6E6;
 }
 table.hovertable2 tr {
 background-color:transparent;
 }
 table.hovertable2 td {
 border-width: 1px;
 padding: 1px;
 border-style: solid;
 border-color: #E6E6E6;
 }
 </style>
</head>

<body>

<form method="POST" name="form2" action="prueba3.php ">
  <table align="center">
  <tr valign="baseline">
      <td nowrap align="right">Busqueda por descripci&oacute;n general / especificaci&oacute;n:</td>
      <td><input type="text" name="idbusc" id="idbusc" value="" size="20">
	  <input type="submit" value="Buscar" style="color: #003366; background-color: #99CCFF"></td>
    </tr>
  
</table>
</form>
<form method="POST" name="form1" action="modifica.php">

<table class="hovertable2" border=1>       
                        <tr onmouseover="this.style.backgroundColor='#F4FA58';" onmouseout="this.style.backgroundColor='transparent';">
                            <td><input type="text" value="Id" readonly="" size="1"></td>&nbsp;
                            <td><input type="text" value="Id_Prod" readonly="" size="8"></td>
                            <td><input type="text" value="Descripgral" readonly="" size="14"></td>
                            <td><input type="text" value="Especificacion" readonly="" size="8"></td>
                            <td><input type="text" value="Linea" readonly="" size="4"></td>
                            <td><input type="text" value="Marca" readonly="" size="8"></td>
                            <td><input type="text" value="Control_alm" readonly="" size="6"></td>
                            <td><input type="text" value="Ubicacion" readonly="" size="6"></td>
                            <td><input type="text" value="Uni_entrada" readonly="" size="6"></td>
                            <td><input type="text" value="Stock_min" readonly="" size="6"></td>
                            <td><input type="text" value="Stock_max" readonly="" size="6"></td>
                            <td><input type="text" value="Uni_salida" readonly="" size="10"></td>
                            <td><input type="text" value="Observaciones" readonly="" size="10"></td>
                            <td><input type="text" value="Existencias" readonly="" size="10"></td>
                            <td><input type="text" value="Unidad" readonly="" size="3"></td>
                            <td><input type="text" value="Tipo" readonly="" size="3"></td>
                            <td><input type="text" value="Status1" readonly="" size="8"></td>
                            <td><input type="text" value="NoParte" readonly="" size="8"></td>
                        </tr>

</table>
<?php do { ?>
<table class="hovertable" border=1>
                    <tr onmouseover="this.style.backgroundColor='#5858FA';" onmouseout="this.style.backgroundColor='transparent';">
                            <td><input type="text" name="id" value="<?php echo $row_Recordset1['id']; ?>" size="1"></td>
                            <td><input type="text" name="id_prod" value="<?php echo $row_Recordset1['id_prod']; ?> "size="8"></td>
                            <td><input type="text" name="descripgral" value="<?php echo $row_Recordset1['descripgral']; ?>"size="14"></td>
                            <td><input type="text" name="especificacion" value="<?php echo $row_Recordset1['especificacion']; ?>" size="8"></td>
                            <td><input type="text" name="linea" value="<?php echo $row_Recordset1['linea']; ?>" size="4"></td>
                            <td><input type="text" name="marca" value="<?php echo $row_Recordset1['marca']; ?>" size="8"></td>
                            <td><input type="text" name="control_alm" value="<?php echo $row_Recordset1['control_alm']; ?>" size="6"></td>
                            <td><input type="text" name="ubicacion" value="<?php echo $row_Recordset1['ubicacion']; ?>" size="6"></td>
                            <td><input type="text" name="uni_entrada" value="<?php echo $row_Recordset1['uni_entrada']; ?>" size="6"></td>
                            <td><input type="text" name="stock_min" value="<?php echo $row_Recordset1['stock_min']; ?>" size="6"></td>
                            <td><input type="text" name="stock_max" value="<?php echo $row_Recordset1['stock_max']; ?>" size="6"></td>
                            <td><input type="text" name="uni_salida" value="<?php echo $row_Recordset1['uni_salida']; ?>" size="10"></td>
                            <td><input type="text" name="observa" value="<?php echo $row_Recordset1['observa']; ?>"size="10"></td>
                            <td><input type="text" name="existencias" value="<?php echo $row_Recordset1['existencias']; ?>"size="10"></td>
                            <td><input type="text" name="unidad" value="<?php echo $row_Recordset1['unidad']; ?>"size="3"></td>
                            <td><input type="text" name="tipo" value="<?php echo $row_Recordset1['tipo']; ?>"size="3"></td>
                            <td><input type="text" name="status1" value="<?php echo $row_Recordset1['status1']; ?>"size="8"></td>
                            <td><input type="text" name="noParte" value="<?php echo $row_Recordset1['noParte']; ?>"size="8"></td>
                            <td><input type="submit" value="Modificar registro" style="color: #003366; background-color: #99CCFF"><!--<input type="submit" value="Actualizar">--></td>
                        </tr>
                  
                   
                    </table>
    <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id_prod" value="<?php echo $row_Recordset1['id_prod']; ?>">
  <!--<input type="hidden" name="MM_insert" value="form1">-->
  <?php } while ($row_Recordset1 = mysql_fetch_array($Recordset1)); ?>
</form>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>