        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">CMS Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <?php header("./functions.php"); ?>
                <li ><a><div class="light"></div> Online Users: <span class='userOnline'></span></a></li>
                <li ><a href='../'>HOME SITE</a></li>
                <li class="dropdown">
                    
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img class='rounded' width='20' src="../images/users/<?php echo $_SESSION[
                        "user_image"
                    ]
                        ? $_SESSION["user_image"]
                        : "default.png"; ?>" alt="<?php echo $_SESSION[
    "user_name"
]; ?>"> <?php echo $_SESSION["user_name"]; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                <?php $current_link = basename($_SERVER["PHP_SELF"]); ?>
                    <li class='<?php echo $isActive =
                        $current_link === "index.php" ? "active" : ""; ?>'>
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class='<?php echo $isActive =
                        $current_link === "categories.php" ? "active" : ""; ?>'>
                        <a href="categories.php"><i class="fa fa-fw fa-desktop"></i> Categories</a>
                    </li>
                    <li class='<?php echo $isActive =
                        $current_link === "posts.php" ? "active" : ""; ?>'>
                        <?php if(isAdmin()){?>
                        <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="posts_dropdown" class="collapse">
                            <li>
                                <a href="posts.php">View All Posts</a>
                            </li>
                            <li>
                                <a href="posts.php?source=add_post">Add A Post</a>
                            </li>
                        </ul>
                        <?php }else{?>
                        <a href="posts.php"><i class="fa fa-fw fa-photo"></i> Posts</a>
                        <?php }?>
                    </li>
                    <li class='<?php echo $isActive =
                        $current_link === "comments.php" ? "active" : ""; ?>'>
                        <a href="comments.php"><i class="fa fa-fw fa-file"></i> Comments</a>
                    </li>
                    <li class='<?php echo $isActive =
                        $current_link === "users.php" ? "active" : ""; ?>'>
                        <?php if(isAdmin()){?>
                        <a href="javascript:;" data-toggle="collapse" data-target="#users_dropdown"><i class="fa fa-fw fa-arrows-v"></i>Users<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="users_dropdown" class="collapse">
                            <li>
                                <a href="users.php">View All Users</a>
                            </li>
                            <li>
                                <a href="users.php?source=add_user">Add User</a>
                            </li>
                        </ul>
                        <?php }else{?>
                        <a href="users.php"><i class="fa fa-fw fa-book"></i> Users</a>
                        <?php }?>
                    </li>
                    <li class='<?php echo $isActive =
                        $current_link === "profile.php" ? "active" : ""; ?>'>
                        <a href="profile.php"><i class="fa fa-fw fa-dashboard"></i> Profile</a>
                        
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>