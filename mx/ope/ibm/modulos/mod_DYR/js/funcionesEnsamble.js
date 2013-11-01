
// JavaScript Document
	/*
	 *funcionEnsamble: contiene las funciones de javascript del modulo
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:192
	 
	*/
function ajaxApp(divDestino,url,parametros,metodo){
	$.ajax({
	async:true,
	type: metodo,
	dataType: "html",
	contentType: "application/x-www-form-urlencoded",
	url:url,
	data:parametros,
	beforeSend:function(){ 
		$("#cargadorGeneral").show(); 
	},
	success:function(datos){ 
		$("#cargadorGeneral").hide();
		$("#"+divDestino).show().html(datos);		
	},
	timeout:90000000,
	error:function() { $("#"+divDestino).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
	});
}

function verificaTeclaImeiEmpaque(evento){
	if(evento.which==13){		
		//se valida la longitud de la cadena capturada
		var imei=document.getElementById("txtImeiEmpaque").value;
		if(imei.length < 15){
			$("#erroresCaptura").html("");
			$("#erroresCaptura").append("Error: verifique que haya introducido en el Imei la informacion correcta.");
			
		}else{
			document.getElementById("txtSimEmpaque").focus();
		}
	}
}
function cerrarVentana(div){
	$("#"+div).hide();
	$("#transparenciaGeneral2").hide();	
}
function clean2(op){
	if(op=="listadoEmpaque"){
		$("#listadoEmpaque").html("");
	}else{
		
		$("#consultaListado").hide();
		$("#selectListado").hide();
		$("#detalleEmpaque").html("");
	}
}
function diagnostica(idProyectoSeleccionado,idUser,opt){
		$("#listadoEmpaque2").hide();
		$("#selectListado").html("");
		$("#consultaListado").html("");
		$("#listadoEmpaque").html("");
		ajaxApp("listadoEmpaque","controladorEnsamble.php","action=diagnostica&idProyectoSeleccionado="+idProyectoSeleccionado+"&idUser="+idUser+"&opt="+opt,"POST");
}
function formDia(idProyectoSeleccionado,idUser,idItem,decide){
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=formDia&idProyectoSeleccionado="+idProyectoSeleccionado+"&idUser="+idUser+"&idItem="+idItem+"&decide="+decide,"POST");
}
function abreVentana(div,accion,idItem,idProyectoSeleccionado,div2){
	
	if(div=="ventanaDialogo1"){
		$("#msgVentanaDialogo").html("");
		$("#transparenciaGeneral2").show();
		$("#ventanaDialogo1").show();
		if(div2=="barraBotonesVentanaDialogo"){
			$("#barraBotonesVentanaDialogo").show();
		}
	}else{
		div="detalleEmpaque";
	}
	ajaxApp("msgVentanaDialogo","controladorEnsamble.php","action=muestraConsultasChk&idItem="+idItem+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&tbl="+accion,"POST");
	
}
function compara(idItem,idProyecto){
	var sel=$("#status").val();
	var arregloSel=sel.split("|");
	var tipoRep=arregloSel[0];
	var idTipoRep=arregloSel[1];
	var campos="";
	var n=0;
	var camposMuestra=arregloSel[2];
	var ap="";
	if(camposMuestra==0){
		$("#contenido").html("");
	}else{
		$("#contenido").html("");
		var camposMuestraArray=camposMuestra.split(",");		
		for(var m=0;m<camposMuestraArray.length;m++){
			var total=camposMuestraArray[m].length;
			cadauno=camposMuestraArray[m].split("-");
			nombre=cadauno[0];
			if(nombre!="FabRev"){
				var txtNom="";
				var pC=nombre.charAt(0);
				var esp="";
				for(var z=1; z<nombre.length;z++){
					zChar=nombre.charAt(z);
					if(zChar.charCodeAt()>=65 && zChar.charCodeAt()<=95){
						esp=" ";
					}else{
						esp="";
					}
					txtNom=txtNom+esp+zChar;
				}
				txtNomFin=pC+txtNom;
				nomVer=txtNomFin.charAt(0).toUpperCase()+txtNomFin.slice(1);
			}else{
				nomVer=nombre;
			}
			verifica=cadauno[1];
			if(verifica==1){
				if(tipoRep=="NT" && nombre=="fallas"){

					//nomVer=nomMin.charAt(0).toUpperCase()+nomMin.slice(1);
					var hidden="<tr><input type='hidden' name='"+nombre+"'id='"+nombre+"' value='1'/>";
					var txtA="<th align='left'>"+nomVer+":</th><td colspan=2><textarea name='"+nombre+"txta'id='"+nombre+"txta' disabled>101</textarea></td></tr>";
					$("#contenido").append(hidden);
					$("#contenido").append(txtA);
				}
				else{
					var hidden="<tr><input type='hidden' name='"+nombre+"'id='"+nombre+"'/>";
					var txtA="<th align='left'>"+nomVer+":</th><td><textarea name='"+nombre+"txta'id='"+nombre+"txta' disabled ></textarea></td>";
					var button="<td><input type='button' name='"+nombre+"Button' id='"+nombre+"Button' value='...' onclick='abreVentana(\"ventanaDialogo1\",\""+nombre+"\",\""+idItem+"\",\""+idProyecto+"\",\"barraBotonesVentanaDialogo\")'/></td><td><div id='"+nombre+"Error' style='display:none;font-size: 10px;border:1px solid #50C9F9;text-align:justify;color:#3306FB;'>Por favor seleccione:"+nombre+"</div></td><td><div id='"+nombre+"Error' style='display:none;font-size: 10px;border:1px solid #50C9F9;text-align:justify;color:#3306FB;text-decoration:blink;'>Por favor ingrese su(s): "+nombre+"</div></td></tr>";
					$("#contenido").append(hidden);
					$("#contenido").append(txtA);
					$("#contenido").append(button);
				}
			}
			else{
				if(nombre=="FabRev"){
					ap="Firmware";
				}else{
					if(nombre.indexOf("Tiempo")>=0){
						ap="Horas";
					}else{
						ap="Piezas";
					}
				}
				var txt="<tr><th ALIGN='left'>"+nomVer+": </th><td colspan=2><input type='text'id='"+nombre+"' name='"+nombre+"'/>"+ap+"</td><td><div id='"+nombre+"Error' style='display:none;font-size: 10px;border:1px solid #50C9F9;text-align:justify;color:#3306FB;'></div></td></tr>";
				//var txt="<tr><th ALIGN='left'>"+nombre+": </th><td colspan=2><input type='text'id='"+nombre+"txt' name='"+nombre+"txt' onBlur='ValidaCampo(\""+nombre+"\",\""+tipoDato+"\")'/></td><td><div id='"+nombre+"Error' style='display:none;font-size: 10px;border:1px solid #50C9F9;text-align:justify;color:#3306FB;text-decoration:blink;'>Por favor ingrese su(s): "+nombre+"</div></td></tr>";
				$("#contenido").append(txt);
			}
		}
	}
}

function recupera(){
	var nombreFormulario=$("#name").val();
	var opt1=document.getElementById("opt1").value;
	var idProyectoSeleccionado=document.getElementById("idProyecto").value;
	var idItem=document.getElementById("idItem").value;
	var cont=$("#"+opt1).val();
	var contText=$("#"+opt1+"txta").val();
	var selection=document.getElementById(nombreFormulario);
	for(j=0;j<selection.elements.length;j++){
		if(selection.elements[j].type =="checkbox"){
		    if(selection.elements[j].checked){
		       if(cont==""){
			 cont=cont+selection.elements[j].value;
			 contText=contText+selection.elements[j].name;
		       }	
		       else{
		        cont=cont+","+selection.elements[j].value;
			contText=contText+"\n"+selection.elements[j].name;
			
			} 
		     }	
		}
	}
        if(cont==""){
		alert("no se ha seleccionado ninguno");
	}
	else{
		contText1=contText;
		conta=cont;
		$("#"+opt1+"txta").attr("value",contText1);
		$("#"+opt1).attr("value",conta);
	}
}

function guardarDiagnostico(idItem,idProyectoSeleccionado,idUser){
	var idFabricante=$("#fabricante").val();
	var TypeField=document.getElementById("TypeField").value;
	var observacionesDia=$("#obsDia").val();
	var status=$("#status").val();
	var tipoEnt=$("#tipoEnt").val();
	if(idFabricante=="fabricante"){
		document.getElementById("fabricante").focus();
		$("#FabricanteError").show();
		return 0;
	}else{
		$("#FabricanteError").hide();
	}
	if(tipoEnt=="x"){
		document.getElementById("tipoEnt").focus();
		$("#TipoEntError").show();
		return 0;
	}else{
		$("#TipoEntError").hide();
	}
	if(status=="0|0|0"){
		document.getElementById("status").focus();
		$("#statusError").show();
		return 0;
	}else{
		$("#statusError").hide();
	}
	var arregloStatus=status.split("|");
	var idtipoRep=arregloStatus[1];
	var nomRep=arregloStatus[0];
	var Campos=arregloStatus[2];
	var camposArray=Campos.split(",");
	var cad1="", an="";
	var cadena="";
	var arraSim=new Array();
	var arrayT=TypeField.split("|");
		for(var m=0;m<camposArray.length;m++){
			var total=camposArray[m].length;
			cadauno=camposArray[m].split("-");
			nombre=cadauno[0];
			verifica=cadauno[1];
			if(verifica==1){
				an="Button";
				ca="id_";
				msjMuestraError="Por favor Selecciona:"+nombre;
			}else{
				an="";
				ca="";
				msjMuestraError="Por favor ingresa:"+nombre;
			}
			var TypeFieldArra=TypeField.split("|");
			var expRegular="";
			for(var l=0;l<TypeFieldArra.length;l++){
				sepTypeField=TypeFieldArra[l].split("=");
				FieldName=sepTypeField[0];
				if(FieldName.indexOf("id_")==-1){
					FieldName=FieldName;
					
				}else{
					FieldName=FieldName.substring(3);
				}
				FieldType=sepTypeField[1];
				if(FieldName==nombre){
					valorTXT=$("#"+FieldName).val();
					cadena=cadena+ca+FieldName+"="+valorTXT+"-";
					if(valorTXT==""){
						document.getElementById(FieldName+an).focus();
						$("#"+FieldName+"Error").show();
						$("#"+FieldName+"Error").css({ color: "#3306FB"});
						document.getElementById(FieldName+"Error").innerHTML = msjMuestraError;
						return 0;
					}else{
						$("#"+FieldName+"Error").hide();
						if(FieldType.indexOf("float")!=-1){
							expRegular=/^[0-9]{1,9}(\.[0-9]{0,5})?$/;
							Errormsj="Por favor verifique que sea un numero Decimal";
							if (!expRegular.test(valorTXT)) {
								document.getElementById(FieldName).focus();
								$("#"+FieldName+"Error").show();
								$("#"+FieldName+"Error").css({ color: "#FA0909"});
								document.getElementById(FieldName+"Error").innerHTML = Errormsj;
								return 0;
							}
						}
						if(FieldType.indexOf("int")!=-1){
							expRegular=/^(?:\+|-)?\d+$/;
							Errormsj="Por favor verifique que sea un numero Entero";
							if (!expRegular.test(valorTXT)){
								document.getElementById(FieldName).focus();
								$("#"+FieldName+"Error").show();
								$("#"+FieldName+"Error").css({ color: "#FA0909"});
								document.getElementById(FieldName+"Error").innerHTML = Errormsj;
								return 0;
							}
						}
						if(FieldType.indexOf("varchar")!=-1){
							expRegular=/^[\.a-zA-z0-9,_-]*$/;
							Errormsj="Por favor verifique que sean numeros,letras,_,-,.";
							if (!expRegular.test(valorTXT)) {
								document.getElementById(FieldName).focus();
								$("#"+FieldName+"Error").show();
								$("#"+FieldName+"Error").css({ color: "#FA0909"});
								document.getElementById(FieldName+"Error").innerHTML = Errormsj;
								return 0;
							}
						}
					}
				}
			}
		}
		cadena1=cadena.substring(0,((cadena.length)-1));
		ajaxApp("listadoEmpaque","controladorEnsamble.php","action=guardaDia&idItem="+idItem+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&idUser="+idUser+"&idFabricante="+idFabricante+"&observacionesDia="+observacionesDia+"&idTipoRep="+idtipoRep+"&status="+nomRep+"&cad="+cadena1+"&tipoEnt="+tipoEnt,"POST");
		return 1;
}
function confirmar(){
	var entrar = confirm("¿Realmente deseas guardar los datos?");
	if ( !entrar ) exit();
}

function consultaDia(idParte,idProyectoSeleccionado,idUser){
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=consultaDia&idProyectoSeleccionado="+idProyectoSeleccionado+"&idParte="+idParte+"&idUser="+idUser,"POST");
}
function muestraSel(idProyectoSeleccionado,idUser){
	$("#listadoEmpaque2").show();
	$("#selectListado").show();
	$("#listadoEmpaque").hide();
	ajaxApp("selectListado","controladorEnsamble.php","action=muestraSel&idProyectoSeleccionado="+idProyectoSeleccionado+"&idUser="+idUser,"POST");
}
function Seleccionado(obj){
	var idProyectoSeleccionado=$("#idProyecto").val();
	var idUser=$("#idUser").val();
	var valorAsignado = obj.options[obj.selectedIndex].value;
	var opt=valorAsignado;
	$("#detalleEmpaque").html("");
	$("#consultaListado").show();
		ajaxApp("consultaListado","controladorEnsamble.php","action=diagnostica&idProyectoSeleccionado="+idProyectoSeleccionado+"&idUser="+idUser+"&opt="+opt,"POST");
}
function recuperaCC(){
	var nombreFormulario=$("#name12").val();
	var opt12=document.getElementById("opt12").value;
	var idProyectoSeleccionado=document.getElementById("idProyecto12").value;
	var idUser=document.getElementById("idUser").value;
	var cont="";
	var contText="";
	var selection=document.getElementById(nombreFormulario);
	for(j=0;j<selection.elements.length;j++){
		if(selection.elements[j].type =="checkbox"){
		    if(selection.elements[j].checked){
		       if(cont==""){
			 cont=cont+selection.elements[j].value;
		       }	
		       else{
		        cont=cont+","+selection.elements[j].value;		
			} 
		     }	
		}
	}
        if(cont==""){
		alert("no se ha seleccionado ninguno");
	}
	else{
		conta=cont;
		ajaxApp("detalleEmpaque","controladorEnsamble.php","action=sendCC&idProyecto="+idProyectoSeleccionado+"&idUser="+idUser+"&idItem="+conta,"POST");	
	}
}