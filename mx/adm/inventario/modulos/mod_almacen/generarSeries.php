<?
	//print_r($_GET);
	$idmov=$_GET['numMov'];
	series($idmov);
	
	function series($idmov){
		set_time_limit(100000);
		$sGen=0;
		$err=0;
		include("../../conf/conectarbase.php");		
		//se consulta si ya se generaron los numeros de serie
		//echo "<br>".
		$sqlGen="select seriesGen from mov_almacen where id_mov='".$idmov."'";
		
		$resGen=mysql_db_query($sql_inv,$sqlGen);
		$rowGen=mysql_fetch_array($resGen);
		
		if($rowGen['seriesGen']=="No Generado"){
			//echo "<br>".
			$sql11="SELECT * FROM prodxmov WHERE nummov='$idmov'";
			$result11=mysql_db_query($sql_inv,$sql11);
			$row=mysql_fetch_array($result11);
			do{
				$ca=$row['cantidad'];
				$clv=$row['clave'];
				for ($j = 1; $j <= $ca; $j++) {
					$con=sprintf('%04s',$j);
					$serie=substr($clv,0,17).date('ymd').$con;
					echo "<br>".$sql4="INSERT INTO num_series (serie,clave_prod,mov) values	('$serie','$clv','$idmov')";
					
					
					$res=mysql_db_query($sql_inv,$sql4);
					
					if($res==true){
						$sGen+=1;	
					}else{
						$err+=1;
					}
					
					
				}
				echo "<br>---------------------------------------------------<br>";
				echo "Se han Generado: ".$sGen." numero(s) de serie.<br>";
				echo "Errores Notificados: ".$err."<br>";
				echo "<br>---------------------------------------------------<br>";
				$sGen=0;
				$err=0;
			}while($row=mysql_fetch_array($result11));
			echo "<br>".$sqlGen1="update mov_almacen set seriesGen='Generado' where id_mov='".$idmov."'";
			
			
			$resGen1=mysql_db_query($sql_inv,$sqlGen1);
			if($resGen1==false){
				echo "Ocurrieron errores en la aplicacion.";	
			}
			
			//$rowGen1=mysql_fetch_array($resGen1);
		}else{
			echo "<br>-----------------------------------------------------------------<br>";
			echo "Los numeros de serie de este movimiento ya han sido creados<br>";
			echo "<br>-----------------------------------------------------------------<br>";
		}
		echo "<br><a href='mov_list.php'>Regresar al listado de Movimientos</a>";		
	}
?>