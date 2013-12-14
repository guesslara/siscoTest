<?
	//configuracion
	include("../../includes/config.inc.php");
	//se incluye el modelo
	require_once("modeloUsuarios.php");	
	//objeto del modelo
	$objModeloUsuarios=new modeloUsuarios($host,$usuario,$pass,$db);
	
	if($_GET['action']=="consultaUsuarios"){
		//se listan los usuarios
		$param=$_GET['param'];
		$orden=$_GET['orden'];
		$txtBuscaInicio=$_GET['txtBusca'];	
		$filtro=$_GET['filtro'];
	
		$objModeloUsuarios->listarUsuarios($param,$orden,$txtBuscaInicio,$filtro);
	}
	//eliminacion de usuarios
	if($_GET['action']=="borrarUsuario"){
		$id_usr=$_GET['id_usr'];
		$objModeloUsuarios->borrarUsuario($id_usr);
	}
	//nuevo usuario
	if($_GET['action']=="nuevoUsuarioForm"){
		$objModeloUsuarios->nuevoUsuarioForm();
	}
	//guarda usuario
	if($_POST['action']=="guardarUsuario"){
		//print_r($_POST);
		$nombre=$_POST['nombre'];
		$apaterno=$_POST['apaterno'];
		$usuario=$_POST['usuario'];
		$pass1=$_POST['pass1'];
		$pass2=$_POST['pass2'];
		$nivel_acceso=$_POST['nivel_acceso'];
		$sexo=$_POST['sexo'];
		//$tipo=$_POST['tipo'];
		//$nomina=$_POST['nomina'];
		$grupo=$_POST['grupo'];
		$grupo2=$_POST['grupo2'];
		$obs=$_POST['obs'];
		$nomina=$_POST['nomina'];
		
		$objModeloUsuarios->guardaUsuario($nombre,$apaterno,$usuario,$pass1,$pass2,$nivel_acceso,$sexo,$grupo,$grupo2,$obs,$nomina);
	}
	//actualizacion de datos
	if($_POST['action']=="actualizaDatosUsuario"){
		//print_r($_POST);
		$nombre=$_POST['nombre'];
		$apaterno=$_POST['apaterno'];
		$usuario=$_POST['usuario'];
		$nivel_acceso=$_POST['nivel_acceso'];
		//$cambioPass=$_POST['cambioPass'];
		$sexo=$_POST['sexo'];
		//$directorioUsuario=$_POST['directorioUsuario'];
		//$tipo=$_POST['tipo'];
		//$idNoNominaUsuario=$_POST['idNoNominaUsuario'];
		$grupo=$_POST['grupo'];
		$grupo2=$_POST['grupo2'];
		$activo=$_POST['activo'];
		$idUsuarioAct=$_POST['idUsuarioAct'];
		$nomina=$_POST['nomina'];
		$objModeloUsuarios->datosActualizados($nombre,$apaterno,$usuario,$nivel_acceso,$sexo,$grupo,$grupo2,$activo,$idUsuarioAct,$nomina);
	}
	//reset pass
	if($_GET['action']=="resetPass"){
		$id_usr=$_GET['id_usr'];
		$objModeloUsuarios->resetPass($id_usr);
	}
	//agrega grupo
	if($_GET['action']=="addGrupo"){
		$objModeloUsuarios->addGrupo();
	}
	//guardado del grupo
	if($_POST['action']=="guardaGrupo"){
		$nombreGrupo=$_POST['nombreGrupo'];
		$permisos=$_POST['permisos'];
		$objModeloUsuarios->guardaGrupo($nombreGrupo,$permisos);
	}
	//consulta de grupos
	if($_GET['action']=="consultarGrupos"){
		$objModeloUsuarios->consultaGrupos();
	}
	//modificar grupo
	if($_GET['action']=="modificaGrupo"){
		$idGrupo=$_GET['idGrupo'];
		$objModeloUsuarios->modificaGrupo($idGrupo);
	}
	//actualizacion del grupo
	if($_POST['action']=="actualizaGrupo"){
		//print_r($_POST);
		$permisos=$_POST['permisos'];
		$idGrupo=$_POST['idGrupo'];
		$objModeloUsuarios->actualizaGrupo($permisos,$idGrupo);
	}
	if($_GET['action']=="nuevaFuncionForm"){
		$objModeloUsuarios->nuevaFuncionForm();
	}
	if($_POST['action']=="guardaRegFuncion"){
			//print_r($_POST);
			$txtModulo=$_POST['txtModulo'];
			$txtPer=$_POST['txtPer'];
			$txtMenu=$_POST['txtMenu'];
			//$txtRuta=$_POST['txtRuta'];
			//$txtImagen=$_POST['txtRuta'];
			$objModeloUsuarios->guardarFuncion($txtModulo,$txtPer,$txtMenu);
	}
	if($_GET['action']=="manttoSistema"){
		$objModeloUsuarios->manttoSistema($_GET['sitio']);
	}
if($_POST['action']=="guardarMantto"){
		//print_r($_POST);
		$valor=$_POST['valor'];
		$comentario=$_POST['comentario'];
		$objModeloUsuarios->guardarMantto($valor,$comentario,$_POST['sitio']);
	}
if($_GET['action']=="controlCambios"){
		$objModeloUsuarios->controlCambios();	
	}
if($_POST['action']=="guardaControlCambios"){
		//print_r($_POST);
		$titulo=$_POST['titulo'];
		$status=$_POST['status'];
		$obs=$_POST['texto'];
		$fecha=$_POST['fecha'];
		$objModeloUsuarios->guardaControlCambios($titulo,$status,$obs,$fecha);
	}
if($_GET['action']=="consultarAct"){
		$objModeloUsuarios->consultaAct();
	}

if($_GET['action']=="cambioStatusAct"){
			//print_r($_GET);
			$idReg=$_GET['idReg'];
			$status=$_GET['status'];
			$objModeloUsuarios->activarStatusAct($idReg,$status);
	}
	if($_GET['action']=="listarModulos"){
		$objModeloUsuarios->listarModulos($_POST["idCliente"]);
	}
	if($_GET['action']=="listarImagen"){
		$objModeloUsuarios->listarImagen();
	}
	if($_GET['action']=="nuevoProcesoForm"){
		$objModeloUsuarios->nuevoProcesoForm();
	}
	if($_GET['action']=="consultarProcesos"){
		$objModeloUsuarios->consultaProcesos();
	}
	if($_GET['action']=="nuevoModeloForm"){
		$objModeloUsuarios->nuevoModeloForm();
	}
	if($_GET['action']=="consultarModelo"){
		$objModeloUsuarios->consultaModelo();
	}
	if($_GET['action']=="nuevaFallaForm"){
		$objModeloUsuarios->nuevaFallaForm();
	}
	if($_GET['action']=="consultarFalla"){
		$objModeloUsuarios->consultaFalla();
	}
	if($_POST['action']=="modProc"){
		//print_r($_POST);
		$id_proc=$_POST['id_proc'];	
		$objModeloUsuarios->modProceso($id_proc);
	}	
	if($_POST['action']=="modModeloMod"){
		//print_r($_POST);
		$id_modelo=$_POST['id_modelo'];	
		$objModeloUsuarios->modModelos($id_modelo);
	}	
	if($_POST['action']=="muestraMod"){
		//print_r($_POST);
		$id_falla=$_POST['id_falla'];	
		$objModeloUsuarios->muestraMod($id_falla);
	}	
	if($_POST['action']=="guardaRegistro"){
			//print_r($_POST);
			$txtProceso=$_POST['txtProceso'];
			$objModeloUsuarios->guardarRegistro($txtProceso);
	}
	if($_POST['action']=="guardaRegistroModelo"){
			//print_r($_POST);
			$txtModelo=$_POST['txtModelo'];
			$txtObs=$_POST['txtObs'];
			$objModeloUsuarios->guardarRegistroModelo($txtModelo,$txtObs);
	}
	if($_POST['action']=="guardaRegistroFalla"){
			//print_r($_POST);
			$txtDes=$_POST['txtDes'];
			$txtObs=$_POST['txtObs'];
			$txtCodigo=$_POST['txtCodigo'];
			$objModeloUsuarios->guardarRegistroFalla($txtDes,$txtObs,$txtCodigo);
	}
	if($_GET['action']=="modificaUsuario"){
		$id_usr=$_GET['id_usr'];
		$objModeloUsuarios->modificaUsuario($id_usr);
	}
	if($_POST['action']=="guardaModProc"){
			//print_r($_POST);
		$txtDes=$_POST['txtDes'];
		$id_proc=$_POST['id_proc'];
		$objModeloUsuarios->guardarModProc($txtDes,$id_proc);
	}
	if($_POST['action']=="guardaModModelo"){
			//print_r($_POST);
			$txtMod=$_POST['txtMod'];
			$txtObs=$_POST['txtObs'];
			$id_modelo=$_POST['id_modelo'];
			$objModeloUsuarios->modGuardaModelo($txtMod,$txtObs,$id_modelo);
	}
	if($_POST['action']=="guardaRegMod"){
			//print_r($_POST);
			$txtDes=$_POST['txtDes'];
			$txtObs=$_POST['txtObs'];
			$txtCodigo=$_POST['txtCodigo'];
			$id_falla=$_POST['id_falla'];
			$objModeloUsuarios->guardarRegMod($txtDes,$txtObs,$txtCodigo,$id_falla);
	}
	if($_GET['action']=="nipUsuario"){
		//print_r($_GET);
		$id_usr=$_GET['id_usr'];
		$objModeloUsuarios->nip($id_usr);
	}
	
	if($_GET['action']=="generaNip"){
		$id_usr=$_GET['id_usr'];
	$objModeloUsuarios->generaNip($id_usr);
		
	}
	if($_GET['action']=="Error"){
		maneja_error();
	}
	if($_GET['action']=="cambioStatus"){
			//print_r($_GET);
			$idReg=$_GET['idReg'];
			$status=$_GET['status'];
			$objModeloUsuarios->activarStatus($idReg,$status);
	}
	if($_POST["action"]=="mostrarConfiguracionesGlobales"){
		$objModeloUsuarios->mostrarConfiguracionesGlobales();
	}
	if($_POST["action"]=="modificarValorConf"){
		//print_r($_POST);
		$objModeloUsuarios->modificarValorConfiguracion($_POST["id"],$_POST["nvoValor"]);
	}
	//print_r($_POST);
	if($_POST["action"]=="eliminarValorConf"){
		//print_r($_POST);
		$objModeloUsuarios->eliminarValorConfiguracion($_POST["id"],$_POST["nvoValor"]);
	}
	if($_POST["action"]=="formAgergarConf"){
		$objModeloUsuarios->formAgergarConf();
	}
	if($_POST["action"]=="guardarNuevaConf"){
		$objModeloUsuarios->guardaConfNueva($_POST["nombreConf"],$_POST["valor"],$_POST["descripcion"]);
	}
	if($_POST["action"]=="agregarSubMenu"){
		$objModeloUsuarios->mostrarOpcionesMenu();
	}
	if($_POST["action"]=="agregarItemSubMenu"){
		$objModeloUsuarios->agregarItemSubmenu($_POST["idElemento"],$_POST["idCliente"]);
	}
	if($_POST["action"]=="guardarSubMenu"){
		//print_r($_POST);
		$idElemento=$_POST["idElemento"];
		$txtNombreSubMenu=$_POST["txtNombreSubMenu"];
		$txtRuta=$_POST["txtRuta"];
		$cboStatusSubmenu=$_POST["cboStatusSubmenu"];
		$objModeloUsuarios->guardarSubmenu($idElemento,$txtNombreSubMenu,$txtRuta,$cboStatusSubmenu);
	}
	if($_POST["action"]=="modificarSubMenu"){
		//print_r($_POST);
		$objModeloUsuarios->modificarSubmenu($_POST["id"]);
	}
	if($_POST["action"]=="guardarSubMenuAct"){
		//print_r($_POST);
		$idElementoAct=$_POST["idElementoAct"];
		$txtNombreSubMenuAct=$_POST["txtNombreSubMenuAct"];
		$txtRutaAct=$_POST["txtRutaAct"];
		$cboStatusSubmenuAct=$_POST["cboStatusSubmenuAct"];
		$objModeloUsuarios->guardarSubmenuAct($idElementoAct,$txtNombreSubMenuAct,$txtRutaAct,$cboStatusSubmenuAct);
	}
	if($_POST["action"]=="mostrarOpcionesMenu"){
		/*Modificacion*/
		$objModeloUsuarios->mostrarOpcionesMenu();
		//$objModelo2=ne
	}
	if($_POST["action"]=="modificarMenuTitulo"){
		$objModeloUsuarios->modificaMenuTitulo($_POST["idMenuTitulo"]);
	}
	if($_POST["action"]=="guardarModificarMenuTitulo"){
		$objModeloUsuarios->guardarModificacionMenuTitulo($_POST["nombreMenuTitulo"],$_POST["numeroMenuAct"],$_POST["idElementoAct"]);
	}
	if($_POST["action"]=="verModulosSistema"){
		$objModeloUsuarios->verModulosSistema();
	}
	if($_POST["action"]=="verArchivo"){
		$objModeloUsuarios->leer_fichero_completo($_POST["archivo"]);
	}
	if($_POST["action"]=="eliminaSubMenu"){
		$objModeloUsuarios->eliminaSubMenu($_POST["idSubMenu"]);
	}
	if($_POST["action"]=="eliminaMenu"){
		$objModeloUsuarios->eliminaMenu($_POST["idMenu"]);
	}
	if($_POST["action"]=="listarBugs"){		
		$objModeloUsuarios->listarBugs();
	}
?>