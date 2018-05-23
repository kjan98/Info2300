<?php
  include('includes/init.php');
  $current_page_id="list_serve";

  #$db = open_or_init_sqlite_db('box.sqlite', "init/init.sql");

  if(isset($_POST["add"])){
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    if($email != null){
      try{
        $db->beginTransaction();
        $sql = "INSERT INTO listserve (id, email) VALUES (:email)";
        $params = array(
          ':email' => $email
        );
        $result = exec_sql_query($db, $sql, $params);
        $db->commit();
        if ($result) {
          array_push($messages, "The email address " . htmlspecialchars($email) . " has been added to the Listserve!");
        } else {
          array_push($messages, "Failed to add your email!");
        }
      }catch(\PDOException $e){
          if($e->errorInfo[1]==19){
            array_push($messages, "You have been added to listserve!");
          }
      }
    }else{
      array_push($messages, "The email address is invalid!");
    }

  }

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
  <title> List Serve </title>
</head>

<body>
  <?php include("includes/header.php"); ?>
  <div class = "content">
    <?php print_messages()?>
    <h1 class = "title">Add to the Listserve for more Information</h1>
    <form id = "add_listserve" action = "list_serve.php" method = "post">
      <div>
        Email Address: <input type='text' name='email' required/>
      </div>
      <br>
      <div>
        <button id="submit-button" name='add' type='submit'>Submit</button>
      </div>
    </form>
  </div>
  <!-- <?php include("includes/footer.php"); ?> -->
</body>
</html>
