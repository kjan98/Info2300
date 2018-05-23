<?php
  include('includes/init.php');
  $current_page_id = "get_list_serve";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

  <title>Listserve</title>
</head>

<body>
  <?php include("includes/header.php"); ?>
  <div class="content">
    <h1 class = "title">All current emails on the listserve</h1>
    <ul>
      <?php
        $db->beginTransaction();
        $records = exec_sql_query($db, "SELECT * FROM listserve")->fetchAll(PDO::FETCH_ASSOC);
        $db->commit();
        foreach($records as $person){
          $curemail = $person['email'];
          echo "<li>".htmlspecialchars($curemail)."</li>";
        }
      ?>
    </ul>
  </div>
  <div class = 'big_space'></div>
  <div class = 'space'></div>
  <div class = 'space'></div>
  <div class = 'space'></div>
  <!-- <?php include("includes/footer.php"); ?> -->
</body>
</html>
