<!--ADD IF PASSWORDS ARE THE SAME ERROR MESSAGE!!!-->



<?php include "init.php"; ?>
<?php include "security.php"; ?>
<?php
    $obj = new base_class;
    if(isset($_POST['change_password'])){
        $current_password = $obj->security($_POST['current_password']);
        $new_password = $obj->security($_POST['new_password']);
        $retype_password = $obj->security($_POST['retype_password']);
        
        
        $current_status = $new_status = $retype_status = 1;
        
        if(empty($current_password)){
            $current_password_error = "Current Password Required";
            $current_status = "";
        }
        if(empty($new_password)){
            $new_password_error = "New Password Required";
            $new_status = "";
        }else if(strlen($new_password) < 5){
            $new_password_error = "New Password Is Too Short Minimum Length is 5 Characters";
            $new_status = "";
        }
        if(empty($retype_password)){
            $retype_error = "New Password Retype Required";
            $retype_status = "";
        }else if($new_password != $retype_password){
            $new_password_error = "New Password's Do Not Match";
            $new_status = "";
        }
        
        if(!empty($current_status) && !empty($new_status) && !empty($retype_status)){
            $user_id = $_SESSION['user_id'];
            if($obj->Normal_Query("SELECT password FROM users WHERE id=?", [$user_id])){
                $row = $obj->Single_Result();
                $db_password = $row->password;
                if(password_verify($current_password, $db_password)){
                    if($obj->Normal_Query("UPDATE users SET password = ? WHERE id = ?", [password_hash($new_password, PASSWORD_DEFAULT), $user_id])){
                        $obj->Create_Session("password_updated", "Your Password Has Been Updated");
                        header("location:index.php");
                    }
                }else{
                    $current_password_error = "Please Enter The Correct Password";
                }
            }
        }
        
    }


?>
<!DOCTYPEhtml>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=nos">
	<title>Home</title>
	<?php include 'components/css.php';?>
</head>
<body>
    <?php include 'components/nav.php';?>
    <div class="chat-container">
        <?php include 'components/sidebar.php';?>
        <section id="right-sidebar">
            <?php include 'components/change_password_form.php';?>
        </section><!-- right-sidebar end-->
   </div><!-- chat-container end-->
    
    
    
	<?php include 'components/js.php';?>
</body>
</html>