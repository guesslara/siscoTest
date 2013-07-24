<?php
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,2,3,11);
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reportes del Sistema de Inventarios IQ.</title>
    <script language="javascript" type="text/javascript" src="../../js/jquery.js"></script>
	<script language="javascript">
		function descripcion(t)
		{
			$("#div_des").html(t);
		}
	</script>
<style type="text/css">
	/*body,document { font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; background-color:#FFFFFF; }*/
	#all{ position:relative; width:800px; height:600px; left:50%; /*top:50%;*/ margin-left:-400px; margin-top:40px; border:#000000 1px solid; background-color:#FFFFFF; padding:0px; }
	a:link{ text-decoration:none;}
	a:hover{ text-decoration:none; color:#FF0000;}
	a:visited{ text-decoration:none;}
	
	
	#div1{ /*position:relative;*/ width:800px; height:600px; border:#000000 1px solid; background-color:#FFFFFF; padding:0px; }
	#div_tit1{ height:20px; text-align:center; font-weight:bold; background-color:#333333; color:#FFFFFF; padding-top:2px;}
	#div_adm{ position:relative; float:left; clear:left; width:250px; height:495px; margin:5px; border:#CCCCCC 1px solid; text-align:center; }
	#div_ope{ position:relative; float:left; clear:right; width:526px; height:495px; margin:5px; border:#CCCCCC 1px solid; text-align:justify; }
	#div_des{ position:relative; clear:both; height:60px; margin:5px; border:#CCCCCC 1px solid; text-align:justify; padding:2px; }
	#img1{ margin-top:150px; }
	.ulli li { margin:5px; text-align:left; font-size:12px; font-weight:normal;}
</style>
</head>

<body>
	<?php include("../menu/menu.php"); ?>
	<div id="all">
		<div id="div1">
			<div id="div_tit1">Reportes del Sistema de Inventarios IQ.</div>
			<div id="div_con1">
				<div id="div_adm"><img src="../../img/document.png" id="img1"/></div>
				<div id="div_ope">
					<br />
					<ul class="ulli">
					<li><a href="reporte_e_s.php" onmouseover="javascript:descripcion('Reporte que permite realizar un consulta de los <b>movimientos realizados en un rango de fechas determinado</b> por el usuario. Los resultados pueden mostrarse en el sistema o exportarse a Microsoft Excel para su edici&oacute;n personalizada.');" onmouseout="javascript:descripcion('');">Movimientos.</a> </li>
					</ul>
				</div>
				<div id="div_des"></div>
			</div>
			
		</div>
		
	</div>
	<?	include("../../f.php");	?>
</body>
</html>
