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
  //calling Ajax for fetching the project data...
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
//       $('#Error').html(data);
      delete data;
      // $('#AjaxToken').val(DataResp.AjaxToken);
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
      var DataResp = $.parseJSON(data);
      // $('#SchoolID').data(DataResp.Data);
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
  // set the slider min value depand on the Scheme name.......
  $("#SchoolID").chosen({width: "450px",
    no_results_text: "Oops, nothing found!"
  }).change(function() {
    var SchoolID = Number($(this).val());
    // var Schools = $('#SchoolID').data;
    $.each(DataResp.Data,
            function(index, value) {
              if (value.SchoolID === SchoolID)
              {

                $('#Mobile').val(value.Mobile);
                $("#RegDate").val(value.RegDate);
                $("#TotalStudent").val(value.TotalStudent);
                $("#NameID").val(value.NameID);
                $("#TotalStudent").val(value.TotalStudent);
                $("#SubDivID").val(value.SubDivName);
                $("#BlockID").val(value.BlockName);
                $("#DesigID").val(value.DesigID).trigger("chosen:updated");
                return false;
              }
            });
  });

});