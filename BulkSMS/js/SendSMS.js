/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(function() {
  $("#ShowPreview").on("click", function() {
    if ($(this).val() === "Show Preview") {
      $.ajax({
        type: 'POST',
        url: 'AjaxSMS.lib.php',
        dataType: 'json',
        xhrFields: {
          withCredentials: true
        },
        data: {
          'CallAPI': 'ShowOnly',
          'TmplName': $("#GroupName").val() //Currently not being used
        }
      }).done(function(DataResp) {
        try {
          $("#PreviewSMS").html(DataResp.TxtSMS);
          $("#PreviewSMS").parent().show();
          $("#ShowPreview").val("Hide Preview");
          $('#Msg').html('');
        }
        catch (e) {
          $('#Msg').html('Server Error:' + e);
          $('#Error').html(DataResp.Msg);
        }
      }).fail(function(msg) {
        $('#Msg').html(msg);
      });
    } else {
      $("#PreviewSMS").parent().hide();
      $("#ShowPreview").val("Show Preview");
    }
  });

  $('#Msg').html('');
});
