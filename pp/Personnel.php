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
  <div class="content">
    <span class="Message" id="Msg" style="float: right;">
      <b>Loading please wait...</b>
    </span>
    <div class="formWrapper">
      <form method="post"
            action="<?php
            echo WebLib::GetVal($_SERVER, 'PHP_SELF');
            ?>" >
        <h3>Personnel Information</h3>
        <?php
        include __DIR__ . '/PersonnelData.php';
        WebLib::ShowMsg();
        ?>
        <fieldset>
          <legend>Employee Details</legend>
          <div class="FieldGroup">
            <label for="OfficeSL"><strong>Name of The Office</strong>
              <select id="OfficeSL" name="OfficeSL"
                      data-placeholder="Select Office Name" required />
              </select>
            </label>
          </div>
          <div style="clear: both;"></div>
          <div class="FieldGroup">
            <input type="hidden" id="EmpSL" name="EmpSL" value="" />
            <label for="EmpName"><strong>Name of Employee</strong>
              <input type="text" name="EmpName" id="EmpName"
                     title="Type or Select from the suggesion list to edit record"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'EmpName');
                     ?>"
                     required />
            </label>
            <label for="DesgID">Designation of Employee:</label>
            <input id="DesgID" name="DesgID" type="text" maxlength="30"
                   value="<?php
                   echo WebLib::GetVal($_SESSION['PostData'], 'DesgID')
                   ?>" required/>
          </div>
          <div class="FieldGroup">
            <label for="DOB"><strong>Date Of Birth</strong>
              <input type="text" name="DOB" id="DOB" placeholder="dd-mm-yyyy"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'DOB');
                     ?>"
                     required/>
            </label>
            <strong>Sex</strong>
            <div id="SexId">
              <input type="radio" id="MaleId" name="SexId" value="male" required />
              <label for="MaleId">Male</label>
              <input type="radio" id="FemaleId" name="SexId" value="female" required />
              <label for="FemaleId">Female</label>
            </div>
          </div>
          <div class="FieldGroup">
            <label id="CmbRemarksLabel" for="Remarks">
              <strong>Remarks</strong>
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
            </label>
            <label id="TxtRemarksLabel" for="TxtRemarks" id="TxtRemarks1">
              <strong><span id="TxtRemarksSpanLabel"></span></strong>
              <input type="text" name="TxtRemarks" id="TxtRemarks"
                     placeholder="" />
            </label>
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
            <label for="PcPreRes"><strong>Present Residence</strong>
              <input type="text" name="PcPreRes" id="PcPreRes"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PcPreRes');
                     ?>" size="12" maxlength="2" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PcPerRes"><strong>Permanent Residence</strong>
              <input type="text" name="PcPerRes" id="PcPerRes"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PcPerRes');
                     ?>" size="12" maxlength="2" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PcPosting"><strong>Place of posting</strong>
              <input type="text" name="PcPosting"  id="PcPosting"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PcPosting');
                     ?>" size="11" maxlength="2" required/>
            </label>
          </div>
        </fieldset>

        <fieldset>
          <legend>Assembly Constituency</legend>
          <div class="FieldGroup">
            <label for="AcPreRes"><strong>Present Residence</strong>
              <input type="text" name="AcPreRes"  id="AcPreRes"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'AcPreRes');
                     ?>" size="12" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="AcPerRes"><strong>Permanent Residence</strong>
              <input type="text"  name="AcPerRes" id="AcPerRes"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'AcPerRes');
                     ?>" size="12" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="AcPostiong"><strong>Place of Posting </strong>
              <input type="text" name="AcPosting" id="AcPosting"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'AcPosting');
                     ?>" size="11" maxlength="3" required/>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Residential Address</legend>
          <div class="FieldGroup">
            <label for="DistHome"><strong>Home District</strong>
              <input type="text"  id="DistHome" name="DistHome"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'DistHome');
                     ?>" maxlength="50" size="14" />
            </label>
            <label for="HistPosting"><strong>Posting History</strong>
              <input type="text"  id="HistPosting" name="HistPosting"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'HistPosting');
                     ?>" maxlength="50" size="14" />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PreAddr1"><strong>Present/1</strong>
              <input type="text"  id="PreAddr1" name="PreAddr1"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PreAddr1');
                     ?>"
                     required/>
            </label>
            <label for="PreAddr2"><strong>Present/2</strong>
              <input type="text"  id="PreAddr2" name="PreAddr2"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PreAddr2');
                     ?>"
                     required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PerAddr1"><strong>Permanent/1</strong>
              <input type="text"  id="PerAddr1" name="PerAddr1"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PerAddr1');
                     ?>"
                     required/>
            </label>
            <label for="PerAddr2"><strong>Permanent/2</strong>
              <input type="text"  id="PerAddr2" name="PerAddr2"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PerAddr2');
                     ?>"
                     required/>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Bank Details</legend>
          <div class="FieldGroup">
            <label for="BankName"><strong>Bank Name</strong>
              <select id="BankName" name="BankName"
                      data-placeholder="Select Bank Name" required />
              </select>
            </label>
            <label for="BranchName"><strong>Branch Name</strong>
              <select id="BranchName" name="BranchName"
                      data-placeholder="Select Branch Name" required />
              </select>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="BankACNo"><strong>BankA/C No.</strong>
              <input type="text" name="BankACNo" id="BankACNo" value="<?php
              echo WebLib::GetVal($_SESSION['PostData'], 'BankACNo');
              ?>"  maxlength="16" size="20" required/>
            </label>
            <label for="IFSC"><strong>IFSC Code</strong>
              <input type="text" name="IFSC" id="IFSC"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'IFSC');
                     ?>"  readonly="readonly" size="20" required/>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Contacts</legend>
          <div class="FieldGroup">
            <label for="ResPhone"><strong>Phone(Residence)</strong>
              <input type="text" name="ResPhone" id="ResPhone" size="15"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'ResPhone');
                     ?>" size="20" />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="Mobile"><strong>Mobile</strong>
              <input type="text"  id="Mobile" name="Mobile"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'Mobile');
                     ?>" size="19" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="EMail"><strong>EMail</strong>
              <input type="email" name="EMail" id="EMail"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'EMail');
                     ?>"  size="20">
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Details Of Enrollment in the current Electoral Roll</legend>
          <div class="FieldGroup">
            <label for="AcNo"><strong>AC No.</strong>
              <input type="text" name="AcNo" id="AcNo"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'AcNo');
                     ?>"
                     size="5" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PartNo"><strong>Part No.</strong>
              <input type="text" name="PartNo"  id="PartNo"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PartNo');
                     ?>"
                     size="5" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="SLNo"><strong>SERIAL NO</strong>
              <input type="text" name="SLNo" id="SLNo"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'SLNo');
                     ?>"
                     size="5" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="EPICNo"><strong>EPIC NO.</strong>
              <input type="text" name="EPIC" id="EPIC"
                     size="13" maxlength="16" placeholder="Voter's ID"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'EPIC');
                     ?>" required/>
            </label>
          </div>
        </fieldset>
        <div style="clear: both;"></div>
        <fieldset>
          <legend>Pay Details</legend>
          <div class="FieldGroup">
            <label for="PayScale"><strong>Scale of Pay</strong>
              <select id="PayScale" name="PayScale"
                      data-placeholder="Select Pay Scale" required />
              </select>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="BasicPay"><strong>Basic Pay </strong>
              <input type="text" name="BasicPay" id="BasicPay"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'BasicPay');
                     ?>" size="10" maxlength="5" required />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="GradePay"><strong>Grade Pay</strong>
              <input type="text" name="GradePay" id="GradePay"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'GradePay');
                     ?>"
                     size="10" maxlength="5" readonly="readonly" required />
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Qualifications</legend>
          <div class="FieldGroup">
            <label for="Qualification"><strong>Academic Qualification</strong>
              <select name="Qualification" id="Qualification" data-placeholder=
                      "Select Qualification" required>
                <option value=""></option>
                <option value="1">1-Non Matric/VIII Standard or below</option>
                <option value="2">2-Matric/School Final or H.S</option>
                <option value="3">3-Graduate & Above</option>
              </select>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="Language"><strong>Language known other than Bengali</strong>
              <div id="Language">
                <input type="radio" id="None" name="Language"  value="None"
                       checked="checked"/>
                <label for="None">None</label>
                <input type="radio" id="Hindi" name="Language" value="Hindi"/>
                <label for="Hindi">Hindi</label>
                <input type="radio" id="Nepali" name="Language" value="Nepali"/>
                <label for="Nepali">Nepali</label>
              </div>
            </label>
          </div>
        </fieldset>
        <div style="clear: both;"></div>
        <hr/>
        <div class="formControl">
          <input type="submit" name="CmdSubmit" id="CmdSaveUpdate" value="Save"/>
          <input type="reset" name="CmdSubmit"  value="Reset"/>
          <input type="submit" name="CmdSubmit" id="CmdDel" value="Delete"/>
          <input type="hidden" name="FormToken"
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
    <div style="clear: both;"></div>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>

