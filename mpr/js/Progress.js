$(function () {
    $('.chzn')
        .chosen({width: "150px",
            no_results_text: "Oops, nothing found!"
        });

    $("#Work").chosen({width: "300px",
        no_results_text: "Oops, nothing found!"
    }).change(function () {
        $.ajax({
            type: 'POST',
            url: 'AjaxData.php',
            dataType: 'html',
            xhrFields: {
                withCredentials: true
            },
            data: {
                'AjaxToken': $('#AjaxToken').val(),
                'CallAPI': 'Progress_GetDetails',
                'Work': $(this).val()
            }
        }).done(function (data) {
            try {
                $('#ProgressTable').html(data);
            }
            catch (e) {
                $('#Msg').html('Server Error:' + e);
                $('#Error').html(data);
            }
        }).fail(function (msg) {
            $('#Msg').html(msg);
        });
    });

    $("#cmbScheme").chosen({width: "175px",
        no_results_text: "Oops, nothing found!"
    }).change(function () {
        $.ajax({
            type: 'POST',
            url: 'AjaxData.php',
            dataType: 'html',
            xhrFields: {
                withCredentials: true
            },
            data: {
                'AjaxToken': $('#AjaxToken').val(),
                'CallAPI': 'Progress_GetWorks',
                'Scheme': $("#cmbScheme").val()
            }
        }).done(function (data) {
            try {
                $("#Work").html(data).trigger("chosen:updated");
                //alert(data);
                $.ajax({
                    type: 'POST',
                    url: 'AjaxData.php',
                    dataType: 'html',
                    xhrFields: {
                        withCredentials: true
                    },
                    data: {
                        'AjaxToken': $('#AjaxToken').val(),
                        'CallAPI': 'Progress_GetWorkDetails',
                        'Scheme': $("#cmbScheme").val()
                    }
                }).done(function (data) {
                    try {
                        $('#DataTable').html(data);
                    }
                    catch (e) {
                        $('#Msg').html('Server Error:' + e);
                        $('#Error').html(data);
                    }
                }).fail(function (msg) {
                    $('#Msg').html(msg);
                });
            }
            catch (e) {
                $('#Msg').html('Server Error:' + e);
                $('#Error').html(data);
            }
        }).fail(function (msg) {
            $('#Msg').html(msg);
        });

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
    }).find(".ui-slider-range").css({ "background": "#729fcf"})
      .find(".ui-slider-handle").css({ "border-color": "#729fcf"});
});
