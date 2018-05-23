<?php
  include('includes/init.php');
  $current_page_id = "index";
  if(isset($_POST["add"])){
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    if($email != null){
      try{
        $db->beginTransaction();
        $sql = "INSERT INTO listserve (email) VALUES (:email)";
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

  <title>Home</title>
</head>

<body>
  <?php include("includes/header.php"); ?>
  <div class="content">
    <?php print_messages(); ?>
    <h1 class="title"> Welcome to the Squash Club Website! </h1>
      <div class = "container">
        <div class = "item">
          <figure><img id="teampic" src="images/team2.jpg" alt="The Team"></figure>
        </div>
        <div class = "item">
          <p id="indexp">
            Squash is a sport dedicated to playing in a four-walled court with a rubber
            ball. It is a great and fun way to stay active on campus. For more information,
            please visit the <a href="faq.php">FAQ page</a> for tryout times and more. Come to
            our tryouts to join a great community and make new friends!
          </p>
          <div class = "h2_form"><h2>  Add yourself to the Listserve! </h2></div>
          <form id = "add_listserve" action = "index.php" method = "post">
            <div>
              Email Address: <input type='text' name='email' required/>
            </div>
            <div class = "space"></div>
            <div>
              <button id="submit-button" name='add' type='submit'>Submit</button>
              <div class = "space"> </div>
            </div>
          </form>
        </div>
      </div>
      <div class = "container">

        <video class = "q"  controls>
          <source src="videos/vid1.mp4" type="video/mp4">
          Sorry, looks like your browser doesn't support this video :(
        </video>
        <video class = "q" controls>
          <source src="videos/vid2.mp4" type="video/mp4">
          Sorry, looks like your browser doesn't support this video :(
        </video>
        <video class = "q" controls>
          <source src="videos/vid3.mp4" type="video/mp4">
          Sorry, looks like your browser doesn't support this video :(
        </video>
      </div>
      <div class = "space"> </div>
  </div>
  <div class = 'big_space'></div>
  <!-- <?php include("includes/footer.php"); ?> -->
</body>
</html>
