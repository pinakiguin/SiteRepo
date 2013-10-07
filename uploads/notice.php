<?php
$reg = new MySQLiDB();
$reg->Debug = 1;
$query = "SELECT `UploadID`,`Dept`,`Subject`,DATE_FORMAT(`Dated`,'%d-%m-%Y') as Dated,DATE_FORMAT(`Expiry`,'%d-%m-%Y') as Expiry ,`size`,`Attachment` FROM `uploads` WHERE NOT `Deleted` AND `Topic`<99 order by `UploadID` desc";

if (isset($_REQUEST['Delete']))
  $reg->do_ins_query("update uploads set Deleted=TRUE where UploadID='" . $_REQUEST['Delete'] . "'") or die('Query failed: ' . mysql_error());

$result = $reg->do_sel_query($query) or die('Query failed: ' . mysql_error());

echo "<h3>Total Records: {$result}</h3>";
?>
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
  while ($row = $reg->get_row()) {
    ?>
    <tr>
      <td width="15%"><?php echo $row['Dept']; ?></td>
      <td width="40%"><a href="get_file.php?ID=<?php echo $row['UploadID']; ?>"><?php echo "" . htmlspecialchars($row['Subject']); ?></a><br/><?php echo "[{$row['UploadID']}]{$row['Attachment']}"; ?></td>
      <td width="10%" align="center"><?php echo WebLib::ToDate($row["Dated"]); ?></td>
      <td width="10%" align="center"><?php echo WebLib::ToDate($row["Expiry"]); ?></td>
      <td width="10%" align="center"><?php echo (($row["size"] / 1024) <= 1024) ? round(($row["size"] / 1024), 0) . " KB" : round((($row["size"] / 1024) / 1024), 0) . " MB"; ?></td>
      <td ><a href="?AdminUpload&Delete=<?php echo $row["UploadID"]; ?>">Delete</a></td>
    </tr>
    <?php
  }
  ?>
</table>
