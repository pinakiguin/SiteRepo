<?php
if ($_SERVER['SCRIPT_FILENAME'] === __FILE__) {
  header("HTTP/1.1 404 Not Found");
  exit();
}
$reg = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);

if (isset($_REQUEST['Delete'])) {
  $DelData['Deleted'] = 1;
  $reg->where('UploadID', WebLib::GetVal($_REQUEST, 'Delete'));
  $reg->update('uploads', $DelData);
}
$query = 'SELECT `UploadID`,`Dept`,`Subject`,`Dated`,`Expiry`,`size`,`Attachment` '
        . ' FROM `uploads` '
        . ' Where NOT `Deleted` order by `UploadID` desc';
$result = $reg->query($query);
unset($reg);
?>
<h3>Total Records: <?php echo count($result); ?></h3>
<table rules="all" frame="box" width="100%" cellpadding="5" cellspacing="1" >
  <tr>
    <th>Department</th>
    <th>Subject</th>
    <th>Dated</th>
    <th>Expiry</th>
    <th>Size</th>
    <th width="15%" >Action</th>
  </tr>
  <?php
  foreach ($result as $row) {
    ?>
    <tr>
      <td width="15%"><?php echo $row['Dept']; ?></td>
      <td width="40%"><a href="get_file.php?ID=<?php echo $row['UploadID']; ?>"><?php echo "" . htmlspecialchars($row['Subject']); ?></a><br/><?php echo "[{$row['UploadID']}]{$row['Attachment']}"; ?></td>
      <td width="10%" align="center"><?php echo WebLib::ToDate($row["Dated"]); ?></td>
      <td width="10%" align="center"><?php echo WebLib::ToDate($row["Expiry"]); ?></td>
      <td width="10%" align="center"><?php echo (($row["size"] / 1024) <= 1024) ? round(($row["size"] / 1024), 0) . " KB" : round((($row["size"] / 1024) / 1024), 0) . " MB"; ?></td>
      <td ><a href="?Delete=<?php echo $row["UploadID"]; ?>">Delete</a></td>
    </tr>
    <?php
  }
  ?>
</table>