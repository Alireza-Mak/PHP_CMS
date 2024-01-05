<?php include 'includes/header.php'; ?>
<!-- Navigation -->
<?php include 'includes/navigation.php'; ?>
<!-- Page Content -->
<div class="container">


  <form class="navbar-form navbar-right" action='' method="get" id="language_form">
    <div class="form-group">
      <select class="form-control" name="lang" onchange="changeLanguage()">
        <option value="en" <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] === 'en') {
                              echo 'selected';
                            } ?>><span></span>English</option>
        <option value="fr" <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr') {
                              echo 'selected';
                            } ?>>French</option>
      </select>
    </div>
  </form>

  <section id="registeration">
    <div class="container">
      <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
          <div class="form-wrap">
            <h1><?php echo _REGISTER ?></h1>
            <?php
            is_logged_in_with_redirect('/portfolio/admin');
            $error = ['username' => '', 'password' => '', 'email' => ''];
            if (isset($_POST['submit'])) {
              $username = escape($_POST['username']);
              $password = escape($_POST['password']);
              $email = escape($_POST['email']);

              if (strlen($username) < 2) {
                $error['username'] =
                  'Username should be more than 2 charectar.';
              }
              if (strlen($password) < 2) {
                $error['password'] =
                  'Password should be more than 2 charectar.';
              }
              if (empty($username)) {
                $error['username'] = 'Username can not be empty.';
              }
              if (empty($password)) {
                $error['password'] = 'Password can not be empty.';
              }
              if (empty($email)) {
                $error['email'] = 'Email can not be empty.';
              }
              if (email_exists($email)) {
                $error['email'] = 'This email already exists.';
              }
              if (username_exists($username)) {
                $error['username'] = 'This username already exists.';
              }
              $allEmpty = true;
              foreach ($error as $key => $value) {
                if (!empty($value)) {
                  $allEmpty = false;
                  break;
                }
              }
              if ($allEmpty) {
                register_user($username, $password, $email);
                login_user($username, $password);
              }
            }
            ?>
            <form method="post" >
              <div class="form-group">
                <label for="username" class="sr-only">username</label>
                <input type="text" name="username" id="username" class="form-control" autocomplete="off" placeholder="<?php echo _USERNAME ?>" value="<?php echo isset($username) ? $username : ''; ?>">
                <p class='text-danger'><?php echo $error['username']; ?></p>
              </div>
              <div class="form-group">
                <label for="email" class="sr-only">Email</label>
                <input type="email" name="email" id="email" class="form-control" autocomplete="off" placeholder="<?php echo _EMAIL ?>" value="<?php echo isset($email) ? $email : '' ?>">
                <p class='text-danger'><?php echo $error['email']; ?></p>
              </div>
              <div class="form-group">
                <label for="password" class="sr-only">Password</label>
                <input type="password" name="password" id="password" class="form-control" autocomplete="off" placeholder="<?php echo _PASSWORD ?>">
                <p class='text-danger'><?php echo $error['password']; ?></p>
              </div>

              <input type='submit' name="submit" id="btn-registeration" class="btn btn-success" value="<?php echo _REGISTER ?>">
              <a href='login.php' class="btn btn-primary"><?php echo _LOGIN ?></a>
            </form>
          </div>
        </div> <!-- /.col-xs-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </section>
  <hr>
  <?php include 'includes/footer.php'; ?>

  <script>
    function changeLanguage() {
      $('#language_form').submit();

    }
  </script>