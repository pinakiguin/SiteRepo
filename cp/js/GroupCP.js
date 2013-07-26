$(function() {

  /**
   * GetRequiredCP API Call for getting blockwise requirements of counting tables
   * Options for ACs are rendered and
   * for Parts Stored in $('#PartID').data('Parts', DataResp.Parts);
   */
  $('#GetRequiredCP').button()
          .bind('click', function() {
    $.ajax({
      type: 'POST',
      url: 'MakeGroup.ajax.php',
      dataType: 'html',
      xhrFields: {
        withCredentials: true
      },
      data: {
        'AjaxToken': $('#AjaxToken').val(),
        'CallAPI': 'GetRequiredCP'
      }
    })
            .done(function(data) {
      try {
        var DataResp = $.parseJSON(data);
        delete data;
        $('#AjaxToken').val(DataResp.AjaxToken);
        $('#Msg').html(DataResp.Msg);
        $('#ED').html(DataResp.RT);
        var Options = '';
        $.each(DataResp.Data,
                function(index, value) {
                  Options += '<tr>'
                          + '<td>' + value.BlockName + '</td>'
                          + '<td id="AsmCode' + index + '">' + value.Assembly + '</td>'
                          + '<td>' + value.Tables + '</td>'
                          + '<td colspan="5"></td></tr>';
                });
        $('#DetailCP').html(Options);
        delete DataResp;
      }
      catch (e) {
        $('#Msg').html('Server Error:' + e);
        $('#Error').html(data);
      }
    })
            .fail(function(msg) {
      $('#Msg').html(msg);
    });
  });
  $('#MakeGroupCP').button()
          .bind('click', function() {
    alert('To Be Implemented...');
  });
});