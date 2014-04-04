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
          'AjaxToken': $('#AjaxToken').val(),
          'CallAPI': 'SaveTmpl',
          'TmplName': $("#GroupName").val(),
          'Tmpl': $("#MsgText").val()
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

  $(".TmplCol").on("click", function() {
    $("#MsgText").insertAtCaret($(this).data('tmpl'));
  });

  $('#Msg').html('');
});

$.fn.insertAtCaret = function(text) {
  return this.each(function() {
    if (document.selection && this.tagName == 'TEXTAREA') {
      //IE textarea support
      this.focus();
      sel = document.selection.createRange();
      sel.text = text;
      this.focus();
    } else if (this.selectionStart || this.selectionStart == '0') {
      //MOZILLA/NETSCAPE support
      startPos = this.selectionStart;
      endPos = this.selectionEnd;
      scrollTop = this.scrollTop;
      this.value = this.value.substring(0, startPos) + text
              + this.value.substring(endPos, this.value.length);
      this.focus();
      this.selectionStart = startPos + text.length;
      this.selectionEnd = startPos + text.length;
      this.scrollTop = scrollTop;
    } else {
      // IE input[type=text] and other browsers
      this.value += text;
      this.focus();
      this.value = this.value;    // forces cursor to end
    }
  });
};