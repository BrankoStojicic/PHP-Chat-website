<?php
include "../init.php";

$obj = new base_class;
$login_time = time();
if(isset($_POST['send_message'])){
    $message = $obj->security($_POST['send_message']);
    $user_id = $_SESSION['user_id'];
    $msg_type = "text";
    
    if($obj->Normal_Query("INSERT INTO messages(message, msg_type, user_id) VALUES (?,?,?)", [$message, $msg_type, $user_id])){
        echo json_encode(['status' => 'success']);
        
        $obj->Normal_Query("UPDATE users_activities SET login_time = ? WHERE user_id = ?", [$login_time, $user_id]);
    }
}


?>