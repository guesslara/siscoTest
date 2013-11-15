<?php
class fecha {
	var $fecha0; var $fecha1;
	public function __construct($fecha_mysql)
	{
		$this->fecha0=$fecha_mysql;
	}
	function dame_fecha()
	{
		$meses=array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIMEBRE","DICIEMBRE");	
		$this->fecha1=intval(substr($this->fecha0,8,2))." ".$meses[intval(substr($this->fecha0,5,2))-1]." ".intval(substr($this->fecha0,0,4));	
		if (strlen($this->fecha1)>5)
			return $this->fecha1;
		else return " ";	
	}

}
// ==================================================================
class usuario {
	var $idu;
	public function __construct($id_usuario)
	{
		$this->idu=$id_usuario;
		//echo "<br>Recibo (".$this->idu.")";
	}
	function dame_usuario()
	{
		include ("../conf/conexion.php");
		$sql="SELECT * FROM userdbingiqcd WHERE ID='".$this->idu."'";
		$sentencia = $db->prepare($sql);
		$sentencia->execute();
		$row = $sentencia->fetchAll();
		foreach ($row as $rowb)
		{
			$nomr=$rowb['nombre'];
			$apar=$rowb['apaterno'];
			$usurp=strtoupper($nomr.' '.$apar);
		}		
		return $usurp;
	}

}


/*
$fecha_recibida="2009-02-14";
$f1=new fecha($fecha_recibida);
echo " La fecha es: ";
echo $f1->dame_fecha();
*/
?>