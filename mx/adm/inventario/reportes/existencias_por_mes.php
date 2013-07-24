<?php 
	session_start();
	//print_r($_SESSION);
	include("../../conf/conectarbase.php");
  	if ($_GET["idp"]) {
		$idp=$_GET["idp"];
		
		$meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$lista_campos=" `id`,`stock_min`, `stock_max`";	
			$sql="SELECT $lista_campos FROM catprod WHERE id= '$idp'";
			$result=mysql_db_query($sql_inv,$sql);
			$row=mysql_fetch_array($result);
			$st_min=$row["stock_min"];
			$st_max=$row["stock_max"];	
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Comportamiento del Producto <?=$idp?> en el a&ntilde;o <?=date("Y")?></title>
<style type="text/css">
	body,document{ margin:0px 0px 0px 0px; font-family:Verdana, Arial, Helvetica, sans-serif;}
	a:link{ text-decoration:none;}
	a:hover{ text-decoration:none; color:#FF0000;}
	a:visited{ text-decoration:none;}
		
	#opciones{ text-align:right; margin:0px 0px 0px 0px; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif;}
	#div1{ text-align:center;}
	.txt1 { border:#CCCCCC 1px solid; background-color:#FFFFFF; text-align:right;} 
	.graficar{border: #666666 1px solid; padding:2px; font-weight:bold; margin:2px; text-decoration:none; background-color:#EFEFEF;}
	
	#datos{ position:relative; width:800px; height:350px; left:50%; margin-left:-400px; margin-bottom:5px; border:#EFEFEF 1px solid; }
	#grafica{ position:relative; width:800px;height:500px; left:50%; margin-left:-400px; border:#EFEFEF 1px solid; }
	
	
</style>
    
    <link href="../../js/flot/examples/layout.css" rel="stylesheet" type="text/css"></link>
    <script language="javascript" type="text/javascript" src="../../js/flot/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="../../js/flot/jquery.flot.js"></script>
</head>

<body>
<?php 
	if ($_SESSION['sistema']=='bd')		include('../menu/menu.php'); 
	if (!$_GET["idp"]) { 
		?>
		<br /><div align="center">
		<form name="frm1" method="GET" action="<?=$_SERVER['PHP_SELF']?>" style="margin:0px;">
		Introduzca el id del Producto <input type="text" name="idp" value="" /> &nbsp; <input type="submit" value="Ver comportamiento" />
		</form>
		</div>
		<?php
		exit;
	} 
?>
<div id="opciones">
	<b>Ver: </b>
	<a href="javascript:ver('datos');  ocultar('grafica');">Datos</a> |
	<a href="javascript:ver('grafica');  ocultar('datos');">Gr&aacute;fica</a> |
	<a href="javascript:ver('grafica'); ver('datos');">Ambos</a>
	&nbsp;&nbsp;&nbsp;  
</div><br />

<div id="datos">
		<div id="grafica_titulo"><a href="javascript:ocultar('datos');" style=" width:25x; text-align:center; border:#EFEFEF 1px solid; background-color:#FFFFFF; color:#FF0000; font-weight:bold; padding:1px; margin-top:2px; margin-right:1px; float:right;">X</a></div>
<table width="600" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td height="28" colspan="5" style="text-align:center; font-weight:bold;">
		<a href="javascript:graficar();" class="" title="Graficar comportamiento del Producto.">Comportamiento del Producto <?=$idp?> en el a&ntilde;o <?=date("Y")?></a>	</td>
  </tr>
  <tr style="text-align:center; font-weight:bold; font-size:12px;">
    <td height="30">Mes </td>
    <td>Stocks (Min:Max) </td>
    <td><a href="javascript:graficarE();" class="" title="Graficar unicamente las Entradas.">Entradas</a></td>
    <td><a href="javascript:graficarS();" class="" title="Graficar unicamente las Salidas.">Salidas</a></td>
    <td><a href="javascript:graficarX();" class="" title="Graficar unicamente las Existencias.">Existencias</a></td>
  </tr>
  
  <?php 
  $cont=1; 
  $existencia_anterior=0;
  foreach ($meses as $mes) { 
  	$m=sprintf('%02s',$cont);
// ENTRADAS POR MES ...
$sql1="SELECT sum( prodxmov.cantidad ) AS suma_total_mensual_e
FROM mov_almacen, prodxmov, concepmov
WHERE mov_almacen.id_mov = prodxmov.nummov
AND prodxmov.id_prod =$idp
AND mov_almacen.tipo_mov = concepmov.id_concep
AND concepmov.tipo = 'Ent'
AND mov_almacen.fecha
BETWEEN '".date("Y")."-".$m."-01'
AND '".date("Y")."-".$m."-31'
ORDER BY mov_almacen.id_mov";
				$result1=mysql_db_query($sql_inv,$sql1);	
				$ndrx=mysql_num_rows($result1);
				//$suma=0;
				//$t_entb=0;
				while ($registro1=mysql_fetch_array($result1))
				{
					//echo "<br>ENTRADAS: ";
					//print_r($registro1);
					
					//echo "<br>SDE=".
					$sumaE=$registro1["suma_total_mensual_e"];
					if ($sumaE=="") $sumaE=0; 
					$t_ent+=$sumaE;
					/* $t_entb+=$suma; */
				}

// SALIDAS POR MES ...

//echo 
$sql1="SELECT sum( prodxmov.cantidad ) AS suma_total_mensual_s
FROM mov_almacen, prodxmov, concepmov
WHERE mov_almacen.id_mov = prodxmov.nummov
AND prodxmov.id_prod =$idp
AND mov_almacen.tipo_mov = concepmov.id_concep
AND concepmov.tipo = 'Sal'
AND mov_almacen.fecha
BETWEEN '".date("Y")."-".$m."-01'
AND '".date("Y")."-".$m."-31'
ORDER BY mov_almacen.id_mov";
				$result1=mysql_db_query($sql_inv,$sql1);	
				$ndrx=mysql_num_rows($result1);
				$suma=0;
				$t_entb=0;
				while ($registro1=mysql_fetch_array($result1))
				{
					//echo "<br>SALIDAS: ";
					//print_r($registro1);
					$sumaS=$registro1["suma_total_mensual_s"];
					if ($sumaS=="") $sumaS=0; 
					
					$t_sal+=$sumaS;
					/*
					$t_entb+=$suma;
					*/
				}
  $existencias_por_mes=($sumaE+$existencia_anterior)-$sumaS;
  
  ?>  
  <tr>
    <td><?=$mes?></td>
    <td align="center">
	<input type="text" name="A<?=$cont?>" id="A<?=$cont?>" value="<?=$st_min?>" size="5" class="txt1" readonly="1"> : <input type="text" name="B<?=$cont?>" id="B<?=$cont?>" value="<?=$st_max?>" size="5" class="txt1" readonly="1">	</td>
    <td align="right"><input type="text" name="C<?=$cont?>" id="C<?=$cont?>" value="<?=$sumaE?>" size="5" class="txt1" readonly="1"></td>
    <td align="right"><input type="text" name="D<?=$cont?>" id="D<?=$cont?>" value="<?=$sumaS?>" size="5" class="txt1" readonly="1"></td>
    <td align="right"><input type="text" name="E<?=$cont?>" id="E<?=$cont?>" value="<?=$existencias_por_mes?>" size="5" class="txt1" readonly="1"></td>
  </tr>
  <?php 
  $existencia_anterior=$existencias_por_mes;
  $cont++;
  } ?>
  
  <tr style="font-weight:bold; text-align:right; font-size:11px;">
    <td height="24" colspan="2"><a href="javascript:graficar_promedios();" title="Graficar las Entradas y Salidas Promedio">Total</a></td>
    <td align="right"><input type="text" name="txt_tea7" id="txt_tea7" readonly="1" size="10" class="txt1" style="font-weight:bold;" value="<?=$t_ent?>" /></td>
    <td align="right"><input type="text" name="txt_tsa7" id="txt_tsa7" readonly="1" size="10" class="txt1" style="font-weight:bold;" value="<?=$t_sal?>" /></td>
    <td align="right"><input type="text" name="txt_texa7" id="txt_texa7" readonly="1" size="10" class="txt1" style="font-weight:bold;" value="<?=$t_ent-$t_sal?>" /></td>
  </tr>
  <tr style="font-weight:bold; text-align:right; font-size:11px;">
    <td height="18" colspan="2">Promedio al mes de <?=$meses[(intval(date("m"))-1)]?> de <?=date("Y")?>&nbsp; </td>
    <td align="right"><input type="text" name="txt_pea7" id="txt_pea7" readonly="1" size="10" class="txt1" style="font-weight:bold;" value="<?=round($t_ent/intval(date("m")),2)?>" /></td>
    <td align="right"><input type="text" name="txt_psa7" id="txt_psa7" readonly="1" size="10" class="txt1" style="font-weight:bold;" value="<?=round($t_sal/intval(date("m")),2)?>" /></td>
    <td align="right">&nbsp;</td>
  </tr>    
</table>
</div>

	<div id="grafica">
		<div id="grafica_titulo"><span id="spa_tdg1" style="float:left; font-weight:bold; font-size:13px;">T&iacute;tulo de la Gr&aacute;fica.</span><a href="javascript:ocultar('grafica');" style="border:#EFEFEF 1px solid; background-color:#FFFFFF; color: #FF0000; font-weight:bold; padding:1px; margin-top:1px; margin-right:1px; float:right;">X</a></div>
		<br />
		<div id="placeholder" style=" position:relative; width:780px; height:460px; left:50%; margin-left:-390px; "></div>
	</div>	
<script language="javascript">
	function ver(d)	{ $("#"+d).show('slow'); }
	function ocultar(d) { $("#"+d).hide('slow'); }	
	function graficar()	{
		$("#grafica").show();
		$("#spa_tdg1").html('&nbsp;&nbsp;Comportamiento General del Producto.');
		var b="B";
		var c="C";		
		var d="D";
		var e="E";
		$(function () {
			var d1 =[[1, $("#A1").attr("value")], [2, $("#A2").attr("value")], [3, $("#A3").attr("value")], [4, $("#A4").attr("value")], [5, $("#A5").attr("value")], [6, $("#A6").attr("value")], [7, $("#A7").attr("value")], [8, $("#A8").attr("value")], [9, $("#A9").attr("value")], [10, $("#A10").attr("value")], [11, $("#A11").attr("value")], [12, $("#A12").attr("value")]];
			var d2 =[[1, $("#B1").attr("value")], [2, $("#B2").attr("value")], [3, $("#B3").attr("value")], [4, $("#B4").attr("value")], [5, $("#B5").attr("value")], [6, $("#B6").attr("value")], [7, $("#B7").attr("value")], [8, $("#"+b+8).attr("value")], [9, $("#"+b+9).attr("value")], [10, $("#"+b+10).attr("value")], [11, $("#"+b+11).attr("value")], [12, $("#"+b+12).attr("value")]];
			var d3 =[[1, $("#"+c+1).attr("value")], [2, $("#"+c+2).attr("value")], [3, $("#"+c+3).attr("value")], [4, $("#"+c+4).attr("value")], [5, $("#"+c+5).attr("value")], [6, $("#"+c+6).attr("value")], [7, $("#"+c+7).attr("value")], [8, $("#"+c+8).attr("value")], [9, $("#"+c+9).attr("value")], [10, $("#"+c+10).attr("value")], [11, $("#"+c+11).attr("value")], [12, $("#"+c+12).attr("value")]];
			var d4 =[[1, $("#"+d+1).attr("value")], [2, $("#"+d+2).attr("value")], [3, $("#"+d+3).attr("value")], [4, $("#"+d+4).attr("value")], [5, $("#"+d+5).attr("value")], [6, $("#"+d+6).attr("value")], [7, $("#"+d+7).attr("value")], [8, $("#"+d+8).attr("value")], [9, $("#"+d+9).attr("value")], [10, $("#"+d+10).attr("value")], [11, $("#"+d+11).attr("value")], [12, $("#"+d+12).attr("value")]];
			var d5 =[[1, $("#"+e+1).attr("value")], [2, $("#"+e+2).attr("value")], [3, $("#"+e+3).attr("value")], [4, $("#"+e+4).attr("value")], [5, $("#"+e+5).attr("value")], [6, $("#"+e+6).attr("value")], [7, $("#"+e+7).attr("value")], [8, $("#"+e+8).attr("value")], [9, $("#"+e+9).attr("value")], [10, $("#"+e+10).attr("value")], [11, $("#"+e+11).attr("value")], [12, $("#"+e+12).attr("value")]];
				$.plot($("#placeholder"), [
					{
						data: d1, label: "Stock Min.",
						lines: { show: true, },
						points: { show: true }
					},
					{
						data: d2, label: "Stock Max.",
						lines: { show: true, },
						points: { show: true }
					},
					{
						data: d4, label: "Salidas",
						lines: { show: true },
						points: { show: true }
					},
					{
						data: d3, label: "Entradas",
						lines: { show: true },
						points: { show: true }
					},
					{
						data: d5, label: "Existencias",
						lines: { show: true },
						points: { show: true}
					}
				],{ 
				xaxis: {
				ticks: [0, [1, "ENE"], [2, "FEB"], [3, "MAR"], [4, "ABR"], [5, "MAY"], [6, "JUN"], [7, "JUL"], [8, "AGO"], [9, "SEP"], [10, "OCT"], [11, "NOV"], [12, "DIC"]]
				}
			});
		});
	}		
	graficar();	

	function graficarE()
	{
		$("#grafica").show();
		$("#spa_tdg1").html('&nbsp;&nbsp;Entradas mensuales del Producto.');
		var b="B";
		var c="C";		
		$(function () {
			var d1 =[[1, $("#A1").attr("value")], [2, $("#A2").attr("value")], [3, $("#A3").attr("value")], [4, $("#A4").attr("value")], [5, $("#A5").attr("value")], [6, $("#A6").attr("value")], [7, $("#A7").attr("value")], [8, $("#A8").attr("value")], [9, $("#A9").attr("value")], [10, $("#A10").attr("value")], [11, $("#A11").attr("value")], [12, $("#A12").attr("value")]];
			var d2 =[[1, $("#B1").attr("value")], [2, $("#B2").attr("value")], [3, $("#B3").attr("value")], [4, $("#B4").attr("value")], [5, $("#B5").attr("value")], [6, $("#B6").attr("value")], [7, $("#B7").attr("value")], [8, $("#"+b+8).attr("value")], [9, $("#"+b+9).attr("value")], [10, $("#"+b+10).attr("value")], [11, $("#"+b+11).attr("value")], [12, $("#"+b+12).attr("value")]];
			var d3 =[[1, $("#"+c+1).attr("value")], [2, $("#"+c+2).attr("value")], [3, $("#"+c+3).attr("value")], [4, $("#"+c+4).attr("value")], [5, $("#"+c+5).attr("value")], [6, $("#"+c+6).attr("value")], [7, $("#"+c+7).attr("value")], [8, $("#"+c+8).attr("value")], [9, $("#"+c+9).attr("value")], [10, $("#"+c+10).attr("value")], [11, $("#"+c+11).attr("value")], [12, $("#"+c+12).attr("value")]];
				var tep=$("#txt_pea7").attr("value");
			var d4 =[[1, tep], [2, tep], [3, tep], [4, tep], [5, tep], [6, tep], [7, tep], [8, tep], [9, tep], [10, tep], [11, tep], [12, tep]];	
			
				$.plot($("#placeholder"), [
					{
						data: d1, label: "Stock Min.",
						lines: { show: true },
						points: { show: true }
					},
					{
						data: d2, label: "Stock Max.",
						lines: { show: true },
						points: { show: true }
					},
					{
						data: d3, label: "Entradas",
						lines: { show: true, fill:true },
						points: { show: true }
					},
					{
						data: d4, label: "Promedio de Entradas",
						lines: { show: true},
						points: { show: true }
					}
				],{ 
				xaxis: {
				ticks: [0, [1, "ENE"], [2, "FEB"], [3, "MAR"], [4, "ABR"], [5, "MAY"], [6, "JUN"], [7, "JUL"], [8, "AGO"], [9, "SEP"], [10, "OCT"], [11, "NOV"], [12, "DIC"]]
				}
			});
		});
	}
	function graficarS()
	{
		$("#grafica").show();
		$("#spa_tdg1").html('&nbsp;&nbsp;Salidas mensuales del Producto.');
		var b="B";
		var d="D";		
		$(function () {
			var d1 =[[1, $("#A1").attr("value")], [2, $("#A2").attr("value")], [3, $("#A3").attr("value")], [4, $("#A4").attr("value")], [5, $("#A5").attr("value")], [6, $("#A6").attr("value")], [7, $("#A7").attr("value")], [8, $("#A8").attr("value")], [9, $("#A9").attr("value")], [10, $("#A10").attr("value")], [11, $("#A11").attr("value")], [12, $("#A12").attr("value")]];
			var d2 =[[1, $("#B1").attr("value")], [2, $("#B2").attr("value")], [3, $("#B3").attr("value")], [4, $("#B4").attr("value")], [5, $("#B5").attr("value")], [6, $("#B6").attr("value")], [7, $("#B7").attr("value")], [8, $("#"+b+8).attr("value")], [9, $("#"+b+9).attr("value")], [10, $("#"+b+10).attr("value")], [11, $("#"+b+11).attr("value")], [12, $("#"+b+12).attr("value")]];
			var d4 =[[1, $("#"+d+1).attr("value")], [2, $("#"+d+2).attr("value")], [3, $("#"+d+3).attr("value")], [4, $("#"+d+4).attr("value")], [5, $("#"+d+5).attr("value")], [6, $("#"+d+6).attr("value")], [7, $("#"+d+7).attr("value")], [8, $("#"+d+8).attr("value")], [9, $("#"+d+9).attr("value")], [10, $("#"+d+10).attr("value")], [11, $("#"+d+11).attr("value")], [12, $("#"+d+12).attr("value")]];
				var tsp=$("#txt_psa7").attr("value");		//alert(tep+' '+tsp);
			var d7 =[[1, tsp], [2, tsp], [3, tsp], [4, tsp], [5, tsp], [6, tsp], [7, tsp], [8, tsp], [9, tsp], [10, tsp], [11, tsp], [12, tsp]];			
			
				$.plot($("#placeholder"), [
					{
						data: d1, label: "Stock Min.",
						lines: { show: true },
						points: { show: true }
					},
					{
						data: d2, label: "Stock Max.",
						lines: { show: true },
						points: { show: true }
					},
					{
						data: d4, label: "Salidas",
						lines: { show: true, fill:true },
						points: { show: true }
					},
					{
						data: d7, label: "Salidas Promedio",
						lines: { show: true },
						points: { show: true }
					}
				],{ 
				xaxis: {
				ticks: [0, [1, "ENE"], [2, "FEB"], [3, "MAR"], [4, "ABR"], [5, "MAY"], [6, "JUN"], [7, "JUL"], [8, "AGO"], [9, "SEP"], [10, "OCT"], [11, "NOV"], [12, "DIC"]]
				}
			});
		});
	}

	function graficarX()
	{
		$("#grafica").show();
		$("#spa_tdg1").html('&nbsp;&nbsp;Existencias mensuales del Producto.');
		var b="B";
		var e="E";		
		$(function () {
			var d1 =[[1, $("#A1").attr("value")], [2, $("#A2").attr("value")], [3, $("#A3").attr("value")], [4, $("#A4").attr("value")], [5, $("#A5").attr("value")], [6, $("#A6").attr("value")], [7, $("#A7").attr("value")], [8, $("#A8").attr("value")], [9, $("#A9").attr("value")], [10, $("#A10").attr("value")], [11, $("#A11").attr("value")], [12, $("#A12").attr("value")]];
			var d2 =[[1, $("#B1").attr("value")], [2, $("#B2").attr("value")], [3, $("#B3").attr("value")], [4, $("#B4").attr("value")], [5, $("#B5").attr("value")], [6, $("#B6").attr("value")], [7, $("#B7").attr("value")], [8, $("#"+b+8).attr("value")], [9, $("#"+b+9).attr("value")], [10, $("#"+b+10).attr("value")], [11, $("#"+b+11).attr("value")], [12, $("#"+b+12).attr("value")]];
			var d5 =[[1, $("#"+e+1).attr("value")], [2, $("#"+e+2).attr("value")], [3, $("#"+e+3).attr("value")], [4, $("#"+e+4).attr("value")], [5, $("#"+e+5).attr("value")], [6, $("#"+e+6).attr("value")], [7, $("#"+e+7).attr("value")], [8, $("#"+e+8).attr("value")], [9, $("#"+e+9).attr("value")], [10, $("#"+e+10).attr("value")], [11, $("#"+e+11).attr("value")], [12, $("#"+e+12).attr("value")]];
				$.plot($("#placeholder"), [
					{
						data: d1, label: "Stock Min.",
						lines: { show: true, },
						points: { show: true }
					},
					{
						data: d2, label: "Stock Max.",
						lines: { show: true, },
						points: { show: true }
					},
					{
						data: d5, label: "Existencias",
						lines: { show: true,fill:true },
						points: { show: true }
					}
				],{ 
				xaxis: {
				ticks: [0, [1, "ENE"], [2, "FEB"], [3, "MAR"], [4, "ABR"], [5, "MAY"], [6, "JUN"], [7, "JUL"], [8, "AGO"], [9, "SEP"], [10, "OCT"], [11, "NOV"], [12, "DIC"]]
				}
			});
		});
	}
	
	function graficar_promedios()
	{
		$("#grafica").show();
		$("#spa_tdg1").html('&nbsp;&nbsp;Entradas y Salidas Promedio mensuales del Producto.');
		var b="B";
		var c="C";		
		var d="D";
		var e="E";
		$(function () {
			var tep=$("#txt_pea7").attr("value");
			var tsp=$("#txt_psa7").attr("value");		//alert(tep+' '+tsp);
			var d1 =[[1, tep], [2, tep], [3, tep], [4, tep], [5, tep], [6, tep], [7, tep], [8, tep], [9, tep], [10, tep], [11, tep], [12, tep]];	
			var d2 =[[1, tsp], [2, tsp], [3, tsp], [4, tsp], [5, tsp], [6, tsp], [7, tsp], [8, tsp], [9, tsp], [10, tsp], [11, tsp], [12, tsp]];			
			
			var d3 =[[1, $("#"+c+1).attr("value")], [2, $("#"+c+2).attr("value")], [3, $("#"+c+3).attr("value")], [4, $("#"+c+4).attr("value")], [5, $("#"+c+5).attr("value")], [6, $("#"+c+6).attr("value")], [7, $("#"+c+7).attr("value")], [8, $("#"+c+8).attr("value")], [9, $("#"+c+9).attr("value")], [10, $("#"+c+10).attr("value")], [11, $("#"+c+11).attr("value")], [12, $("#"+c+12).attr("value")]];
			var d4 =[[1, $("#"+d+1).attr("value")], [2, $("#"+d+2).attr("value")], [3, $("#"+d+3).attr("value")], [4, $("#"+d+4).attr("value")], [5, $("#"+d+5).attr("value")], [6, $("#"+d+6).attr("value")], [7, $("#"+d+7).attr("value")], [8, $("#"+d+8).attr("value")], [9, $("#"+d+9).attr("value")], [10, $("#"+d+10).attr("value")], [11, $("#"+d+11).attr("value")], [12, $("#"+d+12).attr("value")]];
			var d5 =[[1, $("#"+e+1).attr("value")], [2, $("#"+e+2).attr("value")], [3, $("#"+e+3).attr("value")], [4, $("#"+e+4).attr("value")], [5, $("#"+e+5).attr("value")], [6, $("#"+e+6).attr("value")], [7, $("#"+e+7).attr("value")], [8, $("#"+e+8).attr("value")], [9, $("#"+e+9).attr("value")], [10, $("#"+e+10).attr("value")], [11, $("#"+e+11).attr("value")], [12, $("#"+e+12).attr("value")]];
			
				$.plot($("#placeholder"), [
					{
						data: d1, label: "Entradas promedio",
						lines: { show: true },
						points: { show: true }
					},
					{
						data: d2, label: "Salidas promedio",
						lines: { show: true },
						points: { show: true }
					},
					{
						data: d4, label: "Salidas",
						lines: { show: true },
						points: { show: true }
					},{
						data: d3, label: "Entradas",
						lines: { show: true },
						points: { show: true }
					}				
				],{ 
				xaxis: {
				ticks: [0, [1, "ENE"], [2, "FEB"], [3, "MAR"], [4, "ABR"], [5, "MAY"], [6, "JUN"], [7, "JUL"], [8, "AGO"], [9, "SEP"], [10, "OCT"], [11, "NOV"], [12, "DIC"]]
				}
			});
			
		});
	}	
	
	
//if ($.browser.mozilla) { alert('Estas usando el navegador: FireFox'); } 
if ($.browser.msie && $.browser.version >= 8) { alert('Estas usando el navegador: Internet Explorer. Le recomendamos utilice otro Navegador como: \n Firefox o Google Chrome para navegar sin contratiempos a traves de este sitio. \n(Puede descargarlos directamente de Internet o ponerse en contacto con el departamento de Sistemas IQ.)'); } 
</script>
<?php include("../f.php"); ?>
</body>
</html>