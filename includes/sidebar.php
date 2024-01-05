<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="POST">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button  name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                </button>
                </span>
            </div><!-- /.input-group -->
        </form>
            

    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
        <!-- /.col-lg-6 -->
        <?php
        function processTable($tableName, $limitNum)
        {
            global $connection;
            $cats_query = "SELECT * FROM " . $tableName;
            $cats_result = mysqli_query($connection, $cats_query);
            if (!$cats_result) {
                die("Category Query Failed." . mysqli_error($connection));
            }
            $count = mysqli_num_rows($cats_result);
            for ($i = 0; $i <= $count; $i += $limitNum) {
                $cats_query =
                    "SELECT * FROM " .
                    $tableName .
                    " LIMIT " .
                    $i .
                    ", " .
                    $limitNum;
                $cats_result = mysqli_query($connection, $cats_query);
                if ($count > 0) {
                    if ($count === $limitNum) {
                        echo '<div class="col-lg-12">';
                    } else {
                        echo '<div class="col-lg-6">';
                    }
                    echo '<ul class="list-unstyled">';
                    while ($row = mysqli_fetch_assoc($cats_result)) {

                        $cat_id = $row["cat_id"];
                        $cat_title = $row["cat_title"];
                        ?> <li>
                            <a href="/portfolio/category/<?php echo $cat_id; ?>"><?php echo $cat_title; ?></a>
                        </li>
                <?php
                    }
                    echo "</ul></div>";
                }
            }
        }
        processTable("categories", 4);
        ?>
            <!-- /.col-lg-6 -->


        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "widget.php"; ?>

</div>

