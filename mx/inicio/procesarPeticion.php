<?php
    print_r($_POST);    
    echo "<br>".$nombreProyecto=dameNombreProyecto($_POST["radio"]);
    switch($nombreProyecto){
	case "Almacen":
	    header("Location: ../adm/inventario");
            exit();
	break;
        case "Lexmark":
            header("Location: ../lexmark/modulos/mod_login/index.php");
            exit();
        break;
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