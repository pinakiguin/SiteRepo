<?php

class Contact {

  function CreateContact($Mobile, $Name, $Gid) {
    $DB                     = new MySQLiDBHelper();
    $insertData['GroupID']  = $Gid;
    $insertData['Name']     = $Name;
    $insertData['MobileNo'] = $Mobile;
    $ContactID              = $DB->insert(MySQL_Pre . 'SMS_ViewContacts', $insertData);

    return true;
  }

  function getAllContacts() {
    $DB       = new MySQLiDBHelper();
    $Contacts = $DB->get(MySQL_Pre . 'SMS_ViewContacts');
    print_r($Contacts);

    return $Contacts;
  }

  function getContactByGroup($Gid) {
    $DB = new MySQLiDBHelper();
    $DB->where('GroupID', $Gid);
    $Contacts = $DB->get(MySQL_Pre . 'SMS_ViewContacts');

    //print_r($Contacts);
    return $Contacts;
  }

  function CountContactByGroup($GroupName) {
    $Group = new Group();
    $Group->setGroup($GroupName);
    $Gid = $Group->getGroupID();
    $DB  = new MySQLiDBHelper();
    $DB->where('GroupID', $Gid);
    $s = $DB->get(MySQL_Pre . 'SMS_ViewContacts');
    $n = count($s);

    return $n;
  }

}
