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

            <?php if (isset($_POST["submit"])) {
                $search = $_POST["search"];
                $query = "SELECT * FROM posts WHERE post_author LIKE '%$search%' OR post_title LIKE '%$search%' ";
                $result_search_query = mysqli_query($connection, $query);
                if (!$result_search_query) {
                    die("QUERY FAILED" . mysqli_error($connection));
                }
                $count = mysqli_num_rows($result_search_query);
                if ($count == 0) {
                    echo "<h1>NO RESULT</h1>";
                } else {
                    while ($row = mysqli_fetch_assoc($result_search_query)) {

                        $post_title = $row["post_title"];
                        $post_author = $row["post_author"];
                        $post_date = $row["post_date"];
                        $post_content = $row["post_content"];
                        $post_image = $row["post_image"];
            ?>
                        <h1 class="page-header">Page Heading<small>Secondary Text</small></h1>
                        <h2>
                            <a href="#"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="lead">by <a href="index.php"><?php echo $post_author; ?></a></p>
                        <p><span class="glyphicon glyphicon-time"></span>Posted on <?php echo $post_date; ?></p>
                        <hr>
                        <img class="img-responsive" src="./images/posts/<?php echo $post_image; ?>" alt="<?php echo $post_title; ?>">
                        <hr>
                        <p><?php echo $post_content; ?></p>
                        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
            <?php
                    }
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