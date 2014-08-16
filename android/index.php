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

$AuthOTP=new AuthOTP();

//$AuthOTP->setUser('1', 'TOTP');

echo $AuthOTP->getData('1');
?>
<h2>Users</h2>
<table border="1">
<tr><th>UserID</th><th>Has Token?</th><th>Key</th><th>Base 32 Key</th><th>Hex Key</th></tr>
<?php
// now we get our list of users - this part of the page just has a list of users
// and the ability to create new ones. This isnt really in the scope of the
// GA4PHP, but for this example, we need to be able to create users, so heres where
// you do it.
$row["users_username"]='1';
  if($AuthOTP->hasToken($row["users_username"])) {
    $hastoken = "Yes";
    $type = $AuthOTP->getTokenType($row["users_username"]);
    if($type == "HOTP") {
      $type = "- Counter Based";
    } else {
      $type = "- Time Based";
    }
    $hexkey = $AuthOTP->getKey($row["users_username"]);
    $b32key = $AuthOTP->helperhex2b32($hexkey);

    $url = urlencode($AuthOTP->createURL($row["users_username"]));
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

  echo "<tr><td>".$row["users_username"]."</td><td>$hastoken $type</td><td>$keyurl</td><td>$b32key</td><td>$hexkey</td></tr>";

?>
</table>

<?php
if($AuthOTP->authenticateUser('1', '307413')) {
  echo "Authentic";
} else {
  echo "Invalid";
}
?>
