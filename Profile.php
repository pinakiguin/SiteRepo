<?php
/**
 * @todo User Password Change incomplete [Working currently]
 */
require_once('lib.inc.php');
WebLib::AuthSession();
WebLib::Html5Header("Profile");
WebLib::IncludeCSS();
WebLib::IncludeJS("js/md5.js");
WebLib::JQueryInclude();
WebLib::IncludeCSS("Jcrop/css/jquery.Jcrop.min.css");
WebLib::IncludeJS("Jcrop/js/jquery.Jcrop.min.js");
?>
<script>
  $(function() {
    function updateCoords(c) {
      $('#x').val(c.x);
      $('#y').val(c.y);
      $('#w').val(c.w);
      $('#h').val(c.h);
      $('#AdmitPhoto').hide();
      $('#lblAdmitPhoto').hide();
    }
    var name = $("#name"),
            email = $("#email"),
            password = $("#password"),
            allFields = $([]).add(name).add(email).add(password),
            tips = $(".validateTips");
    function updateTips(t) {
      tips
              .text(t)
              .addClass("ui-state-highlight");
      setTimeout(function() {
        tips.removeClass("ui-state-highlight", 1500);
      }, 500);
    }

    function checkLength(o, n, min, max) {
      if (o.val().length > max || o.val().length < min) {
        o.addClass("ui-state-error");
        updateTips("Length of " + n + " must be between " +
                min + " and " + max + ".");
        return false;
      } else {
        return true;
      }
    }

    function checkRegexp(o, regexp, n) {
      if (!(regexp.test(o.val()))) {
        o.addClass("ui-state-error");
        updateTips(n);
        return false;
      } else {
        return true;
      }
    }

    $("#chgpwd-form").dialog({
      autoOpen: false,
      modal: true,
      buttons: {
        "Update": function() {
          var OldPassword = MD5(MD5($('#OldPassWD').val()) + $('#AjaxToken').val());
          $.ajax({
            url: "MySQLiDB.ajax.php",
            type: "POST",
            data: {
              'AjaxToken': $('#AjaxToken').val(),
              'CallAPI': 'ChgPwd',
              'OldPass': OldPassword
            },
            dataType: "html"
          })
                  .done(function(data) {
            try {
              var DataResp = $.parseJSON(data);
              delete data;
              $('#AjaxToken').val(DataResp.AjaxToken);
              $('#Msg').html(DataResp.Msg);
              $('#ED').html(DataResp.RT);
              delete DataResp;
            }
            catch (e) {
              $('#Msg').html('' + e);
              $('#Error').html(data);
            }

          })
                  .fail(function() {
            $('#Msg').html(msg);
          });
          $(this).dialog("close");
        },
        Cancel: function() {
          $(this).dialog("close");
        }
      },
      close: function() {
        allFields.val("").removeClass("ui-state-error");
      }
    });

    $("#ChgPwd")
            .button()
            .click(function() {
      $("#chgpwd-form").dialog("open");
    });

    $("#photo-form")
            .dialog({
      autoOpen: false,
      height: 'auto',
      width: 'auto',
      modal: true,
      buttons: {
        "Update": function() {

        },
        Cancel: function() {
          $(this).dialog("close");
        }
      },
      close: function() {
        allFields.val("").removeClass("ui-state-error");
      }
    });
    $("#update-photo")
            .button()
            .click(function() {
      $("#photo-form").dialog("open");
    });

    $('input[type="button"]').button();
    $('#Msg').text('');
  });
  $('input[type=file]').change(function(e) {
    if (typeof FileReader === "undefined")
      return true;
    var elem = $(this);
    var files = e.target.files;
    for (var i = 0, file; (file = files[i]); i++) {
      if (file.type.match('image.*')) {
        var reader = new FileReader();
        reader.onload = (function(theFile) {
          return function(e) {
            var image = e.target.result;
            previewDiv = $('.ViewPhoto', elem.parent());
            previewDiv.attr({"src": image,
              "complete": function() {
                $('.ViewPhoto').Jcrop({
                  bgColor: 'black',
                  bgOpacity: .4,
                  setSelect: [0, 0, 180, 240],
                  aspectRatio: 3 / 4,
                  allowSelect: false,
                  onSelect: updateCoords
                });
              }
            });
          };
        })(file);
        reader.readAsDataURL(file);
      }
    }
  });
  function updateCoords(c) {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
    $('#AdmitPhoto').hide();
    $('#lblAdmitPhoto').hide();
  }
</script>
</head>
<body>
  <div class="TopPanel">
    <div class="LeftPanelSide"></div>
    <div class="RightPanelSide"></div>
    <h1><?php echo AppTitle; ?></h1>
  </div>
  <div class="Header">
  </div>
  <?php
  WebLib::ShowMenuBar('WebSite');
  ?>
  <div class="content">
    <span class="Message" id="Msg">
      <b>Loading please wait...</b>
    </span>
    <?php
    WebLib::ShowMsg();
    $Data = new MySQLiDB();
    ?>
    <div class="FieldGroup">
      <?php
      $_SESSION['Query'] = 'Select `DistCode`,`District`'
              . ' FROM `' . MySQL_Pre . 'SRER_Districts` '
              . ' Where `UserMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE);
      $Rows = $Data->ShowTable($_SESSION['Query']);
      echo 'Total Records:' . $Rows;
      ?>
    </div>
    <div class="FieldGroup" style="height: 500px;overflow:auto;">
      <?php
      $_SESSION['Query'] = 'Select `District`,`ACNo`,`ACName`'
              . ' FROM `' . MySQL_Pre . 'SRER_ACs` A '
              . ' JOIN `' . MySQL_Pre . 'SRER_Districts` D ON(A.`DistCode`=D.`DistCode`)'
              . ' Where A.`UserMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE);
      $Rows = $Data->ShowTable($_SESSION['Query']);
      echo 'Total Records:' . $Rows;
      ?>
    </div>
    <div class="FieldGroup" style="height: 500px;overflow:auto;">
      <?php
      $_SESSION['Query'] = 'Select `ACNo`,`PartNo`,`PartName`'
              . ' FROM `' . MySQL_Pre . 'SRER_PartMap`'
              . ' Where `UserMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE);
      $Rows = $Data->ShowTable($_SESSION['Query']);
      echo 'Total Records:' . $Rows;
      ?>
    </div>
    <div style="clear: both;"></div>
    <form action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>" method="post">
      <div id="chgpwd-form" title="Change Password" style="display: none;">
        <input type="password" placeholder="Enter Old Password" name="OldPassWD" id="OldPassWD" />
      </div>
      <div class="FieldGroup" id="photo-form" title="Change Photo" style="display: none;">
        <div class="UploadPhoto">
          <img class="ViewPhoto" src="" alt="User Photo">
          <label id="lblAdmitPhoto" for="AdmitPhoto">Select a Photograph:</label>
          <input type="file" id="AdmitPhoto" name="AdmitPhoto" accept="image/*" required="">
        </div>
        <input type="hidden" id="x" name="x" />
        <input type="hidden" id="y" name="y" />
        <input type="hidden" id="w" name="w" />
        <input type="hidden" id="h" name="h" />
      </div>
      <input type="hidden" id="AjaxToken" name="FormToken"
             value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
      <!--input type="button" value="Upload Photo" /-->
      <input type="button" id="ChgPwd" value="Change Password" />
    </form>
    <pre id="Error"></pre>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>

