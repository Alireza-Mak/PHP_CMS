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
            <?php
            $posts_query = "SELECT * FROM posts ";
            $posts_query .= "WHERE post_status='Published'";
            $posts_result = mysqli_query($connection, $posts_query);
            if (!$posts_result) {
                die("Posts Query Failed" . mysqli_error($connection));
            }
            $count = mysqli_num_rows($posts_result);
            $posts_per_page = 2;
            $number_of_pages = ceil($count / $posts_per_page);
            if (isset($_GET["page"])) {
                $page = escape($_GET["page"]);
            } else {
                $page = 0;
            }
            if ($page == 0 || $page == 1) {
                $pages = 0;
            } else {
                $pages = $page * $posts_per_page - $posts_per_page;
            }
            $posts_query = "SELECT * FROM posts ";
            $posts_query .= "WHERE post_status='Published' ORDER BY post_date DESC LIMIT $pages, $posts_per_page";
            $posts_result = mysqli_query($connection, $posts_query);
            if (!$posts_result) {
                die("Posts Query Failed" . mysqli_error($connection));
            }
            $count = mysqli_num_rows($posts_result);
            if (!$count) {
                echo "<h1 class='text-center'>THERE IS NO POST AVAILABLE.</h1>";
            } else {
                while ($row = mysqli_fetch_assoc($posts_result)) {

                    $post_id = $row["post_id"];
                    $post_title = $row["post_title"];
                    $post_author = $row["post_author"];
                    $post_date = $row["post_date"];
                    $post_views_count = $row["post_views_count"];
                    if (strlen($row["post_content"]) <= 15) {
                        $post_content = $row["post_content"];
                    } else {
                        $post_content =
                            substr($row["post_content"], 0, 15) . " ...";
                    }
                    $post_image = $row["post_image"];
            ?>
                    <h1 class="page-header">Page Heading<small>Secondary Text</small></h1>
                    <h2><a href="/portfolio/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2>
                    <p class="lead">by <a href="/portfolio/author/<?php echo $post_author; ?>"><?php echo $post_author; ?></a></p>

                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?> | <span class="glyphicon glyphicon-eye-open"></span> Views <?php echo $post_views_count; ?> |
                        <span class="glyphicon glyphicon-thumbs-up"></span> Likes <?php echo get_post_likes($post_id); ?>
                    </p>

                    <hr>
                    <a href="/portfolio/post/<?php echo $post_id; ?>">
                        <img class="img-responsive" src="/portfolio/images/posts/<?php echo $post_image; ?>" alt="<?php echo $post_title; ?>">
                    </a>
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <a class="btn btn-primary" href="/portfolio/post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
            <?php
                }
            }
            ?>
            <hr>
        </div>



        <?php // <!-- sidebar -->
        include "./includes/sidebar.php"; ?>



    </div>
    <!-- /.row -->


    <hr>
    <!-- Pagination -->
    <ul class='pager'>
        <?php for ($i = 1; $i <= $number_of_pages; $i++) {
            if ($i == $page) {
                $active_link = "active_link";
            } else {
                $active_link = "";
            }
            echo "<li class='mr-3'><a class='$active_link' href='/portfolio/$i'>$i</a></li>";
        } ?>
    </ul>

    <!-- Footer -->

    <?php include "./includes/footer.php"; ?>