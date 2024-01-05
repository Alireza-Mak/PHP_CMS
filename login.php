<?php
// <!-- Header -->
include './includes/header.php';
// <!-- Navigation -->
include './includes/navigation.php';
?>
<!-- Page Content -->
<div class="container">

  <div class="row">
    <!-- Blog Entries Column -->
    <div class="col-xs-6 col-xs-offset-3">
      <!-- First Blog Post -->
      <?php
      is_logged_in_with_redirect('/portfolio/admin');
      $error = ['username' => '', 'password' => '', 'invalid' => ''];
      if (isset($_POST['login'])) {
        $user_name = escape($_POST['user_name']);
        $user_password = escape($_POST['user_password']);
        if (empty($user_name)) {
          $error['username'] = 'Username can not be empty.';
        }
        if (empty($user_password)) {
          $error['password'] = 'password can not be empty.';
        }
        if (
          !empty($user_password) &&
          !empty($user_password) &&
          !login_user($user_name, $user_password)
        ) {
          $error['invalid'] =
            'Username or password is wrong,please try again.';
        }
        $allEmpty = true;
        foreach ($error as $key => $value) {
          if (!empty($value)) {
            $allEmpty = false;
            break;
          }
        }
        if ($allEmpty) {
          login_user($user_name, $user_password);
        }
      }
      ?>
      <div class="form-wrap">

        <h1>Login</h1>
        <hr>

        <form method="POST">
          <div class="form-group">
            <label for="user_name">Username</label>
            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter Username" autocomplete="off">
            <p class='text-danger'><?php echo $error['username']; ?></p>
          </div>
          <div class="form-group">
            <label for="user_password">Passwrod</label>
            <input type="password" name="user_password" id="user_password" class="form-control" placeholder="Enter Password" autocomplete="off">
            <p class='text-danger'><?php echo $error['password']; ?></p>
            <a href='/portfolio/forgot/<?php echo uniqid() ?>' class='main'>Forget Password?</a>
          </div>
          <button class="btn btn-success" name="login" type="submit">Login</button>
          <a href='/portfolio/registration.php' class="btn btn-primary">Sign Up</a>
          <p class='text-danger'><?php echo $error['invalid']; ?></p>
        </form>
      </div>
    </div>

  </div>
  <!-- /.row -->
  <hr>
  <?php // <!-- Footer -->

  include './includes/footer.php';
  ?>