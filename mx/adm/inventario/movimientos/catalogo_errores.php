<?php 
	function errorX($n)
	{
		$errores=array();
			$errores[0]="&nbsp;Error 1: No se encontraron resultados.";
			$errores[1]="&nbsp;Error 2: Error del sistema: Error en la consulta (SQL) a la Base de Datos.";
			//$errores[2]="&nbsp;Error 3: El Movimiento de Inventario Inicial NO se realizo.");
		?>
		<script language="javascript">
			$("#all").css("background-image","url(../img/transparente.png)");
			//$("#all").hide();
		</script>
		<div class="mensaje1" id="mensaje1">
			<div class="cer_mov"><a href="javascript:cerrar('mensaje1');">X</a>&nbsp;</div>
			<div style="text-align:center; font-size:16px; font-weight:bold; margin-top:15px;"><img src="movimientos/Warning.png" />
				<br /><?=$errores[$n]?>
			</div>
		</div>
		<?php		
		//echo "<br>".$errores[$n];
		exit();
	}
	
	function mensaje($v)
	{
		if ($v==0)
		{
			?>
			<div class="mensaje1" id="mensaje1">
				<div class="cer_mov"><a href="javascript:cerrar('mensaje1');">X</a>&nbsp;</div>
				<div style="text-align:center; font-size:16px; font-weight:bold; margin-top:15px;"><img src="movimientos/Warning.png" /><br />No se encontraron resultados.</div>
			</div>
			<?php
			exit;
		}
	}	
		
?>