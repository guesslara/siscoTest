<?php
	session_start();
	//print_r($_SESSION);exit;
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,2,3,11);

	include ("../../conf/conectarbase.php");
	(isset($_GET["menu"]))? $me=0 : $me=1; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>IQe Sisco - M&oacute;dulo de Almac&eacute;n ver. 1.0.0</title>

<script src="../../../../../clases/jquery.js" type="text/javascript"></script>
<script language="javascript">
$(document).ready(start);



	function ver_opciones(){
		$("#opciones2").show();
	}
	function asociar(x){
		var idp=$("#txt_idp").attr("value");
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"asociar.php",
			data:"action=asociar&x="+x+"&idp="+idp,
			beforeSend:function(){ 
				$("#opciones3").show().html('Procesando datos, espere un momento.'); 
			},
			success:function(datos){ $("#opciones3").show().html(datos); },
			timeout:90000000,
			error:function() { $("#opciones3").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});		
		//$("#opciones2").show();
	}	
	function asociar_a_almacen(){
		//alert("Asociar X");
		var claves1="";
		for (var i=0;i<document.form1.elements.length;i++)
		{
			if (document.form1.elements[i].type=="checkbox")
			{
				if (document.form1.elements[i].checked)
				{
					//alert("Variable claves=["+claves+"]");
					if (claves1=="")
						claves1=claves1+document.form1.elements[i].value;
					else
						claves1=claves1+","+document.form1.elements[i].value;
				}	
			}
		}
		if (claves1==""||claves1=='undefined'||claves1==null) return;
		//alert("Ids: "+claves1);		
		var idp=$("#txt_idp").attr("value");
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"asociar.php",
			data:"action=asociar_a_almacen&idsa="+claves1+"&idp="+idp,
			beforeSend:function(){ 
				$("#opciones3").show().html('Procesando datos, espere un momento.'); 
			},
			success:function(datos){ $("#opciones3").show().html(datos); },
			timeout:90000000,
			error:function() { $("#opciones3").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});			
	}

	function asociar_a_cliente(){
		//alert("Asociar a Cliente");
		var claves1="";
		for (var i=0;i<document.form1.elements.length;i++)
		{
			if (document.form1.elements[i].type=="checkbox")
			{
				if (document.form1.elements[i].checked)
				{
					//alert("Variable claves=["+claves+"]");
					if (claves1=="")
						claves1=claves1+document.form1.elements[i].value;
					else
						claves1=claves1+","+document.form1.elements[i].value;
				}	
			}
		}
		if (claves1==""||claves1=='undefined'||claves1==null) return;
		//alert("Ids: "+claves1);		
		var idp=$("#txt_idp").attr("value");
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"asociar.php",
			data:"action=asociar_a_cliente&idsc="+claves1+"&idp="+idp,
			beforeSend:function(){ 
				$("#opciones3").show().html('Procesando datos, espere un momento.'); 
			},
			success:function(datos){ $("#opciones3").show().html(datos); },
			timeout:90000000,
			error:function() { $("#opciones3").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});			
	}
function start()
{
	<?php if ($_GET["op"]==1) echo "bavanzada();"; ?>
	var d="action=xxx";
	//alert(d);
	$.ajax({
    async:true,
    type: "GET",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url:"inventario2.php",
    data:d,
    beforeSend:inicio1,
    success:resultado1,
    timeout:1000000,
    error:problemas1
  	});
}
function inicio1()
{
  	$("#contenido").show().html('<img src="../../../../../img/barra6.gif"><br>Cargando p&aacute;gina, espere un momento.');
}
function resultado1(datos)
{
	$("#contenido").show().html(datos);
}
function problemas1()
{
	$("#contenido").show().html('Error: El servidor no responde.');
}
// =======================================================================================
function paginar(al,ca,op,cr,or,as,pa)
{
	if (cr==undefined||cr==''||cr=='undefined')
		cr='';
	var datos="action=paginar&almacen="+al+"&campo="+ca+"&op="+op+"&cri="+cr+"&orden="+or+"&ascdes="+as+"&pagina="+pa;
	//alert(datos);
	$.ajax({
    async:true,
    type: "GET",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url:"inventario2.php",
    data:datos,
    beforeSend:inicio1,
    success:resultado1,
    timeout:1000000,
    error:problemas1
  	});
	
}
function buscar()
{
	var txt_al=$("#txt_almacen").attr("value");	
	var txt_ca=$("#txt_campo").attr("value");
	var txt_op=$("#txt_op").attr("value");	
	var txt_cri=$("#txt_buscar").attr("value");
	var txt_ord=$("#txt_orden").attr("value");
	var txt_as=$("#txt_ascdes").attr("value");	

	//alert('Buscar y Paginar:'+'\n'+txt_ca+'\n'+txt_op+'\n'+txt_cri+'\n'+txt_ord+'\n'+txt_as);
	paginar(txt_al,txt_ca,txt_op,txt_cri,txt_ord,txt_as,'1');
}
function exportar()
{
	$("#transparente").show();
	$('#ventana1').show();	
}
function exportar_xls()
{
	var w=$("#where1").attr("value");
	var ndr1=$("#ndr1").attr("value");
	//alert(w+'\n'+ndr1);
	if (ndr1>1000){
		
		var conf=confirm("Esta a punto de Exportar gran cantidad de datos. \nEsto puede requerir un tiempo considerable.\n\n\n¿Desea Continuar? ");
		//alert(conf);
		if (!conf==true)
			cancelar();
		else 
			location.href="reportes/xls_inventario.php?sql="+w;	
	} else {
		location.href="reportes/xls_inventario.php?sql="+w;	
	}	
}
// ===========================================================================
function ver_producto(id)
{
	$("#transparente").show();
	$("#ventana2").show();
	//alert(id);
		$.ajax({
    async:true,
    type: "GET",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url:"fichaprod2.php",
    data:"action=ver_producto&id="+id,
    beforeSend:inicio2,
    success:resultado2,
    timeout:1000000,
    error:problemas2(id)
  		});	
}
function inicio2()
{
	$("#v2_c").html('<img src="../../../../../img/barra6.gif"><br>Cargando p&aacute;gina, espere un momento.');
}
function resultado2(datos)
{
	$("#v2_c").html(datos);
}
function problemas2(id)
{
	$("#v2_c").html('Error: El servidor no responde.');
}
// ===========================================================================
function bavanzada()
{
	$('#transparente').show();
	$('#ventana3').show();
}
// ===========================================================================
function bavanzada2()
{
	var al=$("#e_almacen").attr("value");
	var ca=$("#e_campo").attr("value");
	var op=$("#e_operador").attr("value");
	
	var cr=$("#e_criterio").attr("value");
	var or=$("#e_orden").attr("value");
	var as=$("#e_ascdesc").attr("value");

	if (ca=="existencias")
		ca="exist_"+al;
	if (ca=="transferencias")
		ca="trans_"+al;
	if (or=="existencias")
		or="exist_"+al;
	if (or=="transferencias")
		or="trans_"+al;	
		
	//alert(al+'\n'+ca+'\n='+op+'\n='+cr+'\n='+or+'\n='+as);
	paginar(al,ca,op,cr,or,as,'1');
	cancelar();
}
// ===========================================================================
function ver_kardex(id)
{
	$("#ventana2").hide();
	$("#ventana4").show();	
		$.ajax({
    async:true,
    type: "GET",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url:"kardex2.php",
    data:"action=ver_kardex&id="+id,
    beforeSend:inicio4,
    success:resultado4,
    timeout:1000000,
    error:problemas4
  		});		
}
function inicio4()
{
	$("#v4_c").html('<img src="../../../../../img/barra6.gif"><br>Cargando p&aacute;gina, espere un momento.');
}
function resultado4(datos)
{
	$("#v4_c").html(datos);
}
function problemas4(id)
{
	$("#v4_c").html('Error: El servidor no responde.');
}
function cerrar_kardex()
{
	$("#ventana4").hide('slow');
	$("#ventana2").show();
}

// ===========================================================================
function cancelar()
{
	$('#transparente').hide();
	$('#ventana1').hide();

	$('#ventana2').hide();	
	$('#ventana3').hide();	
	$('#ventana4').hide();	
	$('#ventana5').hide();			
}

function modificar_producto(id)
{
	var wx=window.open("modificar_producto.php?id="+id,"","width=450, height=200");
}	

	function inventario_nextel()
	{
		cancelar();
		$('#transparente').show();
		$("#ventana5").show();	
	}

	function busqueda_nextel()
	{
		cancelar();
		var modelo_nextel=$("#nextel_modelo").attr("value");	
		$.ajax({
		async:true,
		type: "GET",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url:"inventario2.php",
		data:"action=ver_inventario_nextel&m="+modelo_nextel,
		beforeSend:inicio1,
		success:resultado1,
		timeout:1000000,
		error:problemas1
		});
	}

function modificar_status(id)
{
	$("#div_st_modificado").show();
}

function modificar_status2()
{
	var i=$("#hdn_idp1").attr("value");
	var ns=$("#sel_status1").attr("value");
	//alert("Modificar el estatus del producto:"+i+"\tNuevo status:"+ns);
	$.ajax({
		async:true,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url:"inventario2.php",
		data:"action=modificar_status&idp="+i+"&nsp="+ns,
		beforeSend:function(){ 
			$("#div_st_modificado").show().html('Cambiando status, espere un momento.'); 
		},
		success:function(datos){ $("#div_st_modificado").show().html(datos); },
		timeout:90000000,
		error:function() { $("#div_st_modificado").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
	});		
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

<style type="text/css" media="print">
.invisible { display:none;}
#all{ display:none; }
#ventana3 { display:block;}
</style>
<style type="text/css">
body{ margin:0px; padding:0px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;}
a:link{ text-decoration:none;}
a:hover{ text-decoration:none; color:#FF0000;}
a:visited{ text-decoration:none;}

#all{ background-color:#ffffff; z-index:1; position:absolute; width:100%; height:100%; }
#paginador{ background-color:#ffffff; /*border:#333333 1px solid; width:900px;*/ height:auto; position:relative; /*top:50%; left:50%;*/ margin:2px; margin-left:-450px; padding:0px;}
#tit{ height:20px; text-align:right; }
#contenido{ margin-top:10px; background-color:#ffffff; padding:0px; text-align:center; z-index:1; }
.td1{ border-right:#CCCCCC 1px solid; padding:1px;}
.buscador{ background-color:#ffffff; text-align:center; font-size:11px; margin-bottom:1px; position:relative; width:1000px; left:50%; margin-left:-500px; }
.form_buscador{ text-align:center; }

/*==========================================================================================*/
 .paginador1:link{ border:#CCCCCC 1px solid; background-color:#efefef; color:#000000; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:10px; margin:1px;}
 .paginador1:visited{ border:#CCCCCC 1px solid; background-color:#efefef; color:#000000; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:10px; margin:1px;}
 .paginador1:hover{ border:#CCCCCC 1px solid; background-color:#efefef; color:#333333; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:15px; margin:1px;}
 .pagact:link{ border:#CCCCCC 1px solid; border-bottom:#CCCCCC 2px solid; border-right:#CCCCCC 2px solid; background-color:#efefef; color:#333333; font-weight:normal; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:15px; margin:1px; margin-right:4px;}
 .pagact:visited{ border:#CCCCCC 1px solid; background-color:#efefef; color:#333333; font-weight:bold; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:15px; margin:1px; margin-right:4px;}
/*==========================================================================================*/
#transparente{ background-image:url(../../../../../img/transparente.png); width:100%; height:900px; position:absolute; margin:0px; padding:0px; z-index:2; display:none;}
#ventana1{ display:none; position:absolute; z-index:3; width:300px; height:200px; top:50%; left:50%; margin-top:-150px; margin-left:-100px; 
border:#333333 2px solid; background-color:#FFFFFF;}
#v1_t{ text-align:right; padding:1px; background-color:#333333; color:#FFFFFF;}

#ventana2{ display:none; position:absolute; z-index:3; width:600px; height:600px; top:50%; left:50%; margin-top:-300px; margin-left:-300px; 
border:#333333 2px solid; background-color:#FFFFFF;}
#v2_t{ height:17px; text-align:right; padding:1px; background-color:#333333; color:#FFFFFF;}
#v2_c{ height:579px; margin-top:0px; overflow:auto; text-align:right; padding:1px; background-color:#ffffff; text-align:center;}

#ventana3{ display:none; position:absolute; z-index:3; width:500px; height:220px; top:50%; left:50%; margin-top:-110px; margin-left:-250px; 
border:#333333 2px solid; background-color:#FFFFFF;}
#v3_t{ height:17px; text-align:right; padding:1px; padding-bottom:2px; background-color:#333333; color:#FFFFFF;}
#v3_c{ height:195px; margin-top:0px; overflow:auto; text-align:right; padding:1px; background-color:#ffffff; text-align:center; background-image:url(../../../../../img/buscar3.png); background-position:right; background-repeat:no-repeat;}

#ventana4{ display:none; position:absolute; z-index:3; width:800px; height:400px; top:50%; left:50%; margin-top:-200px; margin-left:-400px; 
border:#333333 2px solid; background-color:#FFFFFF;}
#v4_t{ height:17px; text-align:right; padding:1px; padding-bottom:2px; background-color:#333333; color:#FFFFFF;}
#v4_c{ height:378px; margin-top:0px; overflow:auto; text-align:right; padding:1px; background-color:#ffffff; text-align:center;}
#busqueda_nextel{ text-align:center; margin-top:70px;}

#ventana5{ display:none; position:absolute; z-index:3; width:300px; height:200px; top:50%; left:50%; margin-top:-150px; margin-left:-100px; 
border:#333333 2px solid; background-color:#FFFFFF;}
#v5_t{ text-align:right; padding:1px; background-color:#333333; color:#FFFFFF;}
</style>
</head>
<body>
	
<div id="ventana5">
	<div id="v5_t">
	<div style="float:left; padding-left:5px; font-weight:bold;">B&uacute;squeda NEXTEL</div>
	<a href="javascript:cancelar();"><img src="../../../../../img/cerrar_2.png" align="Cerrar" border="0" class="invisible" title="Cerrar esta ventana." style="cursor:pointer;" /></a></div>
	<div id="v5_c">
	
	<div id="busqueda_nextel" style="">
		Modelo: <select id="nextel_modelo">
			<option value="*">Todos</option>
			<?php
				echo $sql_nextel="SELECT especificacion FROM catprod WHERE linea='NX' AND length(control_alm)<3 GROUP BY especificacion ORDER BY especificacion,id";
				$result_nextel=mysql_query($sql_nextel,$link);
				while($row_nextel=mysql_fetch_array($result_nextel)){
					echo "<option value='".$row_nextel["especificacion"]."'>".$row_nextel["especificacion"]."</option>";
				
				}
			?>
		</select>
		<input type="button" value="Buscar" onclick="busqueda_nextel()" />
	</div>	
		
	</div>	
</div>	
	
<div id="all">
	<? if ($me==1) //include("../menu/menu.php"); ?>
	<div id="paginador">
		<div id="tit">
			<!--<a href="javascript:inventario_nextel();">Inventario Nextel</a>&nbsp;|&nbsp;//-->
			<a href="javascript:exportar();">Exportar Datos</a>&nbsp;|&nbsp;<a href="javascript:bavanzada();">B&uacute;squeda avanzada</a>
		</div>
	</div>
	<div id="contenido">...</div>

	<? //include("../../f.php"); ?>
</div>

<div id="transparente"></div>

<div id="ventana1">
	<div id="v1_t">
	<div style="float:left; padding-left:5px; font-weight:bold;">Exportar informaci&oacute;n</div>
	<a href="javascript:cancelar();"><img src="../../../../../img/cerrar_2.png" align="Cerrar" border="0" class="invisible" title="Cerrar esta ventana." style="cursor:pointer;" /></a></div>
	<div id="v1_c">
		<img src="../../../../../img/xls1.png" border="0" title="Exportar datos a Excel." style="cursor:pointer; margin:10px; margin-top:50px;" />
		<a href="javascript:exportar_xls();" style="position:absolute; top:89px; left:87px; " title="Esta operacion puede tardar un tiempo considerable en relacion al numero de productos.">
		Exportar resultados a Excel.</a> <br /></div>	
</div>

<div id="ventana2">
	<div id="v2_t">
	<div style="float:left; padding-left:5px; font-weight:bold;">Descripci&oacute;n del Producto</div>
	<a href="javascript:cancelar();"><img src="../../../../../img/cerrar_2.png" align="Cerrar" class="invisible" border="0" title="Cerrar esta ventana." style="cursor:pointer;" /></a></div>
	<div id="v2_c">
		<img src="../../../../../img/xls1.png" border="0" title="Exportar datos a Excel." style="cursor:pointer; margin:10px; margin-top:50px;" />
		<a href="javascript:exportar_xls();" style="position:absolute; top:89px; left:87px; " title="Esta operacion puede tardar un tiempo considerable en relacion al numero de productos.">
		Exportar resultados a Excel.</a>	</div>	
</div>

<div id="ventana3">
	<div id="v3_t">
		<div style="float:left; padding-left:5px; font-weight:bold;">B&uacute;squeda avanzada</div>
		<a href="javascript:cancelar();"><img src="../../../../../img/cerrar_2.png" align="Cerrar" class="invisible" border="0" title="Cerrar esta ventana." style="cursor:pointer;" /></a></div>
	<div id="v3_c">


		<table width="90%" cellspacing="0" align="center" style="margin-top:2px; text-align:left;">
			<tr>
				<td width="13%">&nbsp;</td>
				<td width="72%">&nbsp;</td>
			</tr>
			<tr>
				<td>Almac&eacute;n:</td>
				<td>
				<select name="e_almacen" id="e_almacen">
                  <option value="<?=$idalm?>" selected="selected"><?=$nalm0?></option>
				  <?php 
				  	$sql_alm="SELECT id_almacen,almacen FROM tipoalmacen WHERE almacen<>'$nalm0' ORDER BY almacen";
				  	$result0=mysql_query($sql_alm,$link);
					while ($row0=mysql_fetch_array($result0))
					{ ?>
					 	<option value="<?=$row0["id_almacen"];?>"><?=$row0["almacen"];?></option>
					<?php }  ?>
				</select>
				</td>
			</tr>
			<tr>
				<td>Campo</td>
				<td>
				<select name="e_campo" id="e_campo">
                   <option value="id">Id</option>
				  <option value="id_prod">Clave del producto</option>
                  <option value="descripgral">Descripci&oacute;n</option>
                  <option value="especificacion">Especificaci&oacute;n</option>
                  <option value="control_alm">Control de Almac&eacute;n</option>
                  <option value="linea">L&iacute;nea</option>
				  <option value="unidad">Unidad</option>
				  <option value="stock_min">Stock Minimo</option>
				  <option value="stock_max">Stock Maximo</option>
                  <option value="exist_1">Existencias</option>
                  <option value="trans_1">Transferencias</option>
                </select>				</td>
			</tr>
			<tr>
				<td>Operador</td>
				<td>
				<select name="e_operador" id="e_operador">
				  <option value="LIKE">Similar a</option>
                  <option value="=">Igual</option>
                  <option value=">">Mayor que</option>
                  <option value="<">Menor que</option>
                  <option value="<>">Distinto</option>
                </select></td>
			</tr>
			<tr>
				<td>Criterio</td>
				<td><input type="text"  name="e_criterio"  id="e_criterio" value="" /></td>
			</tr>
			<tr>
				<td>Orden</td>
				<td>
				<select name="e_orden" id="e_orden">                  
				  <option value="id">Id</option>
				  <option value="id_prod">Clave del producto</option>
                  <option value="descripgral">Descripci&oacute;n</option>
                  <option value="especificacion">Especificaci&oacute;n</option>
                  <option value="control_alm">Control de Almac&eacute;n</option>
				  <option value="linea">L&iacute;nea</option>
				  <option value="unidad">Unidad</option>
				  <option value="stock_min">Stock Minimo</option>
				  <option value="stock_max">Stock Maximo</option>
                  <option value="exist_1">Existencias</option>
                  <option value="trans_1">Transferencias</option>
				</select>
				<select name="e_ascdesc" id="e_ascdesc">                  
				  <option value="ASC">Ascendente</option>
                  <option value="DESC">Descendente</option>
				</select>				
			</tr>												
			<tr>
				<td colspan="2" style="text-align:center; padding:2px;">
					<br /><input type="button" id="va_enviar" value="Buscar" onclick="bavanzada2();" />
				</td>
			</tr>												
		</table>


	</div>	
</div>

<div id="ventana4">
	<div id="v4_t">
	<div style="float:left; padding-left:5px; font-weight:bold;">Kardex</div>
	<a href="javascript:cerrar_kardex();"><img src="../../../../../img/cerrar_2.png" align="Cerrar" border="0" class="invisible" title="Cerrar esta ventana." style="cursor:pointer;" /></a></div>
	<div id="v4_c">
		...
	</div>	
</div>

</body>
</html>
