<?php
$title = "Squash Club";
$pages = array(
  "index" => ["Home", -1],
  "admin" => ["Admin", 1],
  "member_attendance" => ["Attendance", 0],
  "update_passwords" => ["Update Password", 0],
  "faq" => ["FAQ", -1],
  "members" => ["Current Members", -1],
  "eboard" => ["Eboard", -1],
  "login" => ["Member Login/Logout", -1]
);



$current_page_id = NULL;
$current_user = NULL;
//messages will hold any error messages
$messages = array();
//print all the messages in the array
function print_messages(){
  global $messages;
  foreach($messages as $message){
    echo "<h3 class = 'error_msg'>" . htmlspecialchars($message) . "</h3>";
  }
}

//add any message to the array
function push_message($message){
  global $messages;
  array_push($messages, $message);
}

//helps the database filter out sql queries
function exec_sql_query($db, $sql, $params = array()) {
  $query = $db->prepare($sql);
  if ($query and $query->execute($params)) {
    return $query;
  }
  return NULL;
}

// YOU MAY COPY & PASTE THIS FUNCTION WITHOUT ATTRIBUTION.
// open connection to database
function open_or_init_sqlite_db($db_filename, $init_sql_filename) {
  if (!file_exists($db_filename)) {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_init_sql = file_get_contents($init_sql_filename);
    if ($db_init_sql) {
      try {
        $result = $db->exec($db_init_sql);
        if ($result) {
          return $db;
        }
      } catch (PDOException $exception) {
        // If we had an error, then the DB did not initialize properly,
        // so let's delete it!
        unlink($db_filename);
        throw $exception;
      }
    }
  } else {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }
  return NULL;
}

// open connection to database
$db = open_or_init_sqlite_db("db.sqlite", "init/init.sql");

//checks to see if the $current user is logged in
function check_login(){
  if (isset($_SESSION['current_user'])){
    return $_SESSION['current_user'];
  }
  return NULL;
}

//logins the members and checks its records with the db
function log_in($username, $password) {
  global $db;
  if ($username && $password) {
    //to prevent race conditions
    $db->beginTransaction();
    $sql = "SELECT * FROM member WHERE username = :username;";
    $params = array(
      ':username' => $username
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    //release the lock
    $db->commit();
    if ($records) {
      $account = $records[0];
      //checks to see if the username and pass match our database
      if (password_verify($password, $account['password'])) {
        $_SESSION['current_user'] = $username;
      } else {
        push_message("Invalid username or password.");
      }
    } else {
      //our error messages are similar as to not give information to hackers
      push_message("Invalid username or password.");
    }
  } else {
    push_message("No username or password given.");
  }
  return NULL;
}

//logs out the user by setting the session and the current user to be null
function log_out() {
  global $current_user;
  $current_user = NULL;
  unset($_SESSION['current_user']);
  session_destroy();
}

//checks to see if we should login the user
session_start();
if (isset($_POST['login'])) {
  //sends the filtered username and password to the login function
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $username = trim($username);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  $current_user = log_in($username, $password);
} else {
  //if we don't need to login, sets the current user
  $current_user = check_login();
}

//checks to see if the user needs to log out
if (isset($_POST['logout'])) {
  log_out();
}else {
  //if we don't need to login, sets the current user
  $current_user = check_login();
}

?>
