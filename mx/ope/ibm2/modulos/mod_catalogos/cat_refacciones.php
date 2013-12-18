<?php 
	session_start();
	//include("../login/validar_usuarios.php");
	//validar_usuarios(0,11,12);
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Catalogo de Refacciones.</title>
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
			url:"cat_refacciones2.php",
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
			url:"cat_refacciones2.php",
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
	
	function elegir_productos(n){
		//alert("elegir productos");
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"cat_refacciones2.php",
			data:"action=elegir_productos&n="+n,
			beforeSend:function(){ 
				$("#div_productos").show().html('Procesando datos, espere un momento.'); 
			},
			success:function(datos){ $("#div_nuevo").hide(); $("#div_productos").show().html(datos); },
			timeout:90000000,
			error:function() { $("#div_productos").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});		
	}
	function coloca_productos(){
		var nX=$("#txt_numeroX").attr("value");
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
		$("#textfield"+nX).attr("value",productos_seleccionados);
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
		if (confirm("¿Desea guardar los cambio realizados en el Refaccion "+idd+"?")){
			$.ajax({
				async:true,
				type: "POST",
				dataType: "html",
				contentType: "application/x-www-form-urlencoded",
				url:"cat_refacciones2.php",
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
		var a=$("#textfield").attr("value");
		var b=$("#textfield2").attr("value");
		var c=$("#textfield3").attr("value");
		var d=$("#textfield4").attr("value");
		var e=$("#textfield5").attr("value");
		var f=$("#textfield6").attr("value");
		
		if(d.indexOf(",")!=-1){ alert("Error: El Id Producto debe ser un unico producto."); return; }
		
		if (a==""||a=="undefined"||a==null||b==""||b=="undefined"||b==null||c==""||c=="undefined"||c==null||d==""||d=="undefined"||d==null||e==""||e=="undefined"||e==null){ 
			$("#mensajeX").html("Error: Por favor no omita los campos: Clave, Refaccion, Aplica a los Productos, Id producto y Cantidad.");
			//alert("Error: Por favor no omita los campos: Clave, Refaccione y Aplica a los Productos.");
			return;
		}
		var url="action=guardar&a="+a+"&b="+b+"&c="+c+"&d="+d+"&e="+e+"&f="+f;	
		//alert(url);
		
		if(confirm("¿Desea guardar la Refaccion?")){
			$.ajax({
				async:true,
				type: "POST",
				dataType: "html",
				contentType: "application/x-www-form-urlencoded",
				url:"cat_refacciones2.php",
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
		//alert("Agregar al Refaccione "+idd);
		$("#all").hide();
		//$("#menu_superior").hide();
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"cat_refacciones2.php",
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

<div id="div_nuevo" style="width: 50%;">
	<div class="div_nuevoA" id="div_nuevoA" style="width: 60%;">&nbsp;Nueva Refaccion.</div>
	<div class="div_nuevoC" id="div_nuevoC"style="width: 10%;">&nbsp;</div>
	<div class="div_nuevoD" id="div_nuevoD" style="width: 40%;">
		<input type="button" value="Guardar" class="boton1" onclick="guardar()" /><input type="button" value="Cancelar" onclick="cancelar()" class="boton1" />
		
	</div>
</div>


<div id="all">
	<div id="menu_superior" style="width: 10%;">
		<a href="javascript:start();">Listar</a> |
		<a href="javascript:nuevo();">Nuevo</a> 
	</div>
	<br /><br />
	<div id="catalogo">&nbsp;</div>
	<div align="center" id="div_datos2">&nbsp;</div>
</div>

</body>
</html>
