<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Format PP2');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('pp/js/forms.js');
WebLib::IncludeCSS('pp/css/forms.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeJS('pp/js/Personnel.js');
?>
</head>
<body>
  <div class="TopPanel">
    <div class="LeftPanelSide"></div>
    <div class="RightPanelSide"></div>
    <h1><?php echo AppTitle; ?></h1>
  </div>
  <div class="Header"></div>
  <?php
  WebLib::ShowMenuBar('PP');
  ?>
  <span class="Message" id="Msg" style="float: right;">
    <b>Loading please wait...</b>
  </span>
  <div class="formWrapper" style="font-size: 12px;">
    <form method="post" id="frmPP2"
          action="<?php
          echo WebLib::GetVal($_SERVER, 'PHP_SELF');
          ?>" >
      <h3>Polling Personnel Information</h3>
      <?php
      include __DIR__ . '/PersonnelData.php';
      WebLib::ShowMsg();
      ?>
      <fieldset>
        <legend>Employee Details</legend>
        <div class="FieldGroup">
          <label for="OfficeSL">
            <strong>Name of The Office</strong>
          </label>
          <select id="OfficeSL" name="OfficeSL"
                  data-placeholder="Select Office Name" required />
          </select>
        </div>
        <div style="clear: both;"></div>
        <div class="FieldGroup">
          <input type="hidden" id="EmpSL" name="EmpSL" value="" />
          <label for="EmpName"><strong>Name of Employee</strong>
            <input type="text" name="EmpName" style="width: 300px;"
                   title="Type or Select from the suggesion list to edit record"
                   value="<?php
                   echo WebLib::GetVal($_SESSION['PostData'], 'EmpName');
                   ?>" id="EmpName" maxlength="50" required />
          </label>
          <label for="DesgID">Designation of Employee:</label>
          <input type="text" id="DesgID" name="DesgID" style="width: 300px;"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'DesgID')
                 ?>" maxlength="30" required/>
        </div>
        <div class="FieldGroup">
          <label for="DOB"><strong>Date Of Birth</strong>
            <input type="text" name="DOB" id="DOB" style="width: 83px;"
                   value="<?php
                   echo WebLib::GetVal($_SESSION['PostData'], 'DOB');
                   ?>" placeholder="dd-mm-yyyy" required/>
          </label>
          <span style="margin-left:5px;">Sex</span>
          <div id="SexId" style="margin-left:5px;">
            <input type="radio" id="MaleId" name="SexId" value="male" required />
            <label for="MaleId">Male</label>
            <input type="radio" id="FemaleId" name="SexId" value="female" required />
            <label for="FemaleId">Female</label>
          </div>
        </div>
        <div class="FieldGroup">
          <label id="CmbRemarksLabel" for="Remarks">
            <strong>Remarks</strong>
          </label>
          <select name="Remarks" id="Remarks" class="chzn-select"
                  data-placeholder="Select Remarks">
            <option value="0">0-Polling Personnel</option>
            <option value="1">1-Head Of Office</option>
            <option value="2">2-Night Guard/Armed Guard</option>
            <option value="3">3-Sweeper</option>
            <option value="4">4-Key Holder</option>
            <option value="5">5-Physically handicapped*</option>
            <option value="6">6-Peoples' Representative</option>
            <option value="7">7-Other</option>
          </select>
          <div id="TxtRemarksLabel">
            <label for="TxtRemarks">
              <strong>
                <span id="TxtRemarksSpanLabel"></span>
              </strong>
            </label>
            <input type="text" name="TxtRemarks" id="TxtRemarks"
                   placeholder="" />
          </div>
        </div>
        <div style="clear: both;"></div>
        <div class="FieldGroup">
          <label for="PostingID">
            <input type="checkbox" id="PostingID" name="PostingID" value="yes"/>
            <strong>working for 3 years out of 4 years
              in the district as on 30/06/2013</strong>
          </label>
        </div>
      </fieldset>
      <fieldset>
        <legend>Parliamentary Constituency</legend>
        <div class="FieldGroup">
          <label for="PcPreRes">
            <strong>Present</strong>
          </label>
          <input type="text" name="PcPreRes" style="width: 50px;"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'PcPreRes');
                 ?>" id="PcPreRes" maxlength="2" required/>
        </div>
        <div class="FieldGroup">
          <label for="PcPerRes">
            <strong>Permanent</strong>
          </label>
          <input type="text" name="PcPerRes" style="width: 50px;"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'PcPerRes');
                 ?>" id="PcPerRes" maxlength="2" required/>
        </div>
        <div class="FieldGroup">
          <label for="PcPosting">
            <strong>Posting</strong>
          </label>
          <input type="text" name="PcPosting" style="width: 50px;"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'PcPosting');
                 ?>" id="PcPosting" maxlength="2" required/>
        </div>
      </fieldset>
      <fieldset>
        <legend>Assembly Constituency</legend>
        <div class="FieldGroup">
          <label for="AcPreRes">
            <strong>Present</strong>
          </label>
          <input type="text" name="AcPreRes" style="width: 50px;"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'AcPreRes');
                 ?>" id="AcPreRes" maxlength="3" required/>
        </div>
        <div class="FieldGroup">
          <label for="AcPerRes">
            <strong>Permanent</strong>
          </label>
          <input type="text"  name="AcPerRes" style="width: 50px;"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'AcPerRes');
                 ?>" id="AcPerRes" maxlength="3" required/>
        </div>
        <div class="FieldGroup">
          <label for="AcPostiong">
            <strong>Posting</strong>
          </label>
          <input type="text" name="AcPosting" style="width: 50px;"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'AcPosting');
                 ?>" id="AcPosting" maxlength="3" required/>
        </div>
      </fieldset>
      <fieldset>
        <legend>Residential Address</legend>
        <div class="FieldGroup">
          <label for="DistHome">
            <strong>Home District</strong>
          </label>
          <input type="text" id="DistHome" name="DistHome" style="width: 150px;"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'DistHome');
                 ?>" maxlength="50" size="14" />

          <label for="HistPosting">
            <strong>Posting History</strong>
          </label>
          <input type="text" id="HistPosting" name="HistPosting" style="width: 150px;"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'HistPosting');
                 ?>" maxlength="50" size="14" />
        </div>
        <div class="FieldGroup">
          <label for="PreAddr1">
            <strong>Present/1</strong>
          </label>
          <input type="text" id="PreAddr1" name="PreAddr1" style="width: 190px;"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'PreAddr1');
                 ?>" required/>
          <label for="PreAddr2">
            <strong>Present/2</strong>
          </label>
          <input type="text" id="PreAddr2" name="PreAddr2" style="width: 190px;"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'PreAddr2');
                 ?>" required/>
        </div>
        <div class="FieldGroup">
          <label for="PerAddr1">
            <strong>Permanent/1</strong>
          </label>
          <input type="text"  id="PerAddr1" name="PerAddr1"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'PerAddr1');
                 ?>" required/>
          <label for="PerAddr2">
            <strong>Permanent/2</strong>
          </label>
          <input type="text"  id="PerAddr2" name="PerAddr2"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'PerAddr2');
                 ?>" required/>
        </div>
      </fieldset>
      <fieldset>
        <legend>Bank Details</legend>
        <div class="FieldGroup">
          <label for="BankName">
            <strong>Bank Name</strong>
          </label>
          <select id="BankName" name="BankName"
                  data-placeholder="Select Bank Name" required />
          </select>
          <input type="hidden" name="IFSC" id="IFSC"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'IFSC');
                 ?>"  readonly="readonly" size="10" required/>
        </div>
        <div class="FieldGroup">
          <label for="BankACNo">
            <strong>BankA/C No.</strong>
          </label>
          <input type="text" name="BankACNo" id="BankACNo"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'BankACNo');
                 ?>"  maxlength="16" size="16"
                 style="padding-right: 9px;width:130px;" required/>
        </div>
        <div style="clear: both;"></div>
        <div class="FieldGroup" style="padding-bottom: 10px;">
          <label for="BranchName">
            <strong>Branch Name</strong>
          </label>
          <select id="BranchName" name="BranchName"
                  data-placeholder="Select Branch Name" required />
          </select>
        </div>
      </fieldset>
      <fieldset>
        <legend>Contacts</legend>
        <div class="FieldGroup">
          <label for="ResPhone">
            <strong>Phone (Res.)</strong>
          </label>
          <input type="text" name="ResPhone" id="ResPhone" maxlength="11"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'ResPhone');
                 ?>" style="padding-right: 9px;width:90px;" />
        </div>
        <div class="FieldGroup">
          <label for="Mobile">
            <strong>Mobile</strong>
          </label>
          <input type="text"  id="Mobile" name="Mobile" maxlength="10"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'Mobile');
                 ?>" style="padding-right: 9px;width:80px;" required/>
        </div>
        <div class="FieldGroup">
          <label for="EMail">
            <strong>EMail</strong>
          </label>
          <input type="email" name="EMail" id="EMail" style="width: 270px;"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'EMail');
                 ?>"  size="30">
        </div>
      </fieldset>
      <fieldset>
        <legend>Details Of Enrollment in the current Electoral Roll</legend>
        <div class="FieldGroup">
          <label for="AcNo">
            <strong>AC No.</strong>
          </label>
          <input type="text" name="AcNo" id="AcNo" style="width: 50px;"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'AcNo');
                 ?>" maxlength="3" required/>
        </div>
        <div class="FieldGroup">
          <label for="PartNo">
            <strong>Part No.</strong>
          </label>
          <input type="text" name="PartNo" id="PartNo" style="width: 50px;"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'PartNo');
                 ?>" size="5" maxlength="3" required/>
        </div>
        <div class="FieldGroup">
          <label for="SLNo">
            <strong>SERIAL NO</strong>
          </label>
          <input type="text" name="SLNo" id="SLNo" style="width: 50px;"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'SLNo');
                 ?>" size="5" maxlength="4" required/>
        </div>
        <div class="FieldGroup">
          <label for="EPICNo">
            <strong>EPIC NO.</strong>
          </label>
          <input type="text" name="EPIC" id="EPIC"
                 size="13" maxlength="16" placeholder="Voter's ID"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'EPIC');
                 ?>" required/>
        </div>
      </fieldset>
      <fieldset>
        <legend>Pay Details</legend>
        <div class="FieldGroup">
          <label for="PayScale">
            <strong>Scale of Pay</strong>
          </label>
          <select id="PayScale" name="PayScale"
                  data-placeholder="Select Pay Scale" required />
          </select>
        </div>
        <div class="FieldGroup">
          <label for="BasicPay">
            <strong>Basic Pay </strong>
          </label>
          <input type="text" name="BasicPay" id="BasicPay" style="width: 50px;"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'BasicPay');
                 ?>" size="10" maxlength="5" required />
        </div>
        <input type="hidden" name="GradePay" id="GradePay"
               value="<?php
               echo WebLib::GetVal($_SESSION['PostData'], 'GradePay');
               ?>" size="10" maxlength="5" readonly="readonly" required />
      </fieldset>
      <fieldset>
        <legend>Qualifications</legend>
        <div class="FieldGroup">
          <label for="Qualification">
            <strong>Academic Qualification</strong>
          </label>
          <select name="Qualification" id="Qualification" data-placeholder=
                  "Select Qualification" required>
            <option value=""></option>
            <option value="1">1-Non Matric/VIII Standard or below</option>
            <option value="2">2-Matric/School Final or H.S</option>
            <option value="3">3-Graduate & Above</option>
          </select>
        </div>
        <div class="FieldGroup">
          <div id="Language" style="height: 60px;width: 250px;padding-left: 90px;">
            <strong>Language known other than Bengali</strong>
            <input type="radio" id="None" name="Language"  value="None"
                   checked="checked"/>
            <label for="None">None</label>
            <input type="radio" id="Hindi" name="Language" value="Hindi"/>
            <label for="Hindi">Hindi</label>
            <input type="radio" id="Nepali" name="Language" value="Nepali"/>
            <label for="Nepali">Nepali</label>
          </div>
        </div>
      </fieldset>
      <div style="clear: both;"></div>
      <hr/>
      <div class="formControl">
        <input type="submit" name="CmdSubmit" id="CmdSaveUpdate" value="Save"/>
        <input type="reset" name="CmdSubmit"  value="Reset"/>
        <input type="submit" name="CmdSubmit" id="CmdDel" value="Delete"/>
        <input type="hidden" name="CmdSubmit" id="TxtAction" />
        <input type="hidden" name="FormToken" id="FormToken"
               value="<?php
               echo WebLib::GetVal($_SESSION, 'FormToken');
               ?>" />
        <input type="hidden" id="AjaxToken"
               value="<?php
               echo WebLib::GetVal($_SESSION, 'Token');
               ?>" />
      </div>
    </form>
  </div>
  <pre id="Error">
  </pre>

  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>

