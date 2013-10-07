<?php
    if($_POST["action"]=="guardaSerie"){
        include("../../conf/conectarbase.php");
	
	$numMov=$_POST["numMov"];
        $claveProd=$_POST["claveProd"];
	$cantidad=$_POST["cantidad"];
        $idElemento=$_POST["idElemento"];
        $valores=$_POST["valores"];        
        
        //se cuenta cuantos registros existen en la tabla numeros de serie con ese movimiento
        $sql="SELECT COUNT(*) AS total FROM num_series WHERE mov='".$numMov."' AND clave_prod='".$claveProd."'";
        $res=mysql_query($sql,$link);
        $row2=mysql_fetch_array($res);        
        	
	if($row2["total"] != $cantidad){//se compara la captura paa saber si finaliza
            //se guarda el numero de serie en la tabla            
	    $valores=explode(",",$valores);
	    //se busca el asociado del movimiento    
	    $sql="SELECT id_mov,fecha,tipo_mov,concepto,concepmov.asociado AS asociado,tipoalmacen.almacen as almacen
	    FROM (mov_almacen INNER JOIN concepmov ON mov_almacen.tipo_mov=concepmov.id_concep) INNER JOIN tipoalmacen ON mov_almacen.almacen=tipoalmacen.id_almacen
	    WHERE id_mov='".$numMov."'";
	    $res=mysql_query($sql,$link);
	    $row=mysql_fetch_array($res);
	    
            $sqlSerie="INSERT INTO num_series (serie,noParte,clave_prod,mov,status,nombreCliente,almacenAsociado) VALUES ('".$valores[0]."','".$valores[1]."','".$claveProd."','".$numMov."','almacen','".$valores[2]."','".$row["almacen"]."')";            
	    //exit();	    
	    $resSerie=mysql_query($sqlSerie,$link);
            if($resSerie){
                $msgCaja="Informacion Guardada";
		$color="Green";
		$fuente="white";		
            }else{
                $msgCaja="Error al Guardar";
		$color="red";
		$fuente="white";
            }            
        }else{
            $msgCaja="Cantidad Excedida";
	    $color="red";
	    $fuente="white";
        }
	echo "<script type='text/javascript'>document.getElementById('".$idElemento."').value='".$msgCaja."'; </script>";
	echo "<script type='text/javascript'>document.getElementById('".$idElemento."').style.background='".$color."'; </script>";
        echo "<script type='text/javascript'>document.getElementById('".$idElemento."').style.color='".$fuente."'; </script>";
	echo "<script type='text/javascript'> ver_movimiento('".$numMov."'); </script>";
    }
?>