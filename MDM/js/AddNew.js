$(function() {
  $('input[type="submit"]').button();
  $('input[type="button"]').button();
  $('input[type="reset"]').button();
  $("#Mobile").numericInput();
  $("#TotalStudent").numericInput();
  $('#ReportDate').datepicker({
    dateFormat: 'dd-mm-yy',
    showOn: "both",
    buttonImage: "images/calendar.gif",
    buttonImageOnly: true
  });
  $("#BlockID").chosen({width: "350px",
    no_results_text: "Oops, nothing found!"
  });
  $("#TypeID").chosen({width: "200px",
    no_results_text: "Oops, nothing found!"
  });
//  $("#SubDivID").chosen({width: "250px",
//    no_results_text: "Oops, nothing found!"
//  });
  $("#DesigID").chosen({width: "250px",
    no_results_text: "Oops, nothing found!"
  });
  //for date field
  $('#RegDate').datepicker({
    dateFormat: 'dd-mm-yy',
    showOn: "both",
    buttonImage: "images/calendar.gif",
    buttonImageOnly: true
  });
  //fetch current date...
  $("#RegDate").val($.datepicker.formatDate("dd-mm-yy", new Date()));
  $('#Refresh').click(function() {
    $('#frmNewAdd').trigger("reset");
    $("#SubDivID").trigger("chosen:updated");
    $("#BlockID").trigger("chosen:updated");
    $("#DesigID").trigger("chosen:updated");
    $("#TypeID").trigger("chosen:updated");
    $("#RegDate").val($.datepicker.formatDate("dd-mm-yy", new Date()));
  });
  //call ajax for fetch data......
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
      delete DataResp;
      $("#SubDivID").chosen({width: "300px",
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
//calling ajax for saving data.............
  $("form").on("submit", function(event) {
    event.preventDefault();
    $('#Msg').html('Saving Please Wait...');
    $.ajax({
      type: 'POST',
      url: 'AjaxSaveData.php',
      dataType: 'html',
      xhrFields: {
        withCredentials: true
      },
      //data: $("#frmDepartment").serialize(),
      data: {
        'FormToken': $('#FormToken').val(),
        'AjaxToken': $('#AjaxToken').val(),
        'CmdSubmit': 'Add Data',
        'SubDivID': $("#SubDivID").val(),
        'BlockID': $("#BlockID").val(),
        'Schoolname': $("#Schoolname").val(),
        'TypeID': $("#TypeID").val(),
        'NameID': $("#NameID").val(),
        'Mobile': $("#Mobile").val(),
        'DesigID': $("#DesigID").val(),
        'RegDate': $("#RegDate").val(),
        'TotalStudent': $("#TotalStudent").val()
      }
    }).done(function(data) {
      try {
        var DataResp = $.parseJSON(data);
        delete data;
        $("#FormToken").val(DataResp.FormToken);
        $("#Ajax").val(DataResp.AjaxToken);
        $("#Msg").html(DataResp.Msg);
        if (DataResp.CheckVal === null)
        {
          $('#frmNewAdd').trigger("reset");
          $("#SubDivID").trigger("chosen:updated");
          $("#BlockID").trigger("chosen:updated");
          $("#DesigID").trigger("chosen:updated");
          $("#TypeID").trigger("chosen:updated");
          $("#RegDate").val($.datepicker.formatDate("dd-mm-yy", new Date()));
        }
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
  $('#Msg').html('Loaded Successfully');

});