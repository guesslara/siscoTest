<?php 
class movimientos{
	var $idm;
	var $id_tipo_mov; 					var $con_mov; 						var $fec_mov;
	var $id_asociado; 					var $cantidad; 						var $clave;
	var $descripcion; 					var $cu;							var $idalmacen;		var $tipo;
	var $almacen; 						var $asociado0;						var $id_p;			var $clavep;
	var $sql_prodxmov;					var $sistema_costeo; 	// 1=CP, 2=PEPS, 3=UEPS
	//=====================================================================================================================
	function __construct($idm,$id_producto,$cantidad,$clave,$cu)
	{
		//echo "<BR>VALORES RECIBIDOS: IDMOV=[$idm] Producto=[$id_producto] Cantidad=[$cantidad] Clave=[$clave] CU=[$cu]";
		$this->idm=$idm;
		$this->id_p=$id_producto;
		$this->cantidad=$cantidad;
		$this->clavep=$clave;
		$this->cu=$cu;		
		include ("../../conf/conectarbase.php");
		//$this->sistema_costeo=$sistema_costeoX;
		$this->sistema_costeo="PEPS";
		//echo "<br>".
		$sql1="SELECT mov_almacen.*,concepmov.id_concep,concepmov.concepto,concepmov.asociado as asociado0,concepmov.tipo FROM mov_almacen,concepmov WHERE mov_almacen.tipo_mov=concepmov.id_concep AND mov_almacen.id_mov='".$this->idm."'";
		$r1=mysql_query($sql1,$link);
		while ($ro1=mysql_fetch_array($r1))
		{
			//echo "<br>"; 			print_r($ro1); 				echo "<hr><br>";
			$this->id_tipo_mov=$ro1["tipo_mov"];
			$this->con_mov=trim($ro1["concepto"]);
			$this->id_almacen=$ro1["almacen"];
			$this->asociado0=$ro1["asociado0"];
			$this->id_asociado=$ro1["asociado"];
			$this->tipo=$ro1["tipo"];
			//echo "<br>TIPO MOV [".$this->id_tipo_mov."] CONCEPTO [".$this->con_mov."] ID ALMACEN [".$this->id_almacen."] ID ASOCIADO [".$this->id_asociado."] ASOCIADO 0 [".$this->asociado0."][]<BR>";
		}		
	}
	//=====================================================================================================================
	public function mueve_producto($sql_prodxmov)
	{
		//echo "<br>Recibo sentencia sql [".
		$this->sql_prodxmov=$sql_prodxmov;
		//echo "<br>Movimiento de (".$this->con_mov."): <br>Mov ($idm) Producto ($id_producto) Cantidad ($cantidad) Clave ($clave) CU ($cu)<br>"; 
		//if ($idm!==$this->idm) exit();
		if ($this->con_mov=="Recibo")
		{
			if ($resultado=$this->m_recibo())
			{
				echo "<li>El movimiento de Recibo del Producto (".$this->id_p.") se realizo correctamente.</li>";
				$this->m_validar_stock();
				$this->m_costeo();
				$this->m_inserta_producto();
				return true;
			} else {
				$this->error(1);
				return false;
			}
		}elseif($this->con_mov=="Traspaso"){
			include ("../../conf/conectarbase.php");
			//echo  "<br>Traspaso ***";
			if ($resultado=$this->m_traspaso())
			{
				echo "<li>El movimiento de Traspaso del Producto (".$this->id_p.") se realizo correctamente.</li>";
				/*
				echo "<br>Tipo Mov: ".$this->id_tipo_mov;
				echo "<br>Concep: ".$this->con_mov;
				echo "<br>Id Almacen".$this->id_almacen;
				echo "<br>Asociado".$this->asociado0;
				echo "<br>id Asociado".$this->id_asociado;
				echo "<br>tipo: ".$this->tipo;
				*/
				if($this->id_almacen==$this->id_asociado){
					//echo "<br>Se realiza el traspaso de la transferencia a la existencia";
					$campoExistencia="exist_".$this->id_almacen;
					$campoTransferencia="trans_".$this->id_almacen;
					$cantidad=$this->cantidad;
					$sqlExist="UPDATE catprod set $campoExistencia=($campoExistencia+$cantidad),$campoTransferencia=($campoTransferencia-$cantidad) WHERE id='".$this->id_p."'";
					$res=mysql_query($sqlExist,$link);
					if($res==false){
						echo "<br>Error al ejecutar el traspaso del Producto Indicado";	
					}
				}
				
				$this->m_validar_stock();
				$this->m_costeo();
				$this->m_inserta_producto();
				return true;
			} else {
				$this->error(2);
				return false;
			}			
		}elseif($this->con_mov=="Salida"){
			include ("../../conf/conectarbase.php");
			//echo  "<br>Salida";
			//print_r($this);
			if (!$this->m_validar_almacen_producto()) { $this->error(9); }  
			if (!$this->m_validar_existencias()) { $this->error(8); }  
			
			echo $sql_salida="UPDATE catprod SET exist_".$this->id_almacen."=exist_".$this->id_almacen."-".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";			
			if (mysql_db_query($sql_inv,$sql_salida)){
				echo "<li>El movimiento de Salida del Producto (".$this->id_p.") se realizo correctamente.</li>";
			} else {
				$this->error(0);
			} 
			$this->m_validar_stock();
			$this->m_inserta_producto();
			return true;
			
		}/*else if($this->con_mov=="Inventario Inicial"){
			
		}*/else{
			echo  "<br>Movimiento NO valido***";
			exit();
		}		
	}

	//=====================================================================================================================
	protected function m_recibo()
	{
		include ("../../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		$sql_venta="UPDATE catprod SET $c_eX=$c_eX+".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
		if (mysql_query($sql_venta,$link))
		{
			echo "<br><li>Se agrego la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").";
			return true;
		} else {
			$this->error(0);
			return false;
		}
	}
	//------------------------------------------------------------------------------------------------	
	protected function m_traspaso()
	{
		include ("../../conf/conectarbase.php");
		//echo "<hr>THiS-><br>";		print_r($this);		echo "<hr>";
		
		//echo "<hr>Movimiento de II Valores(Almacen [".$this->id_almacen."]  Producto [".$this->id_p."] Cantidad [".$this->cantidad."] Asociado0 [".$this->asociado0."])<hr><br>";
		$c_eX="exist_".$this->id_almacen;
		$c_e2="exist_".$this->id_asociado;
		//echo "<br>".
		$sql_ii="UPDATE catprod SET $c_eX=$c_eX-".$this->cantidad.",$c_e2=$c_e2+".$this->cantidad." WHERE id=".$this->id_p." LIMIT 1";
		
		if (mysql_query($sql_ii,$link))
		{
			echo "<br><li>Se agrego la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").</li>";
			return true;
		} else {
			$this->error(0);
			return false;
		}
		
	}
	//------------------------------------------------------------------------------------------------	
	protected function m_salida()
	{
		include ("../../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		//echo "<br>".
		$sql_dsv="UPDATE catprod SET $c_eX=$c_eX+".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
		if (mysql_db_query($sql_inv,$sql_dsv))
		{
			echo "<br><li>Se agrego la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").</li>";
			return true;
		} else {
			$this->error(0);
			return false;
		}
	}
	//=====================================================================================================================	
	protected function m_validar_almacen_producto()
	{
		include ("../../conf/conectarbase.php");
		//echo "<br>".
		$sql_vap0="SELECT almacen from tipoalmacen WHERE id_almacen='".$this->id_almacen."' LIMIT 1";
		$r_vap0=mysql_db_query($sql_inv,$sql_vap0);
		while ($ro_vap0=mysql_fetch_array($r_vap0))
		{
			$almacen=$ro_vap0["almacen"];
			$nc_almacen="a_".$this->id_almacen."_".$almacen;
		}
		//echo "<br>".
		$sql_vap1="SELECT $nc_almacen FROM catprod WHERE id=".$this->id_p." LIMIT 1";
		$r_vap1=mysql_db_query($sql_inv,$sql_vap1);
		while ($ro_vap1=mysql_fetch_array($r_vap1)){
			$almacen_asociado=trim($ro_vap1["$nc_almacen"]);
		}		
		if ($almacen_asociado==1) return true; else return false;
	}
	//------------------------------------------------------------------------------------------------		
	protected function m_validar_existencias()
	{
		include ("../../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		//echo "<br>".
		$sql_vep="SELECT $c_eX from catprod WHERE id=".$this->id_p." LIMIT 1";
		$r_vep=mysql_db_query($sql_inv,$sql_vep);
		while ($ro_vep=mysql_fetch_array($r_vep))
		{
			$existencias=$ro_vep["$c_eX"];
		}			
		if ($existencias>=$this->cantidad) return true; else return false;
	}
	//------------------------------------------------------------------------------------------------		
	protected function m_validar_transferencias()
	{
		include ("../../conf/conectarbase.php");
		$c_tX="trans_".$this->id_almacen;
		//echo "<br>".
		$sql_vep="SELECT $c_tX from catprod WHERE id=".$this->id_p." LIMIT 1";
		$r_vep=mysql_db_query($sql_inv,$sql_vep);
		while ($ro_vep=mysql_fetch_array($r_vep))
		{
			$transferencias=$ro_vep["$c_tX"];
		}			
		if ($this->cantidad<=$transferencias) return true; else return false;
	}	
	//------------------------------------------------------------------------------------------------		
	protected function m_validar_stock()
	{
		include ("../../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		$sql_sto="SELECT $c_eX,stock_min,stock_max FROM catprod WHERE id=".$this->id_p." LIMIT 1";
		$r_sto=mysql_query($sql_sto,$link);
		while ($ro_sto=mysql_fetch_array($r_sto))
		{
			$exi=$ro_sto["$c_eX"];
			$smi=$ro_sto["stock_min"];
			$sma=$ro_sto["stock_max"];
			//echo "<br>Producto ".$this->id_p." existencias [$c_eX]=[$exi] Stock Min ($smi) Stock Max ($sma)";
		}			
		if ($exi<$smi) {
			echo "<b>&nbsp;Error 15: Las EXISTENCIAS ($exi) del producto (".$this->id_p.") son menores al STOCK MINIMO establecido ($smi).</b>";
		}
		if ($exi>$sma) {
			echo "<b>&nbsp;Error 16: Las EXISTENCIAS ($exi) del producto (".$this->id_p.") son mayores al STOCK MAXIMO establecido ($sma).</b>";
		}		
	}
	//------------------------------------------------------------------------------------------------		
	protected function m_inserta_producto(){
		include ("../../conf/conectarbase.php");
		//echo "<br>***...*** Insertar producto: [".$this->sql_prodxmov."]<br>";
		//exit();
		if (mysql_query($this->sql_prodxmov,$link)){
			echo "<li>El producto (".$this->id_p.") se agrego al movimiento (".$this->idm.") correctamente.</li>";
			?>
			<script language="javascript">
				//document.frm1.reset();
			</script>
			<?php
		} else {
			$this->error(19);
		}
	}
	//------------------------------------------------------------------------------------------------		
	protected function m_costeo()
	{
		/*
		include ("../../conf/conectarbase.php");
		echo $sql_registrar1="INSERT INTO prodxmov (nummov,id_prod,cantidad,existen,clave,cu,id,nseries) VALUES ('".$this->idm."','".$this->id_p."','".$this->cantidad."','$xe','".$this->clavep."','".$cus[$contador]."',NULL,'')";
		if (!mysql_db_query($sql_inv,$sql_registrar1))
		{
			$this->error(19);
		} else {
			echo "<li>El producto (".$this->id_p.") se agrego al movimiento (".$this->idm.") correctamente.</li>";
			?>
			<script language="javascript">
				//document.frm1.reset();
			</script>
			<?php
		}
		*/
		return true;
		/*
		$diferencia=$entradas[$contador]-$this->cantidad;
		echo "<br>".$sql_actualizar1="UPDATE prodxmov SET existen='$diferencia' WHERE id='".$id_prodxmov[0]."' ";
		if (!mysql_db_query($sql_inv,$sql_actualizar1))
		{
			echo "<br>Error SQL: No se inserto el registro ($sql_actualizar1).";
			exit();
		}
		//echo "<br>&nbsp;&nbsp; CANTIDAD DEPOSITADA [".$this->cantidad."], DIFERENCIA [$diferencia]= [".$entradas[$contador]."] - [".$this->cantidad."] ";					
		echo "</div>";
		return true;
		*/
	}	
	//=====================================================================================================================

	protected function error($n)
	{
		$errores=array();
			$errores[0]="&nbsp;Error 1: Las existencias del productos (".$this->id_p.") no se afectaron.";
			$errores[1]="&nbsp;Error 2: El Movimiento de Recibos NO se realizo.";
			$errores[2]="&nbsp;Error 3: El Movimiento de Traspaso NO se realizo.";
			$errores[3]="&nbsp;Error 4: El Movimiento de Devolucion sobre Ventas NO se realizo.";
			$errores[4]="&nbsp;Error 5: El Movimiento de Ajuste NO se realizo.";
			$errores[5]="&nbsp;Error 6: Las Transferencias del productos (".$this->id_p.") no se afectaron.";
			$errores[6]="&nbsp;Error 6: El Movimiento de Entrada x Traspaso NO se realizo.";
			$errores[7]="&nbsp;Error 7: El Movimiento de Cancelacion de Recibo NO se realizo.";
			$errores[8]="&nbsp;Error 8: Las Existencias del Producto (".$this->id_p.") son menores a la cantidad solicitada (".$this->cantidad.").";
			$errores[9]="&nbsp;Error 9: El producto (".$this->id_p.") NO esta asociado al Almacen (".$this->id_almacen.").";
			$errores[10]="&nbsp;Error 10: El Movimiento de Devoluci&oacute;n de Recibo NO se realizo.";
			$errores[11]="&nbsp;Error 11: El Movimiento de Ventas NO se realizo.";
			$errores[12]="&nbsp;Error 12: El Movimiento de Merma NO se realizo.";
			$errores[13]="&nbsp;Error 13: El Movimiento de Salida x Traspaso NO se realizo.";
			$errores[14]="&nbsp;Error 14: Las Transferencias del Producto (".$this->id_p.") son menores a la cantidad solicitada (".$this->cantidad.").";
			// 15 y 16 stock
			$errores[18]="&nbsp;Error 18: No se actualizo el COSTO PROMEDIO del Producto (".$this->id_p.").";
			$errores[19]="&nbsp;Error 19: El producto (".$this->id_p.") NO se agrego al movimiento (".$this->idm.").";
			$errores[20]="&nbsp;Error 20: No esta definido el sistema de costeo en el Almacen. Imposible continuar.";
			$errores[21]="&nbsp;Error 21: No hay resultados que mostrar del producto ".$this->id_p.".";
			$errores[22]="&nbsp;Error 22: No se actualizo las existencias en el movimiento.";
			//El producto (".$this->id_p.") se agrego al movimiento (".$this->idm.") correctamente.
		echo "<br>".$errores[$n];
		exit();
	}
}
?>