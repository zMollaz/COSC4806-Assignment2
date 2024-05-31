<?php
require_once 'database.php';

Class User {
  public static function get_all_users () {
    $db = db_connect();
    $statment = $db->prepare("SELECT * FROM users");
    $statment->execute();
    $rows = $statment->fetchAll();
    return $rows;
  }
}
  
echo "<pre>"; 
print_r(User::get_all_users());
?>