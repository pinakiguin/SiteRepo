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
    <div class="formWrapper">
      <form method="post"
            action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>" >
        <h3>Personnel Information</h3>
        <?php
        include __DIR__ . '/PersonnelData.php';
        WebLib::ShowMsg();
        ?>
        <fieldset>
          <legend>Employee Details</legend>
          <div class="FieldGroup">
            <label for="OfficeSL"><strong>Name of The Office</strong>
              <select id="OfficeSL" name="OfficeSL" data-placeholder="Select Department" class="chzn-select">
                <?php
                $Data = new MySQLiDB();
                $Query = 'Select `OfficeSL`, `OfficeName` '
                  . ' FROM `' . MySQL_Pre . 'PP_Offices` '
                  . ' Order By `OfficeName`';
                $Data->show_sel('OfficeSL', 'OfficeName', $Query, WebLib::GetVal($_POST, 'OfficeSL'));
                ?>
              </select>
            </label>
            <label for="NameID"><strong>Name of Employee</strong>
              <input type="text" name="NameID" id="NameID"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'NameID') ?>"
                     required/>
            </label>
            <label for="DesigID"><strong>Designation</strong>
              <input type="text" name="DesgID" id="DesgID"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'DesigID') ?>"
                     required/>
            </label>
            <label for="DOB"><strong>Date Of Birth</strong>
              <input type="text" name="DOB" id="DOB"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'DOB') ?>"
                     required/>
            </label>
            <label for="SexId">
              <strong>Sex</strong>
              <div id="SexId">
                <input type="radio" id="MaleId" name="SexId"  checked="checked">
                <label for="MaleId">Male</label>
                <input type="radio" id="FemaleId" name="SexId">
                <label for="FemaleId">Female</label>
              </div>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Details Of Enrollment in the current Electoral Roll</legend>
          <div class="FieldGroup">
            <label for="AcNo"><strong>AC No.</strong>
              <input type="text" name="AcNo" id="AcNo"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'AcNo') ?>"
                     size="3" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PartNo"><strong>Part No.</strong>
              <input type="text" name="PartNo"  id="PartNo"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'PartNo') ?>"
                     size="3" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="SLNo"><strong>SERIAL NO</strong>
              <input type="text" name="SLNo" id="SLNo"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'SLNo') ?>"
                     size="3" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="EPICNo"><strong>EPIC NO.</strong>
              <input type="text" name="EPIC" id="EPIC"
                     size="8" maxlength="16" placeholder="Voter's ID"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'EPIC') ?>" required/>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Pay Details</legend>
          <div class="FieldGroup">
            <label for="PayScale"><strong>Scale of Pay</strong>
              <input type="text" name="PayScale" id="PayScale"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'OfficeName') ?>"
                     size="3" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="BasicPay"><strong>Basic Pay </strong>
              <input type="text" name="BasicPay" id="BasicPay"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'OfficeName') ?>"
                     size="3" maxlength="5" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="GradePay"><strong>Grade Pay</strong>
              <input type="text"  name="GradePay" id="GradePay"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'OfficeName') ?>"
                     size="3" maxlength="5" required/>
            </label
          </div>
        </fieldset>
        <fieldset>
          <legend>Whether working for 3 years out of 4 years</legend>
          <div class="FieldGroup">
            <label for="Posting"><strong>In the district as on 30/06/2013</strong>
              <div id="Posting">
                <input type="radio" id="YesId" name="PostingId" checked="checked"/>
                <label for="YesId">Yes</label>
                <input type="radio" id="NoId" name="PostingId">
                <label for="NoId">No</label>
              </div>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Residential Address</legend>
          <div class="FieldGroup">
            <label for="PreAddr1"><strong>Present/1</strong>
              <input type="text"  id="PreAddr1" name="PreAddr1"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'PreAddr1') ?>"
                     required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PreAddr2"><strong>Present/2</strong>
              <input type="text"  id="PreAddr2" name="PreAddr2"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'PreAddr2') ?>"
                     required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PerAddr1"><strong>Permanent/1</strong>
              <input type="text"  id="PerAddr1" name="PerAddr1"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'PerAddr1') ?>"
                     required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PerAddr2"><strong>Permanent/2</strong>
              <input type="text"  id="PerAddr2" name="PerAddr2"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'PerAddr2') ?>"
                     required/>
            </label>
          </div>
        </fieldset>
        <fieldset><legend>Assembly Constituency in respect of</legend>
          <div class="FieldGroup">
            <label for="AcPreRes"><strong>Present Residence</strong>
              <input type="text" name="AcPreRes"  id="AcPreRes"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'AcPreRes') ?>"
                     required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="AcPerRes"><strong>Permanent Residence</strong>
              <input type="text"  name="AcPerRes" id="AcPerRes"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'AcPerRes') ?>"
                     required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="AcPostiong"><strong>Place of Posting </strong>
              <input type="text" name="AcPostiong" id="AcPostiong"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'AcPostiong') ?>"
                     required/>
          </div>
        </fieldset>
        <fieldset>
          <legend>Parliamentary Constituency in respect of</legend>
          <div class="FieldGroup">
            <label for="PcPreRes"><strong>Present Residence</strong>
              <input type="text" name="PcPreRes" id="PcPreRes"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'PcPreRes') ?>"
                     required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PcPerRes"><strong>Present Residence</strong>
              <input type="text" name="PcPerRes" id="PcPerRes"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'PcPerRes') ?>"
                     required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PcPosting"><strong>Present Residence</strong>
              <input type="text" name="PcPosting"  id="PcPosting"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'PcPosting') ?>"
                     required/>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Qualifications</legend>
          <div class="FieldGroup">
            <label for="Qualification"><strong>Academic Qualification</strong>
              <select name="Qualification" id="Qualification">
                <option value="Post Graduate">Post Graduate</option>
                <option value="Graduate">Graduate</option>
                <option value="Matric">Matric</option>
                <option value="Nonmatric">Non Matric</option>
                <option value="Madhyamic">Madhyamic</option>
                <option value="Nonmadhyamic">Non Madhyamic</option>
                <option value="VIII">VIII</option>
                <option value="NonVII">Below VIII</option>
                <option value="NotKnown">Not Known</option>
              </select>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="Language"><strong>Language known other than Bengali</strong>
              <div id="Language">
                <input type="radio" id="Hindi" name="Language" checked="checked"/>
                <label for="Hindi">Hindi</label>
                <input type="radio" id="Nepali" name="Language">
                <label for="Nepali">Nepali</label>
              </div>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Contacts</legend>
          <div class="FieldGroup">
            <label for="Phone"><strong>Phone(Residence)</strong>
              <input type="text" name="Phone" id="Phone"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'Phone') ?>"
                     required/>

            </label>
          </div>
          <div class="FieldGroup">
            <label for="Mobile"><strong>Mobile</strong>
              <input type="text"  id="Mobile" name="Mobile"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'Mobile') ?>"
                     required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="EMail"><strong>EMail</strong>
              <input type="email" name="EMail" id="EMail"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'EMail') ?>"
                     required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="Remarks"><strong>Remarks</strong>
              <input type="text" name="Remarks"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'Remarks') ?>"
                     id="Remarks" required/>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Bank Details</legend>
          <div class="FieldGroup">
            <label for="BankACNo"><strong>BankA/C No.</strong>
              <input type="number" name="BankACNo" id="BankACNo"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'BankACNo') ?>"
                     required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="BankName"><strong>Bank Name</strong>
              <input type="text" id="BankName" name="BankName"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'BankName') ?>"
                     required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="BranchName"><strong>Branch Name</strong>
              <input type="text" name="BranchName" id="BranchName"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'BranchName') ?>"
                     required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="IFSCCode"><strong>IFSC Code</strong>
              <input type="text" name="IFSCCode" id="IFSCCode"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'IFSCCode') ?>"
                     required/>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Election Duty Certificate/Postal Ballot</legend>
          <div class="FieldGroup">
            <label for="EDCPBIssued"><strong>EDC/PB Issued</strong>
              <input type="text" name="EDCPBIssued" id="EDCPBIssued"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'EDCPBIssued') ?>"
                     required />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PBReturn"><strong>PB Returned</strong>
              <input type="text" name="PBReturn" id="PBReturn"
                     value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'PBReturn') ?>"
                     required/>
            </label>
          </div>
          <div class="formControl">
            <input type="submit" name="CmdSubmit"  value ="Submit"/>
            <input type="reset" name="CmdSubmit"  value ="Reset"/>
            <input type="hidden" name="FormToken"
                   value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
          </div>
        </fieldset>
      </form>
    </div>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>

