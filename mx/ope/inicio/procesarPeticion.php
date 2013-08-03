<?php
    print_r($_POST);    
    $nombreProyecto=dameNombreProyecto($_POST["radio"]);
    switch($nombreProyecto){
        case "Lexmark":
            header("Location: ../lexmark/modulos/mod_login/index.php");
            exit;
        break;
    }
    
    function dameNombreProyecto($idProyecto){
        $sql="SELECT * FROM proyectos WHERE id_proy='".$idProyecto."'";
        $res=mysql_query($sql,conectarBd());
        $row=mysql_fetch_array($res);
        $nombreProyecto=$row["nomb"];
        return $nombreProyecto;
    }
    
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
?>