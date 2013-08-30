<?php 
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,11,12);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Asignar equipos</title>
<script language="javascript" src="../../../../../clases/jquery.js"></script>
<script language="javascript">
	$("document").ready(start);
	function start(){
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"asignar_equipos2.php",
			data:"accion=listar",
			beforeSend:function(){ 
				$("#resultado2").show().html('<center><br><img src="../img/barra6.gif"><br>Procesando informacion, espere un momento.</center>');
			},
			success:function(datos){ 
				$("#resultado2").show().html(datos);
			},
			timeout:90000000,
			error:function() { 
				$("#resultado2").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>');
			}
		});		
	}
	
	function asignar()
	{
		//alert("Asociar.");
		var tecnico=$("#tecnico").attr("value");
		var claves1="";
		for (var i=0;i<document.frm1.elements.length;i++)
		{
			if (document.frm1.elements[i].type=="checkbox")
			{
				if (document.frm1.elements[i].checked)
				{
					//alert("Variable claves=["+claves+"]");
					if (claves1=="")
						claves1=claves1+document.frm1.elements[i].value;
					else
						claves1=claves1+","+document.frm1.elements[i].value;
				}	
			}
		}
		if (claves1==""||claves1=='undefined'||claves1==null||tecnico==""||tecnico=='undefined'||tecnico==null) return;
		//alert("Claves: "+claves1);
		if (confirm("¿Desea asignar los productos ("+claves1+") al tecnico ("+tecnico+")?")){
			$.ajax({
				async:true,
				type: "POST",
				dataType: "html",
				contentType: "application/x-www-form-urlencoded",
				url:"asignar_equipos2.php",
				data:"accion=asignar&ids="+claves1+"&tecnico="+tecnico,
				beforeSend:function(){ 
					$("#resultado").show().html('<center><br><img src="../img/barra6.gif"><br>Procesando informacion, espere un momento.</center>');
				},
				success:function(datos){ 
					$("#resultado").show().html(datos);
					start();
				},
				timeout:90000000,
				error:function() { 
					$("#resultado").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>');
				}
			});		
		}
	}
</script>
<link href="../../css/css1.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="all">		
		<div id="resultado" align="center">&nbsp;</div>
		<div id="resultado2">&nbsp;</div>        
	</div>
</body>
</html>
