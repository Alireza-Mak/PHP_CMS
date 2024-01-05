<?php
if (isAdmin()) {

  if (isset($_GET['p_id'])) {
    $post_id = escape($_GET['p_id']);
    $query = "SELECT * FROM posts WHERE post_id={$post_id}";
    $post_query = mysqli_query($connection, $query);
    check_error($post_query);
    while ($row = mysqli_fetch_assoc($post_query)) {
      $post_title = $row['post_title'];
      $post_category_id = $row['post_category_id'];
      $cat_query = "SELECT * FROM categories WHERE cat_id=$post_category_id";
      $cat_result = mysqli_query($connection, $cat_query);
      $category_name = mysqli_fetch_assoc($cat_result)['cat_title'];
      check_error($cat_result);
      $post_author = $row['post_author'];
      $post_status = $row['post_status'];
      $post_tags = $row['post_tags'];
      $post_content = $row['post_content'];
      $post_date = $row['post_date'];
      $post_comment_count = $row['post_comment_count'];
      $post_image = $row['post_image'];
    }
  } else {
    header('Location: posts.php');
  }
  if (isset($_POST['update_post'])) {
    $post_title = escape($_POST['title']);
    $post_category_id = escape($_POST['post_category']);
    $post_author = escape($_POST['author']);
    $post_status = escape($_POST['status']);
    $post_tags = escape($_POST['tags']);
    $post_content = escape($_POST['content']);
    $post_image = escape($_FILES['image']['name']);
    if (
      $post_title &&
      $post_category_id &&
      $post_author &&
      $post_status &&
      $post_tags &&
      $post_content
    ) {
      $post_image_temp = escape($_FILES['image']['tmp_name']);
      $query = "SELECT post_image FROM posts WHERE post_id=$post_id";
      $image_query = mysqli_query($connection, $query);
      check_error($image_query);
      if (empty($post_image)) {
        $post_image = mysqli_fetch_assoc($image_query)['post_image'];
      } else {
        $previous_image = mysqli_fetch_assoc($image_query)['post_image'];
        $filePath = '../images/posts/' . $previous_image;
        if (file_exists($filePath)) {
          if (unlink($filePath)) {
          } elseif (!unlink($filePath)) {
            echo 'Failed to delete the file.';
          }
        } else {
          echo 'File not found.';
        }
        move_uploaded_file($post_image_temp, "../images/posts/$post_image");
      }

      $query = 'UPDATE posts SET ';
      $query .= "post_title='{$post_title}', ";
      $query .= "post_category_id='{$post_category_id}', ";
      $query .= "post_author='{$post_author}', ";
      $query .= "post_status='{$post_status}', ";
      $query .= 'post_date=now(), ';
      $query .= "post_content='{$post_content}', ";
      $query .= "post_tags='{$post_tags}', ";
      $query .= "post_image='{$post_image}' ";
      $query .= "WHERE post_id={$post_id}";
      $update_post = mysqli_query($connection, $query);
      check_error($update_post);
      echo "<p class='bg-success'>Post updated. <a href='../post.php?post_id=$post_id'>Veiw this post,</a> or <a href='posts.php'>veiw all posts.</a></p>";
    } else {
      echo "<p class='text-danger'>Please fill out all fields.</p>";
    }
  }
  ?>
   <form action="" method="post" enctype="multipart/form-data">    
      <div class="form-group">
         <label for="title">Post Title</label>
         <input class="form-control" type="text" id="title" name="title" value="<?php echo $post_title; ?>">
      </div>

      <div class="form-group">
         <label for="author">Post Author</label>
         </br>
         <select class="form-control" name="author" id="author">
            <option value="<?php echo $post_author; ?>"><?php echo $post_author; ?></option>
            <?php
            $users_query = "SELECT * FROM users WHERE user_name!='$post_author'";
            $users_result = mysqli_query($connection, $users_query);
            check_error($users_result);
            while ($row = mysqli_fetch_assoc($users_result)) {
              $user_name = $row['user_name'];
              echo "<option value='$user_name'>$user_name</option>";
            }
            ?>
         </select>
      </div>

      <div class="form-group">
         <label for="post_category_id">Post Category</label>
         </br>
         <select class="form-control" name="post_category" id="post_category">
            <option value="<?php echo $post_category_id; ?>"><?php echo $category_name; ?></option>
            <?php
            $cats_query = "SELECT * FROM categories WHERE cat_id !=$post_category_id";
            $cats_result = mysqli_query($connection, $cats_query);
            check_error($cats_result);
            while ($row = mysqli_fetch_assoc($cats_result)) {
              $cat_id = $row['cat_id'];
              $cat_title = $row['cat_title'];
              echo '<option value="' .
                $cat_id .
                '">' .
                $cat_title .
                '</option>';
            }
            ?>
         </select>
      </div>

      <div class="form-group">
         <label for="post_status">Post Status</label>
         <select class="form-control" name="status" id="post_status">
         <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
         <?php if ($post_status === 'Draft') {
           echo "<option value='Published'>Published</option>";
         } else {
           echo "<option value='Draft'>Draft</option>";
         } ?>
         </select>
      </div>
      
      <div class="form-group">
            <label for="post_image">Post Image</label>
            </br>
            <img width="100" src="../images/posts/<?php echo $post_image; ?>" alt="<?php echo $post_title; ?>">
            </br>
            </br>
            <input type="file"  name="image" id="post_image" >
      </div>

      <div class="form-group">
         <label for="post_tags">Post Tags</label>
         <input type="text" class="form-control" id="post_tags" name="tags" value="<?php echo $post_tags; ?>">
      </div>
      
      <div class="form-group">
         <label for="post_content">Content</label>
         <textarea name="content" id="summernote" class="form-control" cols="30" rows="10"><?php echo $post_content; ?></textarea>
      </div>

      <div class="form-group">
         <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
      </div>


</form>
<?php
} ?>


