<?php
include "../init.php";
$obj = new base_class;

if(isset($_POST['clean'])){
    $user_id = $_SESSION['user_id'];
    if($obj->Normal_Query("SELECT id FROM messages ORDER BY id DESC LIMIT 1")){
                                
        $last_row = $obj->Single_Result();
        $last_msg_id = $last_row->id + 1;
        
        if($obj->Normal_Query("UPDATE clean SET clean_message_id = ? WHERE clean_user_id = ?", [$last_msg_id, $user_id])){
            echo json_encode(array("status" => 'clean'));
        }
    }
}

?>