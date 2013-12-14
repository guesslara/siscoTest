<?php 
	session_start();
	include ("../../conf/conectarbase.php");
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Operaciones entre movimientos</title>
<script language="javascript" src="../../../../../clases/jquery.js"></script>
<script language="javascript">
	$(document).ready(start1);	
	function start1()
	{
		//alert('La pagina ha cargado correctamente');
	}
	// ===================================================================================================
	function coloca_movimiento(div,id,tipomovimiento,concepto,id_almacen,id_asociado,referencia)
	{
		//alert("Coloca en la div ["+div+"] \nId ["+id+"] Concepto ["+concepto+"] \nId Asociado [#hdn_asociado_"+div+"::"+id_asociado+"]");
		$("#seleccionar_movimiento").hide();
		 $("#mover_productos ").show();
		if (div==0)
			$("#m_origen").attr("value",id+" "+concepto);
		if (div==1)
			$("#m_destino").attr("value",id+" "+concepto);			

			$("#hdn_idmov_"+div).attr("value",id);
			$("#hdn_tipomov_"+div).attr("value",tipomovimiento);
			$("#hdn_concepto_"+div).attr("value",concepto);
			$("#hdn_almacen_"+div).attr("value",id_almacen);
			$("#hdn_asociado_"+div).attr("value",id_asociado);
			$("#hdn_referencia_"+div).attr("value",referencia);
			
			var capa_resultado="#mover_productos_"+div;

		$("#"+div).attr("value",id+" "+concepto);
		$.ajax({
    async:true,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url:"mover_productos_movimientos2.php",
    data:"action=ver_movimiento&id="+id+"&contenedor="+div,
    beforeSend:function(){ $(capa_resultado).show().html('&nbsp;<center><img src="../img/barra6.gif"></center>'); },
    success:function(datos){ $(capa_resultado).show().html("&nbsp;"+datos); },
    timeout:100000000,
    error:function(){ $(capa_resultado).html('Error: El servidor no responde.'); }
  		});	
	}
	
	function seleccionar_movimiento(div)
	{
	//alert("Funcion [seleccionar_movimiento] Div ["+div+"]");
	$("#seleccionar_movimiento").show();
		$.ajax({
    		async:true,
    		type: "POST",
    		dataType: "html",
    		contentType: "application/x-www-form-urlencoded",
    		url:"mover_productos_movimientos2.php",
    		data:"action=seleccionar_movimiento&div="+div,
    		beforeSend:function(){ $("#seleccionar_movimiento").show().html('&nbsp;<center><img src="../img/barra6.gif"></center>'); $("#mover_productos ").hide(); },
    		success:function(datos){ $("#seleccionar_movimiento").show().html("&nbsp;"+datos); $("#flechas").show(); $("#mover_productos ").hide(); },
    		timeout:100000000,
    		error:function(){ $("#seleccionar_movimiento").html('Error: El servidor no responde.'); $("#mover_productos ").hide(); }
  		});		
	}
	
	
	// ===================================================================================================	
function popUp(URL) {
		day = new Date();
		id = day.getTime();
		eval("page" + id + " = window.open(URL, '" + id + "','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,width=650,height=450');");
	}
	// ===================================================================================================		
	function pasar_productos_0_1()
	{
		var errores=0;
		var idm0=$("#hdn_idmov_0").attr("value");
		var idm1=$("#hdn_idmov_1").attr("value");
		var tipo0=$("#hdn_tipomov_0").attr("value");
		var tipo1=$("#hdn_tipomov_1").attr("value");
		var concepto0=$("#hdn_concepto_0").attr("value");
		var concepto1=$("#hdn_concepto_1").attr("value");
		var almacen0=$("#hdn_almacen_0").attr("value");
		var almacen1=$("#hdn_almacen_1").attr("value");
		var asociado0=$("#hdn_asociado_0").attr("value");
		var asociado1=$("#hdn_asociado_1").attr("value");
		
		var referencia0=$("#hdn_referencia_0").attr("value");
		var referencia1=$("#hdn_referencia_1").attr("value");
				
		//alert("ID MOV ["+idm0+"] ["+idm1+"] \nTIPOS ["+tipo0+"] ["+tipo1+"] \nALMACENES ["+almacen0+"] ["+almacen1+"] \nASOCIADOS ["+asociado0+"] ["+asociado1+"] ");
		//return;
		
		// Validacion...
		if (idm0==""||idm1=="")
		{
			alert("Error 1: Alguno o ambos movimientos estan vacios.");
			return;
		}
		
		if (idm0==idm1)
		{
			alert("Error 2: Los movimientos son iguales.");
			return;
		}	
		
		if (tipo0!==tipo1)
		{
			alert("Error 3: Los tipos de movimientos son diferentes.");
			return;
		}		
		if (almacen0!==almacen1)
		{
			alert("Error 4: Los almacenes operados son diferentes.");
			return;
		}		
		if (asociado0!==asociado1)
		{
			alert("Error 4: Los Asociados son diferentes.");
			return;
		}			
		
		// Obtener los valores de los checkbox A ...
		var claves="";
		for (var i=0;i<document.frm_0.elements.length;i++)
		{
			if (document.frm_0.elements[i].type=="checkbox")
			{
				if (document.frm_0.elements[i].checked)
				{
					//alert("Variable claves=["+claves+"]");
					if (claves=="")
						claves=claves+document.frm_0.elements[i].value;
					else
						claves=claves+","+document.frm_0.elements[i].value;
				}	
			}
		}
		//alert(claves);
		
		// MANDAR LOS DATOS A PHP PARA QUE PASE LOS PRODUCTOS AL MOVIMIENTO DESTINO ...
		if (claves!=="")
		{
			if (confirm("¿Desea mover los productos seleccionados del Movimiento Origen al Movimiento destino?"))
			{
			$.ajax({
    		async:true,
    		type: "POST",
    		dataType: "html",
    		contentType: "application/x-www-form-urlencoded",
    		url:"mover_productos_movimientos2.php",
    		data:"action=agregar_productos_movimiento&mov_destino="+idm1+"&ids="+claves,
    		beforeSend:function(){ $("#status").show().html('&nbsp;<center><img src="../../../../../../img/barra6.gif"></center>'); },
    		success:function(datos){ $("#status").show().html("&nbsp;"+datos); },
    		timeout:100000000,
    		error:function(){ $("#status").html('Error: El servidor no responde.'); return; }
  			});
		
			// REALIZAR NUEVAMENTE LA PETICION ...
			coloca_movimiento(0,idm0,tipo0,concepto0,almacen0,asociado0,referencia0);
			coloca_movimiento(1,idm1,tipo1,concepto1,almacen1,asociado1,referencia1);
			}
		}
	}
	// ===================================================================================================		
	function pasar_productos_1_0()
	{
		var errores=0;
		var idm0=$("#hdn_idmov_0").attr("value");
		var idm1=$("#hdn_idmov_1").attr("value");
		var tipo0=$("#hdn_tipomov_0").attr("value");
		var tipo1=$("#hdn_tipomov_1").attr("value");
		var concepto0=$("#hdn_concepto_0").attr("value");
		var concepto1=$("#hdn_concepto_1").attr("value");
		var almacen0=$("#hdn_almacen_0").attr("value");
		var almacen1=$("#hdn_almacen_1").attr("value");
		var asociado0=$("#hdn_asociado_0").attr("value");
		var asociado1=$("#hdn_asociado_1").attr("value");
		
		var referencia0=$("#hdn_referencia_0").attr("value");
		var referencia1=$("#hdn_referencia_1").attr("value");
				
		//alert("ID MOV ["+idm0+"] ["+idm1+"] \nTIPOS ["+tipo0+"] ["+tipo1+"] \nALMACENES ["+almacen0+"] ["+almacen1+"] \nASOCIADOS ["+asociado0+"] ["+asociado1+"] ");
		//return;
		
		// Validacion...
		if (idm0==""||idm1=="")
		{
			alert("Error 1: Alguno o ambos movimientos estan vacios.");
			return;
		}
		
		if (idm0==idm1)
		{
			alert("Error 2: Los movimientos son iguales.");
			return;
		}	
		
		if (tipo0!==tipo1)
		{
			alert("Error 3: Los tipos de movimientos son diferentes.");
			return;
		}		
		if (almacen0!==almacen1)
		{
			alert("Error 4: Los almacenes operados son diferentes.");
			return;
		}		
		if (asociado0!==asociado1)
		{
			alert("Error 4: Los Asociados son diferentes.");
			return;
		}			
		
		// Obtener los valores de los checkbox A ...
		var claves="";
		for (var i=0;i<document.frm_1.elements.length;i++)
		{
			if (document.frm_1.elements[i].type=="checkbox")
			{
				if (document.frm_1.elements[i].checked)
				{
					//alert("Variable claves=["+claves+"]");
					if (claves=="")
						claves=claves+document.frm_1.elements[i].value;
					else
						claves=claves+","+document.frm_1.elements[i].value;
				}	
			}
		}
		//alert(claves);
		
		// MANDAR LOS DATOS A PHP PARA QUE PASE LOS PRODUCTOS AL MOVIMIENTO DESTINO ...
		if (claves!=="")
		{
			if (confirm("¿Desea mover los productos seleccionados del Movimiento Destino al Movimiento Origen?"))
			{
			$.ajax({
    		async:true,
    		type: "POST",
    		dataType: "html",
    		contentType: "application/x-www-form-urlencoded",
    		url:"mover_productos_movimientos2.php",
    		data:"action=agregar_productos_movimiento&mov_destino="+idm0+"&ids="+claves,
    		beforeSend:function(){ $("#status").show().html('&nbsp;<center><img src="../img/barra6.gif"></center>'); },
    		success:function(datos){ $("#status").show().html("&nbsp;"+datos); },
    		timeout:100000000,
    		error:function(){ $("#status").html('Error: El servidor no responde.'); return; }
  			});
		
			// REALIZAR NUEVAMENTE LA PETICION ...
			coloca_movimiento(0,idm0,tipo0,concepto0,almacen0,asociado0,referencia0);
			coloca_movimiento(1,idm1,tipo1,concepto1,almacen1,asociado1,referencia1);
			}
		}
	}


</script>
<link href="../../css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
#status{display:none; width:auto; background-color:#efefef; border:#333333 2px solid; overflow:auto; text-align:center; }
#seleccionar_movimiento{ display:none; width:auto; margin:5px 5px 5px 5px; padding:2px 2px 2px 2px; overflow:auto;}
#mover_productos{ width:auto; padding:10px; margin:5px 5px 5px 5px;}
	#mover_productos_0{ position:relative; width:400px;  float:left; margin:5px 5px 5px 5px; clear:left; overflow:auto;}
	#mover_productos_1{ position:relative; width:400px;  float:left; margin:5px 5px 5px 5px; clear:right; overflow:auto;}
	#flechas{ display:none;}
.td1{ border-right:#CCCCCC 1px solid; padding:1px; }
.tablax{ border:#333333 1px solid; }
#detalle{ position:absolute; display:none; border:#333333 3px solid; background-color:#ffffff; 
width:800px; height:500px; left:50%; top:50%; margin-left:-400px; margin-top:-250px; z-index:3;}
#d_tit{width:710px; height:20px; float:left; background-color:#333333; color:#FFFFFF;}
#d_cer{width:90px; height:20px; float:right; text-align:right; background-color:#333333;}
#d_con{ clear:both; margin:2px; margin-top:3px; padding:2px; height:470px; /*border:#333333 1px solid;*/ overflow:auto;}

.tdx{ background-color:#CCCCCC; font-weight:bold; text-align:left; padding-left:2px;}
.tex{ height:20px; font-size:12px; text-align:left; padding-left:5px; font-weight:normal; font-family:Verdana, Arial, Helvetica, sans-serif; width:300px; 
background-color:#FFFFFF; border:#CCCCCC 1px solid; padding:1px 1px 1px 1px; cursor:pointer;}
</style>
</head>

<body>
<div id="status"></div>
<div id="seleccionar_movimientos_origen_destino"></div>
<div id="seleccionar_movimiento"></div>

<div id="mover_productos">
	<div id="almacenes_origen_destino">

    <table width="850" align="center">
      <tr style="text-align:center; font-weight:bold;">
        <td height="41" colspan="3" valign="top">TRASPASO DE PRODUCTOS ENTRE MOVIMIENTOS </td>
      </tr>
      <tr style="text-align:center; font-weight:bold;">
        <td width="45%">Movimiento Origen </td>
        <td width="13%">&nbsp;</td>
        <td width="42%">Movimiento Destino </td>
      </tr>
      <tr style="text-align:center">
        <td>
		
		<input type="hidden" id="hdn_idmov_0" />
		<input type="hidden" id="hdn_tipomov_0" />
		<input type="hidden" id="hdn_concepto_0" />
		<input type="hidden" id="hdn_almacen_0" />
		<input type="hidden" id="hdn_asociado_0" />	
		<input type="hidden" id="hdn_referencia_0" />		
		<input type="text" name="m_origen" id="m_origen" class="tex" onClick="seleccionar_movimiento(0);" readonly="1" /></td>
        <td>&nbsp;</td>
		<td>
		<input type="hidden" id="hdn_idmov_1" />
		<input type="hidden" id="hdn_tipomov_1" />
		<input type="hidden" id="hdn_concepto_1" />
		<input type="hidden" id="hdn_almacen_1" />
		<input type="hidden" id="hdn_asociado_1" />	
		<input type="hidden" id="hdn_referencia_1" />	
		<input type="text" name="m_destino" id="m_destino" class="tex" onClick="seleccionar_movimiento(1);" readonly="1" /></td>
      </tr>
      <tr style="text-align:center">
        <td height="122" align="center" valign="top">	
			<div id="mover_productos_0">&nbsp;</div>
		</td>
        <td style="font-weight:bold; font-size:24px; text-align:center;" valign="top">
			<div id="flechas">
				<br />	
				<a href="javascript:pasar_productos_0_1();" title="Pasar productos seleccionados del Movimiento Origen al Movimiento Destino"><img src="../../../../../img/agt_forward-256.png" border="0" /></a>
				<a href="javascript:pasar_productos_1_0();" title="Pasar productos seleccionados del Movimiento Destino al Movimiento Origen"><img src="../../../../../img/agt_back-256.png" border="0" /></a>
			</div>
		</td>
        <td valign="top"><div id="mover_productos_1">&nbsp;</div></td>
      </tr>
      <tr style="text-align:center">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
      </tr>
    </table>
	
	</div>

</div>

	
</body>
</html>
