<?php
	include("../../conf/conectarbase.php");
	$color="#D9FFB3";

	$sql2="SELECT * FROM tipoalmacen";
	$result2=mysql_db_query($sql_inv,$sql2);
	$ndr2=mysql_num_rows($result2);	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte de Entradas y Salidas.</title>
<style type="text/css">
	body{ margin:0px; padding:0px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;}
	a:link{ text-decoration:none;}
	a:hover{ text-decoration:none; color:#FF0000;}
	a:visited{ text-decoration:none;}	
	.tda{ border-left:#CCCCCC 1px solid; border-right:#CCCCCC 1px solid;}
	.tdai{ border-left:#CCCCCC 1px solid; }
	.tdv{ border-right:#CCCCCC 1px solid; font-weight:bold; text-align:left; font-size:12px; }
	.tdv2{ text-align:left; }
	
	#div_principal{ display:none;}
	#div_tipo_movimiento{ text-align:center; }
	#div_fecha{ text-align:center; display:none; }
	#div_conceptos{ display:none; }
	#div_almacenes{ display:none; }
	.subtitulo1{ font-weight:bold; margin-bottom:5px;}
	#div_mensaje1{ display:none; position:relative; width:600px; left:50%; margin-left:-300px; border:#000000 2px solid; background-color:#FFFFCC; margin-bottom:5px; padding:3px;}
</style>
<script src="../../../../../clases/jquery.js" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" media="all" href="../../../../../recursos/Calendario/calendar-green.css" title="win2k-cold-1" /> 
  <script type="text/javascript" src="../../../../../recursos/Calendario/calendar.js"></script>
  <script type="text/javascript" src="../../../../../recursos/Calendario/calendar-es.js"></script>
  <script type="text/javascript" src="../../../../../recursos/Calendario/calendar-setup.js"></script>  
<script language="javascript">
	$(document).ready(start);
	function start()
	{ /* ........... */ }
	
	function coloca_es()
	{
		var tes=getRadioButtonSelectedValue(document.frm0.rad_es);	//alert("Opcion seleccionada: "+tes);
		if (tes==""||tes=="undefined"||tes==null) { alert("Seleccione el Tipo de Movimiento"); return; }
		$("#txt7_1").attr("value",tes);
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"reporte_e_s2.php",
			data:"accion=mostrar_conceptos&tes="+tes,
			beforeSend:function(){ 
				//$("#detalle").hide();
				$("#div_conceptos").show().html('<center><br><img src="../../../../../img/barra6.gif"><br>Procesando informacion, espere un momento.</center>');
			},
			success:function(datos){ 
				$("#div_conceptos").show().html(datos);
				$("#div_tipo_movimiento").hide();
			},
			timeout:9000000,
			error:function() { 
			   //$("#detalle").hide();
				$("#div_conceptos").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>');
			}
		}); 		
	}
	
	function coloca_conceptos()
	{
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
		if (claves1==""||claves1=='undefined') return;
		//alert("Claves: "+claves1);
		$("#txt7_2").attr("value",claves1);	
		$("#div_conceptos").hide();
		$("#div_almacenes").show();
	}

	function coloca_almacenes()
	{
		//alert("Coloca almacenes");
		var claves2="";
		for (var i=0;i<document.frm2.elements.length;i++)
		{
			//alert("i="+i);
			if (document.frm2.elements[i].type=="checkbox")
			{
				if (document.frm2.elements[i].checked)
				{
					//alert("Variable claves=["+claves3+"]");
					if (claves2=="")
						claves2=claves2+document.frm2.elements[i].value;
					else
						claves2=claves2+","+document.frm2.elements[i].value;
				}	
			}
		}
		if (claves2==""||claves2=='undefined'||claves2==null) return;
		//alert("Claves: "+claves2);
		$("#txt7_6").attr("value",claves2);	
		$("#div_almacenes").hide();
		$("#div_fecha").show();		
	}	
	
	function getRadioButtonSelectedValue(ctrl)
	{
		//alert("Recibo: "+ctrl);
		for(i=0;i<ctrl.length;i++)
		{
			if(ctrl[i].checked) 
			{
				return ctrl[i].value;
			}	
		}		
	}

	function coloca_fechas()
	{	
		var f1=$("#txt3_1").attr("value");
		var f2=$("#txt3_2").attr("value");
		$("#txt7_3").attr("value",f1);
		$("#txt7_4").attr("value",f2);
		realizar_descripcion();
		$("#div_fecha").hide();
		$("#div_principal").show();
	}

	function realizar_descripcion()
	{
		/* .......................... */
		var v1=$("#txt7_1").attr("value");
		var v2=$("#txt7_2").attr("value");
		var v3=$("#txt7_3").attr("value");
		var v4=$("#txt7_4").attr("value");
		var v5=$("#txt7_5").attr("value");
		var v6=$("#txt7_6").attr("value");

		var d="MOSTRAR LAS "+v1+" DE EL/LOS CONCEPTO(S) "+v2+" EN EL/LOS ALMACENE(S) "+v6+" ENTRE LAS FECHAS "+v3+" Y "+v4;
		$("#txt7_5").attr("value",d);
	}
		
	function realizar_consulta()
	{
		/* .......................... */
		var v1=$("#txt7_1").attr("value");
		var v2=$("#txt7_2").attr("value");
		var v3=$("#txt7_3").attr("value");
		var v4=$("#txt7_4").attr("value");
		var v5=$("#txt7_5").attr("value");
		var v6=$("#txt7_6").attr("value");
		var v7=getRadioButtonSelectedValue(document.frm7.rad_mos);	//alert("Opcion seleccionada: "+tes);
		var v8=$("#txt7_7").attr("value");
		var v9=getRadioButtonSelectedValue(document.frm7.rad_ascdes);   //$("#rad_ascdes").attr("value");
		var v10=$("#txt7_10").attr("value");
		//alert(v1+'\n'+v2+'\n'+v3+'\n'+v4+'\n'+v5+'\n'+v6+'\n'+v7+'\n'+v8+'\n'+v9);
		if (v1==''||v1=='undefined'||v1==null||v2==''||v2=='undefined'||v2==null||v3==''||v3=='undefined'||v3==null||v4==''||v4=='undefined'||v4==null||v5==''||v5=='undefined'||v5==null||v6==''||v6=='undefined'||v6==null||v7==''||v7=='undefined'||v7==null||v8==''||v8=='undefined'||v8==null||v9==''||v9=='undefined'||v9==null) return;
		//return;
		if (v7=='SISCO')
		{
			$.ajax({
				async:true,
				type: "POST",
				dataType: "html",
				contentType: "application/x-www-form-urlencoded",
				url:"reporte_e_s2.php",
				data:"accion=ejecutar&v1="+v1+"&v2="+v2+"&v3="+v3+"&v4="+v4+"&v5="+v5+"&v6="+v6+"&v7="+v7+"&v8="+v8+"&v9="+v9+"&v10="+v10,
				beforeSend:function(){ 
					//$("#div_principal").hide();
					$("#div_resultados").show().html('<center><br><img src="../../../../../img/barra6.gif"><br>Procesando informacion, espere un momento.</center>');
				},
				success:function(datos){ 
					$("#div_resultados").show().html(datos);
					//$("#div_principal").hide();
				},
				timeout:900000,
				error:function() { 
				    //$("#div_principal").hide();
					$("#div_resultados").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>');
				}
			});
		} else if (v7=='EXCEL') {
			location.href="reporte_e_s3.php?action=ejecutar&v1="+v1+"&v2="+v2+"&v3="+v3+"&v4="+v4+"&v5="+v5+"&v6="+v6+"&v7="+v7+"&v8="+v8+"&v9="+v9+"&v10="+v10;
		}	 		
	}
</script>
</head>
<body>
	<? include("../menu/menu.php"); ?>
	<h3 align="center">Reporte de Entradas y Salidas al Sistema IQ.</h3>
	<div id="div_opciones">&nbsp;</div>
	
	<div id="div_mensaje1">
		<p><a href="#" onclick="javascript:$('#div_mensaje1').hide('slow');" style="float:right;">Cerrar</a>
		<b>Ayuda.</b>	</p>
		<p>Esta p&aacute;gina permite realizar consultas a los movimientos de Entrada y Salida del Sistema de Inventarios IQ de manera personalizada. </p>
		<p>Instrucciones:     </p>
		<ol>
			<li>Seleccionar el tipo de Movimiento (E/S).</li>
			<li>Seleccionar el/los concepto(s)   correspondientes.</li>
			<li>Seleccionar el/los almacen(es) afectados.</li>
			<li>Determinar el rango de fechas de los Movimientos.</li>
			
			<li>Seleccionar el orden de los campos de la Consulta.</li>
			<li>Seleccionar si se desea que los resultados se muestren en la misma p&aacute;gina o en Excel.</li>
			<li>Dar clic en el bot&oacute;n &quot;Aceptar&quot; para ejecutar la consulta.</li>
		</ol>
	</div>
	
	
	<div id="div_tipo_movimiento">
		<div class="subtitulo1">Tipo de Movimiento:</div> 
		<form name="frm0" id="frm0">
			<label><input type="radio" name="rad_es" value="ENTRADAS" />Entradas</label>
			<label><input type="radio" name="rad_es" value="SALIDAS" />Salidas</label>
			&nbsp;&nbsp;
			<input type="button" value="Aceptar" onclick="coloca_es()" />
		</form>
	</div>
	<div id="div_conceptos">&nbsp;</div>
	
	<div id="div_almacenes">
	<form name="frm2" id="frm2">
	  <table width="600" align="center" cellspacing="0" style="border:#333333 2px solid; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
		<tr style="background-color:#333333; text-align:center; color:#FFFFFF; font-weight:bold;">
		  <td colspan="3" height="20"><?=$ndr2?> Almacenes</td>
		</tr>
		<tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
		  <td height="20">&nbsp;</td>
		  <td>Id</td>
		  <td>Almac&eacute;n</td>
		</tr>
		<? 	while($row2=mysql_fetch_array($result2)){ ?>
		<tr bgcolor="<?=$color?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'">
		  <td width="20">
		  <input type="checkbox" name="chb_alm_<?=$row2["id_almacen"]?>" id="chb_alm_<?=$row2["id_almacen"]?>" value="<?=$row2["id_almacen"]?>" />
		  </td>
		  <td align="center" width="41" class="tda"><?=$row2["id_almacen"]?></td>
		  <td width="529">&nbsp;<?=$row2["almacen"]?></td>
		</tr>
		<?	($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3"; 	} ?>
	  </table>
	  <br /><div align="center"><input type="button" value="Aceptar" onclick="coloca_almacenes()" /></div>
	</form>	
	</div>
	
	<div id="div_fecha">
		<form name="frm3" id="frm3">
		<div class="subtitulo1">Entre las fechas:</div>
		<input type="text" name="txt3_1" id="txt3_1" value="" readonly="1" /> y 
		<input type="text" name="txt3_2" id="txt3_2" value="" readonly="1" />
		&nbsp;&nbsp;<input type="button" value="Aceptar" onclick="coloca_fechas()" />
		</form>
		<script type="text/javascript">
			Calendar.setup({
				inputField     :    "txt3_1", // id del campo de texto
				ifFormat       :    "%Y-%m-%d", // formato de la fecha, cuando se escriba en el campo de texto
				button         :    "txt3_1" // el id del botón que lanzará el calendario
			});
		   Calendar.setup({
				inputField     :    "txt3_2", // id del campo de texto
				ifFormat       :    "%Y-%m-%d", // formato de la fecha, cuando se escriba en el campo de texto
				button         :    "txt3_2" // el id del botón que lanzará el calendario
			});	
		</script>		
	</div>
	<div id="div_principal">
		<form name="frm7" id="frm7">
			<table width="600" align="center" cellspacing="0" style="border:#333333 2px solid; font-size:12px;">
			<tr style="background-color:#333333; font-weight:bold; text-align:center; color:#FFFFFF;">
			  <td colspan="3" height="20" > Par&aacute;metros de la Consulta. </td>
			</tr>
			<tr style="background-color:#CCCCCC; text-align:center; font-weight:bold; color:#000000;">
			  <td height="20">Campo</td>
			  <td>Valor</td>
			  </tr>
			<tr >
			  <td height="20" class="tdv">Tipo de Movimiento: </td>
			  <td class="tdv2">&nbsp;<input type="text" name="txt7_1" id="txt7_1" value="" readonly="1" /></td>
			  </tr>
			<tr >
			  <td height="20" class="tdv">Conceptos:</td>
			  <td class="tdv2">&nbsp;<input type="text" name="txt7_2" id="txt7_2" value="" readonly="1" /></td>
			  </tr>
			<tr >
			  <td height="20" class="tdv">Almacenes:</td>
			  <td class="tdv2">&nbsp;<input type="text" name="txt7_6" id="txt7_6" value="" readonly="1" /></td>
			  </tr>
			<tr >
			  <td height="20" class="tdv">Id Asociado:</td>
			  <td class="tdv2">&nbsp;<input type="text" name="txt7_10" id="txt7_10" value="-" />
			  	<a href="#" style=" font-size:14px; color: #0000FF; font-weight:bold;" title="Id de Proveedor, Almacen, etc. seg&uacute;n corresponda. El Campo opcional y en caso de ser varios ids deben ir separados por comas (sin espacios).">  ?  </a> </td>
			  </tr>
			<tr >
			  <td height="20" class="tdv">Rango de fechas: </td>
			  <td class="tdv2">&nbsp;<input type="text" name="txt7_3" id="txt7_3" value="" readonly="1" /> 
			  	  y <input type="text" name="txt7_4" id="txt7_4" value="" readonly="1" />			  </td>
			  </tr>
			<tr >
			  <td height="20" class="tdv">Descripci&oacute;n:</td>
			  <td class="tdv2">&nbsp;<input type="text" name="txt7_5" id="txt7_5" value="" readonly="1" size="47" /></td>
			  </tr>
			<tr >
			  <td height="20" class="tdv">Ordernar por: </td>
			  <td class="tdv2">&nbsp;<select name="txt7_7" id="txt7_7">
			  	<option value="prodxmov.id" selected="selected">Id Item</option>
				<option value="mov_almacen.fecha">Fecha</option>
				<option value="mov_almacen.id_mov">Id Movimiento</option>
				<option value="mov_almacen.tipo_mov">Tipo de Movimiento</option>
				<option value="mov_almacen.almacen">Almacen</option>
				<option value="mov_almacen.asociado">Asociado</option>
				<option value="prodxmov.id_prod">Id Producto</option>
				<option value="prodxmov.clave">Clave del Producto</option>
				<option value="prodxmov.cantidad">Cantidad</option>
				<option value="prodxmov.cu">C.U.</option>
				<option value="subtotal">Subtotal</option>
			  </select>
				<label><input type="radio" name="rad_ascdes" value="ASC" checked="checked" />
				Ascendente </label>
				<label><input type="radio" name="rad_ascdes" value="DESC" />
				Descendente</label>			  </td>
			  </tr>
			<tr >
			  <td width="220" height="20" class="tdv">Mostrar en: </td>
			  <td width="372" class="tdv2">&nbsp;
				<label><input type="radio" name="rad_mos" value="SISCO" checked="checked" />
				Sisco IQe. </label>
				<label><input type="radio" name="rad_mos" value="EXCEL" />
				Excel</label>			  </td>
			  </tr>			
			<tr >
			  <td height="49" colspan="2" style="border-top:#CCCCCC 1px solid; text-align:center;">
			  	<input type="reset" value="limpiar" />
				<input type="button" value="Aceptar" onclick="realizar_consulta()" />			  </td>
			  </tr>
			</table>
		</form>
	</div>	
	<br />
	<div id="div_resultados">&nbsp;</div>

	<? include("../f.php"); ?>

</body>
</html>
