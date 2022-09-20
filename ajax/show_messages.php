<?php
include "../init.php";

$obj = new base_class;

if(isset($_GET['message'])){
    $user_id = $_SESSION['user_id'];
    if($obj->Normal_Query("SELECT clean_message_id FROM clean WHERE clean_user_id = ?", [$user_id])){
        $last_msg_row = $obj->Single_Result();
        //this is first bookmarked id for showing $last_msg_id
        $last_msg_id = $last_msg_row->clean_message_id;
        
        $obj->Normal_Query("SELECT id FROM messages ORDER BY id DESC LIMIT 1");
        $msg_row = $obj->Single_Result();
        //this is just fetching last id from messages 
        $msg_table_id = $msg_row->id;
        
        
        //and this shait is selecting all the messages from first bookmarked id of loged user and last id from messages
        $obj->Normal_Query("SELECT * FROM messages INNER JOIN users ON messages.user_id = users.id WHERE messages.id BETWEEN $last_msg_id AND $msg_table_id ORDER BY messages.id ASC");
        
        
        if($obj->Count_Rows() == 0){
            echo "<p class='clean_message'>You Can Say Something...</p>";
        }else{
            $messages_row = $obj->fetch_all();
            foreach($messages_row as $informations){
                $full_name = ucwords($informations->name);
                $user_image = $informations->image;
                $user_status = $informations->status;
                
                $message = $informations->message;
                $msg_type = $informations->msg_type;
                $db_user_id = $informations->user_id;
                $msg_time = $obj->time_ago($informations->msg_time);
                
                if($user_status == 0){
                    $user_online_status = '<span class="offline-icon"></span>';
                }else{
                    $user_online_status = '<span class="online-icon"></span>';
                }
                
                
                if($db_user_id == $user_id){
                    //Right user's message
                    if($msg_type == "text"){
                        
                        echo  '<div class="right-messages common-margin">
                                    <div class="right-msg-area">
                                        <span class="date-time right-time">
                                                 <span class="send-msg">&#10004;</span>'.$msg_time.'
                                        </span><!--date-time end-->
                                        <div class="right-msg">
                                            <p>
                                            '. $message .'
                                            </p>
                                        </div><!--right-msg end-->
                                    </div><!-- right-msg-area end-->
                                </div><!-- right-messages end-->';
                        
                    }else if($msg_type == "jpg" || $msg_type == "JPG" || $msg_type == "jpeg" || $msg_type == "gif"){
                        
                        echo '<div class="right-messages common-margin">
                                <div class="right-msg-area">
                                    <span class="date-time right-time right-message-time">
                                            <span class="send-msg">&#10004;</span>'.$msg_time.'
                                    </span><!--date-time end-->
                                    <div class="right-files">
                                        <img src="assets/img/' . $message . '" class="common-images">
                                    </div><!--right-msg end-->
                                </div><!-- right-msg-area end-->
                            </div><!-- right-messages end-->';
                        
                    }else if($msg_type == "png" || $msg_type == "PNG"){
                        echo '<div class="right-messages common-margin">
                                <div class="right-msg-area">
                                    <span class="date-time right-time right-message-time">
                                            <span class="send-msg">&#10004;</span>'.$msg_time.'
                                    </span><!--date-time end-->
                                    <div class="right-files">
                                        <img src="assets/img/' . $message . '" class="common-images">
                                    </div><!--right-msg end-->
                                </div><!-- right-msg-area end-->
                            </div><!-- right-messages end-->';
                    }else if($msg_type == "zip" || $msg_type == "ZIP"){
                        echo '<div class="right-messages common-margin">
                                <div class="right-msg-area">
                                    <span class="date-time right-time right-message-time">
                                            <span class="send-msg">&#10004;</span>'.$msg_time.'
                                    </span><!--date-time end-->
                                    <div class="right-files">
                                        <a href="assets/img/'.$message.'" class="all-files"><i class="fas fa-arrow-circle-down files-common zip"></i>'.$message.'</a>
                                    </div><!--right-msg end-->
                                </div><!-- right-msg-area end-->
                            </div><!-- right-messages end-->';
                    }else if($msg_type == "PDF" || $msg_type == "pdf"){
                        echo '<div class="right-messages common-margin">
                                <div class="right-msg-area">
                                    <span class="date-time right-time right-message-time">
                                            <span class="send-msg">&#10004;</span>'.$msg_time.'
                                    </span><!--date-time end-->
                                    <div class="right-files">
                                        <a href="assets/img/'.$message.'" class="all-files" target="_blank"><i class="far fa-file-pdf files-common pdf"></i>'.$message.'</a>
                                    </div><!--right-msg end-->
                                </div><!-- right-msg-area end-->
                            </div><!-- right-messages end-->';
                    }else if($msg_type == "emoji"){
                        echo '<div class="right-messages common-margin">
                                <div class="right-msg-area">
                                    <span class="date-time right-time right-message-time">
                                            <span class="send-msg">&#10004;</span>'.$msg_time.'
                                    </span><!--date-time end-->
                                    <div class="right-files">
                                        <img src="'.$message.'" class="animated-emoji">
                                    </div><!--right-msg end-->
                                </div><!-- right-msg-area end-->
                            </div><!-- right-messages end-->';
                    }else if($msg_type == "docx"){
                        echo '<div class="right-messages common-margin">
                                <div class="right-msg-area">
                                    <span class="date-time right-time right-message-time">
                                            <span class="send-msg">&#10004;</span>'.$msg_time.'
                                    </span><!--date-time end-->
                                    <div class="right-files">
                                        <a href="assets/img/'.$message.'" class="all-files"><i class="far fa-file-word files-common word"></i>'.$message.'</a>
                                    </div><!--right-msg end-->
                                </div><!-- right-msg-area end-->
                            </div><!-- right-messages end-->';
                    }else if($msg_type == "xlsx"){
                        echo '<div class="right-messages common-margin">
                                <div class="right-msg-area">
                                    <span class="date-time right-time right-message-time">
                                            <span class="send-msg">&#10004;</span>'.$msg_time.'
                                    </span><!--date-time end-->
                                    <div class="right-files">
                                        <a href="assets/img/'.$message.'" class="all-files"><i class="far fa-file-excel files-common excel"></i>'.$message.'</a>
                                    </div><!--right-msg end-->
                                </div><!-- right-msg-area end-->
                            </div><!-- right-messages end-->';
                    }
                }else {
                    //Left user's message
                    if($msg_type == "text"){
                        echo  '<div class="left-message common-margin">
                                    <div class="sender-img-block">
                                        <img src="assets/img/'.$user_image.'" alt="jeff" class="sender-img">
                                        '.$user_online_status.'
                                    </div><!-- sender-img-block end-->
                                    <div class="left-msg-area">
                                        <div class="user-name-date">
                                            <span class="sender-name">
                                                '.$full_name.'
                                            </span><!--sender-name end-->
                                            <span class="date-time">
                                                <span class="send-msg">&#10004;</span>'.$msg_time.'
                                            </span><!--date-time end-->
                                        </div><!-- user-name-date end-->
                                        <div class="left-msg">
                                            <p>'.$message.'</p>
                                        </div><!-- left-msg end-->
                                    </div><!-- left-msg-area end-->
                                </div><!-- left-message end-->';
                    }else if($msg_type == "jpg" || $msg_type == "JPG" || $msg_type == "jpeg" || $msg_type == "gif"){
                        echo  '<div class="left-message common-margin">
                                    <div class="sender-img-block">
                                        <img src="assets/img/'.$user_image.'" alt="jeff" class="sender-img">
                                        '.$user_online_status.'
                                    </div><!-- sender-img-block end-->
                                    <div class="left-msg-area">
                                        <div class="user-name-date">
                                            <span class="sender-name">
                                                '.$full_name.'
                                            </span><!--sender-name end-->
                                            <span class="date-time">
                                                <span class="send-msg">&#10004;</span>'.$msg_time.'
                                            </span><!--date-time end-->
                                        </div><!-- user-name-date end-->
                                        <div class="left-files">
                                            <img src="assets/img/' . $message . '" class="common-images">
                                        </div><!-- left-msg end-->
                                    </div><!-- left-msg-area end-->
                                </div><!-- left-message end-->';
                    }else if($msg_type == "png" || $msg_type == "PNG"){
                        echo  '<div class="left-message common-margin">
                                    <div class="sender-img-block">
                                        <img src="assets/img/'.$user_image.'" alt="jeff" class="sender-img">
                                        '.$user_online_status.'
                                    </div><!-- sender-img-block end-->
                                    <div class="left-msg-area">
                                        <div class="user-name-date">
                                            <span class="sender-name">
                                                '.$full_name.'
                                            </span><!--sender-name end-->
                                            <span class="date-time">
                                                <span class="send-msg">&#10004;</span>'.$msg_time.'
                                            </span><!--date-time end-->
                                        </div><!-- user-name-date end-->
                                        <div class="left-files">
                                            <img src="assets/img/' . $message . '" class="common-images">
                                        </div><!-- left-msg end-->
                                    </div><!-- left-msg-area end-->
                                </div><!-- left-message end-->';
                    }else if($msg_type == "zip" || $msg_type == "ZIP"){
                        echo  '<div class="left-message common-margin">
                                    <div class="sender-img-block">
                                        <img src="assets/img/'.$user_image.'" alt="jeff" class="sender-img">
                                        '.$user_online_status.'
                                    </div><!-- sender-img-block end-->
                                    <div class="left-msg-area">
                                        <div class="user-name-date">
                                            <span class="sender-name">
                                                '.$full_name.'
                                            </span><!--sender-name end-->
                                            <span class="date-time">
                                                <span class="send-msg">&#10004;</span>'.$msg_time.'
                                            </span><!--date-time end-->
                                        </div><!-- user-name-date end-->
                                        <div class="left-files">
                                            <a href="assets/img/'.$message.'" class="all-files"><i class="fas fa-arrow-circle-down files-common zip"></i>'.$message.'</a>
                                        </div><!-- left-msg end-->
                                    </div><!-- left-msg-area end-->
                                </div><!-- left-message end-->';
                    }else if($msg_type == "PDF" || $msg_type == "pdf"){
                        echo  '<div class="left-message common-margin">
                                    <div class="sender-img-block">
                                        <img src="assets/img/'.$user_image.'" alt="jeff" class="sender-img">
                                        '.$user_online_status.'
                                    </div><!-- sender-img-block end-->
                                    <div class="left-msg-area">
                                        <div class="user-name-date">
                                            <span class="sender-name">
                                                '.$full_name.'
                                            </span><!--sender-name end-->
                                            <span class="date-time">
                                                <span class="send-msg">&#10004;</span>'.$msg_time.'
                                            </span><!--date-time end-->
                                        </div><!-- user-name-date end-->
                                        <div class="left-files">
                                            <a href="assets/img/'.$message.'" class="all-files"target="_blank"><i class="far fa-file-pdf files-common pdf"></i>'.$message.'</a>
                                        </div><!-- left-msg end-->
                                    </div><!-- left-msg-area end-->
                                </div><!-- left-message end-->';
                    }else if($msg_type == "emoji"){
                        echo  '<div class="left-message common-margin">
                                    <div class="sender-img-block">
                                        <img src="assets/img/'.$user_image.'" alt="jeff" class="sender-img">
                                        '.$user_online_status.'
                                    </div><!-- sender-img-block end-->
                                    <div class="left-msg-area">
                                        <div class="user-name-date">
                                            <span class="sender-name">
                                                '.$full_name.'
                                            </span><!--sender-name end-->
                                            <span class="date-time">
                                                <span class="send-msg">&#10004;</span>'.$msg_time.'
                                            </span><!--date-time end-->
                                        </div><!-- user-name-date end-->
                                        <div class="left-files">
                                            <img src="'.$message.'" class="animated-emoji">
                                        </div><!-- left-msg end-->
                                    </div><!-- left-msg-area end-->
                                </div><!-- left-message end-->';
                    }else if($msg_type == "docx"){
                         echo  '<div class="left-message common-margin">
                                    <div class="sender-img-block">
                                        <img src="assets/img/'.$user_image.'" alt="jeff" class="sender-img">
                                        '.$user_online_status.'
                                    </div><!-- sender-img-block end-->
                                    <div class="left-msg-area">
                                        <div class="user-name-date">
                                            <span class="sender-name">
                                                '.$full_name.'
                                            </span><!--sender-name end-->
                                            <span class="date-time">
                                                <span class="send-msg">&#10004;</span>'.$msg_time.'
                                            </span><!--date-time end-->
                                        </div><!-- user-name-date end-->
                                        <div class="left-files">
                                            <a href="assets/img/'.$message.'" class="all-files"><i class="far fa-file-word files-common word"></i>'.$message.'</a>
                                        </div><!-- left-msg end-->
                                    </div><!-- left-msg-area end-->
                                </div><!-- left-message end-->';
                    }else if($msg_type == "xlsx"){
                         echo  '<div class="left-message common-margin">
                                    <div class="sender-img-block">
                                        <img src="assets/img/'.$user_image.'" alt="jeff" class="sender-img">
                                        '.$user_online_status.'
                                    </div><!-- sender-img-block end-->
                                    <div class="left-msg-area">
                                        <div class="user-name-date">
                                            <span class="sender-name">
                                                '.$full_name.'
                                            </span><!--sender-name end-->
                                            <span class="date-time">
                                                <span class="send-msg">&#10004;</span>'.$msg_time.'
                                            </span><!--date-time end-->
                                        </div><!-- user-name-date end-->
                                        <div class="left-files">
                                            <a href="assets/img/'.$message.'" class="all-files"><i class="far fa-file-excel files-common excel"></i>'.$message.'</a>
                                        </div><!-- left-msg end-->
                                    </div><!-- left-msg-area end-->
                                </div><!-- left-message end-->';
                    }
                }
            }
        }
        
    }
}

?>