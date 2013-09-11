<?php
/*
    *claseDetalle:contiene la clase para guardar la información de cada una de las transacciones que se realiza durante el proceso de HP
    *Autor: Dante Juárez 
    *Fecha:25-04-2012
    *Modificación: Rocio Manuel Aguilar
  
*/
class regLog{

  private $conexion;
  private $total_consultas;

  public function regLog(){
    if(!isset($this->conexion)){
      $this->conexion = (mysql_connect("localhost","root","xlinux")) or 
die(mysql_error());
      mysql_select_db("logRegistros",$this->conexion) or 
die(mysql_error());
    }
  }

  public function consulta($consulta){
       $this->total_consultas++;
        $resultado = mysql_query($consulta,$this->conexion);

        if(!$resultado){
              echo 'Error: ' . mysql_error();
          exit;
        }else{
            echo "se inserto registro";
        }
    return $resultado;
  }
}

$db = new regLog();
$consulta = $db->consulta("INSERT INTO registraEventos(logUsr,logFecha,logHora,logIp,logEvento) VALUES('dante','".date('Y-m-d')."','".date('H:m:s')."','".$_SERVER['REMOTE_ADDR']."','ACCESO')");

?>