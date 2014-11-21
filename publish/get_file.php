<?php

require_once __DIR__ . '/../lib.inc.php';
// Make sure an ID was passed
if (isset($_GET['ID'])) {
  $LetterID = intval($_GET['ID']);
  // Connect to the database
  $Data = new MySQLiDB();
  // Fetch the file information
  if ($LetterID >= 5000) {
    $Schema = 'select `UploadID`,`Attachment` AS `FileName`,`mime`,`size` AS `Size`,`file`'
      . ' from `WebSite_Uploads`';
  } else {
    $Schema = 'select `UploadID`,`Attachment` AS `FileName`,`mime`,`size` AS `Size`,`file`'
      . ' from `uploads`';
  }
  $query  = $Schema . " WHERE `UploadID` = " . $LetterID;
  $result = $Data->do_sel_query($query);

  if ($result > 0) {
    // Get the row
    $row = $Data->get_row();
    // Print headers
    header("Content-Type: " . $row['mime']);
    header("Content-Length: " . $row['Size']);
    header("Content-Disposition: attachment; filename=\"" . $row['FileName'] . "\"");
    // Print data
    echo $row['file'];
    exit;
  } else {
    echo 'Error! No File exists with that ID.';
  }

  // Free the mysql resources
  $Data->do_close();
} else {
  echo 'Error! No ID was passed.';
}
