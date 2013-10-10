<?php

session_start();

if (!isset($_SESSION['ShowAppsMsg'])) {
  require_once __DIR__ . '/lib.inc.php';
  WebLib::SetPATH(8);
  WebLib::initHTML5page("SiteRepo Discontinued");
  WebLib::JQueryInclude();
  ?>
  <style>
    .no-close .ui-dialog-titlebar-close {
      display: none;
    }
  </style>
  <script>
    $(function() {
      $("#dialog").dialog({
        dialogClass: "no-close",
        modal: true,
        height: 400,
        width: 600,
        closeOnEscape: false,
        buttons: {
          Ok: function() {
            window.location = "https://www.paschimmedinipur.gov.in/apps";
          }
        }
      });
    });
  </script>
  </head>
  <body>
    <div id="dialog" title="SiteRepo Discontinued">
      <p>
        Further development of <b>
          <a href="https://www.paschimmedinipur.gov.in/SiteRepo">SiteRepo</a>
        </b> has been <b>discontinued.</b>
      </p>
      <p>
        All further updates will be available on
      </p>
      <p>
        <span class="ui-icon ui-icon-circle-check" style="float:left;margin: 2px 0 0 0"></span>
        <a href="https://www.paschimmedinipur.gov.in/apps">http://www.paschimmedinipur.gov.in/apps</a>.
      </p>
      <p>
        The login credentials and data will remain same and available on both URLs until SRER-2014 is over.
        After that only the <b>
          <a href="https://www.paschimmedinipur.gov.in/apps">Apps link</a>
        </b> will be available and all data will remain unchanged.
      </p>
    </div>
  </body>
  </html>
  <?php

  session_unset();
  session_destroy();
  session_start();
  $_SESSION = array();
  $_SESSION['ShowAppsMsg'] = 1;
  exit();
}
?>
