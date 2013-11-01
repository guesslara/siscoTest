/*
archivo con las funciones para poder generar las ventanas
*/
var contadorVentanasInformacion=1;
var contadorFocoVentanaInformacion=200;
var posicionIzquierdaVentana=200
var posicionArriba=70;
var alturaVentanaInformacion=700;
var anchoVentanaInformacion=450;
var ubicacionImagenes="http://intranet/sisco/mx/iq/ope/nextel2011/recursos/dragdrop";

function generarVentana(tituloVentana,alturaVentanaInformacion1,anchoVentanaInformacion1,urlVentanaInformacion,parametrosVentanaInformacion){
    idVentanaInfo="informacionDetalleVentana"+contadorVentanasInformacion;
    contentVentanaInfo="contentInformacionDetalleVentana"+contadorVentanasInformacion;
    html="<div id='"+idVentanaInfo+"' class='dragDiv' onclick='cambiarModo(\""+idVentanaInfo+"\")'>";
    html+="<h5 class='handler'>"+tituloVentana+"<span style='float: right;margin-top: -2px;'><span style='font-size: 8px;font-weight: 100;'>Puede mover esta ventana</span>&nbsp;<a href='#' onclick='cerrarVentanaInformacion(\""+idVentanaInfo+"\")' title='Cerrar Ventana' style='color:red;'>[X]</a></span></h5>";
    html+="<div id='"+contentVentanaInfo+"' class='content'></div>";
    html+="</div>";
    $("body").append(html);
    $('.dragDiv').Drags({
            handler: '.handler',		
            onMove: function(e) { /*$('.content').html('Div Position:(Left:' + e.pageX + ' ,Top:' + e.pageY + ')');*/},
            onDrop:function(e){ /*$('.content').html('dropped!');*/}
    });
    //se asignan las propiedades a la ventana
    $("#"+idVentanaInfo).css("left",posicionIzquierdaVentana+"px");
    $("#"+idVentanaInfo).css("top",posicionArriba+"px");
    if(alturaVentanaInformacion1==""){
        $("#"+idVentanaInfo).css("height",parseInt(alturaVentanaInformacion)+"px");    
    }else{
        $("#"+idVentanaInfo).css("height",parseInt(alturaVentanaInformacion1)+"px");
    }
    if(anchoVentanaInformacion1==""){
        $("#"+idVentanaInfo).css("width",parseInt(anchoVentanaInformacion)+"px");
    }else{
        $("#"+idVentanaInfo).css("width",parseInt(anchoVentanaInformacion1)+"px");
    }
    $("#"+contentVentanaInfo).css("height","91%");
    //$("#"+idVentanaInfo).css("z-index",contadorFocoVentanaInformacion);
    /*$('#'+idVentanaInfo).click(function(){
            //alert("Foco");
            valorZIndex=(contadorFocoVentanaInformacion+parseInt(contadorVentanasInformacion));
            alert("Id Ventana "+idVentanaInfo+"\n"+valorZIndex);
            $("#"+idVentanaInfo).css("z-index",valorZIndex);
            contadorFocoVentanaInformacion+=1;
    });*/
    //se envia la peticion ajax
    ajaxAppVentanasInformacion(contentVentanaInfo,urlVentanaInformacion,parametrosVentanaInformacion);
    contadorVentanasInformacion+=1;
    posicionIzquierdaVentana+=30;
    posicionArriba+=15;
    //contadorFocoVentanaInformacion+=1;
}
function cambiarModo(idVentanaInfo){
    valorZIndex=(contadorFocoVentanaInformacion+parseInt(contadorVentanasInformacion));
    //alert("Id Ventana "+idVentanaInfo+"\n"+valorZIndex);
    $("#"+idVentanaInfo).css("z-index",valorZIndex);
    contadorFocoVentanaInformacion+=1;
}
function cerrarVentanaInformacion(div){
    $("#"+div).hide();
}
function ajaxAppVentanasInformacion(divDestino,url,parametros){
    $.ajax({
    async:true,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url:url,
    data:parametros,
    beforeSend:function(){ 
            $("#"+divDestino).show().html("Cargando datos..."); 
    },
    success:function(datos){ 
            $("#"+divDestino).show().html(datos);		
    },
    timeout:90000000,
    error:function() { $("#"+divDestino).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
    });
}