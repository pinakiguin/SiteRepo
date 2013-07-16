/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $(".ReceiptDate").datepicker({
    dateFormat: 'dd/mm/yy',
    showOtherMonths: true,
    selectOtherMonths: true,
    showButtonPanel: true,
    showAnim: "slideDown"
  });
  $(".DOB").datepicker({
    dateFormat: 'dd/mm/yy',
    maxDate: new Date(1996, 1 - 1, 1),
    showOtherMonths: true,
    selectOtherMonths: true,
    showButtonPanel: true,
    showAnim: "slideDown"
  });
  $("#Dept").autocomplete({
    source: "query.php",
    minLength: 3,
    select: function(event, ui) {
      $('#Dept').val(ui.item.value);
    }
  });
  $('#ACNo').chosen({width: "300px",
    no_results_text: "Oops, nothing found!"
  });
  $('#PartID').chosen({width: "400px",
    no_results_text: "Oops, nothing found!"
  });
  $(function() {
    $("#SRER_Forms").tabs();
  });
});