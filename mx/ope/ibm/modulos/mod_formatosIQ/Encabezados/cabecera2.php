<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<?
	//print_r($_POST);
	?>
<div id="enc" style="width:100%; height:100%">
	<table border=2 class="TabEN">
		<tr>
			<td rowspan=5>
				<img width=100 src="../../img/iqe.jpeg">
			</td>
			<td rowspan=2 colspan=2>
				<div style="width: 100%;">
					<div id="n" style="font-size:9px; float: left; width: 62%; text-align: right; margin-top: 2px;">
						REVISI&Oacute;N:
					</div>
					<div id="N" style="font-size:12px; font-weight:bold; float: left; width: 38%; text-align: left;">
						01
					</div>
				</div>
			</td>
			<td rowspan=2 colspan=2>
				<div style="width: 100%;">
					<div id="n" style="font-size:9px; float: left; width: 35%; margin-top: 2px; text-align: right;">
						CLAVE:
					</div>
					<div id="N" style="font-size:12px; font-weight:bold; float: left; width: 65%; text-align: left;">
						<div id="clave">
							<?=$_POST['clave'];?>
						</div>
					</div>
				</div>
			</td>
			<td rowspan=3 colspan=2>
				<div id="n" style="font-size:9px;">
					EMISI&Oacute;N:
				</div>
				<div id="N" style="font-size:12px; font-weight:bold;">
					23/10/09
				</div>
			</td>
		</tr>
		<tr></tr>
		<tr>
			<th rowspan=4 colspan=4><div id="nomD"><?=$_POST['nomfor'];?></div></th>
		</tr>
		<tr>
			<td rowspan=3 colspan=2>
				<div id="n" style="font-size:9px;">
					P&Aacute;GINA:
				</div>
				<div id="N" style="font-size:12px; font-weight:bold;">
					<div id="PAct" style="float: left; text-align: right; width: 45%">
						
					</div>
					<div style="float: left; text-align: center; width: 10%">
						/						
					</div>

					<div id="TotPa" style="float: left; text-align: left; width: 45%;">
						
					</div>
				</div>
			</td>
		</tr>

	</table>
</div>			