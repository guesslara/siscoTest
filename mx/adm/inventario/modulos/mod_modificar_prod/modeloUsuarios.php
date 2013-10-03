<?
	/*
	 *Clase para poder enlazar las acciones del usuario con el modulo
	*/
	require_once("../../../../../includes/config.inc.php");
	require_once("../../../../../clases/conexion/conexion.php");
	//require_once("../../../../../clases/verificaUsuario/verificaUsuario.php");
	class modeloUsuarios{
		private $conexion;		
		
		function __construct($host,$usuario,$pass,$db){
			try {
				$conn = new Conexion();
				$this->conexion = $conn->getConexion($host,$usuario,$pass,$db);
				if($this->conexion === false){
					echo "Error en la aplicacion (Modelo)";
				}
			} catch(Exception $e){
				echo "Error en la aplicacion (Excepcion)";
			}
		}//fin construct
		
		 function consulta($buscador){
			
		 }
?>	