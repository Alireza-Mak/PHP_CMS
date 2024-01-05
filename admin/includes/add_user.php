<?php
if (isAdmin()){
 if (isset($_POST["create_user"])) {
    if (
        !empty($_POST["username"]) &&
        !empty($_POST["firstname"]) &&
        !empty($_POST["lastname"]) &&
        !empty($_POST["password"]) &&
        !empty($_POST["email"]) &&
        !empty($_POST["role"]) &&
        !empty($_FILES["image"]["name"])
    ) {
        $user_name = escape($_POST["username"]);
        $user_firstname = escape($_POST["firstname"]);
        $user_lastname = escape($_POST["lastname"]);
        $user_password = escape($_POST["password"]);
        $user_password = password_hash($user_password, PASSWORD_BCRYPT, [
            "cost" => 12,
        ]);
        $user_email = escape($_POST["email"]);
        $user_role = escape($_POST["role"]);
        $user_image = escape($_FILES["image"]["name"]);
        $user_image_temp = $_FILES["image"]["tmp_name"];
        move_uploaded_file($user_image_temp, "../images/users/$user_image");
        $post_query =
            "INSERT INTO users(user_name, user_password, user_firstname, user_lastname, user_email, user_image, user_role) ";
        $post_query .= "VALUES('$user_name','$user_password','$user_firstname','$user_lastname', '$user_email', '$user_image', '$user_role' )";
        $create_post_query = mysqli_query($connection, $post_query);
        check_error($create_post_query);
        echo "<p class='bg-success'>User Created. <a href='users.php'>View Users.</a></p>";
    } else {
        echo "<p class='text-danger'>Please fill out all fields.</p>";
    }
} ?>


<form action="" method="post" enctype="multipart/form-data">    
      <div class="form-group">
         <label for="username">Username</label>
         <input class="form-control" type="text" id="username" name="username">
      </div>

      <div class="form-group">
         <label for="firstname">First Name</label>
         <input  type="text" id="firstname" class="form-control" name="firstname">
      </div>

      <div class="form-group">
         <label for="lastname">Last Name</label>
         <input  type="text" id="lastname" class="form-control" name="lastname">
      </div>

      <div class="form-group">
         <label for="password">Password</label>
         <input  type="password" id="password" class="form-control" name="password">
      </div>
      
      <div class="form-group">
         <label for="email">Email</label>
         <input  type="email" id="email" class="form-control" name="email">
      </div>
      
      <div class="form-group">
         <label for="image">Image</label>
         <input type="file"  name="image" id="image" >
      </div>
      
      <div class="form-group"> 
         <label for="role">Role</label>
         <select class="form-control" name="role" id="role">
            <option value=''>Select Options</option>
            <option value='Admin'>Admin</option>
            <option value='Subscriber'>Subscriber</option>
         </select>
      </div>

      <div class="form-group">
         <input class="btn btn-primary" type="submit" name="create_user" value="Submit">
         <a class="btn btn-default" href='users.php'>Cancel</a>
      </div>


</form>
<?php }?>