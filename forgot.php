<?php include 'includes/header.php';
require('./vendor/autoload.php');

$error = ['email' => '', 'exists' => '', 'success' => '',];
if (!isset($_GET['forgot_id'])) {
  redirect('/portfolio/login');
}

if (request_method_exists('post') && isset($_POST['recover-submit'])) {
  $email = escape($_POST['email']);
  if ($email) {
    if (email_exists($email)) {
      $length = 50;
      $token = bin2hex(openssl_random_pseudo_bytes($length));
      $stmt = mysqli_prepare(
        $connection,
        'UPDATE users SET user_token = ? WHERE user_email = ?'
      );
      $stmt->bind_param('ss', $token, $email);
      $stmt->execute();
      mysqli_stmt_close($stmt);
      $example = new Example();
      $error['success'] = $example->display();
      send_mail_forgot_password($email, $token);
    } else {
      $error['exists'] = 'Email does not exist in the database.';
    }
  } else {
    if (empty($email)) {
      $error['email'] = 'Email can not be empty.';
    }
  }
}
?>


<!-- Page Content -->
<div class="container">

  <div class="form-gap"></div>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="text-center">
              <h3><i class="fa fa-lock fa-4x"></i></h3>
              <h2 class="text-center">Forgot Password?</h2>
              <p>You can reset your password here.</p>
              <div class="panel-body">
                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                      <input id="email" name="email" placeholder="email address" class="form-control" type="email">
                    </div>
                  </div>
                  <p class='text-danger text-left'><?php echo $error['email']; ?></p>
                  <div class="form-group">
                    <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                  </div>
                  <p class='text-danger text-left'><?php echo $error['exists']; ?></p>
                  <p class='text-success text-left'><?php echo $error['success']; ?></p>

                  <input type="hidden" class="hide" name="token" id="token" value="">
                </form>

              </div><!-- Body-->

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr>

  <?php include 'includes/footer.php'; ?>

</div> <!-- /.container -->