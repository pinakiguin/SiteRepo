<?php
/**
 * Created by PhpStorm.
 * User: nic
 * Date: 14/8/14
 * Time: 1:13 PM
 */
require_once('AuthOTP.php');

session_start();

WebLib::CreateDB();

$AuthOTP=new AuthOTP(1);

//$AuthOTP->setUser('1', 'TOTP');

//echo $AuthOTP->getData('8972096989');
?>
<h2>Users</h2>
<table border="1">
<tr><th>Mobile No</th><th>Has Token?</th><th>Key</th><th>Secret Key</th></tr>
<?php
// now we get our list of users - this part of the page just has a list of users
// and the ability to create new ones. This isnt really in the scope of the
// GA4PHP, but for this example, we need to be able to create users, so heres where
// you do it.
$row["MobileNo"]='8972096989';
  if($AuthOTP->hasToken($row["MobileNo"])) {
    $hastoken = "Yes";
    $type = $AuthOTP->getTokenType($row["MobileNo"]);
    if($type == "HOTP") {
      $type = "- Counter Based";
    } else {
      $type = "- Time Based";
    }
    $hexkey = $AuthOTP->getKey($row["MobileNo"]);
    $b32key = $AuthOTP->helperhex2b32($hexkey);

    $url = urlencode($AuthOTP->createURL($row["MobileNo"]));
    $keyurl = "<img src=\"http://chart.apis.google.com/chart?cht=qr&chl=$url&chs=200x200\">";

  }
  else {
    $b32key = "";
    $hexkey = "";
    $type = "";
    $hastoken = "no";
    $keyurl = "";
  }


  // now we generate the qrcode for the user

  echo "<tr><td>".$row["MobileNo"]."</td><td>$hastoken $type</td><td>$keyurl</td><td>$b32key</td></tr>";

?>
</table>
