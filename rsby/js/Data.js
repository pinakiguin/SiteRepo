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
});
