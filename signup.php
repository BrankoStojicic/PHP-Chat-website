<?php
include "init.php";
$obj = new base_class;
if(isset($_POST['signup'])){
    $full_name = $obj->security($_POST['full_name']);
    $email = $obj->security($_POST['email']);
    $password = $obj->security($_POST['password']);
    $img_name = $_FILES['img']['name'];
    $img_tmp = $_FILES['img']['tmp_name'];
    $img_path = "assets/img/";
    $extensions = array('jpg', 'jpeg', 'png', 'pdf');
    $img_ext = explode(".", $img_name);
    $img_extension = end($img_ext);
    $name_status = $email_status = $password_status = $photo_status = 1;
    if(empty($full_name)){
        $name_error = "Full name is required!";
        $name_status = "";
    }
    if(empty($email)){
        $email_error = "Email is required";
        $email_status = "";
    }else{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email_error = "Invalid email format";
            $email_status = "";
        }else{
            if($obj->Normal_Query("SELECT email FROM users WHERE email = ?", array($email))){
                if($obj->Count_Rows() == 0){
                    
                }else{
                    $email_error = "Sorry that email already exists";
                    $email_status = "";
                }
            }
        }
    }
    //Password validation
    if(empty($password)){
        $password_error = "Password is required";
        $password_status = "";
    }else if(strlen($password) < 5){
        $password_error = "Password is too short";
        $password_status = "";
    }
//    Image Validation
    if(empty($img_name)){
        $image_error = "Image is required!";
        $photo_status = "";
    }else if(!in_array($img_extension, $extensions)){
        $image_error = "Invalid image extension!";
        $photo_status = "";
    }
    if(!empty($name_status) && !empty($email_status)&& !empty($password_status)&& !empty($photo_status)){
        
        move_uploaded_file($img_tmp, "$img_path/$img_name");
        $status = 0;
        $clean_status = 0;
        if($obj->Normal_Query("INSERT INTO users (name,email,password,image,status,clean_status) VALUES(?,?,?,?,?,?)", array($full_name, $email, password_hash($password, PASSWORD_DEFAULT), $img_name, $status, $clean_status))) {
            $obj->Create_Session("account_success", "Your account has been successfully created!");
            header("location:login.php");
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
	<div class="signup-container">
		<div class="account-left">
			<div class="account-text">
			    <h1>Lets Talk</h1>
			    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque sed, amet iusto velit nesciunt.</p>
			</div><!-- account-text end -->
		</div><!-- account-left end -->
		
		<div class="account-right">
			<?php include 'components/signup_form.php';?>
		</div><!-- account-right end -->
		
	</div><!-- signup-container end -->
	<?php include 'components/js.php';?>
	<script type="text/javascript" src="assets/js/file_label.js"></script>
</body>
</html>