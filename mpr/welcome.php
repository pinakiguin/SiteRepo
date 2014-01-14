<html>
  <body>

    Welcome <?php
    echo $_POST["name"];
    echo date("Y-m-d", strtotime($_POST["datepicker"])); // PHP:  2009-03-31
    ?><br>

    <?php
    print_r($_POST);
    ?>


  </body>
</html>