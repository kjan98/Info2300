<?php
  include('includes/init.php');
  $current_page_id="update_attendace";

  $month_dic = array(1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June", 7 => "July",
                      8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December");
  function validateDate($date, $format = 'Y-n-j'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
  }

  function delete_in_member_practice($messages,$id){
    global $db;
    try{
      //$db->beginTransaction();
      $sql = "DELETE FROM member_practice WHERE member_practice.practice_id == :practice_id";
      $params = array(':practice_id' => $id);
      $delete_result = exec_sql_query($db, $sql, $params);
      //$db->commit();
    }catch(\PDOException $e){
      array_push($messages, "");
    }
  }

  function reset_all(){
    global $db;
    global $messages;
    try{
      $sql1 = "DELETE FROM member_practice";
      $params1 = array();
      $delete_result1 = exec_sql_query($db, $sql1, $params1);
      $sql2 = "UPDATE member SET num_prac = 0";
      $params2 = array();
      $delete_result1 = exec_sql_query($db, $sql2, $params2);
      $sql3 = "DELETE FROM practice";
      $params3 = array();
      $delete_result3 = exec_sql_query($db, $sql3, $params3);
    }catch(\PDOException $e){
      array_push($messages, "");
    }
  }

  function get_practice_id($practice_date){
    global $db;
    global $messages;
    try{
      //$db->beginTransaction();
      $sql = "SELECT practice.id FROM practice WHERE practice.date == :practice_date";
      $params = array(
        ':practice_date' => $practice_date
      );
      $practice_ids = exec_sql_query($db, $sql, $params)->fetchAll();
      //$db->commit();
      foreach($practice_ids as $prac_id){
        $practice_id = $prac_id[0];
        return $practice_id;
      }
    }catch(\PDOException $e){
      array_push($messages, "");
      return "";
    }
    // return $practice_id;

  }
//update attendance
  if(isset($_POST["update_attendance"])){
     $day = filter_input(INPUT_POST, "practice_day", FILTER_SANITIZE_NUMBER_INT);
     $month = filter_input(INPUT_POST, "practice_month", FILTER_SANITIZE_NUMBER_INT);
     $year = filter_input(INPUT_POST, "practice_year", FILTER_SANITIZE_NUMBER_INT);
     $date = $year.'-'.$month.'-'.$day;
     $members = array();
     if(isset($_POST["member_list"])){
       $tmp = "here";
       foreach($_POST["member_list"] as $member){
         $member_id = filter_var($member, FILTER_SANITIZE_NUMBER_INT);
         if($member_id !=null){
           array_push($members, $member_id);
         }
       }
     }

    if(validateDate($date)&&isset($_POST["member_list"])){
      global $messages;
      // array_push($messages, "day = ".$_GET["day"]."Month = ".$_GET["month"]."Year = ".$_GET["year"]);
      //Add the practice: if this practice has not been updated before, create a new record in the practice table. Otherwise,
      //Delete the corresponding records in the member_practice first.
      $practice_date = $month_dic[$month].' '.$day.', '.$year;
      try{
        //$db->beginTransaction();
        $sql1 = "INSERT INTO practice(date) VALUES (:practice_date)";
        $params1 = array(
          ':practice_date' => $practice_date
        );
        $result1 = exec_sql_query($db, $sql1, $params1);
        //$db->commit();
        array_push($messages, "Added a new practice on ".$practice_date);
      }catch(\PDOException $e){
        if($e->errorInfo[1]==19){
          array_push($messages, "The attendance for the practice on ".$practice_date." has been updated");
          $practice_ids = get_practice_id($practice_date);
          delete_in_member_practice($messages,$practice_ids);
        }
      }
      $practice_ids = get_practice_id($practice_date);


      //Update the records in the member_practice table
      try{
        foreach($members as $member){
          // array_push($messages, "member is: ".$member);
          //$db->beginTransaction();
          $sql2 = "INSERT INTO member_practice(member_id, practice_id) VALUES (:member, :practice)";
          $params2 = array(
            ':member' => $member,
            ':practice' => $practice_ids
          );
          $result3 = exec_sql_query($db, $sql2, $params2);
          //$db->commit();
        }
        //$db->beginTransaction();
        $sql_tmp = "SELECT * from member_practice";
        $params_ar = array();
        $p = exec_sql_query($db, $sql_tmp, $params_ar);
        //$db->commit();
      }catch (\PDOException $e){
        array_push($messages, "That date was already entered! Try entering another date!");
      }

    }else{
      array_push($messages, "The practice date is invalid or the member list is empty!");
    }

  }

  //Reset the practice $records

  if(isset($_POST['reset_attendance'])){
    reset_all();
  }
  class Calendar{
    private $days_labes = array('Sun', 'Mon', 'Tue', 'Wen', 'Thu', 'Fri', 'Sat');
    private $current_month = 0;
    private $current_year = 0;
    private $current_num_days = 0;
    private $current_day = null;
    private $navi_href = null;

    public function construct (){
      $this->navi_href = htmlentities($_SERVER['PHP_SELF']);
    }

    public function show_calendar(){
      $year = null;
      $month = null;

      if($year == null && isset($_GET['year']) && $_GET['year']>0){
        $year = $_GET['year'];
      }else{
        $year = date("Y", time());
      }

      if($month == null && isset($_GET['month']) && 1 <= $_GET['month']){
        $month = $_GET['month'];
      }else{
        $month = date("n", time());
      }
      $this->current_month = $month;
      $this->current_year = $year;
      $this->current_num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
      $date_info = getdate(strtotime('first day of', mktime(0,0,0,$month, $year)));
      $this->current_day = $date_info['wday'];

      // display the navi
      if($this->current_month == 12){
        $next_month = 1;
        $next_year = intval($this->current_year)+1;
      }else{
        $next_month = intval($this->current_month)+1;
        $next_year = $this->current_year;
      }
      if($this->current_month == 1){
        $pre_month = 12;
        $pre_year = intval($this->current_year-1);
      }else{
        $pre_month = intval($this->current_month)-1;
        $pre_year = intval($this->current_year);
      }

      echo '<div class = "calendar_nav">'.
              '<a id = "prev" href = "'.$this->navi_href.'?month='.$pre_month.'&year='.$pre_year.'">Prev</a>'.
                '<span id = "current">'.date("Y m", strtotime($this->current_year.'-'.$this->current_month.'-1')).'</span>'.
              '<a id = "next" href = "'.$this->navi_href.'?month='.$next_month.'&year='.$next_year.'">Next</a>'.
            '</div>';

      $calendar = '<table id = "calendar"><tr>';

      foreach($this->days_labes as $day){
        $calendar .= '<th>'.$day.'</th>';
      }
      $calendar .= '</tr><tr>';
      if($this->current_day>0){
        for($i=0; $i<$this->current_day; $i++){
          $calendar .= '<td></td>';
        }
      }

      $counter = 1;
      while($counter <= $this->current_num_days){
          if($this->current_day == 7){
            $this->current_day = 0;
            $calendar .= '</tr><tr>';
          }
          $calendar .= '<td><a href = "'.$this->navi_href.'?month='.$this->current_month.'&year='.$this->current_year.'&day='.$counter.'">'.$counter.'</a></td>';
          $counter++;
          $this->current_day++;
      }

      if($this->current_day != 7){
        for($i=0; $i<(7-$this->current_day); $i++){
          $calendar .= '<td></td>';
        }
      }
      $calendar .= '</tr>';
      $calendar .= '</table>';
      return $calendar;
    }

  }

  function form_list(){
    global $messages;
    $list = '<form id = "attendance_list action = "update_attendance.php" method = "post">';
    $year = null;
    $month = null;
    $day = null;
    global $db;

    if($year == null && isset($_GET['year']) && $_GET['year']>0){
      $year = $_GET['year'];
    }else{
      $year = date("Y", time());
    }

    if($month == null && isset($_GET['month']) && 1 <= $_GET['month']){
      $month = $_GET['month'];
    }else{
      $month = date("n", time());
    }

    if($day == null && isset($_GET['day']) && 1 <= $_GET['day']){
      $day = $_GET['day'];
    }else{
      $day = date("j", time());
    }

    $list .= "<h3>Practice Date:</h3>
                Day: <input type = 'text' name = 'practice_day' value = '".$day."' required/>
                Month: <input type = 'text' name = 'practice_month' value = '".$month."' required/>
                Year: <input type = 'text' name = 'practice_year' value = '".$year."' required/>";
    $list .= "<table>";
    try{
      //$db->beginTransaction();
      $sql = "SELECT member.fname, member.lname, member.id, member.netid FROM member";
      $params = array();
      $members = exec_sql_query($db, $sql, $params);
      //$db->commit();
      $count = 0;
      foreach($members as $member){
        if($count%5 == 0 && $count != 0){
          $list .= "</tr><tr><td>
          <input type = 'checkbox' name = 'member_list[".$count."]' value = '".$member["id"]."'>".$member["fname"]." ".$member["lname"]."(".$member["netid"].")</td>";
        } else if($count == 0) {
          $list .= "<tr><td>
          <input type = 'checkbox' name = 'member_list[".$count."]' value = '".$member["id"]."'>".$member["fname"]." ".$member["lname"]."(".$member["netid"].")</td>";
        } else {
          $list .= "<td>
          <input type = 'checkbox' name = 'member_list[".$count."]' value = '".$member["id"]."'>".$member["fname"]." ".$member["lname"]."(".$member["netid"].")</td>";
        }
        $count++;
      }
    }catch(\PDOException $e){
      array_push($messages, "Exception detected!");
    }
    // $count = 0;
    // foreach($members as $member){
    //   if($count%5 == 0 && $count != 0){
    //     $list .= "</tr><tr><td>
    //     <input type = 'checkbox' name = 'member_list[".$count."]' value = '".$member["id"]."'>".$member["fname"]." ".$member["lname"]."(".$member["netid"].")</td>";
    //   } else if($count == 0) {
    //     $list .= "<tr><td>
    //     <input type = 'checkbox' name = 'member_list[".$count."]' value = '".$member["id"]."'>".$member["fname"]." ".$member["lname"]."(".$member["netid"].")</td>";
    //   } else {
    //     $list .= "<td>
    //     <input type = 'checkbox' name = 'member_list[".$count."]' value = '".$member["id"]."'>".$member["fname"]." ".$member["lname"]."(".$member["netid"].")</td>";
    //   }
    //   $count++;
    // }
    $list .= "</tr></table>";
    $list .= "<div id = 'update_submit'><button id = 'submit_button' name = 'update_attendance' type = 'submit'>Submit</button>";
    $list .= "</div>";
    $list .= "</form>";
    return $list;
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
    <h1 class = "title"> Update Attendance</h1>
    <?php print_messages()?>
    <?php
      $calendar = new Calendar();
      $calendar->construct();
      echo $calendar->show_calendar();
      echo "<div class = 'space'></div>";
      echo form_list();
    ?>
    <form method = "post" action = "update_attendance.php" onsubmit='return myfunction()'>
      <button id = 'reset_button' name = 'reset_attendance' type = 'submit'>Reset</button>
    </form> -->
    <script>
      function myfunction(){
        return confirm('Are you sure to reset all the practice attendance? Once you confirm, all of the records will be set to zero.');
        var a = confirm("Are you sure to reset all the practice attendance? Once you confirm, all of the records will be set to zero.");
        if(a == true){
          $.ajax({
               url: 'update_attendance.php',
               type: 'POST',
               data: {reset : true},
               success:function(response){
                 alert("reset!");
               }
           });
           alert("in");
        }
      }
    </script>
    <div class = 'space'></div>
    <div class = 'space'></div>
  </div>
  <div class = 'big_space'></div>
  <!-- <?php include("includes/footer.php"); ?> -->
</body>
</html>
