<?php
if (isAdmin()) {
  if (isset($_POST['apply'])) {
    $options = escape($_POST['options']);
    if (isset($_POST['checkBoxArray']) && $options) {
      foreach ($_POST['checkBoxArray'] as $post_id) {
        $post_id = escape($post_id);
        switch ($options) {
          case 'Published':
            $query = "UPDATE posts SET post_status='$options' WHERE post_id=$post_id";
            $update_post_query = mysqli_query($connection, $query);
            check_error($update_post_query);
            break;
          case 'Draft':
            $query = "UPDATE posts SET post_status='$options' WHERE post_id=$post_id";
            $update_post_query = mysqli_query($connection, $query);
            check_error($update_post_query);
            break;
          case 'delete':
            $query = "DELETE FROM posts WHERE post_id=$post_id";
            $delete_post_query = mysqli_query($connection, $query);
            check_error($delete_post_query);
            break;
          case 'copy':
            $posts_query = "SELECT * FROM posts WHERE post_id=$post_id";
            $all_posts_result = mysqli_query($connection, $posts_query);
            check_error($all_posts_result);
            while ($row = mysqli_fetch_assoc($all_posts_result)) {
              $post_author = $row['post_author'];
              $post_title = $row['post_title'];
              $post_category_id = $row['post_category_id'];
              $post_image = $row['post_image'];
              $post_content = $row['post_content'];
              $post_tags = $row['post_tags'];
              $post_status = $row['post_status'];
            }
            $post_query =
              'INSERT INTO posts(post_category_id, post_title,post_author,post_date,post_image,post_content,post_tags,post_status) ';
            $post_query .= "VALUES({$post_category_id},'{$post_title}','${post_author}',now(),'${post_image}','${post_content}','${post_tags}','${post_status}' )";
            $create_post_query = mysqli_query($connection, $post_query);
            check_error($create_post_query);
            break;
        }
      }
    }
  }
} ?>

<form action='' method='post'>
    <?php if (isAdmin()) { ?>
    <div class='col-xs-4'>
        <select class="form-control" name='options'>
            <option value="">Select Options</option>
            <option value="Published">Published</option>
            <option value="Draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="copy">Copy</option>
        </select>
    </div>
    <div class="col-xs-4 list-group">
        <input  name='apply' type="submit" class="btn btn-success" value="Apply">
        <a class='btn btn-primary' href="posts.php?source=add_post">Add New Post</a>
    </div>
    <?php } ?>
    <table class="table table-bordered table-hover">
    <thead>
        <tr>
            <?php if (isAdmin()) { ?>
            <th><input type='checkbox' id='selectAllChecks' /></th>
            <?php } ?>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Date</th>
            <th>Image</th>
            <th>content</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Views</th>
            <th>Status</th>
            <?php if (isAdmin()) { ?>
            <th >Edit</th>
            <th >Delete</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
<!-- VIEW ALL POSTS -->
        <?php
        $posts_query =
          'SELECT posts.post_id, posts.post_author, posts.post_title, posts.post_category_id, posts.post_date, posts.post_views_count, posts.post_tags, posts.post_status, posts.post_image, posts.post_content, ';
        $posts_query .= 'categories.cat_title ';
        $posts_query .= 'FROM posts ';
        $posts_query .=
          'JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC';
        $all_posts_result = mysqli_query($connection, $posts_query);
        check_error($all_posts_result);
        while ($row = mysqli_fetch_assoc($all_posts_result)) {
          $post_id = $row['post_id'];
          $post_author = $row['post_author'];
          $post_title = $row['post_title'];
          $post_category_id = $row['post_category_id'];
          $post_date = $row['post_date'];
          $post_views_count = $row['post_views_count'];
          $post_tags = $row['post_tags'];
          $post_status = $row['post_status'];
          $post_image = $row['post_image'];
          $cat_title = $row['cat_title'];
          $post_comment_count = table_num_rows_conditionable(
            'comments',
            'comment_post_id',
            "$post_id"
          );
          $post_content = format_text($row['post_content'], 40);
          delete_modal(
            'posts',
            "Are you sure you want to delete $post_title?",
            "$post_id",
            "$post_image"
          );
          echo '<tr>';
          echo isAdmin()
            ? "<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='$post_id' /></td>"
            : null;
          echo "<td>$post_id</td>
          <td>$post_author</td>
          <td><a href='../post.php?post_id=$post_id'>$post_title</a></td>
          <td>$cat_title</td>
          <td>$post_date</td>
          <td><img width='100px' class='img-responsive' src='../images/posts/$post_image' alt='$post_title'</td>
          <td>$post_content</td>
          <td>$post_tags</td>
          <td>";
          echo $post_comment_count > 0 && isAdmin()
            ? "<a href='post_comments.php?post_id=$post_id'>$post_comment_count</a>"
            : $post_comment_count;
          echo '</td><td>';
          echo isAdmin()
            ? "<a href='posts.php?reset=$post_id'>$post_views_count</a>"
            : $post_views_count;
          echo "</td>
          <td>$post_status</td>";
          echo isAdmin()
            ? "<td ><a class='text-success' href='posts.php?source=edit_post&p_id=$post_id'><i class='fa fa-pencil'></i></a></td>
          <td><a href='' data-toggle='modal' data-target='#posts-$post_id' class='text-danger'><i class='fa fa-trash'></i></a></td>
        </tr>"
            : null;
        }
        if (isAdmin($_SESSION['user_role'])) {
          //RESET VIEWS POST
          reset_column('posts', 'post_id', 'post_views_count', 'posts.php');
          //DELETE POST
          delete_row('posts', 'post_id', 'posts.php');
          delete_row('comments', 'comment_post_id', 'posts.php');
        }
        ?>
    </tbody>
    </table>        
</form>