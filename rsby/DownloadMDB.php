<?php
require_once('../lib.inc.php');

WebLib::SetPATH(20);
WebLib::Html5Header('Download MDB');
WebLib::IncludeCSS();
?>
</head>
<body>
  <div class="TopPanel">
    <div class="LeftPanelSide"></div>
    <div class="RightPanelSide"></div>
    <h1><?php echo AppTitle; ?></h1>
  </div>
  <div class="Header"></div>
  <div class="MenuBar">
    <ul>
      <?php
      WebLib::ShowMenuitem('Home', '../');
      WebLib::ShowMenuitem('RSBY Beneficiary Data(Round 4)', 'rsby/Data.php');
      WebLib::ShowMenuitem('Download', 'rsby/DownloadMDB.php');
      WebLib::ShowMenuitem('Helpline', '../ContactUs.php');
      ?>
    </ul>
  </div>
  <div class="content">
    <?php

    function ShowFiles($dir) {
      $files = scandir($dir);
      //print_r($files);
      $rsby = array();
      foreach ($files as $key => $file) {
        if (strlen($file) > 4) {
          $Token = md5($dir . $file . session_id() . $_SERVER['REMOTE_ADDR']);
          $rsby[$Token]['DocName'] = $file;
          $rsby[$Token]['Location'] = $dir . $file;
          echo '<h3>Download: <a style="text-decoration:none;" target="_blank" href="Show.php?Token=' . $Token . '">' . $rsby[$Token]['DocName'] . '</a></h3>' . "\n";
        }
        //echo '<li><a style="text-decoration:none;" target="_blank" href="Show.php?Location='.$dir.$file.'&DocName='.substr(substr($file,0,strlen($file)-4),4).'">'.substr(substr($file,0,strlen($file)-4),4).'</a>';
      }
      $_SESSION['rsby'] = $rsby;
    }

    ShowFiles('data/');
    ?>
    <table width="431" class="tftable">
      <tbody><tr>
          <th width="71">Sl No</th>
          <th width="391">SCHOOL </th>
          <th width="159">Total Application Forwarded by DPMU </th>
          <th width="167">Verified and Forwarded to SPMU</th>
          <th width="118">Rejected applications </th>
        </tr>
        <tr>
          <td>1</td>
          <td>ANDHARIA R B HIGH S  U  PRY </td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202103702', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202103702', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202103702', '10999');">0</a></td>
        </tr>
        <tr>
          <td>2</td>
          <td>ATULMONI GIRLS HS U PRY</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202105704', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202105704', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202105704', '10999');">0</a></td>
        </tr>
        <tr>
          <td>3</td>
          <td>BAITA SRI GOPAL HS  U PRY </td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202105301', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202105301', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202105301', '10999');">0</a></td>
        </tr>
        <tr>
          <td>4</td>
          <td>BANPUKURIA AHLADI HIGH SCHOOL</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202108602', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202108602', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202108602', '10999');">0</a></td>
        </tr>
        <tr>
          <td>5</td>
          <td>BARKOLA VIVEKANANDA H S  U PRY</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202108604', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202108604', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202108604', '10999');">0</a></td>
        </tr>
        <tr>
          <td>6</td>
          <td>BINOD BEHARI MSK</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202110806', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202110806', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202110806', '10999');">0</a></td>
        </tr>
        <tr>
          <td>7</td>
          <td>BINOD BEHARI MSK</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202107902', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202107902', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202107902', '10999');">0</a></td>
        </tr>
        <tr>
          <td>8</td>
          <td>BINPUR HIGH SCHOOL U  PRY </td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202100301', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202100301', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202100301', '10999');">0</a></td>
        </tr>
        <tr>
          <td>9</td>
          <td>CHHATTISHGARH HS U PRY</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202106702', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202106702', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202106702', '10999');">0</a></td>
        </tr>




        <tr>
          <td>10</td>
          <td>DAHIJURI MAHATMA VIDYAPITH</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202103902', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202103902', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202103902', '10999');">0</a></td>
        </tr>




        <tr>
          <td>11</td>
          <td>GOHOMIDANGA HS  U PRY </td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202106401', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202106401', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202106401', '10999');">0</a></td>
        </tr>




        <tr>
          <td>12</td>
          <td>GOPALI I M H S  U PRY</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202111002', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202111002', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202111002', '10999');">0</a></td>
        </tr>




        <tr>
          <td>13</td>
          <td>HIJLI HIGH SCHOOL</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202102003', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202102003', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202102003', '10999');">0</a></td>
        </tr>




        <tr>
          <td>14</td>
          <td>KANTAPAHARI V V  VIDYAPITH  U </td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202108802', '10044');">7</a> <font color="#A54A30">(Pending-7)</font></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202108802', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202108802', '10999');">0</a></td>
        </tr>




        <tr>
          <td>15</td>
          <td>KENDRIYA VIDYALAYA II</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202109904', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202109904', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202109904', '10999');">0</a></td>
        </tr>




        <tr>
          <td>16</td>
          <td>KGP UTKAL VIDYAPITH U PRY</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202106804', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202106804', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202106804', '10999');">0</a></td>
        </tr>




        <tr>
          <td>17</td>
          <td>KHARGAPUR ATULMONY POLY U PR</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202105401', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202105401', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202105401', '10999');">0</a></td>
        </tr>




        <tr>
          <td>18</td>
          <td>KORIASOLE HIGH SCHOOL  U PRY</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202110606', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202110606', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202110606', '10999');">0</a></td>
        </tr>




        <tr>
          <td>19</td>
          <td>KUCHIABHULUK JR HIGH UPRY</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202111003', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202111003', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202111003', '10999');">0</a></td>
        </tr>




        <tr>
          <td>20</td>
          <td>K V II KHARAGPUR SCHOOL</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202104702', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202104702', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202104702', '10999');">0</a></td>
        </tr>




        <tr>
          <td>21</td>
          <td>LALGARH R K  VIDYALAYA  U PRY </td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202107402', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202107402', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202107402', '10999');">0</a></td>
        </tr>




        <tr>
          <td>22</td>
          <td>LALGARH S M B  VIDYALAYA  U PR</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202107602', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202107602', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202107602', '10999');">0</a></td>
        </tr>




        <tr>
          <td>23</td>
          <td>MATKATPUR MSK</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202108904', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202108904', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202108904', '10999');">0</a></td>
        </tr>




        <tr>
          <td>24</td>
          <td>MURABONI NETAJI JR   U PRY </td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202102401', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202102401', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202102401', '10999');">0</a></td>
        </tr>




        <tr>
          <td>25</td>
          <td>MURAR ASUTOSH JR  HS  U PRY </td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202109304', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202109304', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202109304', '10999');">0</a></td>
        </tr>




        <tr>
          <td>26</td>
          <td>MURKUNIA VIDYASAGAR MSK</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202107205', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202107205', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202107205', '10999');">0</a></td>
        </tr>




        <tr>
          <td>27</td>
          <td>NACHIPUR HIGH SCHOOL  U  PRY </td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202110902', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202110902', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202110902', '10999');">0</a></td>
        </tr>




        <tr>
          <td>28</td>
          <td>PANNCHBERIA L H M U PRY</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202100503', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202100503', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202100503', '10999');">0</a></td>
        </tr>




        <tr>
          <td>29</td>
          <td>PRATAPUR MSK</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202111502', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202111502', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202111502', '10999');">0</a></td>
        </tr>




        <tr>
          <td>30</td>
          <td>RAKHALGERIA JR HIGH UPRY</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202108402', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202108402', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202108402', '10999');">0</a></td>
        </tr>




        <tr>
          <td>31</td>
          <td>RAMGARH M S  HS  U PRY </td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202110101', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202110101', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202110101', '10999');">0</a></td>
        </tr>




        <tr>
          <td>32</td>
          <td>RANARANI A  HIGH SCHOOL U  PRY</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202102703', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202102703', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202102703', '10999');">0</a></td>
        </tr>




        <tr>
          <td>33</td>
          <td>SAKPARA JR HIGH UPRY</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202110102', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202110102', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202110102', '10999');">0</a></td>
        </tr>




        <tr>
          <td>34</td>
          <td>S E RLY BOYS H S SCHOOL</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202104603', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202104603', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202104603', '10999');">0</a></td>
        </tr>




        <tr>
          <td>35</td>
          <td>SRI KRISHNAPUR HIGH SCHOOL</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202105104', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202105104', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202105104', '10999');">0</a></td>
        </tr>




        <tr>
          <td>36</td>
          <td>SUBHASHPALLY JANAKALYAN VIDYA</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202105802', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202105802', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202105802', '10999');">0</a></td>
        </tr>




        <tr>
          <td>37</td>
          <td>SUBHASPALLI JANAKALYAN BALIKA</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202100103', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202100103', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202100103', '10999');">0</a></td>
        </tr>




        <tr>
          <td>38</td>
          <td>TALBAGICHA HIGH SCHOOL</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202100702', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202100702', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202100702', '10999');">0</a></td>
        </tr>




        <tr>
          <td>39</td>
          <td>TILABONI HS  U PRY </td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202101304', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202101304', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202101304', '10999');">0</a></td>
        </tr>




        <tr>
          <td>40</td>
          <td>WALIPUR JR HIGH UPRY</td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202107204', '10044');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202107204', '10046');">0</a></td>
          <td><a style="cursor:pointer;" onclick="bdo_redrict('19202107204', '10999');">0</a></td>
        </tr>


        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
      </tbody></table>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
  <script type="text/javascript">
    // ==UserScript==
    // @name       Hack Kanyashree Portal
    // @namespace  http://use.i.E.your.homepage/
    // @version    0.1
    // @description  ShowDISECode
    // @match      http://wbkanyashree.gov.in/*
    // @copyright  2012+, You
    // ==/UserScript==


    function ReplaceContentInContainer(selector, content) {
      alert("Started");
      var nodeList = document.getElementsByTagName(selector);
      var DiseCode = "", i = 0, length = 0, n = 0, j = 0;

      for (i = 0, length = nodeList.length; i < length; i++, j++) {
        if ((i % 3 == 0) && (i >= 3)) {
          DiseCode = nodeList[i].innerHTML;
          DiseCode.split("'");
          alert(nodeList[i - 2].innerHTML + " (" + n + ")" + DiseCode[0]);
        }
      }
    }

    ReplaceContentInContainer("td", "HELLO WORLD");
    alert("Hey!");
  </script>
</body>
</html>
