<?php
if (isAdmin()) {
  list($err_msg_edit_cat, $edit_title) = edit_category(); ?>
<form action=""  method="POST">
    <div class="form-group">
    <label for="cat_title">Edit Category</label>
    <input class="form-control" type="text" id="cat_title" name="edited_cat_title" value="<?php echo $edit_title; ?>" />
    <span class="text-danger"><?php echo $err_msg_edit_cat; ?></span>
    </div>
    <div class="form-group">
    <input class="btn btn-success" type="submit" name="edit_cat" value="Edit" />
    <a class="btn btn-default" href='categories.php'>Cancel</a>
    </div>
</form>
<?php
} ?>

