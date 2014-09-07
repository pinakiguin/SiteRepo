$(function () {
    $(".chzn").chosen({width: "200px",
        no_results_text: "Oops, nothing found!"
    });
    $(".datePicker").datepicker().css({"width": "80px"});

    $("#Scheme").chosen({width: "175px",
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
                'CallAPI': 'Works_GetWorks',
                'Scheme': $(this).val()
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
    });

    $("#UserID").chosen({width: "275px",
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
                'CallAPI': 'Works_GetWorks',
                'Scheme': $("#Scheme").val(),
                'User': $(this).val()
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
    });
});