<?php
  include('includes/init.php');
  $current_page_id="members";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
  <title>Members</title>
</head>

<?php
  function draw_picture($file_name, $name){
    echo "
    <div class = 'item'>
      <img class = 'eboard_photo' src = 'images/'.$file_name.'.jpg' alt = $name />
      <h3> $name </h3>
    </div>
    ";
  }
?>

<body>
  <?php include("includes/header.php"); ?>
  <div class = "content">
    <h1 class = "title"> Members! </h1>
    <div class="containermem">
      <?php
        $records = exec_sql_query($db, "SELECT * FROM member")->fetchAll(PDO::FETCH_ASSOC);
        foreach($records as $member){
          $filename = $member['id'];
          $extension = $member['ext'];
          $fname = $member['fname'];
          $lname = $member['lname'];
          $fig = "<figure><img class=\"eboard_photo\" src=uploads/images/$filename.$extension alt=\"Image\"></figure>";
          $figcaption = "<h3> $fname $lname </h3>";
          echo "<div class = \"container\">";
          echo "<div class = \"item\">";
          echo $fig;
          echo $figcaption;
          echo "</div>";
          echo "</div>";
        }
      ?>
    </div>
  </div>
  <div class = 'big_space'></div>
  <!-- <?php include("includes/footer.php"); ?> -->
</body>
</html>
