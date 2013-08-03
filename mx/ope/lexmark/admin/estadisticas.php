<?php
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,11);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Estad&iacute;sticas</title>
</head>
<link href="../../js/flot/examples/layout.css" rel="stylesheet" type="text/css"></link>
<script language="javascript" type="text/javascript" src="../../js/flot/jquery.js"></script>
<script language="javascript" type="text/javascript" src="../../js/flot/jquery.flot.js"></script>

<script language="javascript">
	$("document").ready(start);
	function start(){
		$("#all").show();
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"estadisticas2.php",
			data:"action=listar",
			beforeSend:function(){ 
				$("#contenido").show().html('<div align=center>Guardando datos, espere un momento.</div>'); 
			},
			success:function(datos){ $("#contenido").show().html(datos); },
			timeout:90000000,
			error:function() { $("#contenido").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});	
	}
	function ver_detalle(m){
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"estadisticas2.php",
			data:"action=ver_detalle&m="+m,
			beforeSend:function(){ 
				$("#detalle").show().html('<div align=center>Guardando datos, espere un momento.</div>'); 
			},
			success:function(datos){ $("#detalle").show().html(datos); },
			timeout:90000000,
			error:function() { $("#detalle").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});			
	}
	
</script>	
<style type="text/css">
	body{ margin:0px;}
	a:link{ text-decoration:none;}
	a:hover{ text-decoration:none; color:#F00;}
	a:visited{ text-decoration:none;}
	
	#all{ position:relative; width:800px; left:50%; margin-left:-400px; background-color:#FFF;}
		#menu{}
		#contenido{}
		#grafica{ display:none;}
		#pie{}
	
	
	.txt_numero{ text-align:right;}
</style>
<body>
<?php include("../menu/menu2.php"); ?>	
    <div id="all">
    	<div id="menu">&nbsp;	</div>
        <div id="contenido">&nbsp;</div>
        <div id="detalle">&nbsp;</div>
        <div id="grafica">
        	<div id="placeholder" style=" position:relative; width:600px; height:400px; left:50%; margin-left:-300px; "></div>  
        </div>
        <div id="pie"><?php include("../../f.php"); ?></div>
    </div>
    
    
    
<script language="javascript">
	function graficar_cantidad()	{
		$("#grafica").show();
		$(function () {
			var d1 =[[1, $("#1a").attr("value")], [2, $("#2a").attr("value")], [3, $("#3a").attr("value")], [4, $("#4a").attr("value")], [5, $("#5a").attr("value")]];
			$.plot($("#placeholder"),[	
				{
					data: d1, label: "#",
					bars: { show: true, }
				}
				],{ 
					xaxis: {
						ticks: [0, [1, "RECIBO"], [2, "REPARACION"], [3, "CALIDAD"], [4, "DESPACHO"], [5, "ENVIADOS"]]
					}
				}
			);
		});
	}
	function graficar_porcentaje()	{
		$("#grafica").show();
		$(function () {
			var d1 =[[1, $("#1b").attr("value")], [2, $("#2b").attr("value")], [3, $("#3b").attr("value")], [4, $("#4b").attr("value")], [5, $("#5b").attr("value")]];
			$.plot($("#placeholder"),[	
				{
					data: d1, label: "%",
					bars: { show: true, }
				}
				],{ 
					xaxis: {
						ticks: [0, [1, "RECIBO"], [2, "REPARACION"], [3, "CALIDAD"], [4, "DESPACHO"], [5, "ENVIADOS"]]
					}
				}
			);
		});
	}	
</script>    
    
    
    
</body>
</html>