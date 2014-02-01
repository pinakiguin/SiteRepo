/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(function() {
  $("#MsgText").on("keyup", function(event) {
    $("#PreviewSMS").html($("#MsgText").val());
  });
});

