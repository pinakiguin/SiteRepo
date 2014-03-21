/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $('input[type="submit"]').button();
  $('input[type="button"]').button();
  $('input[type="delete"]').button();
  $('input[type="reset"]').button();
  $('#Refresh').click(function() {
    location.reload();
  });
  $('#Reset').click(function() {
    $('#Schoolfrom').trigger("reset");
    $("#SubDivID").trigger("chosen:updated");
    $("#BlockID").trigger("chosen:updated");
    $("#SchoolID").trigger("chosen:updated");
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
  //fetch data....************************
  $.ajax({
    type: 'POST',
    url: 'AjaxData.php',
    dataType: 'html',
    xhrFields: {
      withCredentials: true
    },
    data: {
      'AjaxToken': $('#AjaxToken').val(),
      'CallAPI': 'GetChosenData'
    }
  }).done(function(data) {
    try {
      var DataResp = $.parseJSON(data);
      //$('#Error').html(data);
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
  //******************fetch school data*************
  $.ajax({
    type: 'POST',
    url: 'AjaxData.php',
    dataType: 'html',
    xhrFields: {
      withCredentials: true
    },
    data: {
      'AjaxToken': $('#AjaxToken').val(),
      'CallAPI': 'SchoolMealData'
    }
  }).done(function(data) {
    try {
      var DataResp = $.parseJSON(data);
      // $('#Error').html(data);
      delete data;
      $('#Msg').html(DataResp.Msg);
      $('#ED').html(DataResp.RT);
      $('#SchoolReportID').data('SchoolMealData', DataResp.SchoolMealData);
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
  // *****filter on school data**************
  $("#SchoolID").change(function() {
    var SchoolID = Number($(this).val());
    var ReportID = $('#SchoolReportID').data('SchoolMealData');
    $.each(ReportID.Data,
            function(index, value) {
              if (value.SchoolID === SchoolID)
              {

                $('#SchoolName').val(value.Schoolname);
                $('#MealMade').val(value.Meal);
                $("#TotalStudent").val(value.TotalStudent);

                return false;
              }
            });
  });

  $('#Msg').html('Loaded Successfully');
});
