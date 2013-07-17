/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $(".ReceiptDate").datepicker({
    dateFormat: 'dd/mm/yy',
    showOtherMonths: true,
    selectOtherMonths: true,
    showButtonPanel: true,
    showAnim: "slideDown"
  });

  $(".DOB").datepicker({
    dateFormat: 'dd/mm/yy',
    maxDate: new Date(1996, 1 - 1, 1),
    showOtherMonths: true,
    selectOtherMonths: true,
    showButtonPanel: true,
    showAnim: "slideDown"
  });

  /**
   * @todo Tabs Rendered
   */
  $('#SRER_Forms').tabs({
    activate: function(event, ui) {
      $('#ActiveSRERForm').val(ui.newPanel.attr('id'));
    }
  });

  /**
   *  OnChange put PartID into hidden field #ActivePartID
   *  @todo PartID Selected
   */
  $('#PartID').chosen({width: "400px",
    no_results_text: "Oops, nothing found!"
  }).change(function() {
    $('#ActivePartID').val(this.value);
  });

  /**
   * Get the list of ACs and register change event to update Parts
   * @todo ACNo Change
   *
   */
  $('#ACNo').chosen({width: "300px",
    no_results_text: "Oops, nothing found!"
  }).change(function() {
    var Options = '<option value=""></option>';
    var Parts = $('#PartID').data('Parts');
    var ACNo = $('#ACNo').val();
    $.each(Parts.Data,
            function(index, value) {
              if (value.ACNo === ACNo) {
                Options += '<option value="' + value.PartID + '">' + value.PartNo + ' - ' + value.PartName + '</option>';
              }
            });
    $('#PartID').html(Options)
            .trigger("liszt:updated");
  });


  /**
   * GetACParts API Call for Caching of AC and Parts
   * Options for ACs are rendered and
   * for Parts Stored in $('#PartID').data('Parts', DataResp.Parts);
   * @todo Caching of AC and Parts
   */
  $.ajax({
    type: 'POST',
    url: '../MySQLiDB.ajax.php',
    dataType: 'html',
    xhrFields: {
      withCredentials: true
    },
    data: {
      'AjaxToken': $('#AjaxToken').val(),
      'CallAPI': 'GetACParts'
    }
  }).done(function(data) {
    var DataResp = $.parseJSON(data);
    delete data;
    $('#AjaxToken').val(DataResp.AjaxToken);
    $('#Msg').html(DataResp.Msg);
    $('#ED').html(DataResp.RT);
    var Options = '<option value=""></option>';
    $.each(DataResp.ACs.Data,
            function(index, value) {
              Options += '<option value="' + value.ACNo + '">' + value.ACNo + ' - ' + value.ACName + '</option>';
            });
    $('#ACNo').html(Options)
            .trigger("liszt:updated");
    $('#PartID').data('Parts', DataResp.Parts);
    delete DataResp;
  }).fail(function(msg) {
    $('#Msg').html(msg);
  });

  /**
   * On Edit Fetch the rows acordingly
   * @todo CmdEdit Click
   *
   */

  $('#CmdEdit').click(function() {
    var FromRow = $('#FromRow').val() - 1;
    if (FromRow <= 0) {
      FromRow = 0;
    }
    $.ajax({
      type: 'POST',
      url: '../MySQLiDB.ajax.php',
      dataType: 'html',
      xhrFields: {
        withCredentials: true
      },
      data: {
        'AjaxToken': $('#AjaxToken').val(),
        'CallAPI': 'GetSRERData',
        'TableName': $('#ActiveSRERForm').val(),
        'Params': new Array($('#ActivePartID').val(), FromRow, 10)
      }
    }).done(function(data) {
      $('#Error').html(data);
      var DataResp = $.parseJSON(data);
      delete data;
      $('#AjaxToken').val(DataResp.AjaxToken);
      $('#Msg').html(DataResp.Msg);
      $.each(DataResp.Data,
              function(index, value) {
                $.each(value, function(key, data) {
                  $('#' + $('#ActiveSRERForm').val() + key + index).val(data);
                });
              });
      $('#ED').html(DataResp.RT);
      delete DataResp;
    }).fail(function(msg) {
      $('#Msg').html(msg);
    });
  });

  /**
   * Insert the rows acordingly
   * @todo CmdSave Click [Currently Working to Get Last SlNo]
   */

  $('#CmdSave').click(function() {

    // for (i = 0; i < 10; i++) {
    var Params = new Array('');
    var i = 0, j = 0;
    $('[id^="' + $('#ActiveSRERForm').val() + '"][id$="' + i + '"]').each(function() {
      Params[j++] = $(this).attr('id');
      //Params[j++] = $(this).val();
    });
    Params[j] = $('#ActivePartID').val();
    // @todo May just the array be prepared instead of the whole request
    $.ajax({
      type: 'POST',
      url: '../MySQLiDB.ajax.php',
      dataType: 'html',
      xhrFields: {
        withCredentials: true
      },
      data: {
        'AjaxToken': $('#AjaxToken').val(),
        'CallAPI': 'PutSRERData',
        'TableName': $('#ActiveSRERForm').val(),
        'Params': Params
      }
    }).done(function(data) {
      $('#Error').append(document.createTextNode(data));
      var DataResp = $.parseJSON(data);
      delete data;
      $('#AjaxToken').val(DataResp.AjaxToken);
      $('#Msg').html(DataResp.Msg);
      /*$.each(DataResp.Data,
       function(index, value) {
       $.each(value, function(key, data) {
       $('#' + $('#ActiveSRERForm').val() + key + index).val(data);
       });
       });*/
      $('#ED').html(DataResp.RT);
      delete DataResp;
    }).fail(function(msg) {
      $('#Msg').html(msg);
    });
    //}
  });

  /**
   * On New Click
   *
   * @todo CmdNew Click [Currently Working to Get Last SlNo]
   */
  $('#CmdNew').click(function() {
    $.ajax({
      type: 'POST',
      url: '../MySQLiDB.ajax.php',
      dataType: 'html',
      xhrFields: {
        withCredentials: true
      },
      data: {
        'AjaxToken': $('#AjaxToken').val(),
        'CallAPI': 'GetLastSl',
        'TableName': $('#ActiveSRERForm').val(),
        'Params': new Array($('#ActivePartID').val())
      }
    }).done(function(data) {
      $('#Error').append(document.createTextNode(data));
      var DataResp = $.parseJSON(data);
      delete data;
      $('#AjaxToken').val(DataResp.AjaxToken);
      $('#Msg').html(DataResp.Msg);
      /*$.each(DataResp.Data,
       function(index, value) {
       $.each(value, function(key, data) {
       $('#' + $('#ActiveSRERForm').val() + key + index).val(data);
       });
       });*/
      $('#ED').html(DataResp.RT);
      delete DataResp;
    }).fail(function(msg) {
      $('#Msg').html(msg);
    });
    $('[id^="' + $('#ActiveSRERForm').val() + '"]').each(function() {
      $(this).val('');
    });
  });

  /**
   * @todo CmdDel Click
   */
  $('#CmdDel').click(function() {
    // @todo Implement CmdNew Click

    $('[id^="' + $('#ActiveSRERForm').val() + '"]').each(function() {
      $(this).val('');
    });
  });

  /**
   * Validates date in dd/mm/yyyy and dd-mm-yyyy format
   *
   * @todo Date Validator function
   *
   * @param {obj} inputText
   * @returns {Boolean}
   */
  function validatedate(inputText)
  {
    var dateformat = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
    // Match the date format through regular expression
    if (inputText.value.match(dateformat))
    {
      //Test which seperator is used '/' or '-'
      var opera1 = inputText.value.split('/');
      var opera2 = inputText.value.split('-');
      lopera1 = opera1.length;
      lopera2 = opera2.length;
      // Extract the string into month, date and year
      if (lopera1 > 1)
      {
        var pdate = inputText.value.split('/');
      }
      else if (lopera2 > 1)
      {
        var pdate = inputText.value.split('-');
      }
      var dd = parseInt(pdate[0]);
      var mm = parseInt(pdate[1]);
      var yy = parseInt(pdate[2]);
      // Create list of days of a month [assume there is no leap year by default]
      var ListofDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
      if (mm === 1 || mm > 2)
      {
        if (dd > ListofDays[mm - 1])
        {
          return false;
        }
      }
      if (mm === 2)
      {
        var lyear = false;
        if ((!(yy % 4) && yy % 100) || !(yy % 400))
        {
          lyear = true;
        }
        if ((lyear === false) && (dd >= 29))
        {
          return false;
        }
        if ((lyear === true) && (dd > 29))
        {
          return false;
        }
      }
    }
    else
    {
      return false;
    }
  }
});