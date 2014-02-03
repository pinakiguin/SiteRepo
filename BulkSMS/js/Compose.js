/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(function() {
  $("#MsgText").on("change", function() {
    var Contacts = $("#PreviewSMS").data('Contacts');
    if (typeof Contacts === "undefined") {
      $.ajax({
        type: 'POST',
        url: 'GetContacts.php',
        dataType: 'html',
        xhrFields: {
          withCredentials: true
        },
        data: {
          'CallAPI': 'GetContacts',
          'Params': new Array($('#GroupName').val())
        }
      }).done(function(data) {
        try {
          var DataResp = $.parseJSON(data);
          $("#PreviewSMS").data('Contacts', data);
          Contacts = data;
          delete data;
          var Fields = '';
          $.each(DataResp, function(index, value) {
            if (index < 2) {
              $.each(value, function(Col, Key) {
                Fields += Col + ' = {' + Key + '}' + '<br/>';
              });
            }
          });
          Fields += '<br/>';
          $("#ListData").html(Fields);
          $('#Msg').html('');
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
    var T = jsontemplate.Template($("#MsgText").val());
    var Text = T.expand(Contacts);
    $("#PreviewSMS").parent().show();
    $("#PreviewSMS").html(Text);
  });
  $('#Msg').html('');
});

