<style type='text/css'>
   body{margin: 0;}
   .estiloTitulosColumnas{height: 20px;padding: 5px;border:1px solid #CCC;background:#F0F0F0;font-weight:bold;}
   .estiloResultados{height:25px;padding: 5px;border-bottom:1px solid #CCC; width:auto;font-size: 10px;text-align: center;}
   .tituloReporte{border: 1px solid #CCC;background-color:#F0F0F0; height:20px; padding: 5px; width:auto; margin:4px;font-weight: bold;font-size: 12px;}
   .paginadorGrid{border: 0px solid #FF0000;text-align:center; height:20px;font-size: 12px; padding:5px;}
   /*filtros en la tabla*/
   .ventanaFiltro{display: none;position: absolute;width: 250px;height: 350px;border: 1px solid #000;background: #FFF;}
   .contenedorTituloFiltro{height: 15px;padding: 3px;background: #000;color: #FFF;}
   .contenidoFiltroResultados{background: #FFF;width: 247px;height: 212px;border: 0px solid #FF0000;overflow: auto;}
   
   .resultadosFiltrosConsulta{width:auto;font-weight:normal;text-align:left;height: auto;padding: 3px;font-size: 10px;border-bottom: 1px solid #CCC;}
   .resultadosFiltrosConsulta:hover{background: #F0F0F0;}
   
   .btnMostrarTodo{float: left;width: 100px;height: 15px;border: 1px solid #CCC;padding: 2px;margin-left: 10px;}
   .btnMostrarTodo:hover{cursor: pointer;background: #f0f0f0;}
</style>
<script type="text/javascript" src="../../../../../clases/jquery.js"></script>
<script type="text/javascript">
    campos="id,noParte,familia,subfamilia,descripgral,linea,control_alm";
    nombreCampos="ID,No Parte,Familia,Subfamilia,Descripcion,Linea,Control Almacen";
    $(document).ready(function(){        	
        //listarInventario('N/A','N/A');
        cargarClientes();
        redimensionarVentana();
    });
    window.onresize=redimensionarVentana;    
    function redimensionarVentana(){
        var altoDoc=$(document).height();
        altoDoc=altoDoc - 100;
        altoDoc1=-(altoDoc / 2);
        $("#contenedorVentanaKardex").css("height",altoDoc+"px");
        $("#contenedorVentanaKardex").css("margin-top",altoDoc1+"px");
    }
    
    function ajaxApp(divDestino,url,parametros,metodo){	
	$.ajax({
	async:true,
	type: metodo,
	dataType: "html",
	contentType: "application/x-www-form-urlencoded",
	url:url,
	data:parametros,
	beforeSend:function(){ 
		$("#"+divDestino).show().html("Cargando informacion..."); 
	},
	success:function(datos){ 		
		$("#"+divDestino).show().html(datos);		
	},
	timeout:90000000,
	error:function() { $("#"+divDestino).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
	});
    }
    
    function cargarClientes(){
        ajaxApp("contenidoListadoClientes","controladorInventario4.php","action=listarClientes","POST");
    }
    
    function listarInventario(campo,valorAFiltrar){
        //se recupera el cliente Seleccionado
        idCliente=$("#cboClienteInventario").val();
        if(idCliente=="" || idCliente==null || idCliente==undefined){
            alert("Seleccione un Cliente para mostrar su inventario");
        }else{            
            ajaxApp("listadoInventario","controladorInventario4.php","action=listarInventario&campos="+campos+"&nombresCampo="+nombreCampos+"&campo="+campo+"&valorAFiltrar="+valorAFiltrar+"&idCliente="+idCliente,"POST");
            $("#div_ventanaSeleccionClientes").hide();
        }        
    }
    
    function Pagina(pagina,campo,valorAFiltrar){
        idCliente=$("#hdnClienteInventario").val();
	if(idCliente=="" || idCliente==null || idCliente==undefined){
            alert("Seleccione un Cliente para mostrar su inventario");
        }else{
	    ajaxApp("listadoInventario","controladorInventario4.php","action=listarInventario&pag="+pagina+"&campos="+campos+"&nombresCampo="+nombreCampos+"&campo="+campo+"&valorAFiltrar="+valorAFiltrar+"&idCliente="+idCliente,"POST");
	}
    }
    
    function colocarCabeceras(){
        ajaxApp("cabecerasFiltros","controladorInventario4.php","action=colocarCabeceras&campos="+campos,"POST");
    }
    
    function mostrarFiltro(div,campo){
        var elem = campos.split(',');
	
	for(i=0;i<elem.length;i++){
	    $("#div_"+(i+1)).hide();
	}
	        
        $("#div_"+div).show();
	//se manda la peticion para llenar el div con el contenido
	divContenido="contenidoFiltro_"+div;
	ajaxApp(divContenido,"controladorInventario4.php","action=llenarFiltro&campo="+campo,"POST");
    }
    
    function cerrarFiltroVentana(div){
        $("#"+div).hide();
    }
    variableCampo="";
    variableFiltro="";
    function aplicarFiltro(campo,valorAFiltrar){
	 //alert(campo+" "+valorAFiltrar);
	 if(variableFiltro==""){
	    variableCampo=campo;
	    variableFiltro=valorAFiltrar;	    
	 }else{
	    variableCampo=variableCampo+","+campo;
	    variableFiltro=variableFiltro+","+valorAFiltrar;
	 }
         idCliente=$("#hdnClienteInventario").val();
         
         if(idCliente=="" || idCliente==null || idCliente==undefined){
            alert("Seleccione un Cliente para mostrar su inventario");
        }else{
            ajaxApp("listadoInventario","controladorInventario4.php","action=listarInventario&campos="+campos+"&nombresCampo="+nombreCampos+"&campo="+variableCampo+"&valorAFiltrar="+variableFiltro+"&idCliente="+idCliente,"POST");
            //se coloca el valor del filtro aplicado en el div de filtros
            divFiltroAplicado="filtrosAplicados_"+campo;
            //alert(divFiltroAplicado);
            //$("#"+divFiltroAplicado).append("<div style='height:10px;padding:5px;border-bottom:1px solid #CCC;'>"+valorAFiltrar+"</div>");
            //$("#"+divFiltroAplicado).append("1");   
        }
    }
    
    function cambiarCliente(){
      $("#div_ventanaSeleccionClientes").show();
      cargarClientes();
    }
    
    function ver_kardex(id){
        $("#div_ventanaKardexProducto").show();	
        ajaxApp("contenidoKardex","kardex2.php","action=ver_kardex&id="+id,"GET");
    }
    
    function exportarExcel(){
        ajaxApp("cabecerasFiltros","controladorInventario4.php","action=exportarInventario","POST");
    }
</script>
<div id="" style="border: 0px solid #FF0000;margin: 2px;font-family: Verdana,Arial;font-size: 12px;" onclick="">
    <div id="cabecerasFiltros"></div>
    <div id="listadoInventario"></div>    
</div>
<div id="div_ventanaSeleccionClientes" style="display: block;position: absolute;width: 100%;height: 100%;z-index: 900;background: url(../../../../../img/desv.png) repeat;top: 0;">
    <div style="position: absolute;width: 400px;height: 200px;left: 50%;top: 50%;margin-left: -200px;margin-top: -100px;border: 1px solid #000;background: #fff;">
        <div style="position: relative;width: 100%;background: #000;overflow: hidden;">
            <div style="float: left;background: #000;border: 1px solid #000;color: #fff;font-size: 12px;padding: 5px;">Seleccione al Cliente para ver sus inventarios</div>
            <div style="float: right;background: #000;border: 1px solid #000;color: #fff;font-size: 12px;padding: 5px;"><!--<a href="#" onclick=""><img src="../../../../../img/close.gif" border="0"></a>--></div>            
        </div>
        <div id="contenidoListadoClientes" style="border: 0px solid #ff0000;width: 100%;height: 165px;overflow: auto;">

        </div>
    </div>
</div>
<div id="div_ventanaKardexProducto" style="display: none;position: absolute;width: 100%;height: 100%;z-index: 900;background: url(../../../../../img/desv.png) repeat;top: 0;">
    <div id="contenedorVentanaKardex" style="position: absolute;width: 800px;/*height: 450px;*/left: 50%;top: 50%;margin-left: -400px;/*margin-top: -225px;*/border: 1px solid #000;background: #fff;">
        <div style="position: relative;width: 100%;background: #000;overflow: hidden;">
            <div style="float: left;background: #000;border: 1px solid #000;color: #fff;font-size: 12px;padding: 5px;">Movimientos - </div>
            <div style="float: right;background: #000;border: 1px solid #000;color: #fff;font-size: 12px;padding: 5px;"><a href="#" onclick="cerrarFiltroVentana('div_ventanaKardexProducto')"><img src="../../../../../img/close.gif" border="0"></a></div>            
        </div>
        <div id="contenidoKardex" style="border: 0px solid #ff0000;width: 99.8%;height: 96%;overflow: auto;">

        </div>
    </div>
</div>
    