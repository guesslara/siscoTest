<?php 
//include("../php/connbaseAlm.php");
	$almacenes=array();
	$sql="SELECT almacen FROM tipoalmacen";
	$result=mysql_db_query($sql_db,$sql); 
		while ($row=mysql_fetch_array($result))
		{
		$valor=$row['almacen'];
		array_push($almacenes,$valor);
		} 
		
			/*foreach ($almacenes as $valor)
			echo '<br>'.$valor;*/
	// ------------------------- investigando nombre de los campos ...
	$se=$_SERVER['PHP_SELF'];
	$solo_ar=basename($se);
	$dir=str_replace($solo_ar,'',$se);

	$sistemas=$almacenes;
	$separado=split('/',$dir);
		foreach ($separado as $valor)
		{ 	//echo '<br>'.$valor;
			foreach ($sistemas as $sistema)
			{
				if (strtolower($sistema)==$valor)
				{
				$sistema_original=$sistema;
				$sistema_actual=strtolower($sistema);
				}
			}	
		} // -----------------------------------------------
	$n=0;
		while ($n<=20)
		{
		$pre_campo="a_".$n."_".$sistema_original; 
		//echo '<br>'.$pre_campo;
		$campo=$pre_campo;
		$qry=mysql_db_query($sql_db,"select * from catprod"); 
		$campos = mysql_num_fields($qry); 
		$i=0; 
			while($i<$campos){ 
				if($campo==mysql_field_name ($qry, $i)){
								
				$campo_almacen_actual=$campo;
				$numero_actual=$n;
				break;
				}
			$i++; 
			} //echo ' X';
		++$n;
		} // -----------------------------------------------
		
		//echo "<br>$sistema_actual ...";
		if ($sistema_actual=='')
		{
			echo '<br>No se encontro coincidencia entre la ruta actual y algun almacen.'; 
			$resultado=false;
		} else {		
			$campo_existencias_actual='exist_'.$numero_actual;
			$campo_transferencias_actual='trans_'.$numero_actual;
			//echo 'Self: '.$se.'<br>Sistema es: ('.$sistema_actual.')<br>Campo almacen: '.$campo_almacen_actual.'<br>Numero Actual: '.$numero_actual.'<br>Existencias Actual: '.$campo_existencias_actual.'<br>Transferencias Actual: '.$campo_transferencias_actual;
			$resultado=true;
		} 
?>