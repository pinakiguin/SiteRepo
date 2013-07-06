<div class="MenuBar">
  <ul>
    <li
      class="<?php echo ($_SERVER['SCRIPT_NAME'] == BaseDIR . 'index.php') ? 'SelMenuitems' : 'Menuitems'; ?>">
      <a href="<?php echo GetAbsoluteURLFolder(); ?>index.php">Home</a>
    </li>
    <li
      class="<?php echo ($_SERVER['SCRIPT_NAME'] == BaseDIR . 'login.php') ? 'SelMenuitems' : 'Menuitems'; ?>">
        <?php echo "<a href=\"" . GetAbsoluteURLFolder() . ((CheckAuth() !== "Valid") ? "login.php\">Log In!</a>" : "login.php?LogOut=1\">Log Out!</a>"); ?>
    </li>
  </ul>
</div>
