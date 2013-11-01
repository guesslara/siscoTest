<?
	/*
	 *controladorEnsamble:contiene la instancia de la clase y las variables para cada una de las funciones de las clases
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:20/Nov/2012
	*/
	include("modeloEnsamble.php");
	$objLote=new modeloEnsamble();
	//print_r($_POST);
	
	function clean($cadclean){
        $cadclean = mysql_real_escape_string(stripslashes(strip_tags($cadclean)));
        return $cadclean;
	}
	switch($_POST['action']){
		/***************************Lote******************************/
		case "mostrarLotes":
			$opt=clean($_POST['opt']);
			$id_usuario=clean($_POST['idUsuario']);
			$idProyecto=clean($_POST['idProyectoSeleccionado']);
			$objLote->mostrarLotesProyecto($opt,$id_usuario,$idProyecto);
		break;
		case "verFormatos":
			$idLote=clean($_POST["idLote"]);
			$idUsuario=clean($_POST["idUsuario"]);
			$idProyecto=clean($_POST["idProyectoSeleccionado"]);
			$numPo=clean($_POST["numPo"]);
			$objLote->verFormatos($idLote,$idUsuario,$idProyecto,$numPo);
		break;
		case "formatoPDF":
			$idLote=clean($_POST["idLote"]);
			$idUsuario=clean($_POST["idUsuario"]);
			$idProyecto=clean($_POST["idProyectoSeleccionado"]);
			$noFormato=clean($_POST["noFormato"]);
			$nombre=clean($_POST["nombre"]);
			if(fopen("../mod_esqueleto/nuevo.php","a")){
				unlink("../mod_esqueleto/nuevo.php");
			}
			$OFiel=fopen("../mod_esqueleto/nuevo.php","a");
			$datosArchivo="<?php".PHP_EOL."\$idUsuario=\"$idUsuario\";".PHP_EOL."\$idLote=\"$idLote\";".PHP_EOL."\$idProyecto=\"$idProyecto\";".PHP_EOL."\$noFormato=\"$noFormato\";".PHP_EOL."\$nombre=\"$nombre\";".PHP_EOL."?>";
			fwrite($OFiel, $datosArchivo);
			fclose($OFiel);
			?>
			<script type="text/javascript">
				_blank=window.open("","_blank");
				_blank.location.href ="<?=$noFormato?>.php?noFormato=<?=$noFormato;?>";
			</script>
			<?
		break;
	}