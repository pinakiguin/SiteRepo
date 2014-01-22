/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $('input[type="submit"]').button();
  $('input[type="delete"]').button();
  $('input[type="reset"]').button();
//Date time
  $('.DatePicker').datepicker({dateFormat: 'yy-mm-dd'});
  //calling ajax
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
//  ("#PhysicalSlider").slider({
//    range: "min",
//    value: 0,
//    min: 0,
//    max: 100,
//    slide: function(event, ui) {
//      $("#lblPhysicalProgress").html("Physical Progress: " + ui.value + "%");
//      $("#PhysicalProgress").val(ui.value);
//    }
//  });
//  $("#FinancialSlider").slider({
//    range: "min",
//    value: 0,
//    min: 0,
//    max: 100,
//    slide: function(event, ui) {
//      $("#lblFinancialProgress").html("Financial Progress: " + ui.value + "%");
//      $("#FinancialProgress").val(ui.value);
//    }
//  });
//  $("#DeptID").chosen({width: "250px",
//    no_results_text: "Oops, nothing found!"});
});
