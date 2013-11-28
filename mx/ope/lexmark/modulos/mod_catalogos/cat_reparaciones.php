<?php 
	session_start();
	//include("../login/validar_usuarios.php");
	//validar_usuarios(0,11,12);
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Catalogo de Reparaciones.</title>
<link href="../../css/estilos.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../../../../../clases/jquery.js"></script>
<script language="javascript">
	$("document").ready(start);
	function start(){
		$("#all").show();
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"cat_reparaciones2.php",
			data:"action=listar",
			beforeSend:function(){ 
				$("#catalogo").show().html('Guardando datos, espere un momento.'); 
			},
			success:function(datos){ $("#catalogo").show().html(datos); },
			timeout:90000000,
			error:function() { $("#catalogo").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});	
	}
	function buscar() {
			var part=document.getElementById("busc").value;
			var idd=document.getElementById("num").value;
			//alert(part);
			if (part==""||part=="undefined"||part==null){ return; }
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"controladorEnsamble.php",
			data:"action=buscar&part="+part+"&idd="+idd,
			beforeSend:function(){ 
				$("#div_productos").show().html('<div align=center>Procesando datos, espere un momento.</div>'); 
			},
			success:function(datos){
				$("#div_productos").show().html(datos);
			},
			timeout:90000000,
			error:function() { $("#div_productos").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});
	}
	function nuevo(){
		$("#all").hide();
		$("#div_nuevo").show();
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"cat_reparaciones2.php",
			data:"action=nuevo",
			beforeSend:function(){ 
				$("#div_nuevoC").show().html('Procesando datos, espere un momento.'); 
			},
			success:function(datos){ $("#div_nuevoC").show().html(datos); },
			timeout:90000000,
			error:function() { $("#div_nuevoC").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});			
	}
	function cancelar(){
		$("#all").show();
		$("#div_nuevo").hide();
	}	
	
	function elegir_productos(){
		//alert("elegir productos");
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"cat_reparaciones2.php",
			data:"action=elegir_productos",
			beforeSend:function(){ 
				$("#div_productos").show().html('Procesando datos, espere un momento.'); 
			},
			success:function(datos){ $("#div_nuevo").hide(); $("#div_productos").show().html(datos); },
			timeout:90000000,
			error:function() { $("#div_productos").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});		
	}
	function coloca_productos(){
		$("#div_nuevo").show();
		var productos_seleccionados="";
		for (var i=0;i<document.frm2.elements.length;i++)
		{
			if (document.frm2.elements[i].type=="checkbox")
			{
				if (document.frm2.elements[i].checked)
				{
					//alert("Variable claves=["+claves+"]");
					if (productos_seleccionados=="")
						productos_seleccionados=productos_seleccionados+document.frm2.elements[i].value;
					else
						productos_seleccionados=productos_seleccionados+","+document.frm2.elements[i].value;
				}	
			}
		}
		if (productos_seleccionados==""||productos_seleccionados=='undefined'||productos_seleccionados==null) return;
		//alert("Ids: "+productos_seleccionados);	
		$("#textfield3").attr("value",productos_seleccionados);
		$("#div_productos").hide();	
	}
	function coloca_productos2(idd){
		//$("#div_nuevo").show();
		var productos_seleccionados="";
		for (var i=0;i<document.frm2.elements.length;i++)
		{
			if (document.frm2.elements[i].type=="checkbox")
			{
				if (document.frm2.elements[i].checked)
				{
					//alert("Variable claves=["+claves+"]");
					if (productos_seleccionados=="")
						productos_seleccionados=productos_seleccionados+document.frm2.elements[i].value;
					else
						productos_seleccionados=productos_seleccionados+","+document.frm2.elements[i].value;
				}	
			}
		}
		if (productos_seleccionados==""||productos_seleccionados=='undefined'||productos_seleccionados==null) return;
		//alert("IDD="+idd+" Ids: "+productos_seleccionados);	
		if (confirm("¿Desea guardar los cambio realizados en la Reparacion "+idd+"?")){
			$.ajax({
				async:true,
				type: "POST",
				dataType: "html",
				contentType: "application/x-www-form-urlencoded",
				url:"cat_reparaciones2.php",
				data:"action=modificar&idd="+idd+"&ps="+productos_seleccionados,
				beforeSend:function(){ 
					$("#div_productos").show().html('Procesando datos, espere un momento.'); 
				},
				success:function(datos){ $("#div_nuevo").hide(); $("#div_productos").show().html(datos); },
				timeout:90000000,
				error:function() { $("#div_productos").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
			});					
		}
	}	
	
	function guardar(){
		var c=$("#textfield").attr("value");
		var d=$("#textfield2").attr("value");
		var p=$("#textfield3").attr("value");
		var o=$("#textfield4").attr("value");
		if (c==""||c=="undefined"||c==null||d==""||d=="undefined"||d==null||p==""||p=="undefined"||p==null){ 
			$("#mensajeX").html("Error: Por favor no omita los campos: Clave, Reparacion y Aplica a los Productos.");
			//alert("Error: Por favor no omita los campos: Clave, Diagnostico y Aplica a los Productos.");
			return;
		}
		var url="action=guardar&c="+c+"&d="+d+"&p="+p+"&o="+o;	
		
		//alert(url);
		if(confirm("¿Desea guardar el Reparacion?")){
			$.ajax({
				async:true,
				type: "POST",
				dataType: "html",
				contentType: "application/x-www-form-urlencoded",
				url:"cat_reparaciones2.php",
				data:url,
				beforeSend:function(){ 
					$("#div_nuevoC").show().html('Procesando datos, espere un momento.'); 
				},
				success:function(datos){ $("#div_nuevoC").show().html(datos); },
				timeout:90000000,
				error:function() { $("#div_nuevoC").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
			});		
		}
	}
	function agregar_tipos_productos(idd){
		//alert("Agregar al diagnostico "+idd);
		$("#all").hide();
		//$("#menu_superior").hide();
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"cat_reparaciones2.php",
			data:"action=elegir_productos2&idd="+idd,
			beforeSend:function(){ 
				$("#div_productos").show().html('Procesando datos, espere un momento.'); 
			},
			success:function(datos){ 
				$("#div_productos").show().html(datos);
			},
			timeout:90000000,
			error:function() { $("#div_productos").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});			
	}
</script>
</head>

<body>

<div id="div_productos">&nbsp;</div>
<div id="catalogo">&nbsp;</div>	
<div id="div_nuevo">
	<div class="div_nuevoA" id="div_nuevoA">&nbsp;Nueva Reparaci&oacute;n.</div>
	<div class="div_nuevoC" id="div_nuevoC">&nbsp;</div>
	<div class="div_nuevoD" id="div_nuevoD">
		<br /><input type="button" value="Guardar" class="boton1" onclick="guardar()" />
		<br /><input type="button" value="Cancelar" onclick="cancelar()" class="boton1" />
	</div>
</div>


<div id="all">
	<div id="menu_superior">
		<a href="javascript:start();">Listar</a> |
		<a href="javascript:nuevo();">Nuevo</a> 
	</div>
	<br /><br />
	
</div>
</body>
</html>
