<?php
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,11,14);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Control de Calidad</title>
<link href="../../css/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	#control_calidad{position:relative; width:800px; left:50%; margin-left:-400px; margin-top:5px; }
	#div_reparacion{ z-index:3; position:relative; width:800px; left:50%; margin-left:-400px; border:#000000 2px solid; background-color:#CCCCCC;}
		#datos_producto{ margin:5px; background-color:#FFF; border:#000 1px solid;}
		#p_funcionales{ margin:5px; width:386px; height:300px; float:left; overflow:auto; background-color:#EFEFEF; border:#000 1px solid;}
			#div_pruebas_f_contenido{ padding:2px; border-top:#000 1px solid; overflow:auto; padding:2px; }
			#div_pruebas_e_contenido{ padding:2px; border-top:#000 1px solid; overflow:auto; padding:2px;}
		#p_esteticas{ margin:5px; width:386px; height:300px; float:left; overflow:auto; background-color:#EFEFEF; border:#000 1px solid;}
		#div_botones_cc{ margin:5px; background-color:#FFFFFF; border:#000 1px solid; text-align:center; padding:5px; }
	#resultados{ z-index:3; position:relative; width:800px; left:50%; margin-left:-400px; margin-top:10px; padding:2px;}	
		
	.tabla2{ border-bottom:#000000 2px solid;}
	.tabla_titulo2{text-align:center; font-size:14px; font-weight:bold; border-bottom:#000000 2px solid; }
	.tabla_campo2{text-align:left; font-weight:bold; }
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
			url:"control_calidad2.php",
			data:"action=listar",
			beforeSend:function(){ 
				$("#catalogo").show().html('<div align=center>Procesando datos, espere un momento.</div>'); 
			},
			success:function(datos){ $("#catalogo").show().html(datos); },
			timeout:90000000,
			error:function() { $("#catalogo").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});	
	}
	function revisar(id){
		//$("#catalogo").hide();
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"control_calidad2.php",
			data:"action=revisar&id_ot="+id,
			beforeSend:function(){ 
				$("#control_calidad").show().html('<div align=center>Procesando datos, espere un momento.</div>'); 
			},
			success:function(datos){ $("#control_calidad").show().html(datos); },
			timeout:90000000,
			error:function() { $("#control_calidad").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});	
		$("#tbl_calidad").hide();		
	}
	function guardar_control_calidad(){
		var idot=$("#hdn_idot").attr("value");
		var idp=$("#hdn_idp").attr("value");
		var nvo_status=$("#statusCalidad").attr("value");
		/*
			1. Si st es OK ()
				a) Revisa si fueron seleccionadas al menos una prueba funcional y estetica.
			2. Si st es NOK ()
			3. Si st es OKF ()
			4. Si st es PDC ()
		*/
		
		if (nvo_status==""||nvo_status=="undefined"||nvo_status==null){	alert("Error: Seleccione un status y presione Guardar.");	return;	}
		
		
		//Ontener valores de la PF.
		var id_pf="";
		for (var i=0;i<document.frm_pfuncionales.elements.length;i++){
			if (document.frm_pfuncionales.elements[i].type=="checkbox")
			{
				if (document.frm_pfuncionales.elements[i].checked)
				{
					//alert("Variable claves=["+claves+"]");
					if (id_pf=="")
						id_pf=id_pf+document.frm_pfuncionales.elements[i].value;
					else
						id_pf=id_pf+","+document.frm_pfuncionales.elements[i].value;
				}	
			}		
		}
		//Ontener valores de la PE.
		var id_pe="";
		for (var i2=0;i2<document.frm_pesteticas.elements.length;i2++){
			if (document.frm_pesteticas.elements[i2].type=="checkbox")
			{
				if (document.frm_pesteticas.elements[i2].checked)
				{
					//alert("Variable claves=["+claves+"]");
					if (id_pe=="")
						id_pe=id_pe+document.frm_pesteticas.elements[i2].value;
					else
						id_pe=id_pe+","+document.frm_pesteticas.elements[i2].value;
				}	
			}		
		}		
		if (nvo_status=="OK"&&(id_pf==""||id_pf=="undefined"||id_pf==null||id_pe==""||id_pe=="undefined"||id_pe==null)){ alert("Error: Seleccione al menos una Prueba Funcional y una Cosmetica y presione Guardar.");	return;}		

		var url="action=guardar_oc&idot="+idot+"&idp="+idp+"&nvo_status="+nvo_status+"&ids_pf="+id_pf+"&ids_pe="+id_pe;
		//alert(url);
		if (confirm("¿Desea guardar la evaluacion de Control de Calidad?")){
			$.ajax({
				async:true,
				type: "POST",
				dataType: "html",
				contentType: "application/x-www-form-urlencoded",
				url:"control_calidad2.php",
				data:url,
				beforeSend:function(){ 
					$("#resultados").show().html('<div align=center>Procesando datos, espere un momento.</div>'); 
				},
				success:function(datos){ $("#resultados").show().html(datos); },
				timeout:90000000,
				error:function() { $("#resultados").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
			});
		}
	}
</script>
</head>

<body>
<div id="all">
	
    <h2 align="center">Control de Calidad.</h2>
    <div id="catalogo">&nbsp;</div>
    <div id="control_calidad">&nbsp;</div>
    <div id="resultados">&nbsp;</div>
    
</div>
</body>
</html>