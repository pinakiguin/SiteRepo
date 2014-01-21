/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(function() {
  var dataSet = new Array();
  $('#ReportDT').dataTable({
    "data": dataSet,
    "columns": [
      {"data": "Name of the Office"},
      {"data": "Designation of Officer-in-Charge"},
      {"data": "Para\/Tola\/Street"},
      {"data": "Village\/Town\/Street"},
      {"data": "PostOffice"},
      {"data": "PSCode"},
      {"data": "PinCode"},
      {"data": "Nature"},
      {"data": "Status"},
      {"data": "Phone"},
      {"data": "Fax"},
      {"data": "Mobile"},
      {"data": "EMail"},
      {"data": "Staffs"},
      {"data": "ACNo"}
    ],
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
        $("#ReportDT").show();
        var dataTablePP1 = $('#ReportDT').dataTable();
        oSettings = dataTablePP1.fnSettings();
        $('#Msg').html(oSettings);
        dataTablePP1.fnClearTable(this);
        for (var i = 0; i < DataResp.Data.length; i++) {
          dataTablePP1.oApi._fnAddData(oSettings, DataResp.Data[i]);
        }
        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
        dataTablePP1.fnDraw();
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
  $('#Msg').html('');
});
