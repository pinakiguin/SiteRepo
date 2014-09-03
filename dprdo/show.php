<?php
//ini_set('display_errors', '1');
//error_reporting(E_ALL);
require_once __DIR__ . '/../lib.inc.php';
$Roll = $_REQUEST['id'];
$DB = new MySQLiDBHelper();
$DB->where('RollNo', $Roll);
$result = $DB->get(MySQL_Pre . 'DPRDO_Admit');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Admit Card</title>
  <style type="text/css" media="screen">
    body {
      width: 750px;
      border: 1px solid;
      padding: 10px;
    }
  </style>
  <style type="text/css" media="all">
    body {
      font-size: 10px;
    }

    table {
      border-collapse: collapse;
    }

    table, th, td {
      border: 1px solid black;
      padding: 4px;
    }

    .photo {
      position: relative;
      width: 90px;
      height: 90px;
      float: right;
      font-size: 8px;
      text-align: center;
      border: 2px dashed;
      margin-top: -10px;
      padding: 5px 5px 5px 5px;
      display: table-cell;
      vertical-align: middle;
    }

    .photo div{
      float: none;
      border:none;
      width: 90px;
      height: 90px;
      margin:0;
      display: table-cell;
      vertical-align: middle;
    }
    .cut-here{
      border-bottom: 1px dashed #000000;
      height: 6px;
      text-align: center;
      clear: both;
    }
    .cut-here em{
      padding: 0px 4px 0px 4px;
      background-color: #ffffff;
    }
    ol,li{
      margin:0px 0px 0px 5px;
    }
    p {
      text-indent: 50px;
    }
  </style>
</head>
<body>
<div style="text-align: center;font-size: 12px;">
  <b>Government of West Bengal</b> <br/>
  <b>Office of the District Magistrate</b> <br/>
  <b>(Panchayats &amp; Rural Development Section)</b> <br/>
  <b>Paschim Medinipur</b>
</div>
<div style="clear: both;"></div>
<div style="float: left;">Memo. No.:1262(823) /III-11037/1/13-14-PRD</div>
<div style="float: right;">Date: 01-09-2014</div>
<div style="clear: both;"></div>
<div style="text-align: center; font-size: 10px;">
  <strong>PROVISIONAL ADMIT CARD FOR THE PROMOTIONAL EXAMINATION OF<br/>
    GRAM PANCHAYAT/PANCHAYAT SAMITI STAFF</strong>
</div>
<div style="text-align: center; font-size: 12px;">
  <strong>Roll No: <?php echo $result[0]['RollNo']; ?></strong>
</div>
<div style="clear: both;"></div>
<div style="float: left; font-size: 12px;line-height: 25px;">
  Name: <?php echo $result[0]['Name']; ?><br/>
  Designation: <?php echo $result[0]['Designation']; ?><br/>
  Name of GP/PS.: <?php echo $result[0]['GP']; ?>
</div>
<div class="photo">
  <div>SELF ATTESTED PASSPORT SIZE PHOTO TO BE PASTED HERE</div>
</div>
<div style="clear: both;"></div>
<p>You are hereby provisionally allowed to appear at the written test in connection
  with selection of candidate against the vacancy of Gram Panchayat and Panchayat
  Samiti level post under Paschim Medinipur district to be held <strong>on 21.09.2014
    at Colonelgola Sri Narayan Vidya Bhavan Boys' High School, Medinipur, Pin-721101.
  </strong>
</p>
<ol>
  <li>The test will commence at 12 noon. He/She is advised to report to the venue
    within 11:30 A.M. No candidate will be allowed to enter the examination hall
    after 12:30 PM. A composite time of one hour thirty minutes will be allowed for the test.
  </li>
  <li>The Test will be of 85 marks comprising questions on following subjects:
    <table>
      <tr>
        <td>1</td>
        <td style="width: 100px;">Deputy Secretary</td>
        <td>Govt. Orders relating to different schemes including NREGA, Chapter-VIII,
          IX, X, XI and XIV of Panchayat Act, 1973.
        </td>
      </tr>
      <tr>
        <td>2</td>
        <td>UDA</td>
        <td>Pay fixation, Reservation policy, Recruitment Rules for the posts of
          Panchayats Samitis, Pension Scheme &amp; GPF Scheme for the employees of
          P.R. Bodies.
        </td>
      </tr>
      <tr>
        <td>3</td>
        <td>Executive Assistant</td>
        <td>Panchayat Act, Rules, Schemes implemented by the Gram Panchayats.</td>
      </tr>
      <tr>
        <td>4</td>
        <td>Secretary</td>
        <td>Panchayat Act, Rules, Schemes implemented by the Gram Panchayats.</td>
      </tr>
      <tr>
        <td>5</td>
        <td>Sahayak</td>
        <td>Noting, Drafting</td>
      </tr>
    </table>
    The question of the test will be of MCQ type and OMR sheet will be given for
    examination.
  </li>
  <li>
    Black Ball point pen to be used for marking the correct answer.
  </li>
  <li>
    He/She is required to write on the stipulated part of the OMR Sheet his / her
    (a) Name (b) Roll No. <strong>Nowhere else in the </strong>OMR Sheet <strong>
      he/she should write his/her name, Roll No. or any other identification mark
      which may lead to rejection of the answer script</strong>.
  </li>
  <li>
    Candidates will sign and submit the duly filled in <strong>Part -II </strong>
    portion of this Card to the Invigilator at the Examination Centre. Photograph
    of the candidate of both the spaces must be identical.
  </li>
  <li>
    Use of Mobile phone/calculator/other communication instruments/gadgets within
    the examination centre is prohibited.
  </li>
  <li>It may please be noted that the verification of the eligibility of the candidate
    has not yet been made and hence the candidature of all the candidates is strictly
    provisional. Mere issue of this call letter does not confer upon the candidate any
    right to be appointed to the post if he/she is otherwise not qualified for the same
    in terms of the eligibility criteria prescribed by the Government.
  </li>
</ol>
<div style="clear: both;"></div>
<div style="float: left;">
  <p><strong>Date: 01/09/2014 </strong></p>

  <p><strong>Place: Medinipur</strong></p>
</div>
<div style="text-align: center;float: right;">
  <img src="sign.png" width="30"/><br/>
  Member Secretary<br/>
  District Level Selection Committee<br/>
  (For Gram Panchayat &amp; Panchayat Samiti)<br/>
  &amp;<br/>
  District Panchayat &amp; Rural Dev. Officer<br/>
  Paschim Medinipur
</div>
  <div class="cut-here">
    <em>Cut Here</em>
  </div>
<br/>
<div style="text-align: center;clear: both;"><strong>Part-II</strong></div>
<div class="photo">
  <div>SELF ATTESTED PASSPORT SIZE PHOTO TO BE PASTED HERE</div>
</div>
<div style="float: right;padding: 100px 10px 0px 0px;">
  Full Signature of the Invigilator
</div>
<div style="float: left;">
  <b>Date of Written Test for Promotional Examination: 21-09-2014</b><br/>
  <ol>
    <li>Name: <?php echo $result[0]['Name']; ?></li>
    <li>Roll No: <?php echo $result[0]['RollNo']; ?></li>
    <li>Mailing Address with PIN code:</li>
  </ol>
  <div style="text-align: center;padding-top: 40px;">
    Full Signature of the Candidate<br/>
    <em>(To be signed in the examination Hall before the Invigilator)</em>
  </div>
</div>
<div style="clear: both;"></div>
</body>
</html>