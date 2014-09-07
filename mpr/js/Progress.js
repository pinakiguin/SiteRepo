$(function () {
    $('.chzn')
        .chosen({width: "150px",
            no_results_text: "Oops, nothing found!"
        });

    $("#Work").chosen({width: "300px",
        no_results_text: "Oops, nothing found!"
    }).change(function () {
        $("#frmProgress").submit();
    });

    $("#cmbScheme").change(function () {
        $("#frmProgress").submit();
    });

    $(".datePick").datepicker().css({"width": "80px"});

    $("#PhyPrgSlider").slider({
        range: "min",
        value: 0,
        min: 0,
        max: 100,
        slide: function (event, ui) {
            $("#PhyPrgValue").val(ui.value);
            $("#PhyPrgLbl").html(ui.value);
        }
    });
});
