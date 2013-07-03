<?php

/*
 * Class DB helper class for MySQL database handling functions
 *
 * @version v1.0
 */

require_once 'DatabaseConfig.inc.php';

/**
 * Class DB helper class for MySQL database handling functions
 * using mysqli php extension
 * @todo Make the class MySQLi Extension based from MySQL Extension
 */
class DB {

  /**
   * Database connection resource
   * @var resource
   * @access private
   */
  private $conn;

  /**
   * Result resourse
   *
   * @var resource
   * @access private
   */
  private $RecSet;

  /**
   * Set debuging On if set to 1.
   *
   * @var int
   */
  private $Debug;

  /**
   * Number of rows returned by the executed query.
   *
   * @var int $RowCount
   * @access private
   */
  private $RowCount;

  /**
   * Number of fields returned by the executed query.
   *
   * @var int
   * @access private
   */
  private $ColCount;

  /**
   * Set to 1 if no result returned by query.
   *
   * @var boolean
   * @access private
   */
  private $NoResult;

  function __get($var) {
    switch ($var) {
      case 'RowCount' :
        return $this->RowCount;
        break;
      case 'ColCount' :
        return $this->ColCount;
        break;
      case 'NoResult' :
        return $this->NoResult;
        break;
    }
  }

  function __set($var, $val) {
    switch ($var) {
      case 'Debug' :
        $this->Debug = $val;
        break;
    }
  }

  private function do_connect() {
    //$this->Debug=1;
    $this->conn = mysql_connect(HOST_Name, MySQL_User, MySQL_Pass);
    if (!$this->conn) {
      die('Could not Connect: ' . mysql_error() . "<br><br>");
    }
    mysql_select_db(MySQL_DB) or die('Cannot select database (database.php): ' . mysql_error() . "<br><br>");
    $this->NoResult = 1;
  }

  public function __sleep() {
    $this->do_close();
    return array('conn', 'result', 'Debug');
  }

  public function __wakeup() {
    $this->do_connect();
  }

  public function SqlSafe($StrValue) {
    $this->do_connect();
    return mysql_real_escape_string(htmlspecialchars($StrValue));
  }

  public function do_ins_query($querystr) {
    $this->do_connect();
    $this->RecSet = mysql_query($querystr, $this->conn);
    if (!$this->RecSet) {
      $message = 'Error(database): ' . mysql_error();
      //$message .= 'Whole query: '. $querystr."<br>";
      if ($this->Debug)
        echo $message;
      $this->RowCount = 0;
      return 0;
    }
    $this->NoResult = 1;
    $this->RowCount = mysql_affected_rows($this->conn);
    return $this->RowCount;
  }

  public function do_sel_query($querystr) {
    $this->do_connect();
    $this->RecSet = mysql_query($querystr, $this->conn);
    if (mysql_errno($this->conn)) {
      if ($this->Debug)
        echo mysql_error($this->conn);
      $this->NoResult = 1;
      $this->RowCount = 0;
      return 0;
    }
    $this->NoResult = 0;
    $this->RowCount = mysql_num_rows($this->RecSet);
    $this->ColCount = mysql_num_fields($this->RecSet);
    return $this->RowCount;
  }

  public function get_row() {
    if (!$this->NoResult)
      return mysql_fetch_assoc($this->RecSet);
  }

  public function get_n_row() {
    if (!$this->NoResult)
      return mysql_fetch_row($this->RecSet);
  }

  public function GetFieldName($ColPos) {
    if (mysql_errno())
      return "ERROR!";
    else if ($this->ColCount > $ColPos)
      return mysql_field_name($this->RecSet, $ColPos);
    else
      return "Offset Error!";
  }

  public function GetTableName($ColPos) {
    if (mysql_errno())
      return "ERROR!";
    else if ($this->ColCount > $ColPos)
      return mysql_field_table($this->RecSet, $ColPos);
    else
      return "Offset Error!";
  }

  public function show_sel($val, $txt, $query, $sel_val = "-- Choose --") {
    $this->do_sel_query($query);
    $opt = $this->RowCount;
    if ($sel_val == "-- Choose --")
      echo "<option value=''>-- Choose --</option>";
    for ($i = 0; $i < $opt; $i++) {
      $row = $this->get_row();
      if ($row[$val] == $sel_val)
        $sel = "selected";
      else
        $sel = "";
      echo '<option value="' . htmlspecialchars($row[$val])
      . '"' . $sel . '>' . htmlspecialchars($row[$txt]) . '</option>';
    }
  }

  public function do_max_query($Query) {
    $this->do_sel_query($Query);
    $row = $this->get_n_row();
    //echo "Whole Row: ".$row[0].$row[1];
    if ($row[0] == null)
      return 0;
    else
      return htmlspecialchars($row[0]);
  }

  public function ShowTable($QueryString) {
    // Performing SQL query
    $this->do_sel_query($QueryString);
    // Printing results in HTML
    echo '<table rules="all" frame="box" width="100%" cellpadding="5" cellspacing="1">';
    $i = 0;
    while ($i < mysql_num_fields($this->RecSet)) {
      echo '<th>' . htmlspecialchars(mysql_field_name($this->RecSet, $i)) . '</th>';
      $i++;
    }
    $j = 0;
    while ($line = mysql_fetch_array($this->RecSet, MYSQL_ASSOC)) {
      echo "\t<tr>\n";
      foreach ($line as $col_value)
        echo "\t\t<td>" . $col_value . "</td>\n";
      //$strdt=date("F j, Y, g:i:s a",$ntime);
      //echo "\t\t<td>$strdt</td>\n";
      echo "\t</tr>\n";
      $j++;
    }
    echo "</table>\n";
    //$this->do_close();
    return ($j);
  }

  public function ShowTableKiosk($QueryString) {
    // Connecting, selecting database
    $this->do_sel_query($QueryString);
    // Printing results in HTML
    echo '<table rules="all" frame="box" width="100%" cellpadding="5" cellspacing="1" border="1">';
    echo '<tr><td colspan="2" style="background-color:#F4A460;height:3px;border: 1px solid black;"></td></tr>';
    $i = 0;
    while ($line = mysql_fetch_array($this->RecSet, MYSQL_ASSOC)) {
      $i = 0;
      foreach ($line as $col_value) {
        echo "\t<tr>\n";
        echo '<th  style="background-color:#FFDA91;font-weight:bold;text-align:left;border: 1px solid black;">' . htmlspecialchars(mysql_field_name($this->RecSet, $i)) . '</th>';
        echo "\t\t" . '<td style="border: 1px solid black;">' . $col_value . "</td>\n";
        //$strdt=date("F j, Y, g:i:s a",$ntime);
        //echo "\t\t<td>$strdt</td>\n";
        echo "\t</tr>\n";
        $i++;
      }
      echo '<tr><td colspan="2" style="background-color:#F4A460;height:3px;border: 1px solid black;"></td></tr>';
    }
    echo "</table>\n";
    $this->do_close();
    return ($i);
  }

  public function do_close() {
    // Free resultset
    if (!$this->NoResult)
      mysql_free_result($this->RecSet);
    // Closing connection
    mysql_close($this->conn);
    //echo "<br />LastQuery: ".$LastQuery;
  }

}

?>
