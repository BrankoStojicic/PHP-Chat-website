<?php include "init.php"; ?>

<?php 
    $obj = new base_class;
    if(isset($_POST['login'])){
        $email = $obj->security($_POST['email']);
        $password = $obj->security($_POST['password']);
        $email_status = $password_status = 1; 
        if(empty($email)){
            $email_error = "Email is required";
            $email_status = "";
        }
        if(empty($password)){
            $password_error = "Password is required";
            $password_status = "";
        }
        
        if(!empty($email_status)&&!empty($password_status)){
            if($obj->Normal_Query("SELECT * FROM users WHERE email=?", [$email])){
                if($obj->Count_Rows() == 0){
                    $email_error = "Please enter the correct email";
                }else{
                    $row = $obj->Single_Result();
                    $db_email = $row->email;
                    $db_password = $row->password;
                    $user_id = $row->id;
                    $user_name = $row->name;
                    $user_image = $row->image;
                    $clean_status = $row->clean_status;
                    
//                    if user loges in
                    if(password_verify($password, $db_password)){
                        //add status 1 so that is known that he is logged in. IT IS KNOWN!!!
                        $status = 1;
                        $obj->Normal_Query("UPDATE users SET status = ? WHERE id = ?", [$status, $user_id]);
                        if($clean_status == 0){
                            //This shaite will select last message
                            if($obj->Normal_Query("SELECT id FROM messages ORDER BY id DESC LIMIT 1")){
                                //This will fetch last message as an object, and now last_row is object with id of an message
                                $last_row = $obj->Single_Result();
                                $last_msg_id = $last_row->id + 1;
                                //This whole thing is there to show the messages from the point of updated clean status, aka point where user first logged in. Clean status is a bookmark for messages starting point
                                if($obj->Normal_Query("INSERT INTO clean(clean_message_id, clean_user_id) VALUES (?,?)", [$last_msg_id, $user_id])){
                                    $update_clean_status = 1;
                                    $obj->Normal_Query("UPDATE users SET clean_status = ? WHERE id = ?",[$update_clean_status, $user_id]); 
                                    
                                    $login_time = time();
                                    if($obj->Normal_Query("SELECT * FROM users_activities WHERE user_id = ?", [$user_id])){
                                        $activity_row = $obj->Single_Result();
                                        if($activity_row == 0){
                                            $obj->Normal_Query("INSERT INTO users_activities(user_id, login_time) VALUES (?,?)", [$user_id, $login_time]);
                                            $obj->Create_Session("user_name", $user_name);
                                            $obj->Create_Session("user_id", $user_id);
                                            $obj->Create_Session("user_image", $user_image);
                                            $obj->Create_Session("loader", "1");
                                            header('location:index.php');
                                        }else{
                                            $obj->Normal_Query("UPDATE users_activities SET login_time = ? WHERE user_id = ?", [$login_time, $user_id]);
                                            $obj->Create_Session("user_name", $user_name);
                                            $obj->Create_Session("user_id", $user_id);
                                            $obj->Create_Session("user_image", $user_image);
                                            $obj->Create_Session("loader", "1");
                                            header('location:index.php');
                                        }
                                    }
                                    
                                    
                                    
                                }
                            }
                            
                        }else{
                            $login_time = time();
                                    if($obj->Normal_Query("SELECT * FROM users_activities WHERE user_id = ?", [$user_id])){
                                        $activity_row = $obj->Single_Result();
                                        if($activity_row == 0){
                                            $obj->Normal_Query("INSERT INTO users_activities(user_id, login_time) VALUES (?,?)", [$user_id, $login_time]);
                                            $obj->Create_Session("user_name", $user_name);
                                            $obj->Create_Session("user_id", $user_id);
                                            $obj->Create_Session("user_image", $user_image);
                                            $obj->Create_Session("loader", "1");
                                            header('location:index.php');
                                        }else{
                                            $obj->Normal_Query("UPDATE users_activities SET login_time = ? WHERE user_id = ?", [$login_time, $user_id]);
                                            $obj->Create_Session("user_name", $user_name);
                                            $obj->Create_Session("user_id", $user_id);
                                            $obj->Create_Session("user_image", $user_image);
                                            $obj->Create_Session("loader", "1");
                                            header('location:index.php');
                                        }
                                    } 
                        }
                        
                        
                        
                        
                        
                        
                    }else{
                        $password_error = "Password Incorect";
                    }
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
	<title>Create New Account</title>
	<?php include 'components/css.php';?>
</head>
<body>
<!--    Need To Be Logged In Message -->
    <?php if(isset($_SESSION['security'])): ?>
    
        <div class="flash error-flash">
          <span class="remove">&times;</span>
           <div class="flash-heading">
               <h3>Hey!!!!!!!</h3>
           </div>
           <div class="flash-body">
               <p><?php echo $_SESSION['security']; ?></p>
           </div>
        </div>
    
    <?php endif; ?>
    <?php unset($_SESSION['security']); ?>

<!--    Signup  -->
	<div class="signup-container">
		<div class="account-left">
			<div class="account-text">
			    <h1>Lets Talk</h1>
			    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque sed, amet iusto velit nesciunt.</p>
			</div><!-- account-text end -->
		</div><!-- account-left end -->
		
		<div class="account-right">
			<?php include 'components/login_form.php';?>
		</div><!-- account-right end -->
		
	</div><!-- signup-container end -->
	<?php include 'components/js.php';?>
	
</body>
</html>