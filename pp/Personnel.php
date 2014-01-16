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
                      data-placeholder="Select Office Name">
              </select>
            </label>
          </div>
          <div style="clear: both;"></div>
          <div class="FieldGroup">
            <label for="NameID"><strong>Name of Employee</strong>
              <input type="text" name="NameID" id="NameID"
                     title="Type or Select from the suggesion list to edit record"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'NameID');
                     ?>"
                     required />
            </label>
            <label for="DOB"><strong>Date Of Birth</strong>
              <input type="text" name="DOB" id="DOB" placeholder="dd-mm-yyyy"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'DOB');
                     ?>"
                     required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="DesigID"><strong>Designation</strong>
              <input type="text" name="DesigID" id="DesigID"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'DesigID');
                     ?>"
                     required/>
            </label>
            <strong>Sex</strong>
            <div id="SexId">
              <input type="radio" id="MaleId" name="SexId" value="male"
                     checked="checked">
              <label for="MaleId">Male</label>
              <input type="radio" id="FemaleId" name="SexId" value="female">
              <label for="FemaleId">Female</label>
            </div>

          </div>
          <div class="FieldGroup">
            <label for="Remarks">
              <strong>Remarks</strong>
              <select name="Remarks" id="Remarks" class="chzn-select"
                      data-placeholder="Select Remarks">
                <option value=""></option>
                <option value="1">1-Head Of Office</option>
                <option value="2">2-Night Guard/Armed Guard</option>
                <option value="3">3-Sweeper</option>
                <option value="4">4-Key Holder</option>
                <option value="5">5-Physically handicapped*</option>
                <option value="6">6-Peoples' Representative</option>
                <option value="7">7-Other</option>
              </select>
            </label>
            <label for="Remarks">
              <strong>Why the employee cannot be spared </strong>
              <input type="text" name="TxtRemarks" id="TxtRemarks"
                     placeholder="Mention Exact Reason"/>
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
                     ?>" size="7" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PcPerRes"><strong>Permanent Residence</strong>
              <input type="text" name="PcPerRes" id="PcPerRes"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PcPerRes');
                     ?>" size="7" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PcPosting"><strong>Place of posting</strong>
              <input type="text" name="PcPosting"  id="PcPosting"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PcPosting');
                     ?>" size="7" maxlength="3" required/>
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
                     ?>" size="7" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="AcPerRes"><strong>Permanent Residence</strong>
              <input type="text"  name="AcPerRes" id="AcPerRes"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'AcPerRes');
                     ?>" size="7" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="AcPostiong"><strong>Place of Posting </strong>
              <input type="text" name="AcPosting" id="AcPosting"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'AcPosting');
                     ?>" size="7" maxlength="3" required/>
            </label>
          </div>
        </fieldset>
        <div style="clear: both;"></div>
        <fieldset>
          <legend>Residential Address</legend>
          <div class="FieldGroup">
            <label for="DistHome"><strong>Home District</strong>
              <input type="text"  id="DistHome" name="DistHome"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'DistHome');
                     ?>" maxlength="50" required/>
            </label>
            <label for="HistPosting"><strong>Posting History</strong>
              <input type="text"  id="HistPosting" name="HistPosting"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'HistPosting');
                     ?>" maxlength="50" required/>
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
                      data-placeholder="Select Bank Name">
              </select>
            </label>
            <label for="BranchName"><strong>Branch Name</strong>
              <select id="BranchName" name="BranchName"
                      data-placeholder="Select Branch Name">
              </select>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="BankACNo"><strong>BankA/C No.</strong>
              <input type="text" name="BankACNo" id="BankACNo" value="<?php
              echo WebLib::GetVal($_SESSION['PostData'], 'BankACNo');
              ?>" required/>
            </label>
            <label for="IFSC"><strong>IFSC Code</strong>
              <input type="text" name="IFSC" id="IFSC"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'IFSC');
                     ?>"  readonly="readonly" required/>
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
                     ?>"
                     required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="Mobile"><strong>Mobile</strong>
              <input type="text"  id="Mobile" name="Mobile"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'Mobile');
                     ?>" size="15" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="EMail"><strong>EMail</strong>
              <input type="email" name="EMail" id="EMail"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'EMail');
                     ?>"  size="19">
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Pay Details</legend>
          <div class="FieldGroup">
            <label for="PayScale"><strong>Scale of Pay</strong>
              <select id="PayScale" name="PayScale"
                      data-placeholder="Select Pay Scale">
              </select>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="BasicPay"><strong>Basic Pay </strong>
              <input type="text" name="BasicPay" id="BasicPay"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'BasicPay');
                     ?>" size="3" maxlength="5" required />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="GradePay"><strong>Grade Pay</strong>
              <input type="text" name="GradePay" id="GradePay"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'GradePay');
                     ?>"
                     size="3" maxlength="5" readonly="readonly" required />
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
                     size="3" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PartNo"><strong>Part No.</strong>
              <input type="text" name="PartNo"  id="PartNo"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PartNo');
                     ?>"
                     size="3" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="SLNo"><strong>SERIAL NO</strong>
              <input type="text" name="SLNo" id="SLNo"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'SLNo');
                     ?>"
                     size="3" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="EPICNo"><strong>EPIC NO.</strong>
              <input type="text" name="EPIC" id="EPIC"
                     size="8" maxlength="16" placeholder="Voter's ID"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'EPIC');
                     ?>" required/>
            </label>
          </div>
        </fieldset>

        <fieldset>
          <legend>Qualifications</legend>
          <div class="FieldGroup">
            <label for="Qualification"><strong>Academic Qualification</strong>
              <select name="Qualification" id="Qualification" class="chzn-select"
                      data-placeholder="Select Qualification">
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
        <fieldset>
          <legend>Whether working for 3 years out of 4 years</legend>
          <div class="FieldGroup">
            <label for="Posting"></label>
            <strong>In the district as on 30/06/2013</strong>
            <div id="Posting">
              <input type="radio" id="YesId" name="PostingID" value="yes"
                     checked="checked" />
              <label for="YesId">Yes</label>
              <input type="radio" id="NoId" name="PostingID" value="no" />
              <label for="NoId">No</label>
            </div>
          </div>
          <div class="FieldGroup">
            <label for="PBReturn"><strong>PB Returned</strong>
              <div id="PBReturn">
                <input type="radio" id="YesId1" name="PBReturn" value="yes"
                       checked="checked" />
                <label for="YesId1">Yes</label>
                <input type="radio" id="NoId1" value="no" name="PBReturn" />
                <label for="NoId1">No</label>
              </div>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="EDCPBIssued"><strong>EDC/PB Issued</strong>
              <div id="EDCPBIssued">
                <input type="radio" id="YesId2" name="EDCPBIssued" value="yes"
                       checked="checked"/>
                <label for="YesId2">Yes</label>
                <input type="radio" id="NoId2" value="no" name="EDCPBIssued" />
                <label for="NoId2">No</label>
              </div>
            </label>
          </div>
        </fieldset>
        <div style="clear: both;"></div>
        <hr/>
        <div class="ui-corner-all"
             style="display: inline-block; float: right;">
          <input type="submit" name="CmdSubmit"  value="Save"/>
          <input type="reset" name="CmdSubmit"  value="Reset"/>
          <input type="submit" name="CmdDelete"  value="Delete"/>
          <input type="hidden" name="FormToken"
                 value="<?php
                 echo WebLib::GetVal($_SESSION, 'FormToken');
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

