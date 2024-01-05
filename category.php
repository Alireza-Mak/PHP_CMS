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
            <?php if (isset($_GET["cat_id"])) {
                $cat_id = escape($_GET["cat_id"]);
                $cats_query = "SELECT * FROM categories WHERE cat_id=$cat_id";
                $cats_result = mysqli_query($connection, $cats_query);
                if (!$cats_result) {
                    die("Categories Query Failed" . mysqli_error($connection));
                }
                while ($row = mysqli_fetch_assoc($cats_result)) {

                    $cat_id = $row["cat_id"];
                    $cat_title = $row["cat_title"];
            ?>
                    <h1 class="page-header"><?php echo $cat_title; ?><small>category</small></h1>
                    <?php
                    $posts_query = "SELECT * FROM posts WHERE post_category_id=$cat_id";
                    $posts_result = mysqli_query($connection, $posts_query);
                    if (!$posts_result) {
                        die("Posts Query Failed" . mysqli_error($connection));
                    }
                    $count = mysqli_num_rows($posts_result);
                    if ($count < 1) {
                        echo "<h2>THERE IS NO POST FOR THIS CATEGORY</h2>";
                    }
                    while ($row = mysqli_fetch_assoc($posts_result)) {

                        $post_title = $row["post_title"];
                        $post_author = $row["post_author"];
                        $post_date = $row["post_date"];
                        $post_content = $row["post_content"];
                        $post_image = $row["post_image"];
                        $post_views_count = $row["post_views_count"];
                    ?>
                        <h2><a href="/portfolio/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2>
                        <p class="lead">by <a href="/portfolio"><?php echo $post_author; ?></a></p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?> | <span class="glyphicon glyphicon-eye-open"></span> Views <?php echo $post_views_count; ?> |
                            <span class="glyphicon glyphicon-thumbs-up"></span> Likes <?php echo get_post_likes($post_id); ?>
                        </p>

                        <hr>
                        <img class="img-responsive" src="/portfolio/images/posts/<?php echo $post_image; ?>" alt="<?php echo $post_title; ?>">
                        <hr>
                        <p><?php echo $post_content; ?></p>
                    <?php
                    }
                    ?>
            <?php
                }
            } ?>
            <hr>
        </div>
        <?php // <!-- sidebar -->

        include "./includes/sidebar.php"; ?>
    </div>
    <!-- /.row -->
    <hr>
    <?php // <!-- Footer -->

    include "./includes/footer.php";
    ?>