/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
  $('input[type="submit"]').button();
  $('input[type="button"]').button();
  $('input[type="delete"]').button();
  $('input[type="reset"]').button();

  $('#reset').click(function () {
    location.reload();
  });

//********************************
  //***********make data table..
  var dataSet = new Array();
  $('#example').dataTable({
    "data": dataSet,
    "columns": [
      {"data": "SchemeID"},
      {"data": "SchemeName"},
      {"data": "ReportDate"},
      {"data": "PhysicalProgress"},
      {"data": "FinancialProgress"},
      {"data": "Remarks"},
    ],
    "pagingType": "full_numbers",
    "jQueryUI": true,
    "lengthMenu": [
      [50, 250, 500, -1],
      [50, 250, 500, "All"]
    ],
    "scrollY": 600/*,
     "paging": false,
     "jQueryUI": true,*/
  });
  $('#CreateReport').click(function (event) {
    event.preventDefault();
    $('#Msg').html('Please Wait...');
    $.ajax({
      type: 'POST',
      url: 'AjaxData.php',
      dataType: 'html',
      xhrFields: {
        withCredentials: true
      },
      data: {
        'AjaxToken': $('#AjaxToken').val(),
        'CallAPI': 'GetReportTable',
      }
    })
        .done(function (data) {
          try {
            // $('#ReportID').data('SectorID', DataResp.SectorID);
            var DataResp = $.parseJSON(data);
            delete data;
            $('#Msg').html(DataResp.Msg);
            $('#ED').html(DataResp.RT);
            $("#Msg").show();
            var dataTableReport = $('#example').dataTable();
            oSettings = dataTableReport.fnSettings();
            dataTableReport.fnClearTable();
            for (var i = 0; i < DataResp.Data.length; i++) {
              dataTableReport.oApi._fnAddData(oSettings, DataResp.Data[i]);
            }
            oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
            dataTableReport.fnDraw();

            delete DataResp;
          }
          catch (e) {
            $('#Msg').html('Server Error:' + e);
            $('#Error').html(data);
          }
        })
        .fail(function (msg) {
          $('#Msg').html(msg);
        });
  });
  $('#Msg').html('Loaded Successfully');
});
