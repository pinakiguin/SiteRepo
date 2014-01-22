/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
google.load('visualization', '1', {packages: ['corechart']});
//google.setOnLoadCallback(drawVisualization);
$(function() {
  $('#CmdRefresh').click(function() {
    drawVisualization();
  });

  $.ajax({
    type: 'POST',
    url: 'AjaxMpr.php',
    dataType: 'html',
    xhrFields: {
      withCredentials: true
    }
  }).done(function(data) {
    try {
      var DataResp = $.parseJSON(data);
      delete data;
      var Options = '<option value=""></option>';
      $.each(DataResp.DeptID,
              function(index, value) {
                //option for Departments...
                Options += '<option value="' + value.DeptID + '">'
                        + value.DeptID + ' - ' + value.DeptName
                        + '</option>';
              });
      $('#DeptID').html(Options)
              .trigger("chosen:updated");
      $('#DeptID').data('DeptID', DataResp.DeptID);
      //option for Sectors..
      Options = '<option value=""></option>';
      $.each(DataResp.SectorID,
              function(index, value) {
                Options += '<option value="' + value.SectorID + '">'
                        + value.SectorID + ' - ' + value.SectorName
                        + '</option>';
              });
      $('#SectorID').html(Options)
              .trigger("chosen:updated");
      $('#SectorID').data('SectorID', DataResp.SectorID);
      //option for Schemes...
      Options = '<option value=""></option>';
      $.each(DataResp.SchemeID,
              function(index, value) {
                Options += '<option value="' + value.SchemeID + '">'
                        + value.SchemeID + ' - ' + value.SchemeName
                        + '</option>';
              });
      $('#SchemeID').html(Options)
              .trigger("chosen:updated");
      $('#SchemeID').data('SchemeID', DataResp.SchemeID);
      //option for projects...
      Options = '<option value=""></option>';
      $.each(DataResp.ProjectID,
              function(index, value) {
                Options += '<option value="' + value.ProjectID + '">'
                        + value.ProjectID + ' - ' + value.ProjectName
                        + '</option>';
              });
      $('#ProjectID').html(Options)
              .trigger("chosen:updated");
      $('#ProjectID').data('ProjectID', DataResp.ProjectID);
      delete DataResp;
      $("#Msg").html('');
    }
    catch (e) {
      $('#Msg').html('Server Error:' + e);
      $('#Error').html(data);
    }
  }).fail(function(msg) {
    $('#Msg').html(msg);
  });
});

/**
 *
 * @returns {undefined}
 */
function drawVisualization() {
  // Create and populate the data table.
  $.ajax({
    type: 'POST',
    url: 'AjaxMpr.php',
    dataType: 'html',
    xhrFields: {
      withCredentials: true
    },
    data: {
      'FormToken': $('#FormToken').val(),
      'CmdSubmit': 'GetREPORTData',
      'ProjectID': $('#ProjectID').val()
    }
  }).done(function(data) {
    try {
      var DataResp = $.parseJSON(data);
      delete data;
      $('#AjaxToken').val(DataResp.AjaxToken);
      $('#Msg').html(DataResp.Msg);
      $('#ED').html(DataResp.RT);
      var dataChart = new google.visualization.DataTable();
      dataChart.addColumn('string', 'Month');
      dataChart.addColumn('number', 'Physical Progress');
      dataChart.addColumn('number', 'Financial Progress');
      dataChart.addRows(3);
      dataChart.setValue(0, 0, 'January');
      dataChart.setValue(0, 1, 16);
      dataChart.setValue(0, 2, 93);
      dataChart.setValue(1, 0, 'February');
      dataChart.setValue(1, 1, 13);
      dataChart.setValue(1, 2, 112);
      dataChart.setValue(2, 0, 'March');
      dataChart.setValue(2, 1, 15);
      dataChart.setValue(2, 2, 116);

      // Create and draw the visualization.
      var ac = new google.visualization.ComboChart(document.getElementById('visualization'));
      ac.draw(dataChart, {
        title: 'Monthly Progress Report',
        width: 600,
        height: 400,
        vAxis: {title: "Progress"},
        hAxis: {title: "Month"},
        seriesType: "bars",
        series: {5: {type: "line"}}
      });
      delete DataResp;
      $("#Msg").hide();
    }
    catch (e) {
      $('#Msg').html('Server Error:' + e);
      $('#Error').html(data);
    }
  }).fail(function(msg) {
    $('#Msg').html(msg);
  });
}
