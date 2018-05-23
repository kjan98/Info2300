<?php
  include('includes/init.php');
  $current_page_id="faq";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
  <title> Frequently Asked Questions </title>
</head>

<body>
  <?php include("includes/header.php"); ?>
  <div class = "content">
    <h1 class = "faq_title"> Frequently Asked Questions </h1>
    <h2> <span class = "bold"> How do we get to the Reis Tennis Center? </span> </h2>
    Typically carpool or uber, depending on if we have someone willing to give
    us a ride.
    <h2> <span class = "bold"> Why are there tryouts? </span> </h2>
    We want to ensure an enjoyable experience for all members, and we feel the
    game is more enjoyable if everyone can play at or around at the same skill
    level.
    <h2> <span class = "bold"> How do tryouts work? </span> </h2>
    You are placed into brackets at random and then compete against each other.
    <h2> <span class = "bold"> How many people are accepted from tryouts? </span> </h2>
    We don't have a maximum number of members, so the number varies on a number
    of factors, such as the skill of the member and the overall environment of
    the members.
    <h2> <span class = "bold"> How many people are trying out? </span> </h2>
    The number varies from semester to semester, but if more people show up at
    tryouts, it won't be more difficult for you to join.
    <h2> <span class = "bold"> How serious is attendance? </span> </h2>
    We understand that every member has other obligations and school work,
    but we require you to attend to at least 3 practices per semester.
    <h2> <span class = "bold"> Do I have to pay dues? </span> </h2>
     Yes, it's $15 due at the beginning of each semester. This fee goes toward
     our uber rides to get to our practice area. All leftover money from the
     semester will be venmoed back to all the members who paid their dues!
     <h2> <span class = "bold"> When is the next practice? </span> </h2>
     Today is <?php echo date("F j, Y"); ?>. The next practices are
     <?php
        $today = date("F j, Y");
        $count = 0;
        $records = exec_sql_query($db, "SELECT date FROM practice")->fetchAll(PDO::FETCH_ASSOC);
        if($records!=NULL) {
          foreach($records as $date) {
            if (strtotime($today) < strtotime($date['date']) ) {
              echo ($date['date']);
              $count = $count + 1;
            }
            if($count>=1){
              echo ", ";
            }
          }
        }
        if($count==0) {
          echo "No future practices currently set up!";
        }
     ?>
  </div>
  <div class = 'big_space'></div>
  <!-- <?php include("includes/footer.php"); ?> -->
</body>
</html>
