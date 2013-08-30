<?php
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,11,15);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Despacho</title>
<link href="../../css/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	#catalogo{ z-index:3; position:relative; width:800px; left:50%; margin-left:-400px; /*border:#000000 1px solid;*/ padding:2px;}
</style>
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
			url:"despacho2.php",
			data:"action=listar",
			beforeSend:function(){ 
				$("#catalogo").show().html('<div align=center>Procesando datos, espere un momento.</div>'); 
			},
			success:function(datos){ $("#catalogo").show().html(datos); },
			timeout:90000000,
			error:function() { $("#catalogo").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});	
	}
	function enviar(){
		//Ontener valores de los Productos.
		var id_almacen=$("#sel_almacen").attr("value");
		var id_p="";
		for (var i=0;i<document.frm1.elements.length;i++){
			if (document.frm1.elements[i].type=="checkbox")
			{
				if (document.frm1.elements[i].checked)
				{
					//alert("Variable claves=["+claves+"]");
					if (id_p=="")
						id_p=id_p+document.frm1.elements[i].value;
					else
						id_p=id_p+","+document.frm1.elements[i].value;
				}	
			}		
		}
		//alert("IDS="+id_p);
		if(id_almacen==""||id_almacen=="undefined"||id_almacen==null||id_p==""||id_p=="undefined"||id_p==null){ return; }
		if(confirm("¿Desea realizar el envio de los productos seleccionados al almacen: "+id_almacen+"?")){
			$.ajax({
				async:true,
				type: "POST",
				dataType: "html",
				contentType: "application/x-www-form-urlencoded",
				url:"despacho2.php",
				data:"action=enviar&ida="+id_almacen+"&idps="+id_p,
				beforeSend:function(){ 
					$("#resultado").show().html('<div align=center>Procesando datos, espere un momento.</div>'); 
				},
				success:function(datos){ $("#catalogo").hide();	$("#resultado").show().html(datos); },
				timeout:90000000,
				error:function() { $("#resultado").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
			});				
		}
	}
</script>	
</head>

<body>
<div id="all">
	<div id="catalogo">&nbsp;</div>
    <div id="resultado">&nbsp;</div>
</div>
</body>
</html>