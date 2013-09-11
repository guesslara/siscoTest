<?php
/*
    *claseDetalle:contiene la clase para guardar la información de cada una de las transacciones que se realiza durante el proceso de HP
    *Autor: Dante Juárez 
    *Fecha:25-Abril-2012
    *Modificación: Agregar las variables para las conecciones a la base de datos, así como realizar la inserción dento de la funcion de consulta
    *Rocio Manuel Aguilar
    *07-05-2013
  
*/
class claseDetalle{

    private $conexion;
    private function conexion(){
  	require("../../includes/config.inc.php");
	$link=mysql_connect($host,$usuario,$pass);
	if($link==false){
            echo "Error en la conexion a la base de datos";
	}else{
          mysql_select_db($db);
          return $link;
	}				
    }
    public function consulta($id_item,$idUsuario,$proceso){
        date_default_timezone_set("America/Mexico_City");
        $consulta ="INSERT INTO detalle_informacion (id_item,proceso,fecha_detalle,hora_detalle,logIp,ID_usuario) VALUES('".$id_item."','".$proceso."','".date('Y-m-d')."','".date('G:i:s')."','".$_SERVER['REMOTE_ADDR']."','".$idUsuario."')";
        $resultado = mysql_query($consulta,$this->conexion());
        if(!$resultado){
            echo 'Error: ' . mysql_error();
            exit;
        }else{
            echo "";
        }
      return $resultado;
    }
}
/*$OBJ = new claseDetalle();
$OBJ->consulta('3','1','Agrega Lote');*/



?>