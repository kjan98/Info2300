<?php
  include('includes/init.php');
  $current_page_id="member_attendance";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
  <title>Attendance</title>
</head>

<body>
  <?php include("includes/header.php"); ?>
  <div class = "content">
    <?php
      $sql_member_name = "SELECT * FROM member WHERE member.netid == :username";
      $params_member_name = array(':username' => $current_user);
      $fname_record = exec_sql_query($db, $sql_member_name, $params_member_name) -> fetchAll();
      $sql_test = "SELECT * FROM member";
      $user = "";
      $number = -1;
      foreach($fname_record as $r) {
        $user = ucfirst($r["fname"]) . " " . ucfirst($r["lname"]);
        // $number = $r["num_prac"];
      }
      $sql_member_id = "SELECT id from member where netid == :p";
      $params_member = array(':p'=>$current_user);
      $p = exec_sql_query($db,$sql_member_id, $params_member);
      $id = -1;
      foreach($p as $m) {
        $id = $m['id'];
      }
      $sql_number = "SELECT COUNT(practice_id) FROM member_practice WHERE member_id == :mid";
      $params_num = array(':mid' => $id);
      $n = exec_sql_query($db, $sql_number, $params_num)->fetchAll();
      foreach($n as $num) {
        $num_attended = $num['COUNT(practice_id)'];
      }
      echo "<h1 class = 'title'> Attendance for " . htmlspecialchars($user)." </h1>";
      $color = "red";
      if ($num_attended >= 3) {
        $color = "green";
      }
      $class = "member_attendance_msg_".$color;
      echo "<h2 class = $class> You have attended ". htmlspecialchars($num_attended)." practices! </h2>";
      $sql_date = "SELECT date from practice";
      $params_date = array();
      $date = exec_sql_query($db,$sql_date, $params_date)-> fetchAll();
      $sql_mem_date = "SELECT practice.date from practice inner join member_practice
      on practice.id == member_practice.practice_id inner join member on member_practice.member_id == :mid group by date";
      $md = exec_sql_query($db, $sql_mem_date, $params_num)->fetchAll();
      $m_d = array();
      foreach($md as $qr) {
        $tmp = $qr['date'];
        array_push($m_d, $tmp);
      }
      /*$t = in_array("May 10, 2018", $m_d);*/
      echo "<ul>";
      foreach($date as $d) {
        $tp = in_array($d['date'], $m_d);
        if ($tp) {
          echo "<li class = 'date_green'>". htmlspecialchars($d['date']) . "</li>";
        }
        else {
        echo "<li class = 'date'>". htmlspecialchars($d['date']) . "</li>";
        }
      }
      echo "</ul>";
    ?>
  </div>
  <div class = 'big_space'> </div>
  <div class = 'space'></div>
  <!-- <?php include("includes/footer.php"); ?> -->
</body>
</html>
