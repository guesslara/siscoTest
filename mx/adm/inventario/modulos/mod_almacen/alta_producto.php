<?php 
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,2);
	
include("../../conf/conectarbase.php");
$se=$_SERVER['PHP_SELF'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Alta de un Producto o Servicio</title>
<script src="../../js/jquery.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
function generar_id()
{
	// Nada...
}
// =======================================================
function cancelar()
{
	$('#ventana0').hide();
}
function cerrarm() {
	$('#men1').hide('slow');
}

function cerrar(elEvento) {
var evento = elEvento || window.event;
var codigo = evento.charCode || evento.keyCode;
var caracter = String.fromCharCode(codigo);
//alert("Evento: "+evento+" Codigo: "+codigo+" Caracter: "+caracter);
	if (codigo==27){
		cancelar();
	}	
}
document.onkeypress = cerrar;
</script>
<link href="../../css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
.cn{ text-align:center; font-weight:bold;}
.dn{ text-align:right; font-weight:bold; padding:1px;}

#ventana0{ display:none; position:absolute; z-index:3; width:600px; height:500px; top:50%; left:50%; margin-top:-250px; margin-left:-300px; 
border:#333333 2px solid; background-color:#FFFFFF;}
#v0_t{ height:17px; text-align:right; padding:1px; background-color:#333333; color:#FFFFFF;}
#v0_c{ height:479px; margin-top:0px; overflow:auto; text-align:right; padding:1px; background-color:#ffffff; text-align:center;}


</style>
</head>
<body>
<div id="all">

<?php 
if(!$_GET) { 
if(!$_POST) { ?>
<br />
<FORM id="form1" name="form1" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" style="margin:0px;">
<table width="600" align="center" style="border:#333333 2px solid; background-color:#fefefe; font-size:11px; font-family:Verdana, Arial, Helvetica, sans-serif;" cellspacing="0">
  <tr>
    <td colspan="4" class="t0" height="20">Datos del Producto o Servicio</td>
  </tr>
  <tr>
    <td height="44" colspan="4" style="text-align:center; font-size:14px; padding:2px;">&nbsp;
<LABEL><INPUT onclick=habilita(1) type=radio CHECKED value=1 name=tipo> Producto </LABEL>
<LABEL><INPUT onclick=habilita(2) type=radio value=2 name=tipo disabled="disabled"> Servicio </LABEL>
<LABEL><INPUT onclick=habilita(3) type=radio value=3 name=tipo disabled="disabled"> Kit de productos </LABEL></td>
  </tr>
  <tr>
    <td width="150" class="etiqueta">Clave del Producto</td>
    <td colspan="3">
	  	<input id=id_prod size=40 name=id_prod readonly="1" value="automatico" style="text-align:center; background-color:#FFFFCC;" />
    </td>
  </tr>
  <tr>
    <td class="etiqueta">Descripci&oacute;n</td>
    <td colspan="3">
      <input id=descripgral size=40 name=descripgral />
    *</td>
  </tr>
  <tr>
    <td class="etiqueta">Especificaci&oacute;n</td>
    <td colspan="3">
      <input id=especificacion size=15 name=especificacion value=""/>* &nbsp;(Modelo,Matricula,otro)</td>
  </tr>
  <tr>
    <td class="etiqueta">Unidad</td>
    <td colspan="3">
      <select id=unidad name=unidad>
        <option value="">...</option>
        <?php 
		$sql_unidades="SELECT * FROM unidades ORDER BY id_unidad";
		$r_u=mysql_db_query($sql_inv,$sql_unidades);
		while ($row_u=mysql_fetch_array($r_u)){
			echo "<option value='".$row_u['prefijo']."'>".$row_u['prefijo'].' - '.$row_u['unidad']."</option>";
		}
		?>
      </select>
    *</td>
  </tr>
  <tr>
    <td class="etiqueta">Control de Almacen </td>
    <td colspan="3">
      <input id=control_alm size=15 name=control_alm />
    *</td>
  </tr>
  <tr>
    <td class="etiqueta">L&iacute;nea de Producto </td>
    <td colspan="3">
      <select id="linea" name="linea">
        <option value="">...</option>
        <?php 
		$sql_lineas="SELECT * FROM lineas ORDER BY linea";
		$r_l=mysql_db_query($sql_inv,$sql_lineas);
		while ($row_l=mysql_fetch_array($r_l)){
			echo "<option value='".$row_l['linea']."'>".$row_l['linea'].' - '.$row_l['descripcion']."</option>";
		}
		?>
      </select>
    *</td>
  </tr>
  <tr>
    <td class="etiqueta" id="div_ubicacion0">Ubicaci&oacute;n</td>
    <td colspan="3" id="div_ubicacion1">
      <input id=ubicacion size=15 name=ubicacion value="" />
    *</td>
    </tr>
  <tr>
    <td class="etiqueta">Marca</td>
    <td width="150">
      <input size=15 name=marca value="LEXMARK" />
        </td>
    <td width="150">&nbsp;</td>
    <td width="150">&nbsp;</td>
  </tr>
  <tr>
    <td height="39" colspan="2" class="cn" valign="bottom">Unidades de: </td>
    <td colspan="2" class="cn" valign="bottom" id="stock0">Stock:</td>
  </tr>
  <tr>
    <td class="dn">Entrada</td>
    <td><input type="text" id=uni_entrada  size=10 name=uni_entrada value="" />*</td>
	<td class="dn" id="stock1">M&iacute;nimo</td>  
    <td id="stock2"><input id=stock_min  size=10 name=stock_min value="" />*</td>
  </tr>
  <tr>
    <td class="dn">Salida</td>
    <td><input id=uni_salida name=uni_salida size=10 value="" />*</td>
    <td class="dn" id="stock3">M&aacute;ximo</td>
    <td id="stock4"><input id=stock_max  size=10 name=stock_max value="" />*</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" class="cn">Almacenes Asociados: <br />
		<div style="text-align:left; padding:2px; height:100px; overflow-y:scroll; margin:20px; border:#CCCCCC 2px solid; ">
		<?php 
		$sql="Select * from tipoalmacen";
		$resultado=mysql_query($sql,$link);
		while($fila=mysql_fetch_array($resultado)){
		echo "<input name='a_".$fila['id_almacen']."_".$fila['almacen']."' type=\"checkbox\" value=\"1\" />a_".$fila['id_almacen']."_".$fila['almacen']."<br>";
		} ?>
	</div></td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;
		<!--
		<div id="kit">
		Kit de Productos <a href="javascript:agregar_kit();">+++</a><br />
		<textarea name="kit_array" id="kit_array" rows="4" cols="25" readonly="readonly"></textarea>
		</div>
		//-->
						</td>
    <td colspan="2" align="center" style="font-weight:bold;">
	Observaciones<br />
      <textarea id="observa" name="observa" rows="4" cols="25"></textarea>    </td>
  </tr>
  <tr>
    <td colspan="4" align="right" style="text-align:right; font-size:10px; color:#666666; padding-right:2px;">&nbsp;Los campos con * son obligatorios</td>
  </tr>
  <tr>
    <td height="44" colspan="4" align="center">&nbsp;
	<INPUT class=boton type=reset value=Limpiar>&nbsp;
	<INPUT class=boton  type=submit value=Enviar  >	</td>
  </tr>
</table>
</FORM>
<?php } else {
	//print_r($_POST);
	$id_prod=$_POST['id_prod'];					$uni_entrada=$_POST['uni_entrada'];  
	$tipo=$_POST['tipo'];						$uni_salida=$_POST['uni_salida'];
	$descripgral=$_POST['descripgral']; 		$stock_min=$_POST['stock_min'];
	$especificacion=$_POST['especificacion']; 	$stock_max=$_POST['stock_max'];
	$control_alm=$_POST['control_alm']; 		$kit_array=$_POST['kit_array'];
	$linea=$_POST['linea']; 					$observa=$_POST['observa'];
	$ubicacion=$_POST['ubicacion'];				$unidad=$_POST['unidad']; 			
	$marca=$_POST['marca'];		 			
	
	if ($id_prod==''||$descripgral==''||$especificacion==''||$control_alm==''||$linea==''||$marca==''||$uni_entrada==''||$uni_salida==''||$unidad=='') 
	{	echo '<br><div align=center>Faltan datos. Por favor no omita campos obligatorios.<div>';	} else {
		// ----------------- INVESTIGAR NOMBRE DE LOS CAMPOS DE LOS ALMACENES ------------------------
		$almacenes=array(); $campos_almacenes=''; $valores_almacenes='';	
		$qry=mysql_query("select * from tipoalmacen",$link); 
		while ($row2=mysql_fetch_array($qry))
		{
			$id_alm=$row2['id_almacen'];
			$alm=$row2['almacen'];
			$campo_almacen="a_".$id_alm."_".$alm;
			if ($_POST[$campo_almacen])
			{
				array_push($almacenes,$campo_almacen);	
				$campos_almacenes=$campos_almacenes.",".$campo_almacen.",exist_".$id_alm.",trans_".$id_alm;
				$valores_almacenes=$valores_almacenes.",'1','',''";
			}
		}
		$ssql="INSERT INTO catprod 
(id,id_prod,tipo,kit,descripgral, especificacion,linea,marca,control_alm,ubicacion,uni_entrada,uni_salida,stock_min,stock_max,observa,existencias,unidad,cpromedio $campos_almacenes) 
VALUES 
(NULL,'$id_prod','$tipo','$kit_array','$descripgral','$especificacion','$linea','$marca','$control_alm','$ubicacion','$uni_entrada','$uni_salida','$stock_min','$stock_max','$observa','','$unidad','' $valores_almacenes)";	
		echo "<br>SQL: <br>$ssql ";
		//exit;
		if (mysql_query($ssql,$link))
		{
			$u_id=mysql_insert_id($link);
			$consec=sprintf('%05s',$u_id);
	
			$ssql_up="SELECT id,id_prod,linea FROM catprod WHERE id='$u_id' AND (id_prod='$id_prod' AND descripgral='$descripgral' AND especificacion='$especificacion' AND control_alm='$control_alm') ";
			$r_up=mysql_query($ssql_up,$link);
			while ($row_up=mysql_fetch_array($r_up))
			{
				$linea2=$row_up["linea"];
				$id_up0=$row_up["id_prod"];
			}
			$update="UPDATE catprod SET id_prod='".$linea2.$especificacion.$consec."' WHERE id='$u_id' AND id_prod='$id_up0' ";
			if (!mysql_query($update,$link))
			{	
				echo "<br><div align='center'>Error SQL: El producto se inserto, pero el consecutivo no se genero.</div>";
				exit();
			}	
			echo "<script languaje='javascript'> alert('Producto agregado al Almacen (".$linea2.$especificacion.$consec.").'); window.location.href='".$se."';</script>";
		} else {
			echo '<br><div align=center>Error SQL: El producto no se registro.</div>';
		}	
	}
} 
} 
?>
</div>
 
 
 <div id="ventana0">
	<div id="v0_t">
	<div style="float:left; padding-left:5px; font-weight:bold;">Descripci&oacute;n del Producto</div>
	<a href="javascript:cancelar();"><img src="../img/cerrar_2.png" align="Cerrar" class="invisible" border="0" title="Cerrar esta ventana." style="cursor:pointer;" /></a></div>
	<div id="v0_c">
		...
	</div>	
</div>
 
 
 
 
</body>
</html>