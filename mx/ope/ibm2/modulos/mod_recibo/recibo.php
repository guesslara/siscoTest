<?php
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,11,12);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--<body background="../cream_pixels.png"> -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Recibo de Productos.</title>
<link href="../../css/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	#all{ /*background-color:#CCCCCC;*/}
</style>
<script language="javascript" src="../../../../../clases/jquery.js"></script>
<script language="javascript">
	function buscar_ns(){
		var nds=$("#txt_ot").attr("value");
		if (nds==""||nds=="undefined"||nds==null){ return; }
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"recibo2.php",
			data:"action=buscar&nds="+nds,
			beforeSend:function(){ 
				$("#div_datos2").show().html('<div align=center>Procesando datos, espere un momento.</div>'); 
			},
			success:function(datos){ $("#div_datos2").show().html(datos); },
			timeout:90000000,
			error:function() { $("#div_datos2").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});				
	}
	
	function guardar_ot(){
		if (document.form1.chk1.checked){ var x="1"; } else { var x="0"; }
		
		var a=$("#nserie").attr("value");
		var b=$("#txt1").attr("value");
		var c=$("#txt2").attr("value");
		var d=$("#txt3").attr("value");
		var e=$("#txt4").attr("value");
		var f=$("#txt6").attr("value");	
		var g=$("#txt5").attr("value");
		var h=$("#txt7").attr("value");	
		if(f==""||f=="undefined"||f==null){
			alert("Por favor seleccione el Diagnostico.");
			return;
		}
		var url="action=guardar&a="+a+"&b="+b+"&c="+c+"&d="+d+"&e="+e+"&f="+f+"&g="+g+"&x="+x+"&h="+h;
		//alert(url);
		if (confirm("¿Desea guardar la OT?")){
			$.ajax({
				async:true,
				type: "POST",
				dataType: "html",
				contentType: "application/x-www-form-urlencoded",
				url:"recibo2.php",
				data:url,
				beforeSend:function(){ 
					$("#div_resultado").show().html('<div align=center>Procesando datos, espere un momento.</div>'); 
				},
				success:function(datos){ $("#div_resultado").show().html(datos); },
				timeout:90000000,
				error:function() { $("#div_resultado").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
			});					
		}
			
	}
	
	function cancelar(){
		$("#all").show();
		$("#div_nuevo").hide();
	}	
</script>
</head>

<body>

<div id="div_productos">&nbsp;</div>


<div id="all">	
	<br /><br />
	
	<div id="div_recibo" style="margin:3px 0px 30px 0px;">
		<form id="form1" name="form1" method="post" action="">
		
		<div align="center" id="div_datos1" style=" background-color:#FFFFFF; margin:3px 3px 2px 348px;width: 50%;border-radius: 10px;text-shadow: 2px 2px 2px gray;-moz-box-shadow: 3px 3px 4px #111; -webkit-box-shadow: 3px 3px 4px #111; box-shadow: 3px 3px 4px #111; -ms-filter: 'progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color=#111111)'; filter: progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#111111');">
			<h3 align="center">Alta de equipos registro de (OT)</h3>
			No. de Serie: <input type="text" name="txt_ot" id="txt_ot" size="50" />
			<input type="button" value="Buscar" onclick="buscar_ns()" />		
		</div>
		<div align="center" id="div_datos2" align= "center" style=" width:100%; border-radius: 10px;text-shadow: 2px 2px 2px gray;">&nbsp;</div>
		<div align="center" id="div_resultado"></div>
                </form>
        </div>
</div>

<div id="div_nuevo">
	<!--<div class="div_nuevoA" id="div_nuevoA">&nbsp;Nuevo Diagn&oacute;stico.</div>
	<div class="div_nuevoC" id="div_nuevoC">&nbsp;</div>
	<div class="div_nuevoD" id="div_nuevoD">
		<br /><input type="button" value="Guardar" class="boton1" onclick="guardar()" />
		<br /><input type="button" value="Cancelar" onclick="cancelar()" class="boton1" />-->
	</div>
</div>

</body>
</html>
