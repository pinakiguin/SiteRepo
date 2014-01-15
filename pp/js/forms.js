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

  $("#SexId").buttonset();
  $("#Posting").buttonset();
  $("#Language").buttonset();

});
