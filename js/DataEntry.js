/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $(".ReceiptDate").datepicker({
    dateFormat: 'dd/mm/yy',
    showOtherMonths: true,
    selectOtherMonths: true,
    showButtonPanel: true,
    showAnim: "slideDown"
  });
  $(".DOB").datepicker({
    dateFormat: 'dd/mm/yy',
    maxDate: new Date(1996, 1 - 1, 1),
    showOtherMonths: true,
    selectOtherMonths: true,
    showButtonPanel: true,
    showAnim: "slideDown"
  });
  $("#Dept").autocomplete({
    source: "query.php",
    minLength: 3,
    select: function(event, ui) {
      $('#Dept').val(ui.item.value);
    }
  });
  $('#ACNo').chosen({width: "300px",
    no_results_text: "Oops, nothing found!"
  });
  $('#PartID').chosen({width: "400px",
    no_results_text: "Oops, nothing found!"
  });
  $('#SRER_Forms').tabs();
  $('#CmdEdit').click(function() {
    $.ajax({
      type: 'POST',
      url: '../MySQLiDB.ajax.php',
      dataType: 'html',
      xhrFields: {
        withCredentials: true
      },
      data: {'AjaxToken': $('#AjaxToken').val(),
        'CallAPI': 'GetData',
        'Fields': '`PartNo`,`PartName`',
        'TableName': 'SRER_PartMap',
        'Criteria': 'Where `PartMapID`=? LIMIT ?,?',
        'Params': new Array('1', 30, 10)
      }
    })
            .done(function(data) {
      var DataResp = $.parseJSON(data);
      $('#AjaxToken').val(DataResp.AjaxToken);
      $('#Msg').html(DataResp.Msg);
      $.each(DataResp.Data,
              function(index, value) {
                $('#Row' + index).val(value.PartNo);
                $('#RowData' + index).val(value.PartName);
                $('#ED').html(DataResp.RT);
              });
    })
            .fail(function(msg) {
      $('#Msg').html(msg);
    });
  });
  $('#CmdNew').click(function() {
    $('#Msg').html($('#SRER_Forms').tabs('option', 'active'));
  });
});