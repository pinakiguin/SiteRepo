/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $("#OfficeName").autocomplete(
          {source: "AjaxOffice.php",
            minLength: 5,
            focus: function(event, ui) {
              event.preventDefault();
            },
            select: function(event, ui) {
              event.preventDefault();
              $('#OfficeName').val(ui.item.label);
              $('#OfficeSL').val(ui.item.value);
              $.ajax({
                type: 'POST',
                url: 'MySQLiDB.pp.ajax.php',
                dataType: 'html',
                xhrFields: {
                  withCredentials: true
                },
                data: {
                  'AjaxToken': $('#AjaxToken').val(),
                  'CallAPI': 'GetOffice',
                  'Params': new Array($('#OfficeSL').val())
                }
              }).done(function(data) {
                try {
                  var DataResp = $.parseJSON(data);
                  delete data;
                  $('#AjaxToken').val(DataResp.AjaxToken);
                  $.each(DataResp.Data,
                          function(index, value) {
                            $.each(value, function(key, data) {
                              var Field = $('#' + key);
                              Field.val(data);
                            });
                          });
                  $('#ED').html(DataResp.RT);
                  $('#CmdSaveUpdate').val('Update');
                  delete DataResp;
                }
                catch (e) {
                  $('#Msg').html('Server Error:' + e);
                  $('#Error').html(data);
                }
              }
              ).fail(function(msg) {
                $('#Msg').html(msg);
              });
            },
            autoFocus: true
          }
  );
  $("#DesgOC").autocomplete(
          {source: "AjaxDesgOC.php",
            minLength: 2,
            focus: function(event, ui) {
              event.preventDefault();
              $('#DesgOC').val(ui.item.label);
            },
            select: function(event, ui) {
              event.preventDefault();
              $('#DesgOC').val(ui.item.value);
            },
            autoFocus: true
          }
  );
  $("#TypeCode").autocomplete(
          {source:
                    [
                      {label: "Central Government (01)", value: "01"},
                      {label: "State Government (02)", value: "02"},
                      {label: "Central Govt. Undertaking (03)", value: "03"},
                      {label: "State Govt. Undertaking (04)", value: "04"},
                      {label: "Local Bodies (05)", value: "05"},
                      {label: "Govt. Aided Organization (06)", value: "06"},
                      {label: "Autonomous Body (07)", value: "07"},
                      {label: "Others (Please Specify) (08)", value: "08"},
                    ],
            focus: function(event, ui) {
              event.preventDefault();
              $('#TypeCode').val(ui.item.label);
            },
            select: function(event, ui) {
              event.preventDefault();
              $('#TypeCode').val(ui.item.value);
            },
            autoFocus: true
          }
  );

  $("#Status").autocomplete(
          {source:
                    [
                      {"value": "01", "label": "Department\/Directorate\/Other subordinate Government Office (01)"},
                      {"value": "02", "label": "Railways (02)"},
                      {"value": "03", "label": "BSNL (03)"},
                      {"value": "04", "label": "Bank (04)"},
                      {"value": "05", "label": "L1C\/GIC etc Financial Institution (05)"},
                      {"value": "06", "label": "Income Tax\/Customs or other Revenue Collection Authority (06)"},
                      {"value": "07", "label": "Primary School (07)"},
                      {"value": "08", "label": "Secondary\/Higher Secondary School (08)"},
                      {"value": "09", "label": "College (09)"},
                      {"value": "10", "label": "University (10)"},
                      {"value": "11", "label": "Water\/Electricity Supply (11)"},
                      {"value": "12", "label": "Panchayat Body (12)"},
                      {"value": "13", "label": "Municipal Body (13)"},
                      {"value": "14", "label": "Others (Please Specify (14))"}
                    ],
            focus: function(event, ui) {
              event.preventDefault();
              $('#Status').val(ui.item.label);
            },
            select: function(event, ui) {
              event.preventDefault();
              $('#Status').val(ui.item.value);
            },
            autoFocus: true
          }
  );
  $("#PSCode").autocomplete(
          {source:
                    [
                      {"value": "01", "label": "KOTWALI (01)"},
                      {"value": "02", "label": "SALBONI (02)"},
                      {"value": "03", "label": "KESHPUR (03)"},
                      {"value": "04", "label": "GARBETA (04)"},
                      {"value": "05", "label": "GOALTORE (05)"},
                      {"value": "06", "label": "KHARAGPUR(L) (06)"},
                      {"value": "07", "label": "KHARAGPUR(R) (07)"},
                      {"value": "08", "label": "DEBRA (08)"},
                      {"value": "09", "label": "PINGLA (09)"},
                      {"value": "10", "label": "KESHIARY (10)"},
                      {"value": "11", "label": "DANTAN (11)"},
                      {"value": "12", "label": "BELDA (12)"},
                      {"value": "13", "label": "NARAYANGARH (13)"},
                      {"value": "14", "label": "MOHANPUR (14)"},
                      {"value": "15", "label": "SABONG (15)"},
                      {"value": "16", "label": "CHANDRAKONA (16)"},
                      {"value": "17", "label": "GHATAL (17)"},
                      {"value": "18", "label": "DASPUR (18)"},
                      {"value": "19", "label": "JHARGRAM (19)"},
                      {"value": "20", "label": "BELPAHARI (20)"},
                      {"value": "21", "label": "BINPUR (21)"},
                      {"value": "22", "label": "LALGARH (22)"},
                      {"value": "23", "label": "JAMBONI (23)"},
                      {"value": "24", "label": "NAYAGRAM (24)"},
                      {"value": "25", "label": "SANKRAIL (25)"},
                      {"value": "26", "label": "GOPIBALLAVPUR (26)"},
                      {"value": "27", "label": "BELIABERAH (27)"}
                    ],
            focus: function(event, ui) {
              event.preventDefault();
              $('#PSCode').val(ui.item.label);
            },
            select: function(event, ui) {
              event.preventDefault();
              $('#PSCode').val(ui.item.value);
            },
            autoFocus: true
          }
  );
  $("#ACNo").autocomplete(
          {source:
                    [
                      {"value": "219", "label": "219-DANTAN"},
                      {"value": "220", "label": "220-NAYAGRAM (ST)"},
                      {"value": "221", "label": "221-GOPIBALLAVPUR"},
                      {"value": "222", "label": "222-JHARGRAM"},
                      {"value": "223", "label": "223-KESHIARY (ST)"},
                      {"value": "224", "label": "224-KHARAGPUR SADAR"},
                      {"value": "225", "label": "225-NARAYANGARH"},
                      {"value": "226", "label": "226-SABANG"},
                      {"value": "227", "label": "227-PINGLA"},
                      {"value": "228", "label": "228-KHARAGPUR"},
                      {"value": "229", "label": "229-DEBRA"},
                      {"value": "230", "label": "230-DASPUR"},
                      {"value": "231", "label": "231-GHATAL (SC)"},
                      {"value": "232", "label": "232-CHANDRAKONA (SC)"},
                      {"value": "233", "label": "233-GARBETA"},
                      {"value": "234", "label": "234-SALBONI"},
                      {"value": "235", "label": "235-KESHPUR (SC)"},
                      {"value": "236", "label": "236-MEDINIPUR"},
                      {"value": "237", "label": "237-BINPUR (ST)"}
                    ],
            focus: function(event, ui) {
              event.preventDefault();
              $('#ACNo').val(ui.item.label);
            },
            select: function(event, ui) {
              event.preventDefault();
              $('#ACNo').val(ui.item.value);
            },
            autoFocus: true
          }
  );
  $('#Msg').html('');
});
