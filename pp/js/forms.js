/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $('input[type="submit"]').button();
  $('input[type="reset"]').button();

  $('.chzn-select').chosen({width: "250px",
    no_results_text: "Oops, nothing found!"
  });

  $('#DOB').datepicker({
    showOn: "both",
    buttonImage: "images/calendar.gif",
    buttonImageOnly: true
  });
  $("#SexId").buttonset();
  $("#Posting").buttonset();
  $("#Language").buttonset();

});
