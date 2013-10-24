function grid_mov_almacen_id_mov_getValue(seqRow) {
  seqRow = scSeqNormalize(seqRow);
  return $("#id_sc_field_id_mov" + seqRow).html();
}

function grid_mov_almacen_id_mov_setValue(newValue, seqRow) {
  seqRow = scSeqNormalize(seqRow);
  $("#id_sc_field_id_mov" + seqRow).html(newValue);
}

function grid_mov_almacen_fecha_getValue(seqRow) {
  seqRow = scSeqNormalize(seqRow);
  return $("#id_sc_field_fecha" + seqRow).html();
}

function grid_mov_almacen_fecha_setValue(newValue, seqRow) {
  seqRow = scSeqNormalize(seqRow);
  $("#id_sc_field_fecha" + seqRow).html(newValue);
}

function grid_mov_almacen_concepto_getValue(seqRow) {
  seqRow = scSeqNormalize(seqRow);
  return $("#id_sc_field_concepto" + seqRow).html();
}

function grid_mov_almacen_concepto_setValue(newValue, seqRow) {
  seqRow = scSeqNormalize(seqRow);
  $("#id_sc_field_concepto" + seqRow).html(newValue);
}

function grid_mov_almacen_almacen_getValue(seqRow) {
  seqRow = scSeqNormalize(seqRow);
  return $("#id_sc_field_almacen" + seqRow).html();
}

function grid_mov_almacen_almacen_setValue(newValue, seqRow) {
  seqRow = scSeqNormalize(seqRow);
  $("#id_sc_field_almacen" + seqRow).html(newValue);
}

function grid_mov_almacen_referencia_getValue(seqRow) {
  seqRow = scSeqNormalize(seqRow);
  return $("#id_sc_field_referencia" + seqRow).html();
}

function grid_mov_almacen_referencia_setValue(newValue, seqRow) {
  seqRow = scSeqNormalize(seqRow);
  $("#id_sc_field_referencia" + seqRow).html(newValue);
}

function grid_mov_almacen_ver_getValue(seqRow) {
  seqRow = scSeqNormalize(seqRow);
  return $("#id_sc_field_ver" + seqRow).html();
}

function grid_mov_almacen_ver_setValue(newValue, seqRow) {
  seqRow = scSeqNormalize(seqRow);
  $("#id_sc_field_ver" + seqRow).html(newValue);
}

function grid_mov_almacen_getValue(field, seqRow) {
  seqRow = scSeqNormalize(seqRow);
  if ("id_mov" == field) {
    return grid_mov_almacen_id_mov_getValue(seqRow);
  }
  if ("fecha" == field) {
    return grid_mov_almacen_fecha_getValue(seqRow);
  }
  if ("concepto" == field) {
    return grid_mov_almacen_concepto_getValue(seqRow);
  }
  if ("almacen" == field) {
    return grid_mov_almacen_almacen_getValue(seqRow);
  }
  if ("referencia" == field) {
    return grid_mov_almacen_referencia_getValue(seqRow);
  }
  if ("ver" == field) {
    return grid_mov_almacen_ver_getValue(seqRow);
  }
}

function grid_mov_almacen_setValue(field, newValue, seqRow) {
  seqRow = scSeqNormalize(seqRow);
  if ("id_mov" == field) {
    grid_mov_almacen_id_mov_setValue(newValue, seqRow);
  }
  if ("fecha" == field) {
    grid_mov_almacen_fecha_setValue(newValue, seqRow);
  }
  if ("concepto" == field) {
    grid_mov_almacen_concepto_setValue(newValue, seqRow);
  }
  if ("almacen" == field) {
    grid_mov_almacen_almacen_setValue(newValue, seqRow);
  }
  if ("referencia" == field) {
    grid_mov_almacen_referencia_setValue(newValue, seqRow);
  }
  if ("ver" == field) {
    grid_mov_almacen_ver_setValue(newValue, seqRow);
  }
}

function scJQAddEvents(seqRow) {
  seqRow = scSeqNormalize(seqRow);
}

function scSeqNormalize(seqRow) {
  var newSeqRow = seqRow.toString();
  if ("" == newSeqRow) {
    return "";
  }
  if ("_" != newSeqRow.substr(0, 1)) {
    return "_" + newSeqRow;
  }
  return newSeqRow;
}
function ajax_navigate(opc, parm)
{
    scAjaxProcOn();
    $.ajax({
      type: "POST",
      url: "index.php",
      data: "nmgp_opcao=ajax_navigate&script_case_init=" + document.F4.script_case_init.value + "&script_case_session=" + document.F4.script_case_session.value + "&opc=" + opc  + "&parm=" + parm,
      success: function(jsonNavigate) {
        var i, oResp;
        eval("oResp = " + jsonNavigate);
        document.getElementById('nmsc_iframe_liga_A_grid_mov_almacen').src = 'NM_Blank_Page.htm';
        document.getElementById('nmsc_iframe_liga_E_grid_mov_almacen').src = 'NM_Blank_Page.htm';
        document.getElementById('nmsc_iframe_liga_D_grid_mov_almacen').src = 'NM_Blank_Page.htm';
        document.getElementById('nmsc_iframe_liga_B_grid_mov_almacen').src = 'NM_Blank_Page.htm';
        document.getElementById('nmsc_iframe_liga_A_grid_mov_almacen').style.height = '0px';
        document.getElementById('nmsc_iframe_liga_E_grid_mov_almacen').style.height = '0px';
        document.getElementById('nmsc_iframe_liga_D_grid_mov_almacen').style.height = '0px';
        document.getElementById('nmsc_iframe_liga_B_grid_mov_almacen').style.height = '0px';
        document.getElementById('nmsc_iframe_liga_A_grid_mov_almacen').style.width  = '0px';
        document.getElementById('nmsc_iframe_liga_E_grid_mov_almacen').style.width  = '0px';
        document.getElementById('nmsc_iframe_liga_D_grid_mov_almacen').style.width  = '0px';
        document.getElementById('nmsc_iframe_liga_B_grid_mov_almacen').style.width  = '0px';
        if (oResp["redirInfo"]) {
           scAjaxRedir(oResp);
        }
        if (oResp["setValue"]) {
          for (i = 0; i < oResp["setValue"].length; i++) {
               $("#" + oResp["setValue"][i]["field"]).html(oResp["setValue"][i]["value"]);
          }
        }
        if (oResp["setVar"]) {
          for (i = 0; i < oResp["setVar"].length; i++) {
               eval (oResp["setVar"][i]["var"] + ' = \"' + oResp["setVar"][i]["value"] + '\"');
          }
        }
        if (oResp["setDisplay"]) {
          for (i = 0; i < oResp["setDisplay"].length; i++) {
               document.getElementById(oResp["setDisplay"][i]["field"]).style.display = oResp["setDisplay"][i]["value"];
          }
        }
        if (oResp["setDisabled"]) {
          for (i = 0; i < oResp["setDisabled"].length; i++) {
               document.getElementById(oResp["setDisabled"][i]["field"]).disabled = oResp["setDisabled"][i]["value"];
          }
        }
        if (oResp["setClass"]) {
          for (i = 0; i < oResp["setClass"].length; i++) {
               document.getElementById(oResp["setClass"][i]["field"]).className = oResp["setClass"][i]["value"];
          }
        }
        if (oResp["setSrc"]) {
          for (i = 0; i < oResp["setSrc"].length; i++) {
               document.getElementById(oResp["setSrc"][i]["field"]).src = oResp["setSrc"][i]["value"];
          }
        }
        if (oResp["redirInfo"]) {
           scAjaxRedir(oResp);
        }
        if (oResp["htmOutput"]) {
           scAjaxShowDebug(oResp);
        }
        SC_init_jquery();
        tb_init('a.thickbox, area.thickbox, input.thickbox');
        scAjaxProcOff();
      }
    });
}
