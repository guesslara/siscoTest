<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Nuevo Modo de Entradas (LEXMARK)</title>
<style type="text/css">
body,html,document{ position:absolute; width:100%; height:100%; margin:0px; padding:0px; background-color:#fff; color:#000;}
/*
#div_transparente{ position:fixed; width:100%; height:100%; margin:0px; padding:0px; z-index:2; background-image:url(../img/transparente.png); cursor:pointer; display:none; }
#div_ventana1 { position:absolute; width:600px; height:400px; left:50%; top:50%; margin-left:-300px; margin-top:-200px; z-index:3; background-color:#FFFFFF; border:#333333 1px solid; overflow:auto; display:none; }

#div_cc_main{ position:absolute; width:100%; height:100%;  margin:0px; padding:0px; background-color:#FFFFFF; font-family:Geneva, Arial, Helvetica, sans-serif; font-size:small; z-index:1; }
	#div_cc_A{ position:relative; width:100%; height:3%; background-image:url(../menu/jdmenu/gradient.png); font-size:11pt; text-align:center;  }
	#div_cc_B{ position:relative; width:100%; height:3%; background-color:#efefef;   text-align:center; }
	#div_cc_C{ position:relative; width:100%; height:93%; border-top:#CCCCCC 1px inset; }
	
*/
#A{ position:absolute; width:100%; height:100%;  margin:0px; padding:0px; background-color:#FFFFFF; font-family:Geneva, Arial, Helvetica, sans-serif; font-size:small; z-index:1; }


table{ border-left:#CCCCCC 1px solid; border-top:#CCCCCC 1px solid; background-color:#FFFFFF; }
td,th { font-size:small; border-right:#CCCCCC 1px solid; border-bottom:#CCCCCC 1px solid; }		
th{ background-color:#efefef; }
a{ text-decoration:none; color:#0033FF; }
h3{ text-align:center;}
	.boton{ 
	width:100px; height:25px; padding:2px; margin-top:5px; margin-bottom:5px; border:#cccccc 1px solid; 
	background-color:#efefef; font-weight:bold; text-align:center; text-decoration:none; color:#666666;
	}
	.boton:active{ 
	width:100px; height:25px; padding:2px; margin-top:5px; margin-bottom:5px; border:#cccccc 1px solid; 
	background-color:#efefef; font-weight:bold; text-align:center; text-decoration:none; color:#666666;
	}
	.boton:link{ 
	width:100px; height:25px; padding:2px; margin-top:5px; margin-bottom:5px; border:#cccccc 1px solid; 
	background-color:#efefef; font-weight:bold; text-align:center; text-decoration:none; color:#666666; 
	}
	.boton:hover{ 
	width:100px; height:25px; padding:2px; margin-top:5px; margin-bottom:5px; border:#cccccc 1px solid;
	background-color:#ffffff; font-weight:bold; text-align:center; text-decoration:none; color:#666666; 
	}	
	.boton:visited{ 
	width:100px; height:25px; padding:2px; margin-top:5px; margin-bottom:5px; border:#cccccc 1px solid;
	background-color:#efefef; font-weight:bold; text-align:center; text-decoration:none; color:#666666; 
	}


.txt_ndsX{ text-align:left; width:250px; }
#txt_cantidad{ text-align:right; width:100px;}

#div_transparente{ position:absolute; z-index:2; display:none; width:100%; height:100%; background-image:url(../../img/transparente.png);	}	
#div_calendario{ position:absolute; z-index:3; display:none; width:300px; height:320px; top:50%; left:50%; margin-left:-150px; margin-top:-160px; border:#999999 1px solid; background-color:#FFFFFF; font-size:10pt; }
	#div_calendario0{ text-align:center; font-weight:bold; padding:3px; font-size:12pt;}
	#div_calendario1{  margin-left:20px; height:260px; }
	#div_calendario2{ text-align:center;  font-size:8pt; }


#tbl_00 input { text-align:center; }


#div_frm1{ display:none; }
#div_frm2{ display:none; }
</style>
<link type="text/css" href="calendario/css/ui-lightness/css_calendario.css" rel="stylesheet" />
<script language="javascript" src="../../js/jquery.js"></script>

<script type="text/javascript" src="calendario/js/js_calendario.js"></script>


<script language="javascript">
$(document).ready(function(){ 
	//ajax('div_cc_C','ac=listar_CC');
	//alert("ok");
});
function ajax(capa,datos,ocultar_capa){
	if (!(ocultar_capa==""||ocultar_capa==undefined||ocultar_capa==null)) { $("#"+ocultar_capa).hide(); }
	var url="acciones.php";
	$.ajax({
		async:true, type: "POST", dataType: "html", contentType: "application/x-www-form-urlencoded",
		url:url, data:datos, 
		beforeSend:function(){ 
			$("#"+capa).show().html('<div align="center">Procesando, espere un momento.</div>'); 
		},
		success:function(datos){ 
			$("#"+capa).show().html(datos); 
		},
		timeout:999999,
		error:function() { $("#"+capa).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
	});
}
// ============================== FUNCIONES DE CALENDARIO =================================================
function fn_calendario(contenedor){
	//alert(contenedor); 
	$('#div_transparente').show();
	$('#div_calendario').show();
	fn_calendario_limpiar();
	$("#txt_fecha_campo_destino").attr("value",contenedor);
	$(function(){	
		$('#div_calendario1').datepicker({	 altField: '#txt_fecha_seleccionada'	});
		//alert("Hola"); 
	});
	
}
	function fn_calendario_limpiar(){
		$("#txt_fecha_campo_destino").attr("value","");
		$("#txt_fecha_seleccionada").attr("value","");
	}
	function fn_calendario_cancelar(){
		$('#div_transparente').hide();
		$('#div_calendario').hide();
	}
	function fn_calendario_aceptar(){
		var contenedor_destino=$("#txt_fecha_campo_destino").attr("value");
		var fecha_seleccionada=$("#txt_fecha_seleccionada").attr("value");
		if ((contenedor_destino==""||contenedor_destino==undefined||contenedor_destino==null||fecha_seleccionada==""||fecha_seleccionada==undefined||fecha_seleccionada==null)){
			return;
		}
		$('#div_transparente').hide();
		$('#div_calendario').hide();
		$("#"+contenedor_destino).attr("value",fecha_seleccionada);
	}
// ============================== FUNCIONES DE CALENDARIO =================================================

function teclaX(x,id_contador,mi_valor,elEvento){
	var evento = elEvento || window.event;
	var codigo = evento.charCode || evento.keyCode;
	if(x==1985&&codigo==13){
		//alert("<div>["+x+"]["+id_contador+"]["+mi_valor+"]</div>");
		if(mi_valor==''||mi_valor==' '||mi_valor==undefined||mi_valor==null) return; 
		
		var no_controles=$("#div_frm2 input:text").length;
		if(id_contador==no_controles){
			agregar_filaX();
		}else{
			// Enfoca siguiente campo
			var numero_siguiente=id_contador+1;			
			$("#txt_nds_"+numero_siguiente).focus();
			//alert("No es igual ... enfocar sig ("+numero_siguiente+")");			
		}
	}

}
function agregar_filaX(){
	//alert("Agregar fila");
	var no_controles=$("#div_frm2 input:text").length;
	var numero_ultimo=no_controles;
	var numero_siguiente=numero_ultimo+1;
	var mi_html='<tr align="center">';
		mi_html+='<td>'+numero_siguiente+'</td>';
		mi_html+='<td><input type="text" class="txt_ndsX" id="txt_nds_'+numero_siguiente+'" onKeyUp="teclaX(1985,'+numero_siguiente+',this.value,event)"></td>';
	mi_html+='</tr>';
	//alert(mi_html);
	$("#tbl_02").append(mi_html);
	
	// Enfoca siguiente campo
	$("#txt_nds_"+numero_siguiente).focus();
}
//$("#btn_02").click(function (){ alert("Guardar no_equipos"); });



function dame_cantidad(){
	//alert("Guardar no_equipos");
	var no_controles=$("#div_frm2 input:text").length;
	var no_valores_validos=0;
	var valorX;
	for(var i=0;i<no_controles;i++){
		//$("#div_frm2 input:text").
		valorX=$("#div_frm2 input:text")[i].value;
		if(valorX==''||valorX==' '||valorX==undefined||valorX==null){
			// Esta vacio, NO incluir
		}else{
			++no_valores_validos;
		}
		//alert(valorX);
	}
	if(no_valores_validos<=0) return;
	$("#txt_cantidad").val(no_valores_validos);
	$("#btn_01").show();
	$("#btn_02").hide();
}
// ===============================================================================================
function Crear_Movimiento(){
	$("#txt_0").attr("disabled","disabled");
	$("#txt_1").attr("disabled","disabled");
	$("#sel_almacen").attr("disabled","disabled");
	$("#sel_asociado").attr("disabled","disabled");
	
	$("#txt_4").attr("disabled","disabled");
	$("#txt_5").attr("disabled","disabled");
	$("#btn_1").hide();
	
	$("#div_frm1").show();
	
}
function muestra_grid(){
	limpiar_grid();
	$("#txt_cantidad").val(0);
	
	$("#div_frm2").show();
	$("#btn_01").hide();
	$("#btn_02").show();	
}
function limpiar_grid(){
	var no_controles=$("#div_frm2 input:text").length;
	for(var i=0;i<no_controles;i++){
		$("#div_frm2 input:text")[i].value='';
	}
	$("#div_frm2 input:text")[0].focus();
}
function inhabilitar_grid(){
	var no_controles=$("#div_frm2 input:text").length;
	for(var i=0;i<no_controles;i++){
		$("#div_frm2 input:text")[i].attr("disabled","disabled");
	}
}

function guardar_items(){
	var numero_movimiento=1000;
	var tipo_movimiento=1;
	var id_almacen=$("#").val();
	var fecha=$("#").val();
	var id_cliente=$("#").val();
	var referencia=$("#").val();
	var obs=$("#").val();
	
	var id_modelo=$("#sel_modelo").val();
	var cantidad=$("#").val();
	
	var numeros_serie=dame_numeros_serie();
	
	var datos = "ac=guardar_items&numero_movimiento="+numero_movimiento+"&numeros_serie="+numeros_serie;
	if (confirm(" ¿ Desea guardar los datos ? ")) ajax('div_frm3',datos);
	//alert(datos);
}
function dame_numeros_serie(){
	var no_controles=$("#div_frm2 input:text").length;
	var no_valores_validos=0;
	var m_nds=new Array();
	var valorX;
	for(var i=0;i<no_controles;i++){
		valorX=$("#div_frm2 input:text")[i].value;
		if(valorX==''||valorX==' '||valorX==undefined||valorX==null){
			// Esta vacio, NO incluir
		}else{
			++no_valores_validos;
			m_nds.push(valorX);
		}
	}
	return m_nds;
}

</script>
</head>

<body>
<div id="div_transparente" onclick="$('#div_transparente').hide()"></div>
<div id="div_calendario">
	<div id="div_calendario0">Calendario</div>
	<div id="div_calendario1"></div>
	<div id="div_calendario2">
		Fecha:
		<input type="hidden" id="txt_fecha_campo_destino" />
		<input type="text" id="txt_fecha_seleccionada" readonly="1"  style="width:90px; text-align:center; font-size:10pt; font-weight:bold; border:none; " />
		&nbsp;
		<a href="#" onclick="fn_calendario_aceptar()" class="boton">&nbsp;Aceptar&nbsp;</a>&nbsp;<a href="#" onclick="fn_calendario_cancelar()" class="boton">&nbsp;Cancelar&nbsp;</a>	
	</div>
</div>


<div id="A">
	<div id="A1">Nuevo Modo de Entradas (LEXMARK)</div>
	<div id="A2">
		<a href="#" onclick="ajax('A3','ac=movimiento_nuevo')">nuevo</a>
		<a href="#" onclick="dame_numero_cajas()">ndc</a>
	</div>
	<div id="A3"></div>
</div>

</body>
</html>
