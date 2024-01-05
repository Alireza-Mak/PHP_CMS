<?php include "includes/header.php"; ?>

<?php
$error_fillout = "";
$success = "";
if (isset($_POST["send"])) {
    $subject = escape($_POST["subject"]);
    $message = escape($_POST["message"]);
    $email = escape($_POST["email"]);

    if (!empty($subject) && !empty($message) && !empty($email)) {
        $to = "info@alirezamak.com";
        send_mail_contact($to, $subject, $message, $email);
        $success = "<p class='text-success'>Your message has been sent.</p>";
    } else {
        $error_fillout =
            "<p class='text-danger'>Please fill out all fields.</p>";
    }
}
?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>
<!-- Page Content -->
<div class="container">

    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Constat Us</h1>
                        <form method="post" id="contact-form">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" autocomplete="off" placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject:</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Forget my password">
                            </div>
                            <div class="form-group">
                                <label for="message">Message:</label>
                                <textarea name="message" class="form-control" id="message" rows="3" placeholder="Would you please send ..."></textarea>
                            </div>

                            <input type='submit' name="send" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Send">
                        </form>
                        <?php echo $error_fillout; ?>
                        <?php echo $success; ?>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>