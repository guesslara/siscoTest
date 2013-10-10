<style type='text/css'>
   .estiloTitulosColumnas{height: 20px;padding: 5px;border:1px solid #CCC;background:#F0F0F0;font-weight:bold;}
   .estiloResultados{height:25px;padding: 5px;border-bottom:1px solid #CCC; width:auto;font-size: 10px;text-align: center;}
   .tituloReporte{border: 1px solid #CCC;background-color:#F0F0F0; height:20px; padding: 5px; width:auto; margin:4px;font-weight: bold;font-size: 12px;}
   .paginadorGrid{border: 0px solid #FF0000;text-align:center; height:20px;font-size: 12px; padding:5px;}
   /*filtros en la tabla*/
   .ventanaFiltro{display: none;position: absolute;width: 250px;height: 350px;border: 1px solid #000;}
   .contenedorTituloFiltro{height: 15px;padding: 3px;background: #000;color: #FFF;}
   .contenidoFiltroResultados{background: #FFF;width: 247px;height: 327px;border: 1px solid #FF0000;overflow: auto;}
   .resultadosFiltrosConsulta{width:auto;font-weight:normal;text-align:left;height: auto;padding: 3px;font-size: 10px;border-bottom: 1px solid #CCC;}
   .resultadosFiltrosConsulta:hover{background: #F0F0F0;}
</style>
<script type="text/javascript" src="../../../../../clases/jquery.js"></script>
<script type="text/javascript">
    campos="id,noParte,familia,subfamilia,descripgral,linea,control_alm";
    $(document).ready(function(){        	
        listarInventario();
        //colocarCabeceras();
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
    
    
    function listarInventario(){
        ajaxApp("listadoInventario","controladorInventario4.php","action=listarInventario&campos="+campos,"POST");
    }
    
    function Pagina(pagina){
        ajaxApp("listadoInventario","controladorInventario4.php","action=listarInventario&pag="+pagina+"&campos="+campos,"POST");
    }
    
    function colocarCabeceras(){
        ajaxApp("cabecerasFiltros","controladorInventario4.php","action=colocarCabeceras&campos="+campos,"POST");
    }
    
    function mostrarFiltro(div,campo){        
        for(i=1;i<=7;i++){
            $("#div_"+i).hide();
        }
        $("#div_"+div).show();
	//se manda la peticion para llenar el div con el contenido
	divContenido="contenidoFiltro_"+div;
	ajaxApp(divContenido,"controladorInventario4.php","action=llenarFiltro&campo="+campo,"POST");
    }
    
    function cierraInstancias(){
        for(i=1;i<=7;i++){
            $("#div_"+i).hide();
        }
    }
    
    function cerrarFiltroVentana(div){
        $("#"+div).hide();
    }
</script>
<div id="" style="border: 1px solid #FF0000;" onclick="">
    <div id="cabecerasFiltros"></div>
    <div id="listadoInventario"></div>    
</div>
    