<!-- header -->
<?php include "./includes/admin_header.php"; ?>
<?php if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $query = "SELECT * FROM users WHERE user_id=$user_id";
    $user_query = mysqli_query($connection, $query);
    check_error($user_query);
    while ($row = mysqli_fetch_assoc($user_query)) {
        $db_user_name = $row["user_name"];
        $db_user_firstname = $row["user_firstname"];
        $db_user_lastname = $row["user_lastname"];
        $db_user_password = $row["user_password"];
        $db_user_email = $row["user_email"];
        $db_user_image = $row["user_image"];
    }
    if (isset($_POST["edit_profile"])) {
        $user_name = escape($_POST["username"]);
        $user_firstname = escape($_POST["firstname"]);
        $user_lastname = escape($_POST["lastname"]);
        $user_password = escape($_POST["password"]);
        $user_email = escape($_POST["email"]);
        $user_image = escape($_FILES['image']['name']);
        $user_image_temp = $_FILES['image']['tmp_name'];
        if (empty($user_image)) {
            $user_image = $db_user_image;
        } else {
            $previous_image = mysqli_fetch_assoc($image_query)['user_image'];
            $filePath = '../images/users' . '/' . $previous_image;
            if (file_exists($filePath)) {
            if (unlink($filePath)) {
            } elseif (!unlink($filePath)) {
                echo 'Failed to delete the file.';
            }
            } else {
            echo 'File not found.';
            }
            move_uploaded_file($user_image_temp, "../images/users/$user_image");
        }
        if ($user_name && $user_firstname && $user_lastname && $user_password && $user_email && $user_image) {
            $user_password = password_hash($user_password, PASSWORD_BCRYPT, [
                "cost" => 12,
            ]);
            $user_query = "UPDATE users SET ";
            $user_query .= "user_name='$user_name', ";
            $user_query .= "user_password='$user_password', ";
            $user_query .= "user_firstname='$user_firstname', ";
            $user_query .= "user_lastname='$user_lastname', ";
            $user_query .= "user_email='$user_email', ";
            $user_query .= "user_image='$user_image' ";
            $user_query .= "WHERE user_id=$user_id";
            $create_user_query = mysqli_query($connection, $user_query);
            check_error($create_user_query);
            header("Location: index.php");
        } else {
            echo "<p class='text-danger'>Please fill out all fields.</p>";
        }
    }
} ?>
    <div id="wrapper">

        <!-- Navigation -->
        <?php include "./includes/admin_navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Your profile
                            <small><?php echo $_SESSION[
                                "user_firstname"
                            ]; ?></small>
                        </h1>
                        <form action="" method="post" enctype="multipart/form-data">    
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input value="<?php echo $db_user_name; ?>" class="form-control" type="text" id="username" name="username">
                            </div>

                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input  type="text" id="firstname" class="form-control" name="firstname" value="<?php echo $db_user_firstname; ?>">
                            </div>

                            <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input  type="text" id="lastname" class="form-control" name="lastname" value="<?php echo $db_user_lastname; ?>">
                            </div>

                            <div class="form-group">
                            <label for="password">Password</label>
                            <input  type="password" id="password" class="form-control" name="password" autocomplete="off" >
                            </div>
                            <div class="form-group">
                            <label for="email">Email</label>
                            <input  type="email" id="email" class="form-control" name="email" value="<?php echo $db_user_email; ?>">
                            </div>

                            <div class="form-group">
                                <label for="image">Image</label>
                                </br>
                                <?php if ($db_user_image) { ?>
                                    <img width="100" src="../images/users/<?php echo $db_user_image; ?>" alt="<?php echo $db_user_name; ?>">
                                    </br>
                                    </br>
                                <?php } ?>

                                <input type="file"  name="image" id="image" >
                            </div>

                            <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="edit_profile" value="Edit Profile">
                            <a class="btn btn-default" href='users.php'>Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


    <!-- footer -->
<?php include "./includes/admin_footer.php"; ?>
