<?php
if (isAdmin()) {
  if (isset($_POST['apply'])) {
    $options = escape($_POST['options']);
    if (isset($_POST['checkBoxArray']) && $options) {
      foreach ($_POST['checkBoxArray'] as $comment_id) {
        $comment_id = escape($comment_id);
        switch ($options) {
          case 'Approved':
            $query = "UPDATE comments SET comment_status='$options' WHERE comment_id=$comment_id";
            $update_comment_query = mysqli_query($connection, $query);
            check_error($update_comment_query);
            break;
          case 'Unapproved':
            $query = "UPDATE comments SET comment_status='$options' WHERE comment_id=$comment_id";
            $update_comment_query = mysqli_query($connection, $query);
            check_error($update_comment_query);
            break;
          case 'delete':
            $query = "DELETE FROM comments WHERE comment_id=$comment_id";
            $delete_comment_query = mysqli_query($connection, $query);
            check_error($delete_comment_query);
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
            <option value="Approved">Approved</option>
            <option value="Unapproved">Unapproved</option>
            <option value="delete">Delete</option>
        </select>
    </div>
    <div class="col-xs-4 list-group">
        <input  name='apply' type="submit" class="btn btn-success" value="Apply">
    </div>
        <?php } ?>
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <?php if (isAdmin()) { ?>
          <th><input type='checkbox' id='selectAllChecks' /></th>
          <?php } ?>
          <th>Id</th>
          <th>Relate to</th>
          <th>Author</th>
          <th>Email</th>
          <th>Date & Time</th>
          <th>Status</th>
          <th>Comment</th>
          <?php if (isAdmin()) { ?>
          <th>Approved</th>
          <th>Unapproved</th>
          <th >Delete</th>
          <?php } ?>
        </tr>
      </thead>
      <tbody>
        <?php
        $comments_query =
          'SELECT  comments.comment_id, comments.comment_post_id, comments.comment_author, comments.comment_email, comments.comment_time, comments.comment_date, comments.comment_content, comments.comment_status, posts.post_id, posts.post_title ';
        $comments_query .= 'FROM comments ';
        $comments_query .= 'JOIN posts ON comment_post_id=post_id ';
        $comments_query .= 'ORDER BY comment_date DESC';
        $all_comments_result = mysqli_query($connection, $comments_query);
        check_error($all_comments_result);
        while ($row = mysqli_fetch_assoc($all_comments_result)) {
          $comment_id = $row['comment_id'];
          $comment_post_Id = $row['comment_post_id'];
          $comment_author = $row['comment_author'];
          $comment_email = $row['comment_email'];
          $comment_time = $row['comment_time'];
          $comment_date = format_date(
            $row['comment_date'],
            $row['comment_time']
          );
          $comment_content = format_text($row['comment_content'], 40);
          $comment_status = $row['comment_status'];
          $post_id = $row['post_id'];
          $post_title = format_text($row['post_title'], 10);
          delete_modal(
            'comments',
            "Are you sure you want to delete comment of $comment_author?",
            "$comment_id",
            ''
          );
          echo '<tr>';
          echo isAdmin()
            ? "<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='$comment_id' /></td>"
            : null;
          echo "<td>$comment_id</td>
          <td><a href='../post.php?post_id=$post_id'>$post_title</a></td>
          <td>$comment_author</td>
          <td>$comment_email</td>
          <td>$comment_date</td>
          <td>$comment_status</td>
          <td>$comment_content</td>";
          echo isAdmin()
            ? "<td ><a class='text-success' href='comments.php?approved=$comment_id'><i class='fa fa-check'></i></a></td>
          <td><a class='text-danger' href='comments.php?unapproved=$comment_id'><i class='fa fa-regular fa-close'></i></a></td>
          <td><a class='text-danger' href='' data-target='#comments-$comment_id' data-toggle='modal'><i class='fa fa-trash'></i></a></td>
        </tr>"
            : null;
        }
        if (isAdmin($_SESSION['user_role'])) {
          //DELETE COMMENT
          delete_row('comments', 'comment_id', 'comments.php');
          // Approved and Unapproved
          status(
            'comments',
            'comment_status',
            'comment_id',
            ['approved', 'unapproved'],
            'comments.php'
          );
        }
        ?>
        
      </tbody>
    </table>
</form>