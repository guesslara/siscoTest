
function scJQGeneralAdd() {
  $('input:text.sc-js-input').listen();
  $('input:password.sc-js-input').listen();
  $('textarea.sc-js-input').listen();

} // scJQGeneralAdd

function scFocusField(sField) {
  var $oField = $('#id_sc_field_' + sField);

  if (0 == $oField.length) {
    $oField = $('input[name=' + sField + ']');
  }

  if (0 == $oField.length && document.F1.elements[sField]) {
    $oField = $(document.F1.elements[sField]);
  }

  if (0 < $oField.length && 0 < $oField[0].offsetHeight && 0 < $oField[0].offsetWidth && !$oField[0].disabled) {
    $oField[0].focus();
  }
} // scFocusField

function scJQEventsAdd(iSeqRow) {
  $('#id_sc_field_id_' + iSeqRow).bind('blur', function() { sc_Discos_duros_id__onblur(this, iSeqRow) })
                                 .bind('change', function() { sc_Discos_duros_id__onchange(this, iSeqRow) })
                                 .bind('focus', function() { sc_Discos_duros_id__onfocus(this, iSeqRow) });
  $('#id_sc_field_capacidad_' + iSeqRow).bind('blur', function() { sc_Discos_duros_capacidad__onblur(this, iSeqRow) })
                                        .bind('change', function() { sc_Discos_duros_capacidad__onchange(this, iSeqRow) })
                                        .bind('focus', function() { sc_Discos_duros_capacidad__onfocus(this, iSeqRow) });
  $('#id_sc_field_rpm_' + iSeqRow).bind('blur', function() { sc_Discos_duros_rpm__onblur(this, iSeqRow) })
                                  .bind('change', function() { sc_Discos_duros_rpm__onchange(this, iSeqRow) })
                                  .bind('focus', function() { sc_Discos_duros_rpm__onfocus(this, iSeqRow) });
  $('#id_sc_field_interface_' + iSeqRow).bind('blur', function() { sc_Discos_duros_interface__onblur(this, iSeqRow) })
                                        .bind('change', function() { sc_Discos_duros_interface__onchange(this, iSeqRow) })
                                        .bind('focus', function() { sc_Discos_duros_interface__onfocus(this, iSeqRow) });
  $('#id_sc_field_pulgada_' + iSeqRow).bind('blur', function() { sc_Discos_duros_pulgada__onblur(this, iSeqRow) })
                                      .bind('change', function() { sc_Discos_duros_pulgada__onchange(this, iSeqRow) })
                                      .bind('focus', function() { sc_Discos_duros_pulgada__onfocus(this, iSeqRow) });
  $('#id_sc_field_no_parte_' + iSeqRow).bind('blur', function() { sc_Discos_duros_no_parte__onblur(this, iSeqRow) })
                                       .bind('change', function() { sc_Discos_duros_no_parte__onchange(this, iSeqRow) })
                                       .bind('focus', function() { sc_Discos_duros_no_parte__onfocus(this, iSeqRow) });
} // scJQEventsAdd

function sc_Discos_duros_id__onblur(oThis, iSeqRow) {
  do_ajax_Discos_duros_validate_id_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_Discos_duros_id__onchange(oThis, iSeqRow) {
  nm_check_insert(iSeqRow);
}

function sc_Discos_duros_id__onfocus(oThis, iSeqRow) {
  scCssFocus(oThis, iSeqRow);
}

function sc_Discos_duros_capacidad__onblur(oThis, iSeqRow) {
  do_ajax_Discos_duros_validate_capacidad_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_Discos_duros_capacidad__onchange(oThis, iSeqRow) {
  nm_check_insert(iSeqRow);
}

function sc_Discos_duros_capacidad__onfocus(oThis, iSeqRow) {
  scCssFocus(oThis, iSeqRow);
}

function sc_Discos_duros_rpm__onblur(oThis, iSeqRow) {
  do_ajax_Discos_duros_validate_rpm_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_Discos_duros_rpm__onchange(oThis, iSeqRow) {
  nm_check_insert(iSeqRow);
}

function sc_Discos_duros_rpm__onfocus(oThis, iSeqRow) {
  scCssFocus(oThis, iSeqRow);
}

function sc_Discos_duros_interface__onblur(oThis, iSeqRow) {
  do_ajax_Discos_duros_validate_interface_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_Discos_duros_interface__onchange(oThis, iSeqRow) {
  nm_check_insert(iSeqRow);
}

function sc_Discos_duros_interface__onfocus(oThis, iSeqRow) {
  scCssFocus(oThis, iSeqRow);
}

function sc_Discos_duros_pulgada__onblur(oThis, iSeqRow) {
  do_ajax_Discos_duros_validate_pulgada_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_Discos_duros_pulgada__onchange(oThis, iSeqRow) {
  nm_check_insert(iSeqRow);
}

function sc_Discos_duros_pulgada__onfocus(oThis, iSeqRow) {
  scCssFocus(oThis, iSeqRow);
}

function sc_Discos_duros_no_parte__onblur(oThis, iSeqRow) {
  do_ajax_Discos_duros_validate_no_parte_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_Discos_duros_no_parte__onchange(oThis, iSeqRow) {
  nm_check_insert(iSeqRow);
}

function sc_Discos_duros_no_parte__onfocus(oThis, iSeqRow) {
  scCssFocus(oThis, iSeqRow);
}

function scJQUploadAdd(iSeqRow) {
} // scJQUploadAdd


function scJQElementsAdd(iLine) {
  scJQEventsAdd(iLine);
  scJQUploadAdd(iLine);
} // scJQElementsAdd

