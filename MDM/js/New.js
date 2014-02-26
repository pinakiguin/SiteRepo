$(function() {
  $('input[type="submit"]').button();
  $('input[type="button"]').button();
  $('input[type="reset"]').button();
  $("#Mobile").numericInput();
  $("#TotalStudent").numericInput();
  $('#CmdSubmit').on("click", function() {
    $("#TxtAction").val($(this).val());
  });
  $('#ReportDate').datepicker({
    dateFormat: 'dd-mm-yy',
    showOn: "both",
    buttonImage: "images/calendar.gif",
    buttonImageOnly: true
  });
  $("#DesigID").chosen({width: "250px",
    no_results_text: "Oops, nothing found!"
  });
  //for date field
  $('#RegDate').datepicker({
    dateFormat: 'dd-mm-yy',
    showOn: "both",
    buttonImage: "images/calendar.gif",
    buttonImageOnly: true,
    changeMonth: true,
    changeYear: true,
    yearRange: "1960:1995"
  });
  $("#BlockID").chosen({width: "350px",
    no_results_text: "Oops, nothing found!"
  });
  $("#RegDate").val($.datepicker.formatDate("dd-mm-yy", new Date()));
  $('#RefreshSchool').click(function() {
    $('#frmNewAdd').trigger("reset");
    $("#SubDivID").trigger("chosen:updated");
    $("#BlockID").trigger("chosen:updated");
    $("#TypeID").trigger("chosen:updated");
  });
  $('#RefreshTeacher').click(function() {
    $('#frmNewAdd').trigger("reset");
    $("#SchoolID").trigger("chosen:updated");
    $("#DesigID").trigger("chosen:updated");
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
      });
      $("#Msg").html('');
    }
    catch (e) {
      $('#Msg').html('Server Error:' + e);
      // $('#Error').html(data);
    }
  }).fail(function(msg) {
    $('#Msg').html(msg);
  });
  $("#TypeID").chosen({width: "350px",
    no_results_text: "Oops, nothing found!"
  });
  //calling Ajax for fetching the School data...
  $.ajax({
    type: 'POST',
    url: 'AjaxData.php',
    dataType: 'html',
    xhrFields: {
      withCredentials: true
    },
    data: {
      'AjaxToken': $('#AjaxToken').val(),
      'CallAPI': 'GetSchoolData'
    }
  }).done(function(data) {
    try {
      var DataResp = $.parseJSON(data);
      delete data;
      $('#Msg').html(DataResp.Msg);
      $('#ED').html(DataResp.RT);
      var Options = '<option value=""></option>';
      $.each(DataResp.Data,
              function(index, value) {
                //option for Schools...
                Options += '<option value="' + value.SchoolID + '">'
                        + value.SchoolID + ' - ' + value.Schoolname
                        + '</option>';
              });
      $('#SchoolID').html(Options)
              .trigger("chosen:updated");
      $('#SchoolID').data('SchoolData', DataResp.Data);
      $("#Msg").html('');
    }
    catch (e) {
      $('#Msg').html('Server Error:' + e);
    }
  }).fail(function(msg) {
    $('#Msg').html(msg);
  });
  // set the schoolvalue depand on the School name.......
  $("#SchoolID").chosen({width: "450px",
    no_results_text: "Oops, nothing found!"
  }).change(function() {
    var School = Number($(this).val());
    var SchoolData = $('#SchoolID').data('SchoolData');
    $.each(SchoolData,
            function(index, value) {
              if (value.SchoolID === School)
              {

                $('#Mobile').val(value.Mobile);
                $("#RegDate").val(value.RegDate);
                $("#TotalStudent").val(value.TotalStudent);
                $("#NameID").val(value.NameID);
                $("#TotalStudent").val(value.TotalStudent);
                $("#SubDivID").val(value.SubdivName);
                $("#BlockID").val(value.BlockName);
                $("#DesigID").val(value.DesigID).trigger("chosen:updated");
                return false;
              }
            });
  });
  //*******save updated data...*******************************
  $('#CmdTeacher').click(function()
  {
    $.ajax({
      type: 'POST',
      url: 'AjaxSaveData.php',
      dataType: 'json',
      xhrFields: {
        withCredentials: true
      },
      data: {
        'FormToken': $('#FormToken').val(),
        'AjaxToken': $('#AjaxToken').val(),
        'CmdSubmit': 'Save Data',
        'RegDate': $("#RegDate").val(),
        'TotalStudent': $("#TotalStudent").val(),
        'NameID': $("#NameID").val(),
        'DesigID': $("#DesigID").val(),
        'Mobile': $("#Mobile").val(),
        'SchoolID': $("#SchoolID").val()
      }
    }).done(function(DataResp) {
      try {

        $("#FormToken").val(DataResp.FormToken);
        $("#AjaxToken").val(DataResp.AjaxToken);
        $("#Msg").html(DataResp.Msg);
        $("#CheckVal").html(DataResp.CheckVal);
        if (DataResp.CheckVal === null)
        {
          var SchoolData = $('#SchoolID').data('SchoolData');
          var School = Number($('#SchoolID').val());
          $.each(SchoolData,
                  function(index, value) {
                    if (value.SchoolID === School)
                    {
                      SchoolData[index].Mobile = $('#Mobile').val();
                      SchoolData[index].RegDate = $('#RegDate').val();
                      SchoolData[index].TotalStudent = $('#TotalStudent').val();
                      SchoolData[index].NameID = $('#NameID').val();
                      SchoolData[index].DesigID = $('#DesigID').val();
                      return false;
                    }
                  });
          $('#SchoolID').data('SchoolData', SchoolData);
          $('#frmedit').trigger("reset");
          $("#DesigID").trigger("chosen:updated");
          $("#SchoolID").trigger("chosen:updated");
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
  $('#CmdSchool').click(function() {
    {
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
          'TypeID': $("#TypeID").val()
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
            $("#TypeID").trigger("chosen:updated");
            location.reload();
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
    }
  });
  $('#Msg').html('Loaded Successfully');
});