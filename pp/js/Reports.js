/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(function() {

  $("#OfficeName").hide();

  $("#OfficeSL").chosen({width: "650px",
    no_results_text: "Oops, nothing found!"
  }).change(function() {
    $("#DataPPs").trigger("click");
  });

  $.ajax({
    type: 'POST',
    url: 'MySQLiDB.pp.ajax.php',
    dataType: 'html',
    xhrFields: {
      withCredentials: true
    },
    data: {
      'AjaxToken': $('#AjaxToken').val(),
      'CallAPI': 'GetOffices'
    }
  }).done(function(data) {
    try {
      var DataResp = $.parseJSON(data);
      delete data;
      $('#AjaxToken').val(DataResp.AjaxToken);
      $('#Msg').html(DataResp.Msg);
      $('#ED').html(DataResp.RT);
      $("#Msg").show();
      var Options = '';
      $.each(DataResp.Data,
              function(index, value) {
                Options += '<option value="' + value.OfficeSL + '">'
                        + value.OfficeSL + ' - ' + value.OfficeName
                        + '</option>';
              });
      $('#OfficeSL').html(Options)
              .trigger("chosen:updated");
      delete DataResp;
      $("#Msg").html('');
    }
    catch (e) {
      $('#Msg').html('Server Error:' + e);
      $('#Error').html(data);
    }
  }).fail(function(msg) {
    $('#Msg').html(msg);
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
        'CallAPI': $(this).val(),
        'Params': new Array($('#OfficeSL').val())
      }
    }).done(function(data) {
      try {
        var DataResp = $.parseJSON(data);
        delete data;
        $('#AjaxToken').val(DataResp.AjaxToken);
        $('#Msg').html(DataResp.Msg);
        $('#ED').html(DataResp.RT);
        $("#Msg").show();
        $("#ReportDT").show();
        var ReportDT = $.fn.dataTable.fnTables(true);
        if (ReportDT.length > 0) {
          $(ReportDT).dataTable().fnDestroy();
        }
        if (DataResp.CallAPI === "DataOffices") {
          $("#OfficeName").hide();
          InitDataTablePP1("#ReportDT");
        } else {
          $("#OfficeName").show();
          InitDataTablePP2("#ReportDT");
        }
        var dataTablePP = $('#ReportDT').dataTable();
        oSettings = dataTablePP.fnSettings();
        $('#Msg').html(oSettings);
        dataTablePP.fnClearTable(this);
        for (var i = 0; i < DataResp.Data.length; i++) {
          dataTablePP.oApi._fnAddData(oSettings, DataResp.Data[i]);
        }
        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
        dataTablePP.fnDraw();
        delete DataResp;
      }
      catch (e) {
        $('#Msg').html('Server Error:' + e);
        $('#Error').html(data);
      }
    }).fail(function(msg) {
      $('#Msg').html(msg);
    });
  });

  $('#Msg').html('');
});

function InitDataTablePP2(TableID) {
  $(TableID).html('<thead>' +
          '<tr>' +
          ' <th>Name of the Employee</th>' +
          ' <th>Designation</th>' +
          ' <th>Date of Birth</th>' +
          ' <th>Sex</th>' +
          ' <th>AC No.</th>' +
          ' <th>Part No.</th>' +
          ' <th>SL No.</th>' +
          ' <th>EPIC</th>' +
          ' <th>Scale Code</th>' +
          ' <th>Basic Pay</th>' +
          ' <th>Grade Pay</th>' +
          ' <th>Posting</th>' +
          ' <th>Posting History</th>' +
          ' <th>Home District</th>' +
          ' <th>Present Address1</th>' +
          ' <th>Present Address2</th>' +
          ' <th>Permanent Addr1</th>' +
          ' <th>Permanent Addr2</th>' +
          ' <th>Present AC</th>' +
          ' <th>Permanent AC</th>' +
          ' <th>Posting AC</th>' +
          ' <th>Present PC</th>' +
          ' <th>Permanent PC</th>' +
          ' <th>Posting PC</th>' +
          ' <th>Qualification</th>' +
          ' <th>Language</th>' +
          ' <th>Phone</th>' +
          ' <th>Mobile</th>' +
          ' <th>EMail</th>' +
          ' <th>Remarks</th>' +
          ' <th>BankACNo</th>' +
          ' <th>BankName</th>' +
          ' <th>BranchName</th>' +
          ' <th>IFSC</th>' +
          '</tr>' +
          '</thead>');
  var dataSet = new Array();
  $(TableID).dataTable({
    "data": dataSet,
    "columns": [
      {"data": "EmpName"},
      {"data": "DesgID"},
      {"data": "DOB"},
      {"data": "SexId"},
      {"data": "AcNo"},
      {"data": "PartNo"},
      {"data": "SLNo"},
      {"data": "EPIC"},
      {"data": "PayScale"},
      {"data": "BasicPay"},
      {"data": "GradePay"},
      {"data": "PostingID"},
      {"data": "HistPosting"},
      {"data": "DistHome"},
      {"data": "PreAddr1"},
      {"data": "PreAddr2"},
      {"data": "PerAddr1"},
      {"data": "PerAddr2"},
      {"data": "AcPreRes"},
      {"data": "AcPerRes"},
      {"data": "AcPosting"},
      {"data": "PcPreRes"},
      {"data": "PcPerRes"},
      {"data": "PcPosting"},
      {"data": "Qualification"},
      {"data": "Language"},
      {"data": "ResPhone"},
      {"data": "Mobile"},
      {"data": "EMail"},
      {"data": "Remarks"},
      {"data": "BankACNo"},
      {"data": "BankName"},
      {"data": "BranchName"},
      {"data": "IFSC"}
    ],
    "pagingType": "full_numbers",
    "lengthMenu": [[50, 250, 500, -1], [50, 250, 500, "All"]],
    "scrollY": 400,
    "scrollX": true,
    "scrollCollapse": true,
    "jQueryUI": true
  });
}

function InitDataTablePP1(TableID) {

  $(TableID).html('<thead>' +
          '<tr>' +
          ' <th>Name of the Office</th>' +
          ' <th>Designation of Officer-in-Charge</th>' +
          ' <th>Para/Tola/Street</th>' +
          ' <th>Village/Town/Street</th>' +
          ' <th>PostOffice</th>' +
          ' <th>PSCode</th>' +
          ' <th>PinCode</th>' +
          ' <th>Nature</th>' +
          ' <th>Status</th>' +
          ' <th>Phone</th>' +
          ' <th>Fax</th>' +
          ' <th>Mobile</th>' +
          ' <th>EMail</th>' +
          ' <th>Staffs</th>' +
          ' <th>ACNo</th>' +
          '</tr>' +
          '</thead>');

  var dataSet = new Array();
  $(TableID).dataTable({
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
}