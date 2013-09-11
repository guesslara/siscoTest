<?
function conectarBd(){
	require("../../../includes/config.inc.php");
	$link=mysql_connect($host,$usuario,$pass);
	if($link==false){
		echo "Error en la conexion a la base de datos";
	}else{
		mysql_select_db($db);
		return $link;
	}				
}
//print_r($_POST);
$idL=$_POST['idLote'];
include("../../mod_formatos/nuevo$idL.php");
?>
<input type="hidden" id="idLote" name="idLote" value="<?=$idL;?>"/><?
$paginasT=$_POST['totalpag'];
$intervalo=$_POST['intervalo'];
$pagAct=$_POST['pagAct'];
$pag=16;//pag es el limite de registros
$lim=$pag+$intervalo;
if($intervalo==0){
	?><script>
		$("#ant").hide();
	</script><?
}
if($paginasT==$pagAct){
	?><script>
		$("#sig").hide();
	</script><?
}
if($paginasT==0 && $intervalo==0){
	$CON="SELECT * FROM CAT_rootCause";
	$exeCon=mysql_query($CON,conectarBd());
	$noReg=mysql_num_rows($exeCon);
	if($noReg>$pag){
		$paginasT=(intval($noReg/$pag));
		//echo"pag= $paginasT";
		?>
		<input type="hidden" id="pagAct" name="pagAct" value="<?=$pagAct;?>"/>
		<input type="hidden" id="limite" name="limite" value="<?=$lim;?>"/>
		<input type="hidden" id="tp" name="tp" value="<?=$paginasT;?>"/>
		<script>
			$("#paginador").show();
			$("#PAct").html("<?=$pagAct;?>");
			$("#TotPa").html("<?=$paginasT;?>")
		</script><?
		$CON="SELECT * FROM CAT_rootCause limit 0,16";
		$exeCon=mysql_query($CON,conectarBd());
	}else{
		?><script>
			$("#PAct").html("1");
			$("#TotPa").html("1")
		</script><?
	}
}else{
	$CON="SELECT * FROM CAT_rootCause limit ".$intervalo.",16";
	$exeCon=mysql_query($CON,conectarBd());
	$noReg=mysql_num_rows($exeCon);
	?>
	<input type="hidden" id="pagAct" name="pagAct" value="<?=$pagAct;?>"/>
	<input type="hidden" id="limite" name="limite" value="<?=$lim;?>"/>
	<input type="hidden" id="tp" name="tp" value="<?=$paginasT;?>"/>
	<script>
		//$("#paginador").show();
		$("#PAct").html("<?=$pagAct;?>");
		//$("#TotPa").html("<?=$paginasT;?>")
	</script><?
}	
$i=($intervalo)+1;
$capC=1;
//print($noReg);
?>
<div id="cont" style="margin-top: 10px;">
	<input type="hidden" id="limreg" name="limreg" value="<?=$pag;?>"/>
<?
	if($noReg==0){
		echo"<p style='text-align:center;text-width:bold;'>Actualmente no hay registros</p>";
	}else{
?>
	<div style="width:100%;heigth:20px;text-align:justify;font-weight:bold;clear:bold;font-size:15px;">
		2.-C&Oacute;DIGOS DE FALLA:
	</div>
	<div id="tablaRoot" style="width:100%;float:left; height:90%;background:#fff;margin-top:0px;">
		<table class="tabRoot">
				<tr>
					<th>Root Cause Code</th>
					<th>Code Descripcio&oacute;n</th>
				</tr>
<?
					while($rowDe=mysql_fetch_array($exeCon)){					    
?>
						<tr>
							<td><?=$rowDe[''];?></td>
							<td><?=$rowDe['']?></td>
		
						</tr>
<?
						$i++;
					}
				if($noReg<$pag){
			    	for($v=$i;$v<=$lim;$v++){
?>
					    <tr>
					    	<td>&nbsp;</td>
					    	<td>&nbsp;</td>
					    </tr>
<?
					}
				}
?>
			</table>
		</div>
<?
	}
?>
</div>