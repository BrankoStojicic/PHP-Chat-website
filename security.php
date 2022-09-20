<?php if(!isset($_SESSION['user_id'])): ?>
<?php  
    $obj = new base_class;

    $obj->Create_Session("security", "You Need To Be Logged In To View This Incredible Stuff!!")
?>
<?php header("location:login.php"); ?>
<?php endif; ?>