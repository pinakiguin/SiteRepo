/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  /**
   * GetComboData API Call for Caching of MasterData
   * Options for Blocks are rendered
   * for Panchayats Stored in
   * $('#CmbPanchayatCode').data('Panchayats', DataResp.Panchayats);
   * $('#CmbVillageCode').data('Villages', DataResp.Villages);
   */
  $.ajax({
    type: 'POST',
    url: 'AjaxData.php',
    dataType: 'html',
    xhrFields: {
      withCredentials: true
    },
    data: {
      'AjaxToken': $('#AjaxToken').val(),
      'CallAPI': 'GetComboData'
    }
  })
          .done(function(data) {
    try {
      var DataResp = $.parseJSON(data);
      delete data;
      $('#AjaxToken').val(DataResp.AjaxToken);
      $('#Msg').html(DataResp.Msg);
      $('#ED').html(DataResp.RT);
      var Options = '<option value=""></option>';
      $.each(DataResp.Blocks.Data,
              function(index, value) {
                Options += '<option value="' + value.BlockCode + '">'
                        + value.BlockCode + ' - ' + value.BlockName
                        + '</option>';
              });
      $('#CmbBlockCode').html(Options)
              .trigger("chosen:updated");
      $('#CmbPanchayatCode').data('Panchayats', DataResp.Panchayats);
      $('#CmbVillageCode').data('Villages', DataResp.Villages);
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
  /**
   * BlockCode Change event registered
   *
   */
  $('#CmbBlockCode')
          .chosen({width: "200px",
    no_results_text: "Oops, nothing found!"
  })
          .change(function() {
    var Options = '<option value=""></option>';
    var Panchayats = $('#CmbPanchayatCode').data('Panchayats');
    var BlockCode = $(this).val();
    $.each(Panchayats.Data,
            function(index, value) {
              if (value.BlockCode === BlockCode) {
                Options += '<option value="' + value.Panchayat_TownCode + '">'
                        + value.Panchayat_TownCode + ' - ' + value.Panchayat_TownName
                        + '</option>';
              }
            });
    $('#CmbPanchayatCode').html(Options)
            .trigger("chosen:updated");
    $('#CmbVillageCode').html('<option value=""></option>')
            .trigger("chosen:updated");
  });
  /**
   * Get the list of ACs and register change event to update Parts
   *
   */
  $('#CmbPanchayatCode')
          .chosen({width: "250px",
    no_results_text: "Oops, nothing found!"
  })
          .change(function() {
    var Options = '<option value=""></option>';
    var Villages = $('#CmbVillageCode').data('Villages');
    var PanchayatCode = $(this).val();
    $.each(Villages.Data,
            function(index, value) {
              if (value.Panchayat_TownCode === PanchayatCode) {
                Options += '<option value="' + value.VillageCode + '">'
                        + value.VillageCode + ' - ' + value.VillageName
                        + '</option>';
              }
            });
    $('#CmbVillageCode').html(Options)
            .trigger("chosen:updated");
  });
  /**
   * Get the list of ACs and register change event to update Parts
   *
   */
  $('#CmbVillageCode').chosen({width: "250px",
    no_results_text: "Oops, nothing found!"
  }).change(function() {
    //alert("Selected:");
  });

  var dataSet = new Array();
  $('#example').dataTable({
    "data": dataSet,
    "columns": [
      {"data": "URN"},
      {"data": "EName"},
      {"data": "Father_HusbandName"},
      {"data": "RSBYType"},
      {"data": "CatCode"},
      {"data": "BPLCitizen"},
      {"data": "Minority"}
    ],
    "pagingType": "full_numbers",
    "jQueryUI": true,
    "lengthMenu": [[50, 250, 500, -1], [50, 250, 500, "All"]],
    "scrollY": 600/*,
     "paging": false,
     "jQueryUI": true,*/
  });

  $('.chzn-select').chosen({width: "250px",
    no_results_text: "Oops, nothing found!"
  });

  $('input[type="submit"]').button();

  $('#CmdRefreshRSBY').click(function(event) {
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
        'CallAPI': 'GetRSBYData',
        'VillageCode': $('#CmbVillageCode').val()
      }
    })
            .done(function(data) {
      try {
        var DataResp = $.parseJSON(data);
        delete data;
        $('#AjaxToken').val(DataResp.AjaxToken);
        $('#Msg').html(DataResp.Msg);
        $('#ED').html(DataResp.RT);

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
