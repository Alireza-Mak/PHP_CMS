<?php
function check_error($result)
{
  global $connection;
  if (!$result) {
    die('Query FAILED' . mysqli_error($connection));
  }
}

function redirect($location)
{
  header("Location: $location");
  exit();
}

function request_method_exists($method = null)
{
  if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
    return true;
  } else {
    return false;
  }
}

function is_logged_in()
{
  if (isset($_SESSION['user_role'])) {
    return true;
  } else {
    return false;
  }
}

function is_logged_in_with_redirect($location = null)
{
  if (is_logged_in()) {
    redirect($location);
  }
}


function add_category()
{
  global $connection;
  $err_msg_add_cat = '';
  if (isset($_POST['submit'])) {
    $cat_title = escape(strtoupper($_POST['cat_title']));
    if (empty($cat_title)) {
      $err_msg_add_cat = 'This field should not be empty!';
    } else {
      $cats_query = "SELECT * FROM categories WHERE cat_title='$cat_title'";
      $cats_result = mysqli_query($connection, $cats_query);
      check_error($cats_result);
      $count = mysqli_num_rows($cats_result);
      if ($count > 0) {
        $err_msg_add_cat = 'This category has already existed.';
      } else {
        $err_msg_add_cat = '';
        $cat_query = 'INSERT INTO categories (cat_title) ';
        $cat_query .= "VALUE ('{$cat_title}')";
        $create_category_result = mysqli_query($connection, $cat_query);
        check_error($create_category_result);
      }
    }
  }
  return $err_msg_add_cat;
}

function edit_category()
{
  global $connection;
  $err_msg_edit_cat = '';
  if ($_GET['edit']) {
    $cat_id = escape($_GET['edit']);
    $edit_cat_query = 'SELECT * FROM categories WHERE ';
    $edit_cat_query .= "cat_id = {$cat_id}";
    $edit_cat_result = mysqli_query($connection, $edit_cat_query);
    check_error($edit_cat_result);
    $row = mysqli_fetch_assoc($edit_cat_result);
    $edit_title = $row['cat_title'];
    if (isset($_POST['edit_cat'])) {
      $cat_title = escape(strtoupper($_POST['edited_cat_title']));
      if (empty($cat_title)) {
        $err_msg_edit_cat = 'This field should not be empty!';
      } else {
        $cats_query = "SELECT * FROM categories WHERE cat_title='$cat_title'";
        $cats_result = mysqli_query($connection, $cats_query);
        check_error($cats_result);
        $count = mysqli_num_rows($cats_result);
        if ($count > 0) {
          $err_msg_edit_cat = 'This category has already existed.';
        } else {
          $err_msg_edit_cat = '';
          $cat_query = "UPDATE categories SET cat_title ='{$cat_title}' ";
          $cat_query .= "WHERE cat_id={$cat_id}";
          $create_category_result = mysqli_query($connection, $cat_query);
          if (!$create_category_result) {
            die('Create Category Query Failed!' . mysqli_error($connection));
          }
          header('Location: categories.php');
        }
      }
    }
  } else {
    header('Location: categories.php');
  }
  return [$err_msg_edit_cat, $edit_title];
}

function delete_row($table, $column_id, $location)
{
  global $connection;
  if (isset($_GET['delete'])) {
    $id = escape($_GET['delete']);
    $image = escape($_GET['image_name']);
    if ($image) {
      $filePath = "../images/$table/$image";
      if (file_exists($filePath)) {
        if (unlink($filePath)) {
        } elseif (!unlink($filePath)) {
          echo 'Failed to delete the file.';
        }
      } else {
        echo 'File not found.';
      }
    }
    $delete_query = "DELETE FROM $table WHERE ";
    $delete_query .= "$column_id=$id";
    $delete_result = mysqli_query($connection, $delete_query);
    check_error($delete_result);
    header("Location: $location");
  }
}
function reset_column($table, $column_id, $column_to_reset, $location)
{
  global $connection;
  if (isset($_GET['reset'])) {
    $id = escape($_GET['reset']);
    $query = "UPDATE $table SET $column_to_reset = 0 WHERE $column_id=$id";
    $update_view_result = mysqli_query($connection, $query);
    check_error($update_view_result);
    header("Location: $location");
  }
}

function find_all_rows_conditionable($table_name, $db_column, $column)
{
  global $connection;
  $query = "SELECT * FROM $table_name WHERE $db_column='$column'";
  $result = mysqli_query($connection, $query);
  check_error($result);
  return $result;
}
function find_all_rows($table)
{
  global $connection;
  $query = "SELECT * FROM $table";
  $result = mysqli_query($connection, $query);
  check_error($result);
  return $result;
}

function users_online()
{
  if (isset($_GET['onlineuser'])) {
    global $connection;
    if (!$connection) {
      session_start();
      include '../includes/db.php';

      $session = session_id();
      $time = time();
      $set_time_out_in_second = 05;
      $time_out = $time - $set_time_out_in_second;
      $query = "SELECT * FROM users_online WHERE user_online_session = '$session'";
      $send_query = mysqli_query($connection, $query);
      $count = mysqli_num_rows($send_query);
      if ($count == null) {
        mysqli_query(
          $connection,
          "INSERT INTO users_online(user_online_session,user_online_time) VALUES('$session','$time')"
        );
      } else {
        mysqli_query(
          $connection,
          "UPDATE users_online SET user_online_time='$time' WHERE user_online_session='$session'"
        );
      }

      $users_online_query = mysqli_query(
        $connection,
        "SELECT * FROM users_online WHERE user_online_time > $time_out"
      );
      $count_user = mysqli_num_rows($users_online_query);
      echo $count_user;
    }
  }
}
users_online();

function escape($value)
{
  global $connection;
  $data = mysqli_real_escape_string($connection, trim(strip_tags($value)));
  return $data;
}

function delete_modal($table, $message, $id, $image_name)
{
  echo "<div class='modal fade' id='$table-$id' tabindex='-1' role='dialog' aria-labelledby='$table-label'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title' id='$table-label'>Modal title</h4>
      </div>
      <div class='modal-body'>
        $message
      </div>
      <div class='modal-footer'>
        <a href='$table.php?delete=$id&image_name=$image_name' class='btn btn-danger'>Delete</a>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
      </div>
    </div>
  </div>
</div>";
}

function table_num_rows($table_name)
{
  global $connection;
  $query = "SELECT * FROM $table_name";
  $result = mysqli_query($connection, $query);
  check_error($result);
  $count = mysqli_num_rows($result);
  return $count;
}

function table_num_rows_conditionable(
  $table_name,
  $db_status_value,
  $status_value
) {
  global $connection;
  $query = "SELECT * FROM $table_name WHERE $db_status_value='$status_value'";
  $result = mysqli_query($connection, $query);
  check_error($result);
  $count = mysqli_num_rows($result);
  return $count;
}

function format_text($text, $character_limitation)
{
  if (strlen($text) <= $character_limitation) {
    return $text;
  } else {
    return substr($text, 0, $character_limitation) . ' ...';
  }
}

function format_date($date, $time)
{
  return date('F d, Y \a\t h:i A', strtotime($date . ' ' . $time));
}

function isAdmin()
{
  if ($_SESSION['user_role'] && $_SESSION['user_role'] === 'Admin') {
    return true;
  } else {
    return false;
  }
}

function status($table, $column_status, $column_id, $inputs, $location)
{
  function query($status, $id, $table, $column_status, $column_id)
  {
    global $connection;
    $status = mysqli_real_escape_string($connection, $status);
    $query = "UPDATE $table SET $column_status = '$status' WHERE $column_id = '$id'";
    $update_user_query = mysqli_query($connection, $query);
    check_error($update_user_query);
  }
  for ($i = 0; $i < count($inputs); $i++) {
    $input = $inputs[$i];
    if (isset($_GET[$input])) {
      $id = escape($_GET[$input]);
      switch ($input) {
        case 'admin':
          query('Admin', $id, $table, $column_status, $column_id);
          break;
        case 'subscriber':
          query('Subscriber', $id, $table, $column_status, $column_id);
          break;
        case 'approved':
          query('Approved', $id, $table, $column_status, $column_id);
          break;
        case 'unapproved':
          query('Unapproved', $id, $table, $column_status, $column_id);
          break;
      }
      header("Location: $location");
    }
  }
}

function username_exists($username)
{
  $count = table_num_rows_conditionable('users', 'user_name', $username);
  if ($count > 0) {
    return true;
  } else {
    return false;
  }
}

function email_exists($email)
{
  $count = table_num_rows_conditionable('users', 'user_email', $email);
  if ($count > 0) {
    return true;
  } else {
    return false;
  }
}

function register_user($username, $password, $email)
{
  global $connection;
  $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
  $query =
    'INSERT INTO users (user_name, user_password, user_email, user_role) ';
  $query .= "VALUES ('$username', '$password','$email','Subscriber') ";
  $result = mysqli_query($connection, $query);
  check_error($result);
}

function login_user($user_name, $user_password)
{
  $select_user_query = find_all_rows_conditionable(
    'users',
    'user_name',
    $user_name
  );
  while ($row = mysqli_fetch_assoc($select_user_query)) {
    $db_user_id = $row['user_id'];
    $db_user_name = $row['user_name'];
    $db_user_password = $row['user_password'];
    $db_user_firstname = $row['user_firstname'];
    $db_user_lastname = $row['user_lastname'];
    $db_user_role = $row['user_role'];
    $db_user_image = $row['user_image'];
  }
  if (
    !empty($db_user_password) &&
    password_verify($user_password, $db_user_password)
  ) {
    $_SESSION['user_id'] = $db_user_id;
    $_SESSION['user_name'] = $db_user_name;
    $_SESSION['user_firstname'] = $db_user_firstname;
    $_SESSION['user_lastname'] = $db_user_lastname;
    $_SESSION['user_role'] = $db_user_role;
    $_SESSION['user_image'] = $db_user_image;
    redirect('admin');
    return true;
  } else {
    return false;
  }
}

function send_mail_contact($to, $subject, $message, $email)
{
  $email = "From: <$email>";
  mail($to, $subject, $message, $email);
}

function send_mail_forgot_password($email, $token)
{
  $resetLink = "https://alirezamak.com/portfolio/reset.php?email=$email&token=$token";
  $subject = "Reset Password";
  $message =
    "<html>
      <head>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM' crossorigin='anonymous'>
      </head>
      <body>
        <div class='d-flex justify-content-between align-items-center'>
          <img class='img-fluid border p-2 rounded' width='50' src='http://alirezamak.com/wp-content/uploads/Fav-Icon-1.png' alt='alirez-amak'>
          <h2 class='fw-bold'>Alireza Mak</h2>
        </div>
        <p class='text-secondary'>To reset password please: <a class='text-primary text-decoration-none' href='$resetLink'>click here.</a></p>
      </body>
    </html>";
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
  $headers .= "From: Alireza Mak <info@alirezamak.com>" . "\r\n";
  $headers .= "Reply-To: alirezamak.com" . "\r\n";
  mail($email, $subject, $message, $headers);
}

function user_liked_the_post($post_id)
{
  global $connection;
  $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false;
  $query = "SELECT * FROM likes WHERE user_id=$user_id AND post_id=$post_id";
  $result = mysqli_query($connection, $query);
  check_error($result);
  $count = mysqli_num_rows($result);
  return $count >= 1 ? true : false;
}

function get_post_likes($post_id)
{
  $result = find_all_rows_conditionable('posts', 'post_id', $post_id);
  $row = mysqli_fetch_assoc($result);
  return $row['post_likes_count'];
}
