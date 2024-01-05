<?php
// <!-- Header -->
include "./includes/header.php";
// <!-- Navigation -->
include "./includes/navigation.php";
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <!-- First Blog Post -->
            <?php if (isset($_GET["author"])) {
                $post_author = escape($_GET["author"]);
                $posts_query = "SELECT * FROM posts WHERE post_author='$post_author'";
                $posts_result = mysqli_query($connection, $posts_query);
                if (!$posts_result) {
                    die("Posts Query Failed" . mysqli_error($connection));
                }
                while ($row = mysqli_fetch_assoc($posts_result)) {

                    $post_id = $row["post_id"];
                    $post_title = $row["post_title"];
                    $post_author = $row["post_author"];
                    $post_date = $row["post_date"];
                    $post_content = $row["post_content"];
                    $post_image = $row["post_image"];
            ?>
                    <h2><a href="/portfolio/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2>
                    <p class="lead">All posts by <?php echo $post_author; ?></p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                    <hr>
                    <img class="img-responsive" src="/portfolio/images/posts/<?php echo $post_image; ?>" alt="<?php echo $post_title; ?>">
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <hr>
            <?php
                }
            } ?>
        </div>
        <?php // <!-- sidebar -->

        include "./includes/sidebar.php"; ?>
    </div>
    <!-- /.row -->
    <hr>
    <?php // <!-- Footer -->

    include "./includes/footer.php";
    ?>