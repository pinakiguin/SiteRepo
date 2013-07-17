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

  $('#SRER_Forms').tabs({
    activate: function(event, ui) {
      $('#ActiveSRERForm').val(ui.newPanel.attr('id'));
    }
  });

  /**
   *  OnChange put PartID into hidden field #ActivePartID
   */
  $('#PartID').chosen({width: "400px",
    no_results_text: "Oops, nothing found!"
  }).change(function() {
    $('#ActivePartID').val(this.value);
  });

  /**
   * Get the list of ACs and register change event to update Parts
   */
  $('#ACNo').chosen({width: "300px",
    no_results_text: "Oops, nothing found!"
  }).change(function() {
    var Options = '<option value=""></option>';
    var Parts = $('#PartID').data('Parts');
    var ACNo = $('#ACNo').val();
    $.each(Parts.Data,
            function(index, value) {
              if (value.ACNo === ACNo) {
                Options += '<option value="' + value.PartID + '">' + value.PartNo + ' - ' + value.PartName + '</option>';
              }
            });
    $('#PartID').html(Options)
            .trigger("liszt:updated");
  });


  /**
   * GetACParts API Call for Caching of AC and Parts
   * Options for ACs are rendered and
   * for Parts Stored in $('#PartID').data('Parts', DataResp.Parts);
   */
  $.ajax({
    type: 'POST',
    url: '../MySQLiDB.ajax.php',
    dataType: 'html',
    xhrFields: {
      withCredentials: true
    },
    data: {
      'AjaxToken': $('#AjaxToken').val(),
      'CallAPI': 'GetACParts'
    }
  }).done(function(data) {
    var DataResp = $.parseJSON(data);
    delete data;
    $('#AjaxToken').val(DataResp.AjaxToken);
    $('#Msg').html(DataResp.Msg);
    $('#ED').html(DataResp.RT);
    var Options = '<option value=""></option>';
    $.each(DataResp.ACs.Data,
            function(index, value) {
              Options += '<option value="' + value.ACNo + '">' + value.ACNo + ' - ' + value.ACName + '</option>';
            });
    $('#ACNo').html(Options)
            .trigger("liszt:updated");
    $('#PartID').data('Parts', DataResp.Parts);
    delete DataResp;
  }).fail(function(msg) {
    $('#Msg').html(msg);
  });

  /**
   * On Edit Fetch the rows acordingly
   *
   *
   */

  $('#CmdEdit').click(function() {
    $.ajax({
      type: 'POST',
      url: '../MySQLiDB.ajax.php',
      dataType: 'html',
      xhrFields: {
        withCredentials: true
      },
      data: {
        'AjaxToken': $('#AjaxToken').val(),
        'CallAPI': 'GetSRERData',
        'TableName': $('#ActiveSRERForm').val(),
        'Params': new Array(56055, 1, 10)//$('#ActivePartID').val(), $('#FromRow').val(), 10)
      }
    }).done(function(data) {
      $('#Error').html(data);
      var DataResp = $.parseJSON(data);
      delete data;
      $('#AjaxToken').val(DataResp.AjaxToken);
      $('#Msg').html(DataResp.Msg);
      $.each(DataResp.Data,
              function(index, value) {
                $.each(value, function(key, data) {
                  $('#' + $('#ActiveSRERForm').val() + key + index).val(data);
                });
              });
      $('#ED').html(DataResp.RT);
      delete DataResp;
    }).fail(function(msg) {
      $('#Msg').html(msg);
    });
  });

  $('#CmdNew').click(function() {
    // @todo Remove the first Row and Add one at end
  });
});