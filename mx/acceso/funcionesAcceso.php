<?php
    include("../../clases/clase_mysql.php");
    class funcionesAcceso{
        
        private function dameClientes(){
            include("../../includes/config.inc.php");
            $sql="SELECT r_social FROM cat_clientes WHERE activo=1";
            $mysql=new DB_mysql($db,$host,$usuario,$pass);
            $res=$mysql->consulta($sql);
            if($mysql->numregistros()==0){
                echo "No hay Clientes Registrados";
            }else{
                $row=$mysql->registrosConsulta();
            }
            return $row;
        }
        
        private function convertirCadena($ap){
            $token=md5($ap);
            $str1=substr($token,0,15);
            $str2=substr($token,16,16);
            $token=$str1.$str2;
            $token=md5($token);
            return $token;
        }
        
        public function verificarNombreAp($enc){
            $resC=$this->dameClientes();
            $arrayC = Array();
            while($rowC=mysql_fetch_array($resC)){
                array_push($arrayC,$rowC["r_social"]);
            }
            array_push($arrayC,"Almacen");            
            foreach( $arrayC as $valorC){
                $op=$this->convertirCadena($valorC);
                if($op==$enc){
                    return $valorC;
                    exit();
                }   
            }
            
        }
        
        private function guardarAccesoErroneo($ip,$enc){
            include("../../includes/config.inc.php");
            $sql="INSERT INTO accesoErroneo (enc,ip,accion,fecha,hora) VALUES ('".$enc."','".$ip."','Cambio de Encriptado','".date("Y-m-d")."','".date("H:i:s")."')";
            $mysql=new DB_mysql($db,$host,$usuario,$pass);
            $res=$mysql->consulta($sql);
            if($res==false){
                echo "Error al Guardar La informacion";
            }
        }
        
        public function registrarEventosErroneos($enc){
            $ip=$this->getIP();
            $this->guardarAccesoErroneo($ip,$enc);
        }
        
        private function getIP(){
            if( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] )) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if( isset( $_SERVER ['HTTP_VIA'] ))  $ip = $_SERVER['HTTP_VIA'];
            else if( isset( $_SERVER ['REMOTE_ADDR'] ))  $ip = $_SERVER['REMOTE_ADDR'];
            else $ip = null ;
            return $ip;
        }
        
        
        public function noCache() {
            header("Expires: Tue, 01 Jul 2001 06:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
        }

    }
?>