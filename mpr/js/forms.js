/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $('input[type="submit"]').button();

  $('.chzn-select').chosen({width: "250px",
    no_results_text: "Oops, nothing found!"
  });

  $('.DatePicker').datepicker({dateFormat: 'yy-mm-dd'});

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
              $.each(DataResp.Depts.Data,
                      function(index, value) {
                        Options += '<option value="' + value.DeptID + '">'
                                + value.DeptID + ' - ' + value.DeptName
                                + '</option>';
                      });
              $('#CmbDeptID').html(Options)
                      .trigger("chosen:updated");
              $('#CmbSectorID').data('Sectors', DataResp.Sectors);
              $('#CmbSchemeID').data('Schemes', DataResp.Schemes);
              $('#CmbProjectID').data('Projects', DataResp.Projects);
              delete DataResp;
              $("#Msg").hide();
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
  $('#CmbDeptID')
          .chosen({width: "200px",
            no_results_text: "Oops, nothing found!"
          })
          .change(function() {
            $("#Msg").hide();
            $("#example_wrapper").hide();
            var Options = '<option value=""></option>';
            var Sectors = $('#CmbSectorID').data('Sectors');
            var DeptID = $(this).val();
            $.each(Sectors.Data,
                    function(index, value) {
                      if (value.DeptID === DeptID) {
                        Options += '<option value="' + value.Sector_TownCode + '">'
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
            $("#Msg").hide();
            $("#example_wrapper").hide();
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
        'CallAPI': 'GetREPORTData',
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


  $("#PhysicalSlider").slider({
    range: "min",
    value: 0,
    min: 0,
    max: 100,
    slide: function(event, ui) {
      $("#PhysicalProgress").val(ui.value + "%");
    }
  });


  $("#FinancialSlider").slider({
    range: "min",
    value: 0,
    min: 0,
    max: 100,
    slide: function(event, ui) {
      $("#FinancialProgress").val(ui.value + "%");
    }
  });


});
