<?php
  include('includes/init.php');
  $current_page_id="admin";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
  <title>Admin Privleges</title>
</head>

<body>
  <?php include("includes/header.php"); ?>
  <?php
    if(!$current_user || $check==0){
  ?>
  <div class = "content">
    <p> You should not be here if you are not logged in and are not an admin!</p>
  </div>
  <?php
    }
  ?>

  <?php
    if($current_user && $check==1){
  ?>
  <div class = "content">
    <h1 class = "title"> Administrative Links </h1>
    <p id = "admin_intro">
      Congrats on being on this year's eboard! As an eboard member, you get to enjoy
      extra privleges on this site as an admin, listed below. Read the description
      below each link to choose which one will suit your needs best.
    </p>

    <ul id = "admin_list">
      <li> <a class = "admin_link" href = "update_attendance.php"> Update Attendance </a> </li>
      <li class = 'administ_desc'><p class = "admin_desc"> Click here to update the attendance for all the
        members that attended the last practice! </p></li>
      <li> <a class = "admin_link" href = "get_list_serve.php"> Get Emails on the List Serve </a> </li>
      <li class = 'administ_desc'><p class = "admin_desc"> Need to send out a mass email to those interested
        in joining the club? Click the link above get all the emails of everyone
        on your listserve! </p></li>
      <li> <a class = "admin_link" href = "update_member.php"> Update Members </a> </li>
      <li class = 'administ_desc'><p class = "admin_desc"> Click the above link if you need to add new members
        to the club,remove any existing ones, or update which members get admin privleges! </p></li>
    </ul>
  </div>
  <?php } ?>
  <div class = 'big_space'></div>
  <!-- <?php include("includes/footer.php"); ?> -->
</body>
</html>
