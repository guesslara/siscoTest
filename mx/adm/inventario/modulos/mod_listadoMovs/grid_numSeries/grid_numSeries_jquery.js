function grid_numSeries_id_getValue(seqRow) {
  seqRow = scSeqNormalize(seqRow);
  return $("#id_sc_field_id" + seqRow).html();
}

function grid_numSeries_id_setValue(newValue, seqRow) {
  seqRow = scSeqNormalize(seqRow);
  $("#id_sc_field_id" + seqRow).html(newValue);
}

function grid_numSeries_noparte_getValue(seqRow) {
  seqRow = scSeqNormalize(seqRow);
  return $("#id_sc_field_noparte" + seqRow).html();
}

function grid_numSeries_noparte_setValue(newValue, seqRow) {
  seqRow = scSeqNormalize(seqRow);
  $("#id_sc_field_noparte" + seqRow).html(newValue);
}

function grid_numSeries_serie_getValue(seqRow) {
  seqRow = scSeqNormalize(seqRow);
  return $("#id_sc_field_serie" + seqRow).html();
}

function grid_numSeries_serie_setValue(newValue, seqRow) {
  seqRow = scSeqNormalize(seqRow);
  $("#id_sc_field_serie" + seqRow).html(newValue);
}

function grid_numSeries_nombrecliente_getValue(seqRow) {
  seqRow = scSeqNormalize(seqRow);
  return $("#id_sc_field_nombrecliente" + seqRow).html();
}

function grid_numSeries_nombrecliente_setValue(newValue, seqRow) {
  seqRow = scSeqNormalize(seqRow);
  $("#id_sc_field_nombrecliente" + seqRow).html(newValue);
}

function grid_numSeries_almacenasociado_getValue(seqRow) {
  seqRow = scSeqNormalize(seqRow);
  return $("#id_sc_field_almacenasociado" + seqRow).html();
}

function grid_numSeries_almacenasociado_setValue(newValue, seqRow) {
  seqRow = scSeqNormalize(seqRow);
  $("#id_sc_field_almacenasociado" + seqRow).html(newValue);
}

function grid_numSeries_status_getValue(seqRow) {
  seqRow = scSeqNormalize(seqRow);
  return $("#id_sc_field_status" + seqRow).html();
}

function grid_numSeries_status_setValue(newValue, seqRow) {
  seqRow = scSeqNormalize(seqRow);
  $("#id_sc_field_status" + seqRow).html(newValue);
}

function grid_numSeries_getValue(field, seqRow) {
  seqRow = scSeqNormalize(seqRow);
  if ("id" == field) {
    return grid_numSeries_id_getValue(seqRow);
  }
  if ("noparte" == field) {
    return grid_numSeries_noparte_getValue(seqRow);
  }
  if ("serie" == field) {
    return grid_numSeries_serie_getValue(seqRow);
  }
  if ("nombrecliente" == field) {
    return grid_numSeries_nombrecliente_getValue(seqRow);
  }
  if ("almacenasociado" == field) {
    return grid_numSeries_almacenasociado_getValue(seqRow);
  }
  if ("status" == field) {
    return grid_numSeries_status_getValue(seqRow);
  }
}

function grid_numSeries_setValue(field, newValue, seqRow) {
  seqRow = scSeqNormalize(seqRow);
  if ("id" == field) {
    grid_numSeries_id_setValue(newValue, seqRow);
  }
  if ("noparte" == field) {
    grid_numSeries_noparte_setValue(newValue, seqRow);
  }
  if ("serie" == field) {
    grid_numSeries_serie_setValue(newValue, seqRow);
  }
  if ("nombrecliente" == field) {
    grid_numSeries_nombrecliente_setValue(newValue, seqRow);
  }
  if ("almacenasociado" == field) {
    grid_numSeries_almacenasociado_setValue(newValue, seqRow);
  }
  if ("status" == field) {
    grid_numSeries_status_setValue(newValue, seqRow);
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
