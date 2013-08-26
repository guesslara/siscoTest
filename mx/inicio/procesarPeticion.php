<?php
    //print_r($_POST);
    //exit();
    if($_POST["radio"]=="Almacen"){
	$nombreProyecto="Almacen";
    }else{
	$nombreProyecto=dameNombreProyecto($_POST["radio"]);
    }    
    
    switch($nombreProyecto){
	case "Almacen":
	    $token=devuelveNombreProyectoConvertido($nombreProyecto);
	    $url="../acceso/index.php?ap=".$token;
	    header("Location: ".$url);	   
            exit();
	break;
        case "Lexmark":
            header("Location: ../ope/lexmark/modulos/mod_login/index.php");
            exit();
        break;
	default:
	    header("Location: index.php");
	    exit();
	break;
    }
    
    function devuelveNombreProyectoConvertido($nombreProyecto){
	$token=md5($nombreProyecto);
	$str1=substr($token,0,15);
	$str2=substr($token,16,16);
	$token=$str1.$str2;
	$token=md5($token);
	return $token;
    }
    
    function dameNombreProyecto($idProyecto){
        $sql="SELECT * FROM cat_clientes WHERE id_cliente='".$idProyecto."'";
        $res=mysql_query($sql,conectarBd());
        $row=mysql_fetch_array($res);
        $nombreProyecto=$row["r_social"];
        return $nombreProyecto;
    }
    
    function conectarBd(){
	require("../../includes/config.inc.php");
	$link=mysql_connect($host,$usuario,$pass);
	if($link==false){
		echo "Error en la conexion a la base de datos";
	}else{
		mysql_select_db($db);
		return $link;
	}				
    }
?>