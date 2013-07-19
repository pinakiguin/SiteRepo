/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * @todo Turned on the Checkboxes of changed records
 */

$(function() {
  $(".ReceiptDate").datepicker({
    dateFormat: 'yy-mm-dd',
    showOtherMonths: true,
    selectOtherMonths: true,
    showButtonPanel: true,
    showAnim: "slideDown"
  });

  $(".DOB").datepicker({
    dateFormat: 'yy-mm-dd',
    maxDate: new Date("1996-01-01"),
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
   * @todo ACNo Change event registered
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
                Options += '<option value="' + value.PartID + '">'
                        + value.PartNo + ' - ' + value.PartName
                        + '</option>';
              }
            });
    $('#PartID').html(Options)
            .trigger("liszt:updated");
  });


  /**
   * GetACParts API Call for Caching of AC and Parts
   * Options for ACs are rendered and
   * for Parts Stored in $('#PartID').data('Parts', DataResp.Parts);
   * @todo Caching of AC and Parts done
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
  })
          .done(function(data) {
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
  })
          .fail(function(msg) {
    $('#Msg').html(msg);
  });

  /**
   * On Edit Fetch the rows acordingly
   * @todo CmdEdit Click
   *
   */

  $('#' + $('#ActiveSRERForm').val() + 'CmdEdit')
          .click(function() {
    ClearAll();
    $('#Msg').html('Editing Please Wait...');
    var FromRow = $('#' + $('#ActiveSRERForm').val() + 'FromRow').val() - 1;
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
    })
            .done(function(data) {
      //$('#Error').html(data);
      var DataResp = $.parseJSON(data);
      delete data;
      $('#AjaxToken').val(DataResp.AjaxToken);
      $('#Msg').html(DataResp.Msg);
      $.each(DataResp.Data,
              function(index, value) {
                $.each(value, function(key, data) {
                  var Field = $('#' + $('#ActiveSRERForm').val() + key + index + '_D');
                  Field.val(data);
                  SaveFieldData(Field);
                });
              });
      $('#ED').html(DataResp.RT);
      delete DataResp;
    })
            .fail(function(msg) {
      $('#Msg').html(msg);
    });
  });

  /**
   * Insert the rows acordingly
   * @todo CmdSave Click [Currently Working to Get Last SlNo]
   * @todo Save only those rows that are selected by checkbox
   * @todo Clear Checkboxes on Save
   */

  $('#' + $('#ActiveSRERForm').val() + 'CmdSave')
          .click(function() {
    $('#Error').html('');
    $('#Msg').html('Preparing to Save Please Wait...');
    var i = 0, j, Params = new Array('');
    j = 0;
    $('input[type="checkbox"]').filter(':checked')
            .each(function() {
      Params[i] = new Object();
      $('#Msg').append(document.createTextNode($(this).val() + ', '));
      $('[id$="' + $(this).attr('id').slice(-3) + '"][id^="' + $('#ActiveSRERForm').val() + '"]')
              .each(function() {
        Params[i][$(this).attr('id').slice($('#ActiveSRERForm').val().length, -3)] = $(this).val();
      });
      Params[i++]["PartID"] = $('#ActivePartID').val();
    });
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
    })
            .done(function(data) {
      $('#Error').append(document.createTextNode(data));
      try {
        var DataResp = $.parseJSON(data);
        delete data;
        $('#AjaxToken').val(DataResp.AjaxToken);
        $('#Msg').html(DataResp.Msg);
        $('#ED').html(DataResp.RT);
        delete DataResp;
      }
      catch (e) {
        $('#Msg').html('Server Error:' + e);
      }
    })
            .fail(function(msg) {
      $('#Msg').html(msg);
    });
  });

  /**
   * On New Click
   *
   * @todo CmdNew Click [Currently Working to Get Last SlNo]
   */
  $('#' + $('#ActiveSRERForm').val() + 'CmdNew')
          .click(function() {
    $('#Msg').html('Creating Please Wait...');
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
      //$('#Error').append(document.createTextNode(data));
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
    ClearAll();
  });

  /**
   * @todo CmdDel Click
   * @todo Make API Call directly to delete.
   * @toto Implement SaveFieldData and DataChanged on Delete
   */
  $('#' + $('#ActiveSRERForm').val() + 'CmdDel')
          .click(function() {
    $('#Msg').html('RecordID: ');
    $('input[type="checkbox"]').filter(':checked').each(function() {

      $('#Msg').append(document.createTextNode($(this).val() + ', '));
      $('[id!="' + $('#ActiveSRERForm').val() + 'RowID' + $(this).attr('id').slice(-3) + '"]'
              + '[id$="' + $(this).attr('id').slice(-3) + '"]'
              + '[id^="' + $('#ActiveSRERForm').val() + '"]').val('');
    });
    $('#Msg').append(document.createTextNode(' deleted.'));
  });

  /**
   * Stores the initial data and bind the blur event of all fields
   */
  $('[id$="_D"]').each(function() {
    $(this).bind('blur', function() {
      DataChanged(this);
    });
    SaveFieldData(this);
  });

  /**
   * Shows the Tabs when loading completes.
   *
   * ****Important*****
   * Don't do anything beyond this at document ready
   */
  $('#SRER_Forms').css('display', 'table');
});

/**
 * Clears all the fields
 *
 * @returns {undefined}
 */
function ClearAll() {
  $('[id^="' + $('#ActiveSRERForm').val() + '"][id$="_D"]').each(function() {
    $(this).val('');
    SaveFieldData(this);
    if ($(this).filter(':checked').length !== 0) {
      $(this).click();//attr('checked', 'checked');
    }
  });
}

/**
 * Save the element data as it was while loaded from Database
 *
 * @param {jQuery} Obj
 * @returns {undefined}
 */
function SaveFieldData(Obj) {
  $(Obj).data('DB', $(Obj).val());
}

/**
 * Check the element data if it is still as it was while loaded from Database
 *
 * @todo Check the whole row if any data has been changed turn the corresponding checkbox acordingly
 *
 * @param {jQuery} Obj
 * @returns {undefined}
 */
function DataChanged(Obj) {
  var CheckBox = new Object();
  $('#Msg').text($(Obj).attr('id') + ':blur');
  if ($(Obj).data('DB') !== $(Obj).val()) {
    CheckBox = $('#' + $('#ActiveSRERForm').val() + 'RowID' + $(Obj).attr('id').slice(-3));
    if (CheckBox.filter(':checked').length === 0) {
      CheckBox.click();//attr('checked', 'checked');
    }
    $('#Msg').text($(Obj).attr('id') + ':changed[' + CheckBox.attr('checked') + ']');
  } else {
    var hasChangedAnyElementOnRow = 0;
    $('[id$="' + $(Obj).attr('id').slice(-3) + '"]').each(function() {
      if ($(this).data('DB') !== $(this).val()) {
        hasChangedAnyElementOnRow = 1;
        $('#Msg').text($(this).data('DB') + '!==' + $(this).val() + '|' + $(this).attr('id'));
      }
    });
    if (hasChangedAnyElementOnRow === 0) {
      CheckBox = $('#' + $('#ActiveSRERForm').val() + 'RowID' + $(Obj).attr('id').slice(-3));
      if (CheckBox.filter(':checked').length !== 0) {
        CheckBox.click();//removeAttr('checked');
      }
      $('#Msg').text($(Obj).attr('id') + ':All-unchanged[' + CheckBox.attr('checked') + ']');
    }
  }
}

/**
 * Validates date in dd/mm/yyyy and dd-mm-yyyy format
 *
 * @todo Date Validator function
 *
 * @param {obj} inputText
 * @returns {Boolean}
 */
function validatedate(inputText) {
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
