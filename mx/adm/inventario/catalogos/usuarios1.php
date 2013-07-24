<?php 
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,11);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Usuarios del Sistema</title>
  <script src="../../js/jquery.js" type="text/javascript"></script>
  <script type="text/javascript">
	//$(document).ready(accion('listar'));
	function accion(a)
	{
		  $.ajax({
		   async:true,
		   type: "POST",
		   dataType: "html",
		   contentType: "application/x-www-form-urlencoded",
		   url:"usuarios2.php",
		   data:"accion="+a,
		   beforeSend:function(){ 
				$("#contenido").show().html('<center><br><img src="../../img/loading2.gif"><br>Cargando pagina, espere un momento.</center>'); 
			},
		   success:function(datos){ $("#contenido").show().html(datos); },
		   timeout:90000000,
		   error:function() { $("#contenido").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		 }); 	
	}
	
	function validar_frm0()
	{
		//alert('Nuevo');
		var id_usuario=$("#id_usuario").attr("value");				if (validar_campo("Id del Usuario",id_usuario)) { /*OK*/ } else { return; }
		var f_alta=$("#f_alta").attr("value");						if (validar_campo("Fecha de alta",f_alta)) { /*OK*/ } else { return; }
		var usuario=$("#usuario").attr("value");					if (validar_campo("Usuario",usuario)) { /*OK*/ } else { return; }
		var password=$("#password").attr("value");					if (validar_campo("Password",password)) { /*OK*/ } else { return; }
		var password2=$("#password2").attr("value");				if (validar_campo("Repetir Password",password2)) { /*OK*/ } else { return; }
		
		
		var activo=$("#activo").attr("value");	
		var nivel_usuario=$("#nivel_usuario").attr("value");		if (validar_campo("Nivel de Usuario",nivel_usuario)) { /*OK*/ } else { return; }
		var grupo=$("#grupo").attr("value");						if (validar_campo("Grupo",grupo)) { /*OK*/ } else { return; }				
		var ip=$("#ip").attr("value");
		

		var dp_nombre=$("#dp_nombre").attr("value");				if (validar_campo("Nombre",dp_nombre)) { /*OK*/ } else { return; }
		var dp_apaterno=$("#dp_apaterno").attr("value");			if (validar_campo("Primer Apellido",dp_apaterno)) { /*OK*/ } else { return; }
		var dp_amaterno=$("#dp_amaterno").attr("value");			if (validar_campo("Segundo Apellido",dp_amaterno)) { } else { return; }
		var dp_email=$("#dp_email").attr("value");
		var dp_sexo=obtener_valor_sexo();							//if (validar_campo("Sexo",dp_sexo)) {  } else { return; } 
		var foto=$("#foto").attr("value");	

		var de_proyecto=$("#de_proyecto").attr("value");				//if (validar_campo("Area / Proyecto",de_proyecto)) {  } else { return; }
		var de_noempleadoiq=$("#de_noempleadoiq").attr("value");		/*if (validar_campo("No. de empleado IQ",de_noempleadoiq)) {  } else { return; }*/
		var de_puesto=$("#de_puesto").attr("value");					/*if (validar_campo("Puesto",de_puesto)) {  } else { return; }*/
		var de_jefe_inmediato=$("#de_jefe_inmediato").attr("value");	
		var de_tel_trabajo=$("#de_tel_trabajo").attr("value");			
		var obs=$("#obs").attr("value");
		
		//var cdc=$("#txt_almacenes").attr("value");				if (validar_campo("Almacenes Asociados",cdc)) {  } else { return; }
											
		if (password!==password2) { alert("Error: Las passwords son diferentes."); return; }
		if (isNaN(nivel_usuario)||nivel_usuario<=0) { alert("Error: El nivel_usuario debe ser un numero mayor a 0."); return; }
		
		var d="id_usuario="+id_usuario+"&f_alta="+f_alta+"&activo="+activo+"&nivel_usuario="+nivel_usuario+"&grupo="+grupo+"&ip="+ip;
		d+="&usuario="+usuario+"&password="+password+"&password2="+password2+"&dp_nombre="+dp_nombre+"&dp_apaterno="+dp_apaterno+"&dp_amaterno="+dp_amaterno;
		d+="&foto="+foto+"&dp_sexo="+dp_sexo+"&dp_email="+dp_email+"&de_proyecto="+de_proyecto+"&de_puesto="+de_puesto+"&de_tel_trabajo="+de_tel_trabajo;
		d+="&de_jefe_inmediato="+de_jefe_inmediato+"&de_noempleadoiq="+de_noempleadoiq+"&cambio_password=0&obs="+obs;
		//alert(d);

		if (confirm("¿Desea guardar el usuario?")){
		     //document.frm0.submit();
			 
			  $.ajax({
			   async:true,
			   type: "POST",
			   dataType: "html",
			   contentType: "application/x-www-form-urlencoded",
			   url:"usuarios2.php",
			   data:d,
			   beforeSend:function(){ 
					$("#contenido").show().html('<center><br><img src="../../img/loading2.gif"><br>Cargando pagina, espere un momento.</center>'); 
				},
			   success:function(datos){ $("#contenido").show().html(datos); },
			   timeout:90000000,
			   error:function() { $("#contenido").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
			 });
			 
		 }		
	}
	
	function validar_campo(campo,valor)
	{
		//alert("Campo: "+campo+"\nValor: "+valor);
		if (valor==""||valor=="undefined"||valor==null)
		{
			alert("Error: El campo: "+campo+" es obligatorio, por favor capture un valor.");
			return false;
		} else {
			// ok
			return true;
		}	
	}
	
	function obtener_valor_sexo(){
		for(var i=0; i <document.frm0.dp_sexo.length; i++){
			if(document.frm0.dp_sexo[i].checked){
				var valorSeleccionado = document.frm0.dp_sexo[i].value;
				if (valorSeleccionado==''||valorSeleccionado=='undefined'||valorSeleccionado==null)
				{ alert('El campo Sexo esta vacio.'); return; } else { /*ok*/ }
			}
		}
		//alert("Sexo: "+valorSeleccionado);
		return valorSeleccionado;
	}
	
	
	function obtenervalores1(a)
	{
		var claves="";
		if (document.getElementById("frm1"))
		{
			for (var i=0;i<document.frm1.elements.length;i++)
			{
				if (document.frm1.elements[i].type=="checkbox")
				{
					if (document.frm1.elements[i].checked)
					{
						//alert("Variable claves=["+claves+"]");
						if (claves=="")
							claves=claves+document.frm1.elements[i].value;
						else
							claves=claves+","+document.frm1.elements[i].value;
					}	
				}
			}
			//alert("Claves: "+claves);
		}
		if (claves==""||claves=='undefined') return;	
		if (a=="eliminar")
		{
			//alert("Eliminar: "+claves);
			if (confirm("¿Desea eliminar el/los usuario(s) seleccionado(s)?"))
			{
			  $.ajax({
			   async:true,
			   type: "POST",
			   dataType: "html",
			   contentType: "application/x-www-form-urlencoded",
			   url:"usuarios.php",
			   data:"accion=eliminar&ids="+claves,
			   beforeSend:function(){ 
					$("#contenido").show().html('<center><br><img src="../../img/loading2.gif"><br>Cargando pagina, espere un momento.</center>'); 
				},
			   success:function(datos){ $("#contenido").show().html(datos); },
			   timeout:90000000,
			   error:function() { $("#contenido").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
			 });
			} 			
		}
	}
	
	function ver_usuario(id_usuario)
	{
		  $.ajax({
		   async:true,
		   type: "POST",
		   dataType: "html",
		   contentType: "application/x-www-form-urlencoded",
		   url:"usuarios2.php",
		   data:"accion=ver_usuario&id_usuario="+id_usuario,
		   beforeSend:function(){ 
				$("#contenido").show().html('<center><br><img src="../../img/loading2.gif"><br>Cargando pagina, espere un momento.</center>'); 
			},
		   success:function(datos){ $("#contenido").show().html(datos); },
		   timeout:90000000,
		   error:function() { $("#contenido").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		 });
	}
	
	function muestra_almacenes()
	{
		//alert('Muestra almacenes');
		$("#contenido").hide();
		$.ajax({
		async:true,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url:"usuarios2.php",
		data:"accion=ver_almacenes",
		beforeSend:function(){ 
			$("#div_almacenes").show().html('<center><br><img src="../../img/loading2.gif"><br>Cargando pagina, espere un momento.</center>'); 
		},
		success:function(datos){ $("#div_almacenes").show().html(datos); },
		timeout:90000000,
		error:function() { $("#div_almacenes").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});		
	}
	function obtener_almacenes()
	{
		var claves4="";
		if (document.getElementById("frm4"))
		{
			for (var i=0;i<document.frm4.elements.length;i++)
			{
				if (document.frm4.elements[i].type=="checkbox")
				{
					if (document.frm4.elements[i].checked)
					{
						//alert("Variable claves=["+claves+"]");
						if (claves4=="")
							claves4=claves4+document.frm4.elements[i].value;
						else
							claves4=claves4+","+document.frm4.elements[i].value;
					}	
				}
			}
			//alert("Claves: "+claves4);
		}
		if (claves4==""||claves4=='undefined') return;		
		$("#txt_almacenes").attr("value",claves4);
		$("#div_almacenes").hide();
		$("#contenido").show();
	}
	function c_m(){ $("#mensajeX").hide();	}
	/*javascript:obtenervalores1('eliminar');*/	
  </script>	
	<style type="text/css">
		body,document{ margin:0px 0px 0px 0px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;}
		a:link{ text-decoration:none;}
		a:hover{ text-decoration:none; color:#FF0000;}
		a:visited{ text-decoration:none;}		
		#all { margin:0px 0px 0px 0px; }
			#titulo { text-align:center; padding:2px; font-size:16px; margin:10px 10px 10px 10px;  }
			#opciones { text-align:right; margin:1px 10px 2px 0px; }
			#contenido { text-align:left; margin:10px 10px 10px 0px; padding:10px 10px 10px 0px; }
			
		.txtoc { text-align:center; background-color:#FFFFFF; border: #CCCCCC 1px solid; height:17px;}	
		.txtoi { text-align:left; background-color:#FFFFFF; border: #333333 1px solid; height:17px;}
		.txtvi { text-align:left; background-color:#FFFFFF; border: #333333 1px dotted; height:17px;}
		
		.td1{ border-left:#efefef 1px solid; border-right:#efefef 1px solid;}
		.td1i{ border-left:#efefef 1px solid; }		
		.imgx { width:32px; height:32px;}
		/*.imgmediana{ width:50%; height:50%;}*/
		/*javascript:accion('nuevo');*/
		.cv { font-weight:bold; text-align:left; background-color:#EFEFEF; color: #666666; padding-left:5px; }				
	</style>	  
</head>

<body onload="accion('listar')">

	<div id="all">
		<?php include("../menu/menu.php"); ?>
		<br />
		<div id="opciones">
			<a href="javascript:accion('listar');"><img src="../../img/businessmen.png" border="0" title="Listar Usuarios" class="imgx" /></a>&nbsp;
			<a href="javascript:accion('nuevo');"><img src="../../img/businessman_add.png" border="0" title="Agregar Usuario" class="imgx" /></a>&nbsp;
			<a href="#"><img src="../../img/businessman_delete.png" border="0" title="Eliminar Usuario" class="imgx" /></a> 
		</div>
		<div id="contenido">
			<center>&nbsp;</center>
		</div>
		<div id="div_almacenes" style="background-color:#FFFFFF; display:none;">&nbsp;</div>
        <?	include("../../f.php");	?>
	</div>
</body>
</html>
