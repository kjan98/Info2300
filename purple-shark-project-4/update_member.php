<?php
  include('includes/init.php');
  $current_page_id="update_member";
  const BOX_UPLOADS_PATH = "uploads/images/";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
  <title>Update Members</title>
</head>

<body>
  <?php
    include("includes/header.php");
    print_messages();
   ?>
  <div class = "content">
    <h1 class = "title"> Update Members! </h1>
    <div id = "add">
      <form id = 'add_form' method = POST enctype="multipart/form-data">
          <p class = 'table_name'> ADD </p>
          <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
          <label class = "update_member_label"> First Name </label>
          <input class = "update_member_input" type = 'text' name = 'fname' required>
          <label class = "update_member_label"> Last Name: </label>
          <input class = "update_member_input" type = 'text' name = 'lname' required>
          <label class = "update_member_label"> NetId: </label>
          <input class = "update_member_input_last" type = 'text' name = 'netid' required  >
          <div class = 'space'></div>
          <label class = "update_member_label"> Upload file: </label>
          <input class = "update_member_input_last" name="img_file" type="file" required>
          <input class = 'submit_button' name = "add_submit" type = 'submit' value = ADD>
      </form>
    </div>
    <!-- add form  -->
    <?php
    // store, filter, sanitize the submitted information if submit button is pressed
      if (isset($_POST["add_submit"])) {
        $fname = trim(filter_var(htmlspecialchars($_POST["fname"]), FILTER_SANITIZE_STRING));
        $lname = trim(filter_var(htmlspecialchars($_POST["lname"]), FILTER_SANITIZE_STRING));
        $netid = trim(strtolower(htmlspecialchars($_POST["netid"])));
        $netid_check = preg_match("/^[a-z]{2,}[0-9]{1,}$/", $netid);
        if ($netid_check != 1) {
          echo "<div class = 'error_msg'>
          <p> Not a valid NetId! Make sure the NetId you have inputted is valid! </p>
          </div>";
          $netid = "";
        }
        else {
          //add member to database
          $db->beginTransaction();
          $upload_info = $_FILES["img_file"];
          if ($upload_info['error']==UPLOAD_ERR_OK) {
            $filename = basename($upload_info["name"]);
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $testrecords = exec_sql_query($db, "SELECT * FROM member WHERE netid='$netid'")->fetchAll(PDO::FETCH_ASSOC);
            if($testrecords==NULL){
              $sql = "INSERT INTO member (username, password, ext, fname, lname, netid, admin)
              VALUES (:username, :password, :ext, :fname, :lname, :netid, :admin)";
              $pass = password_hash($netid, PASSWORD_DEFAULT);
              $params_add = array(':username' => $netid, ':password' => $pass, ':ext' => $extension, ':fname' => $fname, ':lname' => $lname, ":netid" => $netid, ":admin"=> 0);
              exec_sql_query($db, $sql, $params_add);

              $img_id = $db->lastInsertId("id");
              $newfilename = BOX_UPLOADS_PATH.$img_id.".".$extension;
              move_uploaded_file($upload_info["tmp_name"], $newfilename);
              echo("Addition successful!");
            }
            else{
              echo "<p> This netid is already in the database! </p>";
            }
          }
          $db->commit();
        }
      }
    ?>

    <div id = "remove">
      <form id = 'remove_form' method = POST>
          <p class = 'table_name'> REMOVE </p>
          <label class = "update_member_label"> NetId: </label>
          <input class = "update_member_input_last" type = 'text' name = 'netId_remove' required>
          <input class = 'submit_button' name = remove_submit type = 'submit' value = REMOVE>
      </form>
    </div>
    <!-- remove form  -->
    <?php
    // store, filter, sanitize the submitted information if submit button is pressed
      if (isset($_POST["remove_submit"])) {
        $netid = trim(strtolower(htmlspecialchars($_POST["netId_remove"])));
        $netid_check = preg_match("/^[a-z]{2,}[0-9]+$/", $netid);
        if ($netid_check != 1) {
          echo "<div class = 'error_msg'>
          <p> Not a valid NetId! Make sure the NetId you have inputted is valid! </p>
          </div>";
        }
        else {
          //remove member from database
          $db->beginTransaction();
          $sql_check = "SELECT id FROM member where netid == :netid";
          $params_delete = array(':netid' => $netid);
          $check = exec_sql_query($db, $sql_check, $params_delete)->fetchAll();
          if (empty($check)) {
            echo "<div class = 'error_msg'> <p> Hmm looks like that person's not a member! </p> </div>";
          }
          else {
            $sql = "DELETE FROM member WHERE netid == :netid";
            $sql_for_unlinking = "SELECT id, ext FROM member WHERE netid == :netid";
            $file_name = exec_sql_query($db,$sql_for_unlinking, $params_delete)->fetchAll();
            foreach($file_name as $f) {
              $f_n = $f['id'].".".$f['ext'];
            }
            $link = 'uploads/images/'.$f_n;
            unlink($link);
            exec_sql_query($db, $sql, $params_delete);
            echo("Deletion successful!");
            $db->commit();
          }
        }
      }
    ?>
    <div class = "space"></div>
  </div>
  <div class = 'big_space'></div>
  <!-- <?php include("includes/footer.php"); ?> -->
</body>
</html>
