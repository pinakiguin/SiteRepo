
$(function () {

    var dialog = $("#createNewScheme").dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        buttons: {
            "Create Scheme": function(){
                $("#frmCreateScheme").submit();
                dialog.dialog( "close" );
            },
            Cancel: function() {
                dialog.dialog( "close" );
            }
        }
    });

    $(".chzn").chosen({width: "200px",
        no_results_text: "Oops, nothing found!"
    }).change(function () {
        if ($(this).val() === "NewScheme") {
            dialog.dialog("open");
        }
    });
});