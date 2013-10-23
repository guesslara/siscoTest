<style type='text/css'>
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
</style>
<script type="text/javascript" src="../../../../../clases/jquery.js"></script>
<script type="text/javascript">
    campos="id,noParte,familia,subfamilia,descripgral,linea,control_alm,exist_1,exist_2,exist_3,exist_4,exist_5,exist_6";
    nombreCampos="ID,No Parte,Familia,Subfamilia,Descripción,Línea,Control Almacén,Exist. 1,Exist. 2,Exist. 3,Exist. 4,Exist. 5,Exist. 6";
    $(document).ready(function(){        	
        listarInventario('N/A','N/A');
    });
    
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
    
    
    function listarInventario(campo,valorAFiltrar){
        ajaxApp("listadoInventario","controladorInventario4.php","action=listarInventario&campos="+campos+"&nombresCampo="+nombreCampos+"&campo="+campo+"&valorAFiltrar="+valorAFiltrar,"POST");
    }
    
    function Pagina(pagina,campo,valorAFiltrar){
        ajaxApp("listadoInventario","controladorInventario4.php","action=listarInventario&pag="+pagina+"&campos="+campos+"&nombresCampo="+nombreCampos+"&campo="+campo+"&valorAFiltrar="+valorAFiltrar,"POST");
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
	 ajaxApp("listadoInventario","controladorInventario4.php","action=listarInventario&campos="+campos+"&nombresCampo="+nombreCampos+"&campo="+variableCampo+"&valorAFiltrar="+variableFiltro,"POST");
	 //se coloca el valor del filtro aplicado en el div de filtros
	 divFiltroAplicado="filtrosAplicados_"+campo;
	 //alert(divFiltroAplicado);
	 //$("#"+divFiltroAplicado).append("<div style='height:10px;padding:5px;border-bottom:1px solid #CCC;'>"+valorAFiltrar+"</div>");
	 //$("#"+divFiltroAplicado).append("1");
    }
</script>
<div id="" style="border: 1px solid #FF0000;" onclick="">
    <div id="cabecerasFiltros"></div>
    <div id="listadoInventario"></div>    
</div>
    