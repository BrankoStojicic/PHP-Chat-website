        <section id="sidebar">
            <ul class="left-ul">
                <li><a href="javascript:void(0);"><span class="profile-img-span"><img src="assets/img/<?php echo $_SESSION['user_image'];?>" alt="my_name_jeff" class="profile-img"></span></a></li>
                <li><a href="index.php"><?php echo ucfirst($_SESSION['user_name']); ?><span class="hover-atack"></span></a></li>
                <li><a href="change_name.php">Change Name<span class="hover-atack"></span></a></li>
                <li><a href="change_password.php">Change Password<span class="hover-atack"></span></a></li>
                <li><a href="change_image.php">Change Image<span class="hover-atack"></span></a></li>
                <li><a href="#"><span class="online_users"></span><span class="hover-atack"></span></a></li>
                <li><a href="javascript:void(0);" class="clean">Clean History<span class="hover-atack"></span></a></li>
                <li><a href="logout.php">Logout<span class="hover-atack"></span></a></li>
            </ul>
        </section><!-- sidebar end-->