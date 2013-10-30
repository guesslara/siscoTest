<?php 
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,11,12,13,14);

	if ($_GET["action"]){
		$action=$_GET["action"];
		//print_r($_GET);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consulta de equipos</title>
<script language="javascript" src="../../js/jquery.js"></script>
<script language="javascript">
$(document).ready(start);
function start()
{
	var d="action=xxx";
	//alert(d);
	$.ajax({
    async:true,
    type: "GET",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url:"consulta2.php",
    data:"action=paginar",
    beforeSend:function (){$("#contenido").html('<center>Cargando pagina, por favor espere...</center>'); },
    success:function (datos){$("#contenido").html(datos); },
    timeout:10000000,
    error:function (){ $("#contenido").html('<center>Error: El servidor no responde.</center>'); }
  	});
}
// =======================================================================================
function paginar(mo,ca,op,cr,or,as,pa)
{
	if (cr==undefined||cr==''||cr=='undefined')	cr='';
	var datosx="action=paginar&modulo="+mo+"&campo="+ca+"&op="+op+"&cri="+cr+"&orden="+or+"&ascdes="+as+"&pagina="+pa;
	//alert(datosx);

	$.ajax({
    async:true,
    type: "GET",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url:"consulta2.php",
    data:datosx,
    beforeSend:function (){ $("#contenido").html('<center>Cargando pagina, por favor espere...</center>'); },
    success:function (datos){ $("#contenido").html(datos); },
    timeout:100000000,
    error:function (){ $("#contenido").html("<center>Error: El servidor no responde.</center>"); }
  	});
	
	
}

// =======================================================================================


function ver_equipo(ot)
{
	//alert(ot);
	$('#transparente').show();
	//$('#busqueda1').show();	
	
	
	//$('#todo').hide();
	$('#ventana').show();
			$.ajax({
           async:true,
           type: "POST",
           dataType: "html",
           contentType: "application/x-www-form-urlencoded",
           url:"consulta2.php",
           data:"action=ver_equipo&ot="+ot,
           beforeSend:inicio,
           success:resultado,
           timeout:1000,
           error:problemas
         	});	
}

function cerrar_ventana()
{
$('#ventana').hide();
$('#todo').show();	
}
// =============================================================
function inicio()
{
  	var x=$("#ven_con");
  	x.html('<center><img src="../img/loading2.gif"><center>');
}
function resultado(datos)
{
	$("#ven_con").html(datos);
}
function problemas()
{
	$("#ven_con").html('Error: El servidor no responde.');
}

// =======================================================================================
function bavanzada()
{
	$('#transparente').show();
	$('#busqueda1').show();
}

function bavanzada2()
{
	var mo=$("#ba_modx").attr("value");
	var ca=$("#e_campo").attr("value");
	var op=$("#e_operador").attr("value");
	
	var cr=$("#e_criterio").attr("value");
	var or=$("#e_orden").attr("value");
	var as=$("#e_ascdesc").attr("value");

	//alert(mo+'\n'+ca+'\n='+op+'\n='+cr+'\n='+or+'\n='+as);
	paginar(mo,ca,op,cr,or,as,'1');
	cancelar();
}
//===============================================================================================
function expotar_a_excel()
{
	var excel_xls=$("#sql_xlsx").attr("value");
	location.href="../admin/xls.php?sql="+excel_xls;
}
//===============================================================================================
function cancelar()
{
	$('#transparente').hide();
	$('#busqueda1').hide();

	$('#todo').show();	
	$('#ventana').hide();	
	//$('#ventana4').hide();			
}
// ---------------------------------------------------
function cerrar(elEvento) {
var evento = elEvento || window.event;
var codigo = evento.charCode || evento.keyCode;
var caracter = String.fromCharCode(codigo);
//alert("Evento: "+evento+" Codigo: "+codigo+" Caracter: "+caracter);
	if (codigo==27||codigo==13){
		cancelar();
	}	
}
document.onkeypress = cerrar;
</script>
<link href="../../css/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
td{ padding:2px;}
option,input{ font-size:10px; padding:2px;}
#ventana{ z-index:3; width:580px; height:500px; top:50%; left:50%; position:absolute; margin-left:-260px; margin-top:-250px; background-color:#FFFFFF; 
border:#000000 2px solid; display:none; padding:0px 0px 0px 0px; }
	.ven_tit{ width:580px; height:17px; text-align:right; padding:1px; padding-bottom:2px; background-color:#000000; color:#FFFFFF;}
	.ven_cer{ float:right; width:50px; padding:2px; text-align:right; font-weight:bold; margin-top:5px; margin-right:5px;}
	#ven_con{ float:left; width:570px; height:470px; margin-top:5px; padding:0px; text-align:justify; font-weight:normal; overflow:auto; 
	background-color:#FFFFFF; border:#FF0000 0px solid;}	


#todo{ z-index:1; position:absolute; width:100%; height:100%; margin:0px; padding:0px;}
#contenido{ z-index:1; }
#transparente{ z-index:2; background-image:url(../../img/transparente.png); width:100%; height:900px; position:absolute; margin:0px; padding:0px; display:none;}
#busqueda1{ z-index:5; display:none; position:absolute; width:400px; height:230px; top:50%; left:50%; margin-left:-200px; margin-top:-110px; background-color:#FFFFFF; border:#000000 2px solid; }
#v3_t{ height:17px; text-align:right; padding:1px; padding-bottom:2px; background-color:#000000; color:#FFFFFF;}
#v3_c{ height:200px; margin-top:0px; overflow:auto; text-align:right; padding:1px; background-color:#ffffff; text-align:center;}

 .paginador1:link{ border:#cccccc 1px solid; background-color:#efefef; color:#000000; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:10px; margin:1px;}
 .paginador1:visited{ border:#cccccc 1px solid; background-color:#efefef; color:#000000; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:10px; margin:1px;}
 .paginador1:hover{ border:#cccccc 1px solid; background-color:#efefef; color:#333333; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:15px; margin:1px;}
 .pagact:link{ border:#cccccc 1px solid; border-bottom:#cccccc 2px solid; border-right:#cccccc 2px solid; background-color:#efefef; color:#333333; font-weight:normal; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:15px; margin:1px; margin-right:4px;}
 .pagact:visited{ border:#cccccc 1px solid; background-color:#efefef; color:#333333; font-weight:bold; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:15px; margin:1px; margin-right:4px;}

.buscador{ /*background-color:#ffffff;*/ text-align:center; font-size:11px; margin-bottom:1px; margin:1px; }
.form_buscador{ text-align:right; margin:0px;}
#paginador{ width:900px; height:auto; position:relative; }
.campos_verticales_n{ font-size:12px; text-align:left; font-weight:bold;}
.campos_verticales_d{ font-size:14px; text-align:left; font-weight:normal;}
/*==========================================================================================*/

</style>
</head>
<body>
<div id="transparente"></div>
<div id="todo">
	<?php include("../../menu/menu2sjq.php"); ?>
	<div style="text-align:right;">
		<a href="javascript:bavanzada();">Busqueda Avanzada</a> &nbsp;&nbsp;&nbsp;
	</div><br />
	<div id="contenido">&nbsp;</div>
	
</div>

	<div id="busqueda1" align="center">
	<div id="v3_t">
		<div style="float:left; padding-left:5px; font-weight:bold;">B&uacute;squeda avanzada</div>
			<a href="javascript:cancelar();"><img src="../../img/cerrar_2.png" align="Cerrar" class="invisible" border="0" title="Cerrar esta ventana." style="cursor:pointer;" /></a>
		</div>
	<div id="v3_c">
		
		<table width="90%" cellspacing="0" align="center" style="margin-top:2px; text-align:left;">
			<tr>
				<td width="13%">&nbsp;</td>
				<td width="72%">&nbsp;</td>
			</tr>
			<tr>
				<td>MODULO</td>
				<td>
				  <select name="ba_modx" id="ba_modx">
					<option value="">...</option>
					<option value="REC">RECIBO</option>
				  	<option value="REP">REPARACION</option>
					<option value="CC">CALIDAD</option>
					<option value="DES">DESPACHO</option>
					<option value="ENV">ENVIADOS</option>
				  </select>
				</td>
			</tr>
			<tr>
				<td>CAMPO</td>
				<td>
				<select name="e_campo" id="e_campo">
				  <option value="ot.id">Id</option>
				  <!--<option value="userdbingiqcd.nombre">Usuario recibe</option>	//-->
				  <option value="ot.ot">Orden de Trabajo (OT)</option>
				  <option value="ot.nserie">No. Serie</option>
				  <option value="ot.status_proceso">STATUS</option>
				  <option value="ot.obs">Observaciones</option>				  
                </select>
				</td>
			</tr>
			<tr>
				<td>OPERADOR</td>
				<td>
				<select name="e_operador" id="e_operador">
				  <option value="LIKE">Similar a</option>
                  <option value="<>">Distinto</option>
                </select></td>
			</tr>
			<tr>
				<td>CRITERIO</td>
				<td><input type="text"  name="e_criterio"  id="e_criterio" value="" /></td>
			</tr>
			<tr>
				<td>ORDEN</td>
				<td>
				<select name="e_orden" id="e_orden">                  
				  <option value="ot.id">Id</option>
				  <option value="ot.ot">Orden de Trabajo (OT)</option>
				  <option value="ot.nserie">No. Serie</option>
				  <option value="ot.status_proceso">STATUS</option>
				  <option value="ot.obs">Observaciones</option>	
				  ot.status_proceso
				  		  
				</select>
				<select name="e_ascdesc" id="e_ascdesc">                  
				  <option value="ASC">Ascendente</option>
                  <option value="DESC">Descendente</option>
				</select>				
			</tr>												
			<tr>
				<td colspan="2" style="text-align:center; padding:2px;">
					<br /><input type="button" id="va_enviar" value="BUSCAR" onclick="bavanzada2();" />
				</td>
			</tr>												
		</table>
	</div>
	</div>


	<div id="ventana">
	<div class="ven_tit">
		<div style="float:left; padding-left:5px; font-weight:bold;">Descripci&oacute;n de la Orden de Trabajo (OT).</div>
		<a href="javascript:cancelar();"><img src="../../img/cerrar_2.png" align="Cerrar" class="invisible" border="0" title="Cerrar esta ventana." style="cursor:pointer;" /></a>
	</div>			
		<div class="ven_con" id="ven_con"></div>
	</div>
	
</body>
</html>