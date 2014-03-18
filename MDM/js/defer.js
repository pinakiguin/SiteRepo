
$(function() {
  $.ajax({
    type: 'POST',
    url: 'AjaxData.php',
    dataType: 'html',
    xhrFields: {
      withCredentials: true
    },
    data: {
      'AjaxToken': $('#AjaxToken').val(),
      'CallAPI': 'GetdailyData'
    }
  }).done(function(data) {
    try {
      var DataResp = $.parseJSON(data);
      // $('#Error').html(data);
      delete data;
      $('#Msg').html(DataResp.Msg);
      $('#ED').html(DataResp.RT);
      //$('#TotalReport').data('DailyReport', DataResp.DailyReport);
      //delete DataResp;
      $("#Msg").html('');
    }
    catch (e) {
      $('#Msg').html('Server Error:' + e);
      $('#Error').html(data);
    }
  }).fail(function(msg) {
    $('#Msg').html(msg);
  });
  var TotalMeal = 0;
  var TotalStudent = 0;
  var SubSData = array();
  var SubMData = array();
  var BlockSData = array();
  var BlockMData = array();
  var TotalBlock = array();
  var ReportedBlock = array();
  var TotalSchool = array();
  var ReportedSchool = array();

  $.each(DataResp, function(key, value) {
    TotalStudent = TotalStudent + parseInt(DataResp['TotalStudent']);
    TotalMeal = TotalMeal + parseInt(DataResp['Meal']);
    SubMData[value ['SubdivID']] = SubMData[value ['SubdivID']] + parseInt(DataResp['Meal']);
    SubSData[value ['SubdivID']] = SubSData[value ['SubdivID']] + parseInt(DataResp['TotalStudent']);
    BlockSData[value ['BlockID']] = BlockSData[value ['BlockID']] + parseInt(DataResp['TotalStudent']);
    BlockMData[value ['BlockID']] = BlockMData[value ['BlockID']] + parseInt(DataResp['Meal']);
  });
  var TotalBlock = count(DataResp);
  var TotalSchool = count(DataResp);
  //alert(result);
//  $('#TotalReport tr').each(function(i) {
//    $(this).find('td:first span').html(DataResp[i]);
//  });
});
function Blockcount(array, value) {
  var Blocknumber = 0;
  for (var i = 0; i < array.length; i++) {
    TotalBlock[value ['SubdivID']] = TotalBlock[value ['SubdivID']] + value [Blocknumber + 1];
  }
  return TotalBlock;

}
;
function Schoolcount(array, value) {
  var SchoolNumber = 0;
  for (var i = 0; i < array.length; i++) {
    TotalSchool[value ['BlockID']] = TotalSchool[value ['BlockID']] + value [SchoolNumber + 1];
  }
  return TotalSchool;

}
;