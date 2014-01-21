/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $('input[type="submit"]').button();

  $('.chzn-select').chosen({width: "250px",
    no_results_text: "Oops, nothing found!"
  });

  $('.DatePicker').datepicker({dateFormat: 'yy-mm-dd'});

  $('.chzn-select').chosen({width: "250px",
    no_results_text: "Oops, nothing found!"
  });

  $('input[type="submit"]').button();
});
