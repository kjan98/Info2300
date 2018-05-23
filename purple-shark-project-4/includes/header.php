<header>
  <nav>
    <ul class="navigation">
      <?php
        $check = -1;
        if($current_user){
          $sql = "SELECT * FROM member WHERE username = :username;";
          $params = array(
            ':username' => $current_user
          );
          $records = exec_sql_query($db, $sql, $params)->fetchAll();
          if ($records) {
            $result = $records[0];
            $check = $result["admin"];
          }
        }
        foreach($pages as $page_id => $page_arr) {
          if($page_arr[1] <= $check){
            if ($page_id == $current_page_id) {
              $css_id = "id='current_page'";
            } else {
              $css_id = "";
            }
            if($page_id == "login"){
              if(check_login()){
                echo "<li><a " . $css_id . " href='" . $page_id. ".php'>Logout</a></li>";
              }
              else{
                echo "<li><a " . $css_id . " href='" . $page_id. ".php'>Member Login</a></li>";
              }
            }
            else{
              echo "<li><a " . $css_id . " href='" . $page_id. ".php'>" . $page_arr[0] . "</a></li>";
            }
          }
        }
      if ($current_user){
        echo "<li id=\"login_notif\"><a> Welcome, $current_user !</a></li>";
      }
      ?>
    </ul>
 </nav>
 <h1 id="title"><?php echo $title; ?></h1>
</header>
