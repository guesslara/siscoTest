<?php
    /*
     *Clase para las funciones de la interfaz principal de usuario
     *Fecha: 12 de Noviembre de 2012
     *Autor: Gerardo Lara
    */
    include_once("../../../../clases/clase_mysql.php");
    class funcionesInterfazPrincipal{
        
        public function dameNombreProyecto($idProyecto){
	    include("../../../../includes/config.inc.php");
	    $sql="select * from proyecto where id_proyecto='".$idProyecto."'";
	    $mysql = new DB_mysql($db,$host,$usuario,$pass);	    
	    $mysql->consulta($sql);    
	    $row=$mysql->registroUnico();
	    return $row["nombre_proyecto"];
	}
        
        public function buscaActualizacionesNuevas(){
	    include("../../../../includes/config.inc.php");
            $sqlActNuevas="SELECT COUNT(*) AS totalActualizaciones FROM cambiossistema WHERE status='Nueva'";
	    $mysql = new DB_mysql($db,$host,$usuario,$pass);
	    $mysql->consulta($sqlActNuevas);    
            $rowActNuevas=$mysql->registroUnico();
            return $rowActNuevas["totalActualizaciones"];
        }        
    }//fin de la clase
?>