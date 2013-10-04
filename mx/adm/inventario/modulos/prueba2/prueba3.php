<?php require_once('Connections/operacion.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE catprod SET id=%s, descripgral=%s, especificacion=%s, linea=%s, marca=%s, control_alm=%s, ubicacion=%s, uni_entrada=%s, uni_salida=%s, stock_min=%s, stock_max=%s, observa=%s, existencias=%s, unidad=%s, tipo=%s, status1=%s, noParte=%s WHERE id_prod=%s",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['descripgral'], "text"),
                       GetSQLValueString($_POST['especificacion'], "text"),
                       GetSQLValueString($_POST['linea'], "text"),
                       GetSQLValueString($_POST['marca'], "text"),
                       GetSQLValueString($_POST['control_alm'], "text"),
                       GetSQLValueString($_POST['ubicacion'], "text"),
                       GetSQLValueString($_POST['uni_entrada'], "int"),
                       GetSQLValueString($_POST['uni_salida'], "double"),
                       GetSQLValueString($_POST['stock_min'], "int"),
                       GetSQLValueString($_POST['stock_max'], "int"),
                       GetSQLValueString($_POST['observa'], "text"),
                       GetSQLValueString($_POST['existencias'], "double"),
                       GetSQLValueString($_POST['unidad'], "text"),
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['status1'], "int"),
                       GetSQLValueString($_POST['noParte'], "text"),
                       GetSQLValueString($_POST['id_prod'], "text"));

  mysql_select_db($database_operacion, $operacion);
  $Result1 = mysql_query($updateSQL, $operacion) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO catprod (id, id_prod, descripgral, especificacion, linea, marca, control_alm, ubicacion, uni_entrada, uni_salida, stock_min, stock_max, observa, existencias, unidad, tipo, status1) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['id_prod'], "text"),
                       GetSQLValueString($_POST['descripgral'], "text"),
                       GetSQLValueString($_POST['especificacion'], "text"),
                       GetSQLValueString($_POST['linea'], "text"),
                       GetSQLValueString($_POST['marca'], "text"),
                       GetSQLValueString($_POST['control_alm'], "text"),
                       GetSQLValueString($_POST['ubicacion'], "text"),
                       GetSQLValueString($_POST['uni_entrada'], "int"),
                       GetSQLValueString($_POST['uni_salida'], "double"),
                       GetSQLValueString($_POST['stock_min'], "int"),
                       GetSQLValueString($_POST['stock_max'], "int"),
                       GetSQLValueString($_POST['observa'], "text"),
                       GetSQLValueString($_POST['existencias'], "double"),
                       GetSQLValueString($_POST['unidad'], "text"),
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['status1'], "int"));

  mysql_select_db($database_operacion, $operacion);
  $Result1 = mysql_query($insertSQL, $operacion) or die(mysql_error());
}
if($Result1){
echo"Registros modificados correctamente";
}

$maxRows_Recordset1 = 1;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;


mysql_select_db($database_operacion, $operacion);
$query_Recordset1 = "SELECT id, id_prod, descripgral, especificacion, linea, marca, control_alm, ubicacion, uni_entrada, uni_salida, stock_min, stock_max, observa, existencias, unidad, tipo, kit, cpromedio, activo, status1 FROM catprod ORDER BY id ASC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $operacion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);

function buscador(){
$buscador=$_POST["idbusc"];
$query_Recordset1 = "SELECT * FROM catprod WHERE id= '".$buscador."'";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $operacion) or die(mysql_error());

}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>

<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">Primero</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Anterior</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Siguiente</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">&Uacute;ltimo</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>

<form method="POST" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
  <tr valign="baseline">
      <td nowrap align="right">Busqueda por Id:</td>
      <td><input type="text" name="idbusc" id="idbusc" value="" size="20">
	  <input type="submit" value="Buscar" onclick="buscador()"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Id:</td>
      <td><input type="text" name="id" value="<?php echo $row_Recordset1['id']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Id_prod:</td>
      <td><input type="text" name="id_prod" value="<?php echo $row_Recordset1['id_prod']; ?>"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Descripgral:</td>
      <td><input type="text" name="descripgral" value="<?php echo $row_Recordset1['descripgral']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Especificacion:</td>
      <td><input type="text" name="especificacion" value="<?php echo $row_Recordset1['especificacion']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Linea:</td>
      <td><input type="text" name="linea" value="<?php echo $row_Recordset1['linea']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Marca:</td>
      <td><input type="text" name="marca" value="<?php echo $row_Recordset1['marca']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Control_alm:</td>
      <td><input type="text" name="control_alm" value="<?php echo $row_Recordset1['control_alm']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Ubicacion:</td>
      <td><input type="text" name="ubicacion" value="<?php echo $row_Recordset1['ubicacion']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Uni_entrada:</td>
      <td><input type="text" name="uni_entrada" value="<?php echo $row_Recordset1['especificacion']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Uni_salida:</td>
      <td><input type="text" name="uni_salida" value="<?php echo $row_Recordset1['uni_entrada']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Stock_min:</td>
      <td><input type="text" name="stock_min" value="<?php echo $row_Recordset1['stock_min']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Stock_max:</td>
      <td><input type="text" name="stock_max" value="<?php echo $row_Recordset1['stock_max']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Observa:</td>
      <td><input type="text" name="observa" value="<?php echo $row_Recordset1['observa']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Existencias:</td>
      <td><input type="text" name="existencias" value="<?php echo $row_Recordset1['uni_entrada']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Unidad:</td>
      <td><input type="text" name="unidad" value="<?php echo $row_Recordset1['unidad']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tipo:</td>
      <td><input type="text" name="tipo" value="<?php echo $row_Recordset1['tipo']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Status1:</td>
      <td><input type="text" name="status1" value="<?php echo $row_Recordset1['tipo']; ?>" size="32"></td>
    </tr>
    <!--<tr valign="baseline">
      <td nowrap align="right">NoParte:</td>
      <td><input type="text" name="noParte" value="" size="32"></td>
    </tr>-->
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Guardar Modificacion"><!--<input type="submit" value="Actualizar registro">--></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id_prod" value="<?php echo $row_Recordset1['id_prod']; ?>">
  <!--<input type="hidden" name="MM_insert" value="form1">-->
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>