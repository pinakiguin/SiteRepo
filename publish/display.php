<?php
require_once __DIR__ . '/../lib.inc.php';
if ($_SERVER['SCRIPT_FILENAME'] === __FILE__) {
  header("HTTP/1.1 404 Not Found");
  exit();
}
$reg = new MySQLiDBHelper();

if (isset($_SESSION['Topic'])) {
  $reg->where('Topic', WebLib::GetVal($_SESSION, 'Topic'));
}

if (isset($_SESSION['ViewWhatsNew']) && ($_SESSION['ViewWhatsNew']==true)) {
  $result = $reg->get('`' . MySQL_Pre . 'ViewWhatsNew`');
} else {
  $result = $reg->get('`' . MySQL_Pre . 'ViewUploads`');
}

$Users = $reg->query("Select UserMapID,UserName from `" . MySQL_Pre . "Users`");

foreach ($Users as $User) {
  $mUsers[$User['UserMapID']] = $User['UserName'];
}
unset($Users);
unset($reg);
?>
<h3>Total Records: <?php echo count($result); ?></h3>
<table rules="all" frame="box" width="100%" cellpadding="5" cellspacing="1">
  <?php
  $Topic['0'] = "Tender";
  $Topic['1'] = "Recruitment";
  $Topic['2'] = "Report";
  $Topic['3'] = "Panchayat General Election 2013";
  $Topic['4'] = "Notice";
  $Topic['5'] = "Election 2014";
  foreach ($result as $row) {
    if (($row["size"] / 1024) <= 1024) {
      $Size = round(($row["size"] / 1024), 0) . " KB";
    }
    else {
      $Size = round((($row["size"] / 1024) / 1024), 0) . " MB";
    }
    ?>
    <tr>
      <td>
        <?php echo $row['UploadID']; ?>
      </td>
      <td>
        <?php
        echo '<strong>Office: </strong>' . $row['Dept'] .
          '<br/><strong>Purpose: </strong>' . htmlspecialchars($row['Subject']) .
          '<br/><strong>File: </strong><a '
          . 'href="http://www.paschimmedinipur.gov.in/apps/publish/get_file.php?ID='
          . $row['UploadID'] . '" rel="nofollow">' . $row['FileName'] . '</a><br/>'
          . '<strong>Category: </strong>' . $Topic[$row["Topic"]]
          . ' <strong>Dated: </strong>' . WebLib::ToDate($row["Dated"])
          . ' <strong>Valid Upto: </strong>' . WebLib::ToDate($row["Expiry"])
          . ' <strong>Size: </strong>' . $Size
          . '<br/><strong>Uploaded By: </strong>' . $mUsers[$row['UserMapID']];
        ?>
      </td>
    </tr>
  <?php
  }
  ?>
</table>