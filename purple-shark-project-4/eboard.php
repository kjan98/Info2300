<?php
  include('includes/init.php');
  $current_page_id="eboard";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

  <title>Eboard</title>
</head>

<body>
  <?php include("includes/header.php"); ?>
  <div class = "content">
    <h1 class = "title"> 2017-2018 Executive Board </h1>
    <?php
      $map = array(
        "president" => "President",
        "treasurer" => "Treasurer",
        "tourn_coord" => "Tournament Coordinator"
      );
      if(isset($_GET["netid"]) and isset($_GET["title"])) {
        $title = filter_input(INPUT_GET, "title", FILTER_SANITIZE_STRING);
        $netid = filter_input(INPUT_GET, "netid", FILTER_SANITIZE_STRING);
        $sql = "SELECT * FROM member WHERE netid = :netid";
        $params = array(":netid" => $netid);
        $eboard_mem = exec_sql_query($db, $sql, $params)->fetchAll();
        if (isset($eboard_mem) and !empty($eboard_mem)) {
          $sql = "SELECT * FROM eboard WHERE title = :title";
          $params = array(":title" => $title);
          $eboard_mem = exec_sql_query($db, $sql, $params)->fetchAll();
          if (isset($eboard_mem) and !empty($eboard_mem)) {
            $old_netid = $eboard_mem[0];
            $sql = "UPDATE member SET admin = 0 WHERE netid = :old_netid";
            $params = array(":netid" => $old_netid);
            exec_sql_query($db, $sql, $params);
          }
          $sql = "UPDATE eboard SET netid = :netid WHERE title = :title";
          $params = array(":netid" => $netid, ":title" => $map[$title]);
          exec_sql_query($db, $sql, $params);
        }
        else{
          echo "<p class='error_msg'>Error: Not a valid member.</p>";
        }
      }
     ?>
    <div class = "container">
      <?php
      $sql = "SELECT * FROM eboard";
      $params = array();
      $admins = exec_sql_query($db, $sql, $params)->fetchAll();
      if (isset($admins) and !empty($admins)) {
        foreach($admins as $admin){
          $netid = $admin["netid"];
          $sql = "SELECT * FROM member WHERE member.netid = :netid";
          $params = array(":netid" => $netid);
          $admin_info = exec_sql_query($db, $sql, $params)->fetchAll();
          if (isset($admin_info) and !empty($admin_info)) {
            echo "<div class = 'item'>";
            echo "<img class = 'eboard_photo' alt =\"image\" src='/uploads/images/" . $admin_info[0]["id"] . "." . $admin_info[0]["ext"] . "'/>";
            echo "<h3>" . $admin["title"] . ": " . $admin_info[0]["fname"] . " " . $admin_info[0]["lname"] . "</h3>";
            echo "</div>";
          }
          $sql = "UPDATE member SET admin = 1 WHERE netid = :netid";
          $params = array(":netid" => $netid);
          exec_sql_query($db, $sql, $params);
        }
      }
    ?>
    </div>
    <?php
      if($check==1){
        echo '<div id="update_admins">
              <p>Update Admins</p>
              <form id="eboard" action="eboard.php" method="GET">
              Netid: <input type="text" name="netid" required/>
              <select id="dropdown" name="title">
                <option value ="president">President</option>
                <option value ="treasurer">Treasurer</option>
                <option value ="tourn_coord">Tournament Coordinator</option>
              </select>
              <button type="submit">Update</button>
              </form></div>';
      }
   ?>
  </div>
  <div class = 'big_space'></div>
  <!-- <?php include("includes/footer.php"); ?> -->
</body>
</html>
