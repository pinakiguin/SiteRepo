/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $('input[type="submit"]').button();
  $('input[type="reset"]').button();
  $('input[type="button"]').button();
  $('.chzn-select').chosen({width: "250px",
    no_results_text: "Oops, nothing found!"
  });
  $("#PayScale").chosen({width: "350px",
    no_results_text: "Oops, nothing found!"
  });
  $("#OfficeSL").chosen({width: "600px",
    no_results_text: "Oops, nothing found!"
  });
  $("#BranchName").chosen({width: "250px",
    no_results_text: "Oops, nothing found!"
  }).change(function() {
    var BranchSL = Number($(this).val());
    var IFSC = $('#BranchName').data('BranchName');
    $.each(IFSC,
            function(index, value) {
              if (value.BranchSL === BranchSL) {
                $("#IFSC").val(value.IFSC);
                return false;
              }
            });
  });
  $("#BankName").chosen({width: "250px",
    no_results_text: "Oops, nothing found!"
  }).change(function() {
    var Options = '<option value=""></option>';
    var BranchName = $('#BranchName').data('BranchName');
    var BankSL = Number($(this).val());
    $.each(BranchName,
            function(index, value) {
              if (value.BankSL === BankSL) {
                Options += '<option value="' + value.BranchSL + '">'
                        + value.IFSC + ' - ' + value.BranchName
                        + '</option>';
              }
            });
    $('#BranchName').html(Options)
            .trigger("chosen:updated");
  });
  $('#DOB').datepicker({
    dateFormat: 'dd-mm-yy',
    showOn: "both",
    buttonImage: "images/calendar.gif",
    buttonImageOnly: true
  });
  $("#SexId").buttonset();
  $("#Posting").buttonset();
  $("#Language").buttonset();
  $("#EDCPBIssued").buttonset();
  $("#PBReturn").buttonset();
  $("#DesgID").autocomplete(
          {source: "AjaxDesgOC.php",
            minLength: 2,
            focus: function(event, ui) {
              event.preventDefault();
              $('#DesgID').val(ui.item.label);
            },
            select: function(event, ui) {
              event.preventDefault();
              $('#DesgID').val(ui.item.value);
            },
            autoFocus: true
          }
  );
  $("#EmpName").autocomplete(
          {source: "AjaxEmpName.php",
            minLength: 2,
            focus: function(event, ui) {
              event.preventDefault();
              $('#EmpName').val(ui.item.label);
            },
            select: function(event, ui) {
              event.preventDefault();
              $('#EmpName').val(ui.item.value);
            },
            autoFocus: true
          }
  );
  $.ajax({
    type: 'POST',
    url: 'AjaxPersonnel.php',
    dataType: 'html',
    xhrFields: {
      withCredentials: true
    }
  })
          .done(function(data) {
            try {
              var DataResp = $.parseJSON(data);
              delete data;
              var Options = '<option value=""></option>';
              $.each(DataResp.Scales,
                      function(index, value) {
                        Options += '<option value="' + value.ScaleCode + '">'
                                + value.ScaleCode + ' - ' + value.Scale
                                + '</option>';
                      });
              $('#PayScale').html(Options)
                      .trigger("chosen:updated");
              $('#PayScale').data('Scales', DataResp.Scales);
              Options = '<option value=""></option>';
              $.each(DataResp.OfficeSL,
                      function(index, value) {
                        Options += '<option value="' + value.OfficeSL + '">'
                                + value.OfficeSL + ' - ' + value.OfficeName
                                + '</option>';
                      });
              $('#OfficeSL').html(Options)
                      .trigger("chosen:updated");
              $('#OfficeSL').data('OfficeSL', DataResp.Scales);
              Options = '<option value=""></option>';
              $.each(DataResp.BankName,
                      function(index, value) {
                        Options += '<option value="' + value.BankSL + '">'
                                + value.BankSL + ' - ' + value.BankName
                                + '</option>';
                      });
              $('#BankName').html(Options)
                      .trigger("chosen:updated");
              $('#BankName').data('BankName', DataResp.BankName);
              $('#BranchName').data('BranchName', DataResp.BranchName);
              delete DataResp;
              $("#Msg").html('');
            }
            catch (e) {
              $('#Msg').html('Server Error:' + e);
              $('#Error').html(data);
            }
          })
          .fail(function(msg) {
            $('#Msg').html(msg);
          });
  $("#PayScale").bind({"change": function() {
      var ScaleCode = $(this).val();
      var Scales = $(this).data('Scales');
      $.each(Scales,
              function(index, value) {
                if (value.ScaleCode === ScaleCode) {
                  $("#GradePay").val(value.GradePay);
                  return false;
                }
              });
    }
  });
  $('#TxtRemarks1').hide();
  $('#Remarks').change(function() {
    if ($(this).val() == '7')
      $('#TxtRemarks1').show();
    else if ($(this).val() == '5')
    {
      $('#TxtRemarks1').show();
      $('#TxtRemarks.placeholder="Mention Ref.number"');
    }
    else
      $('#TxtRemarks1').hide();
  });
});
