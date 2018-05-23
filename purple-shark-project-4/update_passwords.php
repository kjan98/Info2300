<?php
  include('includes/init.php');
  $current_page_id="update_passwords";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
  <title>Update Passwords</title>
</head>

<?php
  if (isset($_POST["pass_submit"])) {
    $curr_password= trim(strtolower(htmlspecialchars($_POST["curr_pass"])));
    $new_pass  = trim(strtolower(htmlspecialchars($_POST["new_pass_1"])));
    $check_pass = trim(strtolower(htmlspecialchars($_POST["new_pass_2"])));
    $given_netid = trim(strtolower(htmlspecialchars($_POST["netid"])));
    $netid_check = preg_match("/^[a-z]{2,}[0-9]{2,}$/", $given_netid);
    // $given_netid = $_POST["netid"];
    $db->beginTransaction();
    $sql_pass = "SELECT password from member where netid == :netid";
    $params = array(':netid' => $current_user);
    $pass = exec_sql_query($db,$sql_pass, $params);
    $db->commit();
    $pa = "";
    foreach ($pass as $p){
      $pa = password_verify($curr_password, $p['password']);
    }

    if ($new_pass != $check_pass) {
       push_message("Whoops! Looks like your new passwords aren't the same. Make sure
      you type the same password into the last two boxes!");
    }

    else if ($given_netid == $current_user && $pa) {
      $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
      $db->beginTransaction();
      $sql_update = "UPDATE member SET password = :hashed_pass WHERE netid == :netid";
      $params_arr = array(':hashed_pass' => $hashed_pass, ':netid'=> $current_user);
      exec_sql_query($db, $sql_update, $params_arr);
      $db->commit();

      push_message("Congratulations, you've successfully updated your password!");
    }

    else {
      push_message("Sorry, you weren't able to update your password. Double check and make sure
      everything's correct.");
    }

  }

?>

<body>
  <?php include("includes/header.php"); ?>
  <div class = "content">
    <h1 class = "title"> Update Password </h1>
    <?php print_messages(); ?>
    <p class = "pass_desc"> To change your password, fill out the bottom form! </p>
    <form id = 'password_form' method = POST>
      <ul class = "form_list">
        <li> <label class = "update_pass_label"> NetId: </label> </li>
        <li> <input class = "update_pass_input" type = 'text' name = 'netid' required <?php if (isset($_POST["netid"])) { echo "value = "; echo $_POST["netid"]; }?> > </li>
        <li> <label class = "update_pass_label"> Current Password: </label> </li>
        <li> <input class = "update_pass_input" type = 'password' name = 'curr_pass' required <?php if (isset($_POST["curr_pass"])) { echo "value = "; echo $_POST["curr_pass"]; }?> > </li>
        <li> <label class = "update_pass_label"> New Password: </label> </li>
        <li> <input class = "update_pass_input" type = 'password' name = 'new_pass_1' required <?php if (isset($_POST["new_pass_1"])) {echo "value = "; echo $_POST["new_pass_1"];}?> > </li>
        <li> <label class = "update_pass_label"> Retype New Password: </label> </li>
        <li> <input class = "update_pass_input_last" type = 'password' name = 'new_pass_2' required <?php if (isset($_POST["new_pass_2"])) { echo "value = "; echo $_POST["new_pass_2"]; }?> > </li>
        <li> <input class = 'submit_button_pass' name = "pass_submit" type = 'submit' value = 'Change Password'> </li>
      </ul>
    </form>

  </div>
  <div class = 'space'></div>
  <div class = 'space'></div>
  <!-- <?php include("includes/footer.php"); ?> -->
</body>
</html>
