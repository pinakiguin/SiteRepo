
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
//      $('#Msg').html(DataResp.Msg);
//      $('#ED').html(DataResp.RT);
      var TotalMeal = 0;
      var TotalStudent = 0;
      var SubSData = new Array();
      var SubMData = new Array();
      var BlockSData = new Array();
      var BlockMData = new Array();
      var TotalBlock = new Array();
      var ReportedBlock = new Array();
      var TotalSchool = new Array();
      var ReportedSchool = new Array();
      $.each(DataResp, function(key, value) {
        TotalStudent = TotalStudent + value['TotalStudent'];
        TotalMeal = TotalMeal + value['Meal'];
        SubMData[value ['SubdivID']] = SubMData[value ['SubdivID']] + parseInt(value['Meal']);
        SubSData[value ['SubdivID']] = SubSData[value ['SubdivID']] + parseInt(value['TotalStudent']);
        BlockSData[value ['BlockID']] = BlockSData[value ['BlockID']] + parseInt(value['TotalStudent']);
        BlockMData[value ['BlockID']] = BlockMData[value ['BlockID']] + parseInt(value['Meal']);
      });
      //$('#TotalReport').data('DailyReport', DataResp.DailyReport);
      //delete DataResp;
      $("#Msg").html('');
      // **********example of table population************************************************//
      var reservations = [
        {"HotelId": "01", "HotelName": "SPA", "ReservNum": "0166977",
          "Guest Name": "Jonny", "Room": null, "Type": "SUIT", "Rooms": "1",
          "Board": "BB", "Status": "IH", "Pax": "2,0,0,0", "Arrival": "07/08/12",
          "Departure": "09/08/12", "AgentDesc": "FIT", "AgentCode": "FIT",
          "Group": null, "Balance": "0", "Requests": "", "Remarks": null,
          "Fit/Group": "FIT", "ReturnGuestName": "", "StatusColor": "LightCoral"},
        {"HotelId": "01", "HotelName": "SPA", "ReservNum": "H000192", "Guest Name": null,
          "Room": null, "Type": "Folio", "Rooms": "0", "Board": "", "Status": "IH",
          "Pax": "0,0,0,0", "Arrival": "07/08/12", "Departure": "10/09/12",
          "AgentDesc": "movies", "AgentCode": "001", "Group": null, "Balance": "0",
          "Requests": "", "Remarks": "", "Fit/Group": "FIT", "ReturnGuestName": "",
          "StatusColor": "LightCoral"}
      ];

      var tbody = $('#TotalReport tbody'),
              props = ["HotelId", "Guest Name", "Status", "Arrival", "Departure", "Type"];
      $.each(reservations, function(i, reservation) {
        var tr = $('<tr>');
        $.each(props, function(i, prop) {
          $('<td>').html(reservation[prop]).appendTo(tr);
        });
        tbody.append(tr);
      });
//total block in try method done successfully..*******
//************************************************************************************
      $('#TotalMeal').val(TotalMeal);
      $('#TotalStudent').val(TotalStudent);
    }
    catch (e) {
      $('#Msg').html('Server Error:' + e);
      $('#Error').html(data);
    }
  }).fail(function(msg) {
    $('#Msg').html(msg);
  });
//  var TotalBlock = count(DataResp);
//  var TotalSchool = count(DataResp);
  //alert(result);
//  $('#TotalReport tr').each(function(i) {
//    $(this).find('td:first span').html(DataResp[i]);
//  });
});
//function Blockcount(array, value) {
//  var Blocknumber = 0;
//  for (var i = 0; i < array.length; i++) {
//    TotalBlock[DataResp ['SubdivID']] = TotalBlock[DataResp ['SubdivID']] + value [Blocknumber + 1];
//  }
//  return TotalBlock;
//
//}
//;
//function Schoolcount(array, value) {
//  var SchoolNumber = 0;
//  for (var i = 0; i < array.length; i++) {
//    TotalSchool[value ['BlockID']] = TotalSchool[value ['BlockID']] + value [SchoolNumber + 1];
//  }
//  return TotalSchool;
//
//}
//;