<?php if(isAdmin()){ if (isset($_POST["create_post"])) {
    if (
        !empty($_POST["title"]) &&
        !empty($_POST["category_id"]) &&
        !empty($_POST["author"]) &&
        !empty($_POST["status"]) &&
        !empty($_POST["tags"]) &&
        !empty($_POST["content"]) &&
        !empty($_FILES["image"]["name"])
    ) {
        $post_title = escape($_POST["title"]);
        $post_category_id = escape($_POST["category_id"]);
        $post_author = escape($_POST["author"]);
        $post_status = escape($_POST["status"]);
        $post_tags = escape($_POST["tags"]);
        $post_content = escape($_POST["content"]);
        $post_date = date("d-m-y");
        $post_image = escape($_FILES["image"]["name"]);
        $post_image_temp = $_FILES["image"]["tmp_name"];
        move_uploaded_file($post_image_temp, "../images/posts/$post_image");
        $post_query =
            "INSERT INTO posts(post_category_id, post_title,post_author,post_date,post_image,post_content,post_tags,post_status) ";
        $post_query .= "VALUES({$post_category_id},'{$post_title}','${post_author}','{$post_date}','${post_image}','${post_content}','${post_tags}','${post_status}' )";
        $create_post_query = mysqli_query($connection, $post_query);
        check_error($create_post_query);
        echo "<p class='bg-success'>Post added. <a href='posts.php'>Veiw all posts.</a></p>";
    } else {
        echo "<p class='text-danger'>Please fill out all fields.</p>";
    }
} ?>


<form action="" method="post" enctype="multipart/form-data">    
      <div class="form-group">
         <label for="title">Post Title</label>
         <input class="form-control" type="text" id="title" name="title">
      </div>

      <div class="form-group">
         <label for="author">Post Author</label>
         </br>
         <select class="form-control" name="author" id="author">
            <option value=''>Select Options</option>
            <?php
            $users_query = "SELECT * FROM users";
            $users_result = mysqli_query($connection, $users_query);
            check_error($users_result);
            while ($row = mysqli_fetch_assoc($users_result)) {
                $user_name = $row["user_name"];
                echo "<option value='$user_name'>$user_name</option>";
            }
            ?>
         </select>
      </div>

      <div class="form-group">
         <label for="post_category">Post Category</label>
         <select class="form-control" name="category_id" id="post_category">
            <option value=''>Select Options</option>
            <?php
            $cats_query = "SELECT * FROM categories";
            $cats_result = mysqli_query($connection, $cats_query);
            check_error($cats_result);
            while ($row = mysqli_fetch_assoc($cats_result)) {
                $cat_id = $row["cat_id"];
                $cat_title = $row["cat_title"];
                echo "<option value='$cat_id'>$cat_title</option>";
            }
            ?>
         </select>
      </div>

      <div class="form-group">
         <label for="post_status">Post Status</label>
         <select class="form-control" name="status" id="post_status">
            <option value=''>Select Options</option>
            <option value='Draft'>Draft</option>
            <option value='Published'>Published</option>
         </select>
      </div>
      
      <div class="form-group">
            <label for="post_image">Post Image</label>
            <input type="file"  name="image" id="post_image" >
      </div>

      <div class="form-group">
         <label for="post_tags">Post Tags</label>
         <input type="text" class="form-control" id="post_tags" name="tags">
      </div>
      
      <div class="form-group">
         <label for="summernote">Content</label>
         <textarea name="content" id="summernote"  class="form-control" cols="30" rows="10"></textarea>
      </div>

      <div class="form-group">
         <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
      </div>


</form>
<?php } ?>