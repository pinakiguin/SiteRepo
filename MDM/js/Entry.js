$(function() {
  $('input[type="submit"]').button();
  $('input[type="button"]').button();
  $("#SchoolName").chosen({width: "250px",
    no_results_text: "Oops, nothing found!"
  });
  //for date field
  $('#ReportDate').datepicker({
    dateFormat: 'dd-mm-yy',
    showOn: "both",
    buttonImage: "images/calendar.gif",
    buttonImageOnly: true,
    changeMonth: true,
    changeYear: true,
    yearRange: "2014:2030"
  });
  $("#ReportDate").val($.datepicker.formatDate("dd-mm-yy", new Date()));
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
      $('#SchoolName').html(Options)
              .trigger("chosen:updated");
      $('#SchoolName').data('SchoolData', DataResp.Data);
      $("#Msg").html('');
    }
    catch (e) {
      $('#Msg').html('Server Error:' + e);
    }
  }).fail(function(msg) {
    $('#Msg').html(msg);
  });
  // set the schoolvalue depand on the School name.......
  $("#SchoolName").chosen({width: "450px",
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
  //************************************************************

  $('#Pre').click(function() {
    var date2 = $('#ReportDate').datepicker('getDate');
    date2.setDate(date2.getDate() - 1);
    $('#ReportDate').datepicker('setDate', date2);
  });
  $('#Refresh').click(function() {
    location.reload();
  });
  //****************savung***************************************
  $('#Next').click(function() {
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
          'CmdSubmit': 'Insert Data',
          'ReportDate': $("#ReportDate").val(),
          'Meal': $("#Meal").val(),
          'SchoolID': $("#SchoolName").val(),
          'TotalStudent': $("#TotalStudent").val()

        }
      }).done(function(data) {
        try {
          var DataResp = $.parseJSON(data);
          delete data;
          $("#FormToken").val(DataResp.FormToken);
          $("#Ajax").val(DataResp.AjaxToken);
          $("#Msg").html(DataResp.Msg);
          if (DataResp.CheckVal !== null)
          {
            var date2 = $('#ReportDate').datepicker('getDate');
            date2.setDate(date2.getDate() + 1);
            $('#ReportDate').datepicker('setDate', date2);
            $("#Meal").val('');

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