$(function() {
  $('input[type="submit"]').button();
  $('input[type="button"]').button();
  $('input[type="reset"]').button();
  $("#Mobile").numericInput();


  $("#Type").chosen({width: "350px",
    no_results_text: "Oops, nothing found!"
  });

  //fetch current date...


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
        'Schoolname': $("#Schoolname").val()
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