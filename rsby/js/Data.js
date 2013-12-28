/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $('#example').dataTable({
    "ajax": "AjaxData.php",
    "columns": [
      {"data": "URN"},
      {"data": "EName"},
      {"data": "Father_HusbandName"},
      {"data": "Door_HouseNo"},
      {"data": "VillageCode"},
      {"data": "Panchayat_TownCode"},
      {"data": "BlockCode"}
    ],
    "jQueryUI": true,
    "lengthMenu": [[50, 250, 500, -1], [50, 250, 500, "All"]],
    "scrollY": 400/*,
     "paging": false,
     "jQueryUI": true,*/
  });

  $('.chzn-select').chosen({width: "300px",
    no_results_text: "Oops, nothing found!"
  });

  $('input[type="submit"]').button();
  /**
   * Get the list of ACs and register change event to update Parts
   * @todo ACNo Change event registered
   *
   */
  $('#ACNo')
          .chosen({width: "300px",
    no_results_text: "Oops, nothing found!"
  })
          .change(function() {
    var Options = '<option value=""></option>';
    var Parts = $('#PartID').data('Parts');
    var ACNo = $('#ACNo').val();
    $.each(Parts.Data,
            function(index, value) {
              if (value.ACNo === ACNo) {
                Options += '<option value="' + value.PartID + '">'
                        + value.PartNo + ' - ' + value.PartName
                        + '</option>';
              }
            });
    $('#PartID').html(Options)
            .trigger("liszt:updated");
  });
});
