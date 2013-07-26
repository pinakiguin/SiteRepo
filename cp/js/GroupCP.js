$(function() {

  /**
   * GetRequiredCP API Call for getting blockwise requirements of counting tables
   * Options for ACs are rendered and
   * for Parts Stored in $('#PartID').data('Parts', DataResp.Parts);
   */
  $('#GetRequiredCP').button()
          .bind('click', function() {
    $(this).button("option", "disabled", true);
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
                          + '<td id="Status' + index + '">Not Randomized</td></tr>';
                });
        $('#DetailCP').html(Options);
        $('#GroupCP').data('CountingTables', DataResp.Data);
        delete DataResp;
        $('#MakeGroupCP').button("option", "disabled", false);
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
  $('#MakeGroupCP').button({'disabled': true})
          .bind('click', function() {
    $(this).button("option", "disabled", true);
    var Tables = $('#GroupCP').data('CountingTables');
    $.each(Tables, function(Index, Data) {
      $('#Status' + Index).html('Processing...');
      $('#Msg').html('Processing ' + Data.BlockName + ' For ' + Data.Tables + ' Tables');
      $.ajax({
        type: 'POST',
        url: 'MakeGroup.ajax.php',
        dataType: 'html',
        //async: false,
        xhrFields: {
          withCredentials: true
        },
        data: {
          'AjaxToken': $('#AjaxToken').val(),
          'CallAPI': 'MakeGroupCP',
          'Params': Data,
          'Posts': Array(1, 2, 3)}
      })
              .done(function(data) {
        try {
          var DataResp = $.parseJSON(data);
          delete data;
          $('#AjaxToken').val(DataResp.AjaxToken);
          $('#Msg').html(DataResp.Msg);
          $('#ED').html(DataResp.RT);
          $('#Status' + Index).html(DataResp.Data.Status);
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
  });
  $('#Msg').html('Successfully Loaded!');
});