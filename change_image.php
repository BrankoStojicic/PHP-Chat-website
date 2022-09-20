<?php include "init.php"; ?>
<?php include "security.php"; ?>
<?php 
    $obj = new base_class;
    if(isset($_POST['change_img'])){
        $img_name = $_FILES['change_img']['name'];
        $img_tmp = $_FILES['change_img']['tmp_name'];
        $img_path = "assets/img/";
        $extensions = array('jpg', 'jpeg', 'png', 'pdf');
        $img_ext = explode(".", $img_name);
        $img_extension = end($img_ext);
        
        if(empty($img_name)){
            $img_error = "Please Choose The Image";
        }else if(!in_array($img_extension, $extensions)){
            $img_error = "Please Choose Different Image Type";
        }else{
            $user_id = $_SESSION['user_id'];
            move_uploaded_file($img_tmp, "$img_path/$img_name");
            
            if($obj->Normal_Query("UPDATE users SET image = ? WHERE id = ?", [$img_name, $user_id])){
                $obj->Create_Session("update_image", "Your Image Has Been Successfully Updated");
                $obj->Create_Session("user_image", $img_name);
                header("location:index.php");
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
            <?php include 'components/change_image_form.php';?>
        </section><!-- right-sidebar end-->
   </div><!-- chat-container end-->
    
    
    
	<?php include 'components/js.php';?>
</body>
</html>