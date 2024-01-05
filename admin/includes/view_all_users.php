<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Username</th>
      <th>Firstname</th>
      <th>Lastname</th>
      <th>Email</th>
      <th>Image</th>
      <th>Role</th>
      <?php if (isAdmin()) { ?>
      <th>Admin</th>
      <th>Suscriber</th>
      <th>Edit</th>
      <th >Delete</th>
      <?php } ?>
    </tr>
  </thead>
  <tbody>
    <?php
    $users_query = "SELECT * FROM users";
    $all_users_result = mysqli_query($connection, $users_query);
    check_error($all_users_result);
    while ($row = mysqli_fetch_assoc($all_users_result)) {
        $user_id = $row["user_id"];
        $user_name = $row["user_name"];
        $user_email = $row["user_email"];
        $user_image = $row["user_image"];
        !$user_image ? ($user_image = "default.png") : null;
        $user_firstname = $row["user_firstname"];
        $user_lastname = $row["user_lastname"];
        $user_role = $row["user_role"];
        delete_modal(
            "users",
            "Are you sure you want to delete $user_name?",
            "$user_id",
            "$user_image"
        );

        echo "<tr><td>$user_id</td>
        <td>$user_name</td>
        <td>$user_firstname</td>
        <td>$user_lastname</td>
        <td>$user_email</td>
        <td><img width='100' src='../images/users/$user_image' alt='$user_firstname'/></td>
        <td>$user_role</td>";
        echo isAdmin()
            ?
        "<td ><a class='text-success' href='users.php?admin=$user_id'><i class='fa fa-gear'></i></a></td>
        <td><a class='text-danger' href='users.php?subscriber=$user_id'><i class='fa fa-user'></i></a></td>
        <td ><a class='text-success' href='users.php?source=edit_user&user_id=$user_id'><i class='fa fa-pencil'></i></a></td>
        <td><a href='' class='text-danger' data-toggle='modal' data-target='#users-$user_id'><i class='fa fa-trash'></i></a></td>
        </tr>" :null;
    }
    if (isAdmin($_SESSION["user_role"])) {
        //DELETE USER
        delete_row("users", "user_id", "users.php");
        // Admin and Subscriber
        status(
            "users",
            "user_role",
            "user_id",
            ["admin", "subscriber"],
            "users.php"
        );
    }
    ?>
  
  </tbody>
</table>

