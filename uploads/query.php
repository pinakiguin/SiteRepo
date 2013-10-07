<?php

require_once( '../library.php');
$Data = new MySQLiDB();
$return_arr = array();
/* If connection to database, run sql statement. */

$Query = "SELECT Dept FROM uploads where Dept like '%" . WebLib::GetVal($_REQUEST, 'term') . "%' group by Dept";
$fetch = $Data->do_sel_query($Query);

/* Retrieve and store in array the results of the query. */
while ($row = mysql_fetch_array($Data->result, MYSQL_ASSOC)) {
  $row_array['label'] = $row['Dept'];
  $row_array['value'] = $row['Dept'];
  array_push($return_arr, $row_array);
}
//echo $Query;
/* Toss back results as json encoded array. */
echo json_encode($return_arr);
?>