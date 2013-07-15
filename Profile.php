<?php
/**
 * @todo User Password Change incomplete
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
  WebLib::ShowMenuBar();
  $action = 0;
  $Data = new MySQLiDB();
  if (WebLib::GetVal($_POST, 'FormToken') !== NULL) {
    if (WebLib::GetVal($_POST, 'FormToken') !== WebLib::GetVal($_SESSION, 'FormToken')) {
      $action = 4;
    } else {
      if (WebLib::GetVal($_POST, 'NewPassWD') !== md5(WebLib::GetVal($_POST, 'CNewPassWD') . md5(WebLib::GetVal($_SESSION, 'FormToken')))) {
        $action = 3;
      } elseif (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", WebLib::GetVal($_POST, 'NewPassWD'))) {
        $Qry = "Update `" . MySQL_Pre . "Users` set UserPass='" . WebLib::GetVal($_POST, 'CNewPassWD', TRUE)
                . "' where UserMapID=" . WebLib::GetVal($_SESSION, 'UserMapID') . " AND "
                . "md5(concat(`UserPass`,md5('" . WebLib::GetVal($_POST, 'FormToken') . "')))='"
                . WebLib::GetVal($_POST, 'OldPassWD') . "'";
        $rows = $Data->do_ins_query($Qry);
        if ($rows > 0) {
          $action = 1;
        } else {
          $action = 2;
        }
      } else {
        $action = 5;
      }
    }
    $_SESSION['FormToken'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . microtime());
  }
  ?>
  <div class="content">
    <?php
    $Msg[0] = NULL;
    $Msg[1] = "<b>Your password changed Successfully!</b>";
    $Msg[2] = "<b>Sorry! Invalid Old Password!</b>";
    $Msg[3] = "<b>New Passwords do not match.</b>";
    $Msg[4] = "<b>Un-Authorised " . WebLib::GetVal($_POST, 'FormToken') . "|" . WebLib::GetVal($_SESSION, 'FormToken') . "</b>";
    $Msg[5] = "<b>Your password is not safe.</b>";

    $_SESSION['Msg'] = $Msg[$action];
    WebLib::ShowMsg();
    if ($action !== 4) {
      ?>
      <div class="FieldGroup" id="dialog-form" title="Change Password">
        <form name="frmChgPWD" id="frmChgPWD" method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
          <label for="OldPassWD">Old Password:</label><br />
          <input type="password" name="OldPassWD" id="OldPassWD" />
          <input type="hidden" name="FormToken" value="<?php echo WebLib::GetVal($_SESSION, 'FormToken'); ?>" />
        </form>
      </div>
      <div class="FieldGroup" id="photo-form" title="Change Photo">
        <form action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>" method="post" onsubmit="return checkCoords();">
          <div class="UploadPhoto">
            <img class="ViewPhoto" src="" alt="User Photo">
            <label id="lblAdmitPhoto" for="AdmitPhoto">Select a Photograph:</label>
            <input type="file" id="AdmitPhoto" name="AdmitPhoto" accept="image/*" required="">
          </div>
          <input type="hidden" id="x" name="x" />
          <input type="hidden" id="y" name="y" />
          <input type="hidden" id="w" name="w" />
          <input type="hidden" id="h" name="h" />
        </form>
      </div>
      <input type="submit" id="update-photo" value="Upload Photo" class="btn btn-large btn-inverse" />
      <input type="button" id="create-user" value="Change Password" class="btn btn-inverse" />
      <?php
    }
    ?>
    <script>

          $('input[type=file]').change(function(e) {
            function updateCoords(c) {
              $('#x').val(c.x);
              $('#y').val(c.y);
              $('#w').val(c.w);
              $('#h').val(c.h);
              $('#AdmitPhoto').hide();
              $('#lblAdmitPhoto').hide();
            }
            if (typeof FileReader == "undefined")
              return true;

            var elem = $(this);
            var files = e.target.files;

            for (var i = 0, file; file = files[i]; i++) {
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
                          onSelect: updateCoords,
                        });
                      }
                    });
                  };
                })(file);
                reader.readAsDataURL(file);
              }
            }
          });
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

            $("#dialog-form").dialog({
              autoOpen: false,
              height: 300,
              width: 350,
              modal: true,
              buttons: {
                "Update": function() {
                  var menuId = $("ul.nav").first().attr("id");
                  var request = $.ajax({
                    url: "script.php",
                    type: "POST",
                    data: {id: menuId},
                    dataType: "html"
                  });
                },
                Cancel: function() {
                  $(this).dialog("close");
                }
              },
              close: function() {
                allFields.val("").removeClass("ui-state-error");
              }
            });

            $("#create-user")
                    .button()
                    .click(function() {
              $("#dialog-form").dialog("open");
            });

            $("#photo-form").dialog({
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
          });
    </script>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>

