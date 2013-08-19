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
            //echo "Se guarda el numero de serie";
            //print_r($_POST);
	    $valores=explode(",",$valores);
	    
            $sqlSerie="INSERT INTO num_series (serie,noParte,clave_prod,mov,status) VALUES ('".$valores[0]."','".$valores[1]."','".$claveProd."','".$numMov."','almacen')";
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