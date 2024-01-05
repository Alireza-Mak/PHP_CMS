<?php
// <!-- Header -->
include "./includes/header.php";
// <!-- Navigation -->
include "./includes/navigation.php";
if (isset($_POST['liked'])) {
    $like_id = $_POST['liked'];
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    $posts_likes_query = "UPDATE posts SET post_likes_count=post_likes_count+1 WHERE post_id=$post_id";
    $posts_likes_result = mysqli_query($connection, $posts_likes_query);
    check_error($posts_likes_result);
    $likes_query = "INSERT INTO likes(post_id,user_id) ";
    $likes_query .= "VALUES ($post_id,$user_id) ";
    $likes_result = mysqli_query($connection, $likes_query);
    check_error($likes_result);
}
if (isset($_POST['disliked'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    $posts_likes_query = "UPDATE posts SET post_likes_count=post_likes_count-1 WHERE post_id=$post_id";
    $posts_likes_result = mysqli_query($connection, $posts_likes_query);
    check_error($posts_likes_result);
    $remove_likes_query = "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id";
    $likes_result = mysqli_query($connection, $remove_likes_query);
    check_error($likes_result);
}


?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <!-- First Blog Post -->
            <?php if (isset($_GET["post_id"])) {
                $post_id = $_GET["post_id"];
                $posts_views_query = "UPDATE posts SET post_views_count=post_views_count+1 WHERE post_id=$post_id";
                $posts_views_result = mysqli_query(
                    $connection,
                    $posts_views_query
                );
                if (!$posts_views_result) {
                    die("Posts Query Failed" . mysqli_error($connection));
                }
                $posts_query = "SELECT * FROM posts WHERE post_id=$post_id";
                $posts_result = mysqli_query($connection, $posts_query);
                if (!$posts_result) {
                    die("Posts Query Failed" . mysqli_error($connection));
                }
                while ($row = mysqli_fetch_assoc($posts_result)) {
                    $post_title = $row["post_title"];
                    $post_author = $row["post_author"];
                    $post_date = $row["post_date"];
                    $post_content = $row["post_content"];
                    $post_image = $row["post_image"];
                    $post_views_count = $row["post_views_count"];
            ?>
                    <h2><?php echo $post_title; ?></h2>
                    <p class="lead">by <a href="/portfolio/author.php?author=<?php echo $post_author; ?>"><?php echo $post_author; ?></a></p>
                    <div class="d-flex">
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?> | <span class="glyphicon glyphicon-eye-open"></span> Views <?php echo $post_views_count; ?> |
                            <span class="glyphicon glyphicon-thumbs-up"></span> Likes <?php echo get_post_likes($post_id); ?>
                        </p>
                        <?php if (is_logged_in()) {
                        ?>
                            <p><a data-toggle='tooltip' data-placement='top' title="<?php echo user_liked_the_post($post_id) ? 'I liked this before!' : 'Want to like it?' ?>" class="text-decoration-none <?php echo user_liked_the_post($post_id) ? 'dislike' : 'like' ?>" href=''>
                                    <span class="glyphicon glyphicon-thumbs-<?php echo user_liked_the_post($post_id) ? 'down' : 'up' ?>"></span> <?php echo user_liked_the_post($post_id) ? 'Dislike' : 'Like' ?>
                                </a></p>
                        <?php } else { ?>
                            <p>please <a class='text-decoration-none' href='/portfolio/login'>login</a> to like it.</p>

                        <?php } ?>
                    </div>
                    <hr>
                    <img class="img-responsive" src="/portfolio/images/posts/<?php echo $post_image; ?>" alt="<?php echo $post_title; ?>">
                    <hr>
                    <p><?php echo $post_content; ?></p>

            <?php
                }
            } else {
                header("Location: index.php");
            } ?>
            <hr>
            <!-- Blog Comments -->

            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <?php
                $errorFillout = "";
                $success = "";
                if (isset($_POST["create_comment"])) {
                    $comment_author = $_POST["comment_author"];
                    $comment_email = $_POST["comment_email"];
                    $comment_content = $_POST["comment_content"];
                    $comment_date = date("y-m-d");
                    $comment_time = date("H:i");
                    $comment_status = "Unapproved";
                    $comment_post_id = $post_id;
                    if (
                        !empty($comment_author) &&
                        !empty($comment_email) &&
                        !empty($comment_content)
                    ) {
                        $query = "INSERT INTO comments ";
                        $query .=
                            "(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date, comment_time) ";
                        $query .= "VALUES ($comment_post_id, '$comment_author', '$comment_email', '$comment_content', '$comment_status', '$comment_date', '$comment_time') ";
                        $result_comment_query = mysqli_query(
                            $connection,
                            $query
                        );
                        if (!$result_comment_query) {
                            die("Comment Query Faield" .
                                mysqli_error($connection));
                        }
                        $success =
                            "<p class='text-success'>Your Comment has been sent.</p>";
                    } else {
                        $errorFillout =
                            "<p class='text-danger'>Please fill out all fields.</p>";
                    }
                }
                ?>
                <form role="form" action='' method='POST'>
                    <div class="form-group">
                        <label for="comment_author">Author</label>
                        <input class="form-control" type="text" id="comment_author" name="comment_author">
                    </div>
                    <div class="form-group">
                        <label for="comment_email">Email</label>
                        <input class="form-control" type="email" id="comment_email" name="comment_email">
                    </div>
                    <div class="form-group">
                        <label for="comment_content">Your Comment</label>
                        <textarea name="comment_content" class="form-control" rows="3" id="comment_content"></textarea>
                    </div>
                    <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                </form>
                <?php echo $errorFillout; ?>
                <?php echo $success; ?>
            </div>

            <hr>

            <!-- Posted Comments -->

            <!-- Comment -->
            <?php
            $query = "SELECT * FROM comments WHERE comment_post_id=$post_id ";
            $query .= "AND comment_status='approved' ";
            $query .= "ORDER BY comment_id DESC";
            $comment_query = mysqli_query($connection, $query);
            if (!$comment_query) {
                die("Comment Query Faield" . mysqli_error($connection));
            }
            $count = mysqli_num_rows($comment_query);
            if (!$count) {
                echo "<div class='media-body'>There is no comment to show.</div>";
            } else {
                while ($row = mysqli_fetch_assoc($comment_query)) {

                    $comment_author = $row["comment_author"];
                    $comment_email = $row["comment_email"];
                    $comment_content = $row["comment_content"];
                    $comment_date = $row["comment_date"];
                    $comment_time = $row["comment_time"];
                    $formatedDate = date(
                        'F d, Y \a\t h:i A',
                        strtotime($comment_date . " " . $comment_time)
                    );
                    $comment_status = $row["comment_status"];
            ?>
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="http://placehold.it/64x64" alt="<?php echo $comment_author; ?>">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $comment_author; ?>
                                <small><?php echo $formatedDate; ?></small>
                            </h4>
                            <?php echo $comment_content; ?>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
        <?php // <!-- sidebar -->

        include "./includes/sidebar.php"; ?>
    </div>
    <!-- /.row -->
    <hr>
    <?php // <!-- Footer -->

    include "./includes/footer.php";
    ?>