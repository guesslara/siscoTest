<?
//print_r($_GET);
	include("../../includes/cabecera.php");
	$noform=$_GET['noFormato'];
	$idLote=$_GET['idLote'];
	$nc=$_GET['cab'];
	include("../mod_formatos/nuevo$idLote.php");
	$divNom=explode("_",$nombre);
	if($noform=="IQF0750305" || $noform=="IQF0750307" || $noform=="IQF0750311" || $noform=="IQF0750317" || $noform=="IQF0750318" || $noform=="IQF0750321"){
		$w="24.9cm";
		$h="18.5cm";
		if($divNom[3]==0){
			$hc=18.5-3;
			$hp=0;
		}else{
			$hc=18.5-5;
			$hp=2;
		}
	}else{
		$w="18.5cm";
		$h="24.9cm";
		if($divNom[3]==0){
			$hc=24.9-3;
			$hp=0;
		}else if($divNom[3]==2){
			$hc=24.9-6;
			$hp=3;
		}else{
			$hc=24.9-5;
			$hp=2;
		}
	}
?>
<script type="text/javascript" src="js/funcionesEnsamble.js"></script>
<link rel="stylesheet" type="text/css" href="css/hojaCentrado.css" />
<link rel="stylesheet" type="text/css" href="css/estilos.css" />
<link rel="stylesheet" type="text/css" href="css/hojaCentradoPrint.css" media="print"/>
<script type="text/javascript" src="../../clases/jquery-1.3.2.min.js"></script>
<script type="text/javascript">
	var op=<?=$divNom[3];?>;
	ajaxApp("cabecera","Encabezados/cabecera<?=$nc;?>.php","nomfor=<?=$divNom[1];?>&clave=<?=$noform;?>","POST");
	ajaxApp("cuerpo","Cuerpos/<?=$noform;?>.php","pagAct=1&intervalo=0&totalpag=0&idLote=<?=$idLote;?>","POST");
	if (op!="0"){
		ajaxApp("pie","Pies/pie<?=$divNom[3];?>.php","","POST");
	}
</script>
<?

?>
<div id="contenedorEnsamble">
	<div id="pag">
		<div id="paginador" style="display: none; height: 25px; width: 100%; background: #f0f0f0; text-align: center;">
			<div id="ant" style="display: none; float: left; margin-left: 100px;" onclick="att('<?=$noform;?>')">anterior<<</div>
			<div id="sig" style="float: right; margin-right: 100px;" onclick="add('<?=$noform;?>')">siguiente>></div>
		</div>
			<div id="hoja" style="width:<?=$w;?>;height:<?=$h?>;">
				<div id="cabecera">
				</div>
				<div id="cuerpo" style="height:<?=$hc;?>cm;">
				</div>
				<div id="pie" style="height: <?=$hp;?>cm;">
				</div>
			</div>
	</div>
</div>

<?
include ("../../includes/pie.php");
?>
