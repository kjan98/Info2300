<?php
  include('includes/init.php');
  $current_page_id="login";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
  <title>Member Login/Logout</title>
</head>

<body>
  <?php include("includes/header.php"); ?>
  <div class = "content">
    <?php print_messages(); ?>
    <?php
      if($current_user){
        echo '<h1 class = "title"> Logout </h1>';
        echo "<form id='logout' action='#' method='post'>";
          echo "<button name='logout' type='submit'>Logout</button>";
          echo "</form>";
      }
      else{
        echo '<h1 class = "title"> Login </h1>';
        echo "<form id='login' action='#' method='post'>
          <div>
            Username: <input type='text' name='username' required/>
          </div>
          <div>
            Password: <input type='password' name='password' required/>
          </div>
          <br>
          <button id='submit-button' name='login' type='submit'>Submit</button>
        </form>";
      }
     ?>
  </div>
  <div class = 'big_space'></div>
  <div class = 'big_space'></div>
  <div class = 'space'></div>
  <div class = 'space'></div>
  <!-- <?php include("includes/footer.php"); ?> -->
</body>
</html>
