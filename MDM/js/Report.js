/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $('input[type="submit"]').button();
  $('input[type="button"]').button();
  $('input[type="delete"]').button();
  $('input[type="reset"]').button();

  $('#reset').click(function() {
    location.reload();
  });
  $("#SubDivID").chosen({width: "300px",
    no_results_text: "Oops, nothing found!"
  });
  $("#BlockID").chosen({width: "300px",
    no_results_text: "Oops, nothing found!"
  });
  $("#SchoolID").chosen({width: "300px",
    no_results_text: "Oops, nothing found!"
  });
  //fetch data....
  $.ajax({
    type: 'POST',
    url: 'AjaxData.php',
    dataType: 'html',
    xhrFields: {
      withCredentials: true
    },
    data: {
      'AjaxToken': $('#AjaxToken').val(),
      'CallAPI': 'GetReportData'
    }
  }).done(function(data) {
    try {
      var DataResp = $.parseJSON(data);
      // $('#Error').html(data);
      delete data;
      $('#Msg').html(DataResp.Msg);
      $('#ED').html(DataResp.RT);
      var Options = '<option value=""></option>';
      $.each(DataResp.SubDivID.Data,
              function(index, value) {
                //option for Projects...
                Options += '<option value="' + value.SubDivID + '">'
                        + value.SubDivID + ' - ' + value.SubDivName
                        + '</option>';
              });
      $('#SubDivID').html(Options)
              .trigger("chosen:updated");
      $('#SubDivID').data('SubDivID', DataResp.SubDivID);
      $('#BlockID').data('Blocks', DataResp.Blocks);
      $('#SchoolID').data('Schools', DataResp.Schools);
      delete DataResp;
      $("#SubDivID").chosen({width: "350px",
        no_results_text: "Oops, nothing found!"
      }).change(function() {
        var SubDivID = ($(this).val());
        var Options = '<option value=""></option>';
        var Blocks = $('#BlockID').data('Blocks');
        $.each(Blocks.Data,
                function(index, value) {
                  if (value.SubDivID === SubDivID) {
                    Options += '<option value="' + value.BlockID + '">'
                            + value.BlockID + ' - ' + value.BlockName
                            + '</option>';
                  }
                });
        $('#BlockID').html(Options)
                .trigger("chosen:updated");
        $('#SchoolID').html('<option value=""></option>')
                .trigger("chosen:updated");


      });
      $("#BlockID").chosen({width: "350px",
        no_results_text: "Oops, nothing found!"
      }).change(function() {
        var BlockID = ($(this).val());
        var Options = '<option value=""></option>';
        var Schools = $('#SchoolID').data('Schools');
        $.each(Schools.Data,
                function(index, value) {
                  if (value.BlockID === BlockID)
                  {
                    Options += '<option value="' + value.SchoolID + '">'
                            + value.SchoolID + ' - ' + value.Schoolname
                            + '</option>';
                  }
                });
        $('#SchoolID').html(Options)
                .trigger("chosen:updated");


      });
      $("#Msg").html('');
    }
    catch (e) {
      $('#Msg').html('Server Error:' + e);
      $('#Error').html(data);
    }
  }).fail(function(msg) {
    $('#Msg').html(msg);
  });
  $("#TypeID").chosen({width: "350px",
    no_results_text: "Oops, nothing found!"
  });
  //set the schoolvalue depand on the School name.......
  $("#SchoolID").chosen({width: "450px",
    no_results_text: "Oops, nothing found!"
  }).change(function() {
    var School = Number($(this).val());
    var SchoolData = $('#SchoolName').data('SchoolData');
    $.each(SchoolData,
            function(index, value) {
              if (value.SchoolID === School)
              {
                $("#TotalStudent").val(value.TotalStudent);
                return false;
              }
            });
  });

//********************************
  //***********make data table..
  var dataSet = new Array();
  $('#Mdmreport').dataTable({
    "data": dataSet,
    "columns": [
      {"data": "School Name"},
      {"data": "Type of School"},
      {"data": "Report Date"},
      {"data": "Total Number Of Student"},
      {"data": "Meal"}
    ],
    "pagingType": "full_numbers",
    "jQueryUI": true,
    "lengthMenu": [[50, 250, 500, -1], [50, 250, 500, "All"]],
    "scrollY": 600/*,
     "paging": false,
     "jQueryUI": true,*/
  });
  $('#CreateReport').click(function(event) {
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
        'CallAPI': 'GetMealData',
      }
    })
            .done(function(data) {
              try {
                // $('#ReportID').data('SectorID', DataResp.SectorID);
                var DataResp = $.parseJSON(data);
                delete data;
                $('#Msg').html(DataResp.Msg);
                $('#ED').html(DataResp.RT);
                $("#Msg").show();
                var dataTableReport = $('#Mdmreport').dataTable();
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
            .fail(function(msg) {
              $('#Msg').html(msg);
            });
  });
  $('#Msg').html('Loaded Successfully');
});
