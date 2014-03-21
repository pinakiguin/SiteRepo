/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $('input[type="submit"]').button();
  $('input[type="button"]').button();
  $('input[type="delete"]').button();
  $('input[type="reset"]').button();

  $('#reset').click(function() {
    location.reload();
  });
  $("#TypeID").chosen({width: "350px",
    no_results_text: "Oops, nothing found!"
  });
  //set the schoolvalue depand on the School name.......
  $("#SchoolID").chosen({width: "450px",
    no_results_text: "Oops, nothing found!"
  }).change(function() {
    var School = Number($(this).val());
    var SchoolData = $('#SchoolName').data('SchoolData');
    $.each(SchoolData,
            function(index, value) {
              if (value.SchoolID === School)
              {
                $("#TotalStudent").val(value.TotalStudent);
                return false;
              }
            });
  });

//********************************
  //***********fetch individual school data****************..

  $('#Msg').html('Loaded Successfully');
});
