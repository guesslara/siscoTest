<?php 
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,2);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Contactos del Sistema</title>



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

		   url:"contactos2.php",

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

		var id_contacto=$("#id_contacto").attr("value");				

		var activo=$("#activo").attr("value");					

		var f_alta=$("#f_alta").attr("value");					

		var categoria=$("#categoria").attr("value");					if (validar_campo("Categoria",categoria)) { /*OK*/ } else { return; }				

		var nombre=$("#nombre").attr("value");							if (validar_campo("Nombre(s)",nombre)) { /*OK*/ } else { return; }

		var apellidos=$("#apellidos").attr("value");					if (validar_campo("Apellidos",apellidos)) { /*OK*/ } else { return; }

		var tel_oficina=$("#tel_oficina").attr("value");				if (validar_campo("Tel. Oficina",tel_oficina)) { /*OK*/ } else { return; }

		var tel_particular=$("#tel_particular").attr("value");			if (validar_campo("Tel. Particular",tel_particular)) { /*OK*/ } else { return; }

		var fax=$("#fax").attr("value");								if (validar_campo("Fax",fax)) { /*OK*/ } else { return; }

		var email=$("#email").attr("value");							

		var organizacion=$("#organizacion").attr("value");				if (validar_campo("Organizacion",organizacion)) { /*OK*/ } else { return; }

		var obs=$("#obs").attr("value");									



		if (confirm("¿Desea guardar los datos del Contacto?"))

		{

			 var d="accion=guardar_contacto&id_contacto="+id_contacto+"&activo="+activo+"&f_alta="+f_alta+"&categoria="+categoria+"&nombre="+nombre+"&apellidos="+apellidos+"&tel_oficina="+tel_oficina+"&tel_particular="+tel_particular+"&fax="+fax+"&email="+email+"&organizacion="+organizacion+"&obs="+obs;

			 //alert(d);

			  $.ajax({

			   async:true,

			   type: "POST",

			   dataType: "html",

			   contentType: "application/x-www-form-urlencoded",

			   url:"contactos2.php",

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

		if (valor==""||valor=="undefined")

		{

			alert("Error: El campo: "+campo+" es obligatorio, por favor capture un valor.");

			return false;

		} else {

			// ok

			return true;

		}	

	}

	

	function ver_contacto(id_contacto)

	{

	  $.ajax({

	   async:true,

	   type: "POST",

	   dataType: "html",

	   contentType: "application/x-www-form-urlencoded",

	   url:"contactos2.php",

	   data:"accion=ver_contacto&id_contacto="+id_contacto,

	   beforeSend:function(){ 

			$("#contenido").show().html('<center><br><img src="../../img/loading2.gif"><br>Cargando pagina, espere un momento.</center>'); 

		},

	   success:function(datos){ $("#contenido").show().html(datos); },

	   timeout:90000000,

	   error:function() { $("#contenido").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }

	 });	

	}	

	

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

		.txtoi { text-align:left; background-color:#FFFFFF; border: #CCCCCC 1px solid; height:17px;}

		.txtvi { text-align:left; background-color:#FFFFFF; border: #CCCCCC 1px dotted; height:17px;}

		

		.td1{ border-left:#efefef 1px solid; border-right:#efefef 1px solid;}

		.td1i{ border-left:#efefef 1px solid; }		

		img { width:32px; height:32px;}

		

		.cv { font-weight:bold; text-align:left; background-color:#EFEFEF; color: #666666; padding-left:5px; }		

	</style>	  

</head>



<body onload="accion('listar')">
	<? include("../menu/menu.php"); ?>
	<div id="all">
		<br />
		<div id="opciones">
			<a href="javascript:accion('listar');">Listar</a> | 
			<a href="javascript:accion('nuevo');">Nuevo Contacto </a>&nbsp;
		</div>
		<div id="contenido">
			<center>&nbsp;</center>
		</div>
	</div>
	<?	include("../../f.php");	?>
</body>

</html>

