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
  $("#OfficeSL").chosen({width: "350px",
    no_results_text: "Oops, nothing found!"
  });
  $('#DOB').datepicker({
    showOn: "both",
    buttonImage: "images/calendar.gif",
    buttonImageOnly: true
  });
  $("#SexId").buttonset();
  $("#Posting").buttonset();
  $("#Language").buttonset();
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
              $.each(DataResp.OfficeSL,
                      function(index, value) {
                        Options += '<option value="' + value.OfficeSL + '">'
                                + value.OfficeSL + ' - ' + value.OfficeName
                                + '</option>';
                      });
              $('#OfficeSL').html(Options)
                      .trigger("chosen:updated");
              $('#OfficeSL').data('OfficeSL', DataResp.Scales);
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


  $("#PayScale").bind({"change": function() {
      var ScaleCode = Number($(this).val());
      var Scales = $(this).data('Scales');
      //alert($(this).val());
      $.each(Scales,
              function(index, value) {
                if (value.ScaleCode === ScaleCode) {
                  $("#GradePay").val(value.GradePay);
                  return false;
                }
              });
    }
  });
});
