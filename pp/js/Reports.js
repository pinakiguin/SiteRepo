/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $('#ReportDT').dataTable({
    "pagingType": "full_numbers",
    "lengthMenu": [[50, 250, 500, -1], [50, 250, 500, "All"]],
    "scrollY": 400,
    "scrollX": true,
    "scrollCollapse": true,
    "jQueryUI": true
  });

  $('input[name="CmdReport"]').click(function(event) {
    event.preventDefault();
    $('#Msg').html('Please Wait...');
    $.ajax({
      type: 'POST',
      url: 'MySQLiDB.pp.ajax.php',
      dataType: 'html',
      xhrFields: {
        withCredentials: true
      },
      data: {
        'AjaxToken': $('#AjaxToken').val(),
        'CallAPI': $(this).val()
      }
    })
            .done(function(data) {
      try {
        var DataResp = $.parseJSON(data);
        delete data;
        $('#AjaxToken').val(DataResp.AjaxToken);
        $('#Msg').html(DataResp.Msg);
        $('#ED').html(DataResp.RT);
        $("#Msg").show();
        $("#example_wrapper").show();
        var dataTableRSBY = $('#example').dataTable();
        oSettings = dataTableRSBY.fnSettings();
        dataTableRSBY.fnClearTable(this);
        for (var i = 0; i < DataResp.Data.length; i++) {
          dataTableRSBY.oApi._fnAddData(oSettings, DataResp.Data[i]);
        }
        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
        dataTableRSBY.fnDraw();

        delete DataResp;
      }
      catch (e) {
        $('#Msg').html('Server Error:' + e);
        $('#Error').html(data);
      }
    })
            .fail(function(msg) {
      $('#Msg').html(msg);
    });
  });

});
