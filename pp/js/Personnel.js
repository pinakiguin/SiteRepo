/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $('input[type="submit"]').button();
  $('input[type="reset"]').button();
  $('input[type="button"]').button();

  $("#PayScale").chosen({width: "300px",
    no_results_text: "Oops, nothing found!"});

  $("#OfficeSL").chosen({width: "650px",
    no_results_text: "Oops, nothing found!"})
          .change(function() {
            $.ajax({
              type: 'POST',
              url: 'MySQLiDB.pp.ajax.php',
              dataType: 'html',
              xhrFields: {
                withCredentials: true
              },
              data: {
                'AjaxToken': $('#AjaxToken').val(),
                'CallAPI': 'GetPersonnel',
                'Params': new Array($('#OfficeSL').val())
              }
            }).done(function(data) {
              try {
                var DataResp = $.parseJSON(data);
                delete data;
                $('#AjaxToken').val(DataResp.AjaxToken);
                $("#EmpName").autocomplete("option", "source", DataResp.Data);
                $('#ED').html(DataResp.RT);
                delete DataResp;
              }
              catch (e) {
                $('#Msg').html('Server Error:' + e);
                $('#Error').html(data);
              }
            }
            ).fail(function(msg) {
              $('#Msg').html(msg);
            });
          });

  $("#Qualification").chosen({width: "300px",
    no_results_text: "Oops, nothing found!"});

  $("#BranchName")
          .chosen({width: "250px",
            no_results_text: "Oops, nothing found!"})
          .change(function() {
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

  $("#BankName")
          .chosen({width: "250px",
            no_results_text: "Oops, nothing found!"})
          .change(function() {
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
            minLength: 3,
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

  $('#CmdDel').hide();

  $("#EmpName").autocomplete(
          {source: [],
            minLength: 2,
            focus: function(event) {
              event.preventDefault();
            },
            select: function(event, ui) {
              event.preventDefault();
              $('#EmpName').val(ui.item.label);
              $('#EmpSL').val(ui.item.value);
              $.ajax({
                type: 'POST',
                url: 'MySQLiDB.pp.ajax.php',
                dataType: 'html',
                xhrFields: {
                  withCredentials: true
                },
                data: {
                  'AjaxToken': $('#AjaxToken').val(),
                  'CallAPI': 'GetDataPP2',
                  'Params': new Array($('#EmpSL').val())
                }
              }).done(function(data) {
                try {
                  var DataResp = $.parseJSON(data);
                  delete data;
                  $.each(DataResp.Data,
                          function(index, value) {
                            $.each(value, function(key, data) {
                              var Field = $('#' + key);
                              Field.val(data);
                            });
                          });
                  $('#BankName').trigger("chosen:updated");
                  $('#BankName').trigger("change");
                  $('#BranchName').val(DataResp.Data[0].BranchName).trigger("chosen:updated");
                  $('#Remarks').trigger("chosen:updated");
                  $('#Qualification').trigger("chosen:updated");
                  $('#PayScale').trigger("chosen:updated");
                  if (DataResp.Data[0].SexId === 'male') {
                    $('#MaleId').attr("checked", "checked").button("refresh");
                  } else {
                    $('#FemaleId').attr("checked", "checked").button("refresh");
                  }
                  if (DataResp.Data[0].Language === 'None') {
                    $('#None').attr("checked", "checked").button("refresh");
                  } else if (DataResp.Data[0].Language === 'Hindi') {
                    $('#Hindi').attr("checked", "checked").button("refresh");
                  } else {
                    $('#Nepali').attr("checked", "checked").button("refresh");
                  }
                  if (DataResp.Data[0].PostingID === 'yes') {
                    $('#PostingID').attr("checked", "checked");
                  }
                  $('#CmdSaveUpdate').val('Update');
                  $('#CmdDel').show();

                  $('#AjaxToken').val(DataResp.AjaxToken);
                  $('#ED').html(DataResp.RT);
                  delete DataResp;
                }
                catch (e) {
                  $('#Msg').html('Server Error:' + e);
                  $('#Error').html(data);
                }
              }).fail(function(msg) {
                $('#Msg').html(msg);
              });
            },
            autoFocus: true
          });

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

  $('#TxtRemarksLabel').hide();

  $('#Remarks').change(function() {
    if ($(this).val() === '7') {
      $('#TxtRemarksLabel').show();
      $('#TxtRemarksSpanLabel').html("Why the employee cannot be spared");
      $('#TxtRemarks').attr("placeholder", "Mention Exact Reason");
      $(this).attr("name", "CmbRemarks");
      $('#CmbRemarksLabel').attr("for", "CmbRemarks");
      $('#TxtRemarksLabel').attr("for", "Remarks");
      $('#TxtRemarks').attr("name", "Remarks");
    } else if ($(this).val() === '5') {
      $('#TxtRemarksLabel').show();
      $('#TxtRemarksSpanLabel').html("Certificate Issued by appropriate authority");
      $('#TxtRemarks').attr("placeholder", "Mention Ref.number");
      $(this).attr("name", "CmbRemarks");
      $('#CmbRemarksLabel').attr("for", "CmbRemarks");
      $('#TxtRemarksLabel').attr("for", "Remarks");
      $('#TxtRemarks').attr("name", "Remarks");
    } else {
      $('#TxtRemarksLabel').hide();
      $(this).attr("name", "Remarks");
      $('#TxtRemarks').attr("name", "TxtRemarks");
      $('#CmbRemarksLabel').attr("for", "Remarks");
      $('#TxtRemarksLabel').attr("for", "TxtRemarks");
    }
  });
});