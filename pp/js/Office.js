/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $("#InstType").autocomplete(
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
            autoFocus: true
          }
  );
});
