/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $.getScript('https://www.google.com/jsapi', function() {
    google.load('visualization', '1', {packages: ['corechart']});
    google.setOnLoadCallback(drawVisualization);
  });

//  $.ajax({
//    type: 'POST',
//    url: 'AjaxData.php',
//    dataType: 'html',
//    xhrFields: {
//      withCredentials: true
//    },
//    data: {
//      'AjaxToken': $('#AjaxToken').val(),
//      'CallAPI': 'GetREPORTData'
//    }
//  }).done(function(data) {
//    try {
//      var DataResp = $.parseJSON(data);
//      delete data;
//      $('#AjaxToken').val(DataResp.AjaxToken);
//      $('#Msg').html(DataResp.Msg);
//      $('#ED').html(DataResp.RT);
//      var Options = '<option value=""></option>';
//      $.each(DataResp.Depts.Data,
//              function(index, value) {
//                Options += '<option value="' + value.DeptID + '">'
//                        + value.DeptID + ' - ' + value.DeptName
//                        + '</option>';
//              });
//      $('#CmbDeptID').html(Options)
//              .trigger("chosen:updated");
//      $('#CmbSectorID').data('Sectors', DataResp.Sectors);
//      $('#CmbSchemeID').data('Schemes', DataResp.Schemes);
//      $('#CmbProjectID').data('Projects', DataResp.Projects);
//      delete DataResp;
//      $("#Msg").hide();
//    }
//    catch (e) {
//      $('#Msg').html('Server Error:' + e);
//      $('#Error').html(data);
//    }
//  }).fail(function(msg) {
//    $('#Msg').html(msg);
//  });
});

/**
 *
 * @returns {undefined}
 */
function drawVisualization() {
  // Create and populate the data table.
  var data = new google.visualization.DataTable();
  data.addColumn('string', 'Month');
  data.addColumn('number', 'Physical Progress');
  data.addColumn('number', 'Financial Progress');
  data.addRows(3);
  data.setValue(0, 0, 'January');
  data.setValue(0, 1, 165);
  data.setValue(0, 2, 938);
  data.setValue(1, 0, 'February');
  data.setValue(1, 1, 135);
  data.setValue(1, 2, 1120);
  data.setValue(2, 0, 'March');
  data.setValue(2, 1, 157);
  data.setValue(2, 2, 1167);
  // Create and draw the visualization.
  var ac = new google.visualization.ComboChart(document.getElementById('visualization'));
  ac.draw(data, {
    title: 'Monthly Progress Report',
    width: 600,
    height: 400,
    vAxis: {title: "Progress"},
    hAxis: {title: "Month"},
    seriesType: "bars",
    series: {5: {type: "line"}}
  });
}