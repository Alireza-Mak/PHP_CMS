<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            
            <a class="navbar-brand" href="/portfolio">
             Alireza Mak
            </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <?php $current_link = basename($_SERVER['PHP_SELF']); ?>  
                <li class='<?php echo $isActive =
                  $current_link === 'index.php'
                    ? 'active'
                    : ''; ?>'><a href="/portfolio">Home</a></li> 
                <?php if (!is_logged_in()): ?>
                <li class='<?php echo $isActive =
                  $current_link === 'login.php'
                    ? 'active'
                    : ''; ?>'><a href='/portfolio/login'>Login</a></li>
                <li class='<?php echo $isActive =
                  $current_link === 'registration.php'
                    ? 'active'
                    : ''; ?>'><a href="/portfolio/registration">Sign Up</a></li>
                                    <li class="dropdown">
                  <?php
                  $cats_result = find_all_rows('categories');
                  $count = table_num_rows('categories');
                  if ($count > 0) { ?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php while ($row = mysqli_fetch_assoc($cats_result)) {
                          $cat_id = $row['cat_id'];
                          $cat_title = $row['cat_title'];
                          echo "<li><a href='/portfolio/category/$cat_id'>$cat_title</a></li>";
                        } ?>
                    </ul>
                    <?php }
                  ?>
                </li>

                <li class="dropdown">
                  <?php
                  $posts_result = find_all_rows_conditionable(
                    'posts',
                    'post_status',
                    'Published'
                  );
                  $count = table_num_rows_conditionable(
                    'posts',
                    'post_status',
                    'Published'
                  );
                  if ($count > 0) { ?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Posts <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                      <?php while ($row = mysqli_fetch_assoc($posts_result)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        echo "<li><a href='/portfolio/post/$post_id'>$post_title</a></li>";
                      } ?>
                    </ul>
                    <?php }
                  ?>
                </li>
                <?php else: ?>
                <li><a href='/portfolio/logout'>Logout</a></li>





                    
                  <li><a href='/portfolio/admin'>Admin</a></li>
                 <?php if (isset($_GET['post_id'])) {
                   $post_id = $_GET['post_id'];
                   echo "<li><a href='/portfolio/admin/posts.php?source=edit_post&p_id=$post_id'>Edit Post</a></li>";
                 }endif; ?>
                <li class='<?php echo $isActive =
                  $current_link === 'contact.php'
                    ? 'active'
                    : ''; ?>'><a href="/portfolio/contact">Contact</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>