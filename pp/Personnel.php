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
            <label for="OfficeID"><strong>Name of The Office</strong>
              <input type="text" name="OfficeID" id="OfficeID" value="" required/>
            </label>
            <label for="NameID"><strong>Name of Employee</strong>
              <input type="text" name="Name ID" id="Name ID" value=""required/>
            </label>
            <label for="DesigID"><strong>Designation</strong>
              <input type="text" name="Desig ID" id="Name ID" value="" required/>
            </label>
            <label for="DOB"><strong>Date Of Birth</strong>
              <input type="text" value="" name="DOB" id="DOB" required/>
            </label>
            <label for="Sex">
              <strong>Sex</strong>
              <select name="SexId" id="SexId">
                <option value="M">Male</option>
                <option value="F">Female</option>
              </select>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Details Of Enrollment in the current Electoral Roll</legend>
          <div class="FieldGroup">
            <label for="AcNo"><strong>AC No.</strong>
              <input type="text" name="AcNo" id="AcNo" value=""
                     size="3" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PartNo"><strong>Part No.</strong>
              <input type="text" name="PartNo" value="" id="PartNo"
                     size="3" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="SLNo"><strong>SERIAL NO</strong>
              <input type="text" name="SLNo" id="SLNo" value=""
                     size="3" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="EPICNo"><strong>EPIC NO.</strong>(Voter's Photo id card)
              <input type="text" name="EPIC" id="EPIC" value="" required/>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Pay Details</legend>
          <div class="FieldGroup">
            <label for="PayScale"><strong>Scale of Pay</strong>
              <input type="text" name="PayScale" id="PayScale" value=""
                     size="3" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="BasicPay"><strong>Basic Pay </strong>
              <input type="text" name="BasicPay" id="BasicPay" value=""
                     size="3" maxlength="5" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="GradePay"><strong>Grade Pay</strong>
              <input type="text" value="" name="GradePay" id="GradePay"
                     size="3" maxlength="5" required/>
            </label>
          </div>
          <br/>
          <div class="FieldGroup">
            <label for="Posting">
              <span class="ui-icon ui-icon-clock" style="float:left;"></span>
              Whether Working in the district for 3 years out of 4 years as on 30/6/2013
              <select name="Posting" id="Posting">
                <option value="YES">YES</option>
                <option value="NO">NO</option>
              </select>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Residential Address</legend>
          <div class="FieldGroup">
            <label for="PreAddr1"><strong>Present/1</strong>
              <input type="text" value="" id="PreAddr1" name="PreAddr1" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PreAddr2"><strong>Present/2</strong>
              <input type="text" value="" id="PreAddr2" name="PreAddr2" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PerAddr1"><strong>Permanent/1</strong>
              <input type="text" value="" id="PerAddr1" name="PerAddr1" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PerAddr2"><strong>Permanent/2</strong>
              <input type="text" value="" id="PerAddr2" name="PerAddr2" required/>
            </label>
          </div>
        </fieldset>
        <fieldset><legend>Assembly Constituency in respect of</legend>
          <div class="FieldGroup">
            <label for="AcPreRes"><strong>Present Residence</strong>
              <input type="text" name="AcPreRes" value="" id="AcPreRes" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="AcPerRes"><strong>Permanent Residence</strong>
              <input type="text" value="" name="AcPerRes" id="AcPerRes" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="AcPostiong"><strong>Place of Posting </strong>
              <input type="text" name="AcPostiong" id="AcPostiong"value="" required/>
          </div>
        </fieldset>
        <fieldset>
          <legend>Parliamentary Constituency in respect of</legend>
          <div class="FieldGroup">
            <label for="PcPreRes"><strong>Present Residence</strong>
              <input type="text" name="PcPreRes" value="" id="PcPreRes" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PcPerRes"><strong>Present Residence</strong>
              <input type="text" name="PcPerRes" value="" id="PcPerRes" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PcPosting"><strong>Present Residence</strong>
              <input type="text" name="PcPosting" value="" id="PcPosting" required/>
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
              <select name="Language" id="Language">
                <option value="Hindi">Hindi</option>
                <option value="Nepali">Nepali</option>
              </select>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Contacts</legend>
          <div class="FieldGroup">
            <label for="Phone"><strong>Phone(Residence)</strong>
              <input type="text" name="Phone" value="" id="Phone" required/>

            </label>
          </div>
          <div class="FieldGroup">
            <label for="Mobile"><strong>Mobile</strong>
              <input type="text" value="" id="Mobile" name="Mobile" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="EMail"><strong>EMail</strong>
              <input type="email" name="EMail" id="EMail" value="" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="Remarks"><strong>Remarks</strong>
              <input type="text" name="Remarks" value="" id="Remarks" required/>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Bank Details</legend>
          <div class="FieldGroup">
            <label for="BankACNo"><strong>BankA/C No.</strong>
              <input type="number" name="BankACNo" id="BankACNo" value="" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="BankName"><strong>Bank Name</strong>
              <input type="text" id="BankName" name="BankName" value="" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="BranchName"><strong>Branch Name</strong>
              <input type="text" name="BranchName" id="BranchName" value="" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="IFSCCode"><strong>IFSC Code</strong>
              <input type="text" name="IFSCCode" id="IFSCCode" value="" required/>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Election Duty Certificate/Postal Ballot</legend>
          <div class="FieldGroup">
            <label for="EDCPBIssued"><strong>EDC/PB Issued</strong>
              <input type="text" name="EDCPBIssued" id="EDCPBIssued" value="" />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PBReturn"><strong>PB Returned</strong>
              <input type="text" name="PBReturn" id="PBReturn" value="" />
            </label>
          </div>
          <div class="formControl">
            <input type="submit" name="CmdSubmit"  value ="Submit"/>
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

