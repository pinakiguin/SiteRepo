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
              <select id="OfficeSL" name="OfficeSL" data-placeholder="Select Office Name">
                <?php
                $Data  = new MySQLiDB();
                $Query = 'Select `OfficeSL`, `OfficeName` '
                    . ' FROM `' . MySQL_Pre . 'PP_Offices` '
                    . ' Order By `OfficeName`';
                $Data->show_sel('OfficeSL', 'OfficeName', $Query,
                    WebLib::GetVal($_POST, 'OfficeSL'));
                ?>
              </select>
            </label>
            <label for="NameID"><strong>Name of Employee</strong>
              <input type="text" name="NameID" id="NameID"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'NameID')
                     ?>"
                     required/>
            </label>
            <label for="DesigID"><strong>Designation</strong>
              <input type="text" name="DesigID" id="DesigID"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'DesigID')
                     ?>"
                     required/>
            </label>
            <label for="DOB"><strong>Date Of Birth</strong>
              <input type="text" name="DOB" id="DOB"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'DOB')
                     ?>"
                     required/>
            </label>
            <label for="SexId">
              <strong>Sex</strong>
              <div id="SexId">
                <input type="radio" id="MaleId" name="SexId" value="m"
                       checked="checked">
                <label for="MaleId">Male</label>
                <input type="radio" id="FemaleId" name="SexId" value="f">
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
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'AcNo')
                     ?>"
                     size="3" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PartNo"><strong>Part No.</strong>
              <input type="text" name="PartNo"  id="PartNo"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PartNo')
                     ?>"
                     size="3" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="SLNo"><strong>SERIAL NO</strong>
              <input type="text" name="SLNo" id="SLNo"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'SLNo')
                     ?>"
                     size="3" maxlength="3" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="EPICNo"><strong>EPIC NO.</strong>
              <input type="text" name="EPIC" id="EPIC"
                     size="8" maxlength="16" placeholder="Voter's ID"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'EPIC')
                     ?>" required/>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Parliamentary Constituency</legend>
          <div class="FieldGroup">
            <label for="PcPreRes"><strong>Present Residence</strong>
              <input type="text" name="PcPreRes" id="PcPreRes"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PcPreRes')
                     ?>" size="7" maxlength="2" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PcPerRes"><strong>Present Residence</strong>
              <input type="text" name="PcPerRes" id="PcPerRes"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PcPerRes')
                     ?>" size="7" maxlength="2" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PcPosting"><strong>Present Residence</strong>
              <input type="text" name="PcPosting"  id="PcPosting"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PcPosting')
                     ?>" size="7" maxlength="2" required/>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Contacts</legend>
          <div class="FieldGroup">
            <label for="ResPhone"><strong>Phone(Residence)</strong>
              <input type="text" name="ResPhone" id="ResPhone" size="15"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'ResPhone')
                     ?>"
                     required/>
            </label>
            <label for="Mobile"><strong>Mobile</strong>
              <input type="text"  id="Mobile" name="Mobile"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'Mobile')
                     ?>" size="15" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="EMail"><strong>EMail</strong>
              <input type="email" name="EMail" id="EMail"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'EMail')
                     ?>"  size="19"
                     required/>
            </label>
            <label for="Remarks"><strong>Remarks</strong>
              <input type="text" name="Remarks"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'Remarks')
                     ?>" size="19"
                     id="Remarks" required/>
            </label>
          </div>
        </fieldset>
        <fieldset><legend>Assembly Constituency</legend>
          <div class="FieldGroup">
            <label for="AcPreRes"><strong>Present Residence</strong>
              <input type="text" name="AcPreRes"  id="AcPreRes"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'AcPreRes')
                     ?>" size="7" maxlength="2" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="AcPerRes"><strong>Permanent Residence</strong>
              <input type="text"  name="AcPerRes" id="AcPerRes"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'AcPerRes')
                     ?>" size="7" maxlength="2" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="AcPostiong"><strong>Place of Posting </strong>
              <input type="text" name="AcPosting" id="AcPosting"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'AcPosting')
                     ?>" size="7" maxlength="2" required/>
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
                <input type="radio" id="None" name="Language" checked="checked"/>
                <label for="None">None</label>
                <input type="radio" id="Hindi" name="Language"/>
                <label for="Hindi">Hindi</label>
                <input type="radio" id="Nepali" name="Language"/>
                <label for="Nepali">Nepali</label>

              </div>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Residential Address</legend>
          <div class="FieldGroup">
            <label for="PreAddr1"><strong>Present/1</strong>
              <input type="text"  id="PreAddr1" name="PreAddr1"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PreAddr1')
                     ?>"
                     required/>
            </label>
            <label for="PreAddr2"><strong>Present/2</strong>
              <input type="text"  id="PreAddr2" name="PreAddr2"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PreAddr2')
                     ?>"
                     required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PerAddr1"><strong>Permanent/1</strong>
              <input type="text"  id="PerAddr1" name="PerAddr1"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PerAddr1')
                     ?>"
                     required/>
            </label>
            <label for="PerAddr2"><strong>Permanent/2</strong>
              <input type="text"  id="PerAddr2" name="PerAddr2"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'PerAddr2')
                     ?>"
                     required/>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Bank Details</legend>
          <div class="FieldGroup">
            <label for="BankName"><strong>Bank Name</strong>
              <input type="text" id="BankName" name="BankName"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'BankName')
                     ?>"
                     required/>
            </label>
            <label for="BranchName"><strong>Branch Name</strong>
              <input type="text" name="BranchName" id="BranchName"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'BranchName')
                     ?>"
                     required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="BankACNo"><strong>BankA/C No.</strong>
              <input type="text" name="BankACNo" id="BankACNo"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'BankACNo')
                     ?>"
                     required/>
            </label>
            <label for="IFSCCode"><strong>IFSC Code</strong>
              <input type="text" name="IFSCCode" id="IFSCCode"
                     value="<?php
                     echo WebLib::GetVal($_SESSION['PostData'], 'IFSCCode')
                     ?>"
                     required/>
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
            <div class="FieldGroup">
              <label for="BasicPay"><strong>Basic Pay </strong>
                <input type="text" name="BasicPay" id="BasicPay"
                       value="<?php
                       echo WebLib::GetVal($_SESSION['PostData'], 'OfficeName');
                       ?>" size="3" maxlength="5" required />
              </label>
            </div>
            <div class="FieldGroup">
              <label for="GradePay"><strong>Grade Pay</strong>
                <input type="text" name="GradePay" id="GradePay"
                       value="<?php
                       echo WebLib::GetVal($_SESSION['PostData'], 'OfficeName');
                       ?>"
                       size="3" maxlength="5" readonly="readonly" required />
              </label>
            </div>
          </div>
        </fieldset>
        <fieldset>
          <legend>Whether working for 3 years out of 4 years</legend>
          <div class="FieldGroup">
            <label for="Posting"></label>
            <strong>In the district as on 30/06/2013</strong>
            <div id="Posting">
              <input type="radio" id="YesId" name="PostingID" value="y"
                     checked="checked" />
              <label for="YesId">Yes</label>
              <input type="radio" id="NoId" name="PostingID" value="n" />
              <label for="NoId">No</label>
            </div>
          </div>
          <div class="FieldGroup">
            <label for="PBReturn"><strong>PB Returned</strong>
              <div id="PBReturn">
                <input type="radio" id="YesId1" name="PBReturn" checked="checked"/>
                <label for="YesId1">Yes</label>
                <input type="radio" id="NoId1" name="PBReturn">
                <label for="NoId1">No</label>
              </div>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="EDCPBIssued"><strong>EDC/PB Issued</strong>
              <div id="EDCPBIssued">
                <input type="radio" id="YesId2" name="EDCPBIssued" checked="checked"/>
                <label for="YesId2">Yes</label>
                <input type="radio" id="NoId2" name="EDCPBIssued">
                <label for="NoId2">No</label>
              </div>
            </label>
          </div>
        </fieldset>
        <fieldset>
          <div class="ui-widget-header ui-corner-all">
            <input type="submit" name="CmdSubmit"  value="Save"/>
            <input type="reset" name="CmdSubmit"  value="Reset"/>
            <input type="submit" name="CmdDelete"  value="Delete"/>
            <input type="hidden" name="FormToken"
                   value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
          </div>
        </fieldset>
    </div>
  </form>
  <pre id="Error">
    <?php
    print_r($_POST);
    print_r($_SESSION['DB']);
    ?>
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

