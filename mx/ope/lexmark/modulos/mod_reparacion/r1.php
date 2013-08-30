<?php
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,11,13);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reparacion 1</title>
<link href="../../css/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	#div_reparacion{ z-index:3; position:absolute; width:800px; left:50%; margin-left:-400px; border:#000000 2px solid; background-color:#CCCCCC;}
		#div_rep0{ width:794px; height:20px; margin:2px; border:#000000 1px solid; float:left; clear:both;  background-color:#FFFFFF; text-align:center; font-size:16px; font-weight:bold; }
		#div_rep1{ width:400px; height:200px; margin:2px; border:#000000 1px solid; float:left;  background-color:#FFFFFF;}
		#div_rep2{ width:388px; height:200px; margin:2px; border:#000000 1px solid; float:left; clear:right;  background-color:#FFFFFF;}
		#div_rep3{ width:400px; height:200px; margin:2px; border:#000000 1px solid; float:left;  background-color:#FFFFFF; overflow:auto;}
		#div_rep4{ width:388px; height:200px; margin:2px; border:#000000 1px solid; float:left; clear:right;  background-color:#FFFFFF; overflow:auto;}		
		
		#div_rep5{ width:400px; height:160px; margin:2px; border:#000000 1px solid; float:left; clear:left;  background-color:#FFFFFF;}
		#div_rep6{ width:388px; height:160px; margin:2px; border:#000000 1px solid; float:left; clear:right;  background-color:#FFFFFF; overflow:auto;}
	#guardar{ position:relative; width:800px; left:50%; margin-left:-400px; z-index:4; background-color:#FFFFFF; text-align:justify; padding:10px; display:none; margin-top:700px;}
	
		
	.tabla2{ border-bottom:#000000 2px solid;}
	.tabla_titulo2{text-align:center; font-size:14px; font-weight:bold; border-bottom:#000000 2px solid; }
	.tabla_campo2{text-align:left; font-weight:bold; }
	.txt_ya_registrados{ border:#CCCCCC 1px solid; background-color:#FFFFFF; padding:1px;}
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
			url:"r2.php",
			data:"action=listar",
			beforeSend:function(){ 
				$("#catalogo").show().html('<div align=center>Procesando datos, espere un momento.</div>'); 
			},
			success:function(datos){ $("#catalogo").show().html(datos); },
			timeout:90000000,
			error:function() { $("#catalogo").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});	
	}
	function reparar(id){
		//$("#catalogo").hide();
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"r2.php",
			data:"action=reparar&id_ot="+id,
			beforeSend:function(){ 
				$("#catalogo").hide();
				$("#reparacion").show().html('<div align=center>Procesando datos, espere un momento.</div>'); 
			},
			success:function(datos){ $("#reparacion").show().html(datos); },
			timeout:90000000,
			error:function() { $("#reparacion").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});			
	}
	function seleccionar(l,n,t){
		var idot=$("#hdn_idot").attr("value");
		var idp=$("#hdn_idp").attr("value");
		
		//alert("Seleccionar \nIDOT="+idot+"\nL="+l+"\nN="+n);
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"r2.php",
			data:"action=seleccionar&tipo="+t+"&id_ot="+idot+"&idp="+idp+"&l="+l+"&n="+n,
			beforeSend:function(){ 
				$("#catalogo").hide();
				$("#reparacion").hide();
				$("#seleccion").show().html('<div align=center>Procesando datos, espere un momento.</div>'); 
			},
			success:function(datos){ $("#seleccion").show().html(datos); },
			timeout:90000000,
			error:function() { $("#seleccion").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});			
	}
	function coloca_datos(i,d,l,n){
		//alert("Coloca: \ni="+i+"\nd="+d+"\nl="+l+"\nN="+n);
		$("#reparacion").show();
		$("#seleccion").hide();
		
		$("#"+l+n).attr("value",i);	
		$("#"+l+l+n).attr("value",d);		
	}
	
	function cancelar3(){
		$("#reparacion").show();
		$("#seleccion").hide();	
	}
	
	function guardar_reparacion(){
		//alert("guardar OT");
		// Recolectar las variables.
		var idot=$("#hdn_idot").attr("value");
		var idp=$("#hdn_idp").attr("value");
		var nvo_status=$("#nvo_status").attr("value");
		var ant_status=$("#hdn_st_anterior").attr("value");
		var obs_rep=$("#txt_obs_rep").attr("value");
		
		var a1=$("#a1").attr("value");		var aa1=$("#aa1").attr("value");		var b1=$("#b1").attr("value");		var bb1=$("#bb1").attr("value");
		var c1=$("#c1").attr("value");		var cc1=$("#cc1").attr("value");		var d1=$("#d1").attr("value");		var dd1=$("#dd1").attr("value");		
		var e1=$("#e1").attr("value");		var ee1=$("#ee1").attr("value");		var f1=$("#f1").attr("value");		var ff1=$("#ff1").attr("value");
		var g1=$("#g1").attr("value");		var gg1=$("#gg1").attr("value");		var h1=$("#h1").attr("value");		var hh1=$("#hh1").attr("value");
		var i1=$("#i1").attr("value");		var ii1=$("#ii1").attr("value");		var j1=$("#j1").attr("value");		var jj1=$("#jj1").attr("value");				
		var k1=$("#a1").attr("value");		var kk1=$("#kk1").attr("value");		var l1=$("#l1").attr("value");		var ll1=$("#ll1").attr("value");		
		var m1=$("#m1").attr("value");		var mm1=$("#mm1").attr("value");		var n1=$("#n1").attr("value");		var nn1=$("#nn1").attr("value");				
		var o1=$("#o1").attr("value");		var oo1=$("#oo1").attr("value");		
				
		if (nvo_status==""||nvo_status=="undefined"||nvo_status==null) { faltan_datos(); return; }
		if (nvo_status==ant_status) { alert("Error: Debe cambiar el status.");  faltan_datos(); return; }
		if (nvo_status=="WIP"||nvo_status=="SCRAP"||nvo_status=="NOREP"){
			// No revisar si colocaron fallas, refacciones, Reparaciones.
		}else{
			if (a1==""||a1=="undefined"||a1==null||f1==""||f1=="undefined"||f1==null||k1==""||k1=="undefined"||k1==null) { faltan_datos(); return; }	
		}
		
		var url="action=guardar_reparacion&idot="+idot+"&idp="+idp+"&nvo_status="+nvo_status+"&obs_rep="+obs_rep+"&a1="+a1+"&b1="+b1+"&c1="+c1+"&d1="+d1+"&e1="+e1+"&f1="+f1+"&g1="+g1+"&h1="+h1+"&i1="+i1+"&j1="+j1+"&k1="+k1+"&l1="+l1+"&m1="+m1+"&n1="+n1+"&o1="+o1;
		//alert(url);
		if (confirm("¿Desea guadar la Reparacion del equipo?")){
			$("#reparacion").hide();
			$("#catalogo").hide();
			
			$.ajax({
				async:true,
				type: "POST",
				dataType: "html",
				contentType: "application/x-www-form-urlencoded",
				url:"r2.php",
				data:url,
				beforeSend:function(){ 
					$("#guardar").show().html('<div align=center>Procesando datos, espere un momento.</div>'); 
				},
				success:function(datos){ 
					$("#guardar").show().html(datos); 
				},
				timeout:90000000,
				error:function() { $("#guardar").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
			});		
		}
	}
	
	function faltan_datos(){
		alert("Error: Faltan datos. Por favor capture: \n1. Un Status diferente del que se muestra en la ficha Datos de Reparacion (Status) \n2. Al menos el valor en la ficha Fallas Tecnicas. \n3. Al menos el valor en la ficha Refacciones Utilizadas. \n4. Al menos el valor en la ficha Reparaciones Efectuadas. \n");
		return;	
	}
	
	function llenar_campos(){
		//alert("llenar_campos");
		var idot=$("#hdn_idot").attr("value");
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"r2.php",
			data:"action=buscar_datos&ot="+idot,
			beforeSend:function(){ 
				$("#reingreso").show().html('<div align=center>Procesando datos, espere un momento.</div>'); 
			},
			success:function(datos){ $("#reingreso").show().html(datos); },
			timeout:90000000,
			error:function() { $("#reingreso").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});	
	}
</script>
</head>

<body>

<div id="div_productos">&nbsp;</div>
<div id="div_nuevo">
	<div class="div_nuevoA" id="div_nuevoA">&nbsp;Nuevo Diagn&oacute;stico.</div>
	<div class="div_nuevoC" id="div_nuevoC">&nbsp;</div>
	<div class="div_nuevoD" id="div_nuevoD">
		<br /><input type="button" value="Guardar" class="boton1" onclick="guardar()" />
		<br /><input type="button" value="Cancelar" onclick="cancelar()" class="boton1" />
	</div>
</div>


<div id="all">
	<!--<div id="reingreso">&nbsp;</div>//-->	
    <!--<div id="menu_superior">//-->
	</div>
	<br />
	<div id="catalogo">&nbsp;</div>	
	<div id="reparacion">&nbsp;</div>
	<div id="seleccion">&nbsp;</div>
	<div id="guardar">&nbsp;</div>	
    
</div>
</body>
</html>
