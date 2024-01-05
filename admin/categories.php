<!-- header -->
<?php include './includes/admin_header.php'; ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include './includes/admin_navigation.php'; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Categories
                            <small><?php echo $_SESSION[
                              'user_firstname'
                            ]; ?></small>
                        </h1>
                        <div class="col-xs-6">
                            <!-- ADD A CATEGORY -->

                            <?php if (isAdmin()) {
                              $err_msg_add_cat = add_category(); ?>
                            <form id='add_categorty' action=''  method="POST">
                                <div class="form-group">
                                <label for="cat_title">Add Category</label>
                                <input class="form-control" type="text" id="cat_title" name="cat_title" />
                                <span id='error_msg' class="text-danger"><?php echo $err_msg_add_cat; ?></span>
                                </div>
                                <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="submit" value="Add Category" />
                                </div>
                            </form>


                            <!-- EDIT A CATEGORY -->
                            <?php if (isset($_GET['edit'])) {
                              include './includes/edit_categories.php';
                            }
                            } ?>
                            
                        </div>
                        <?php  if(isAdmin()){ ?>
                        <div class="col-xs-6">
                        <?php }else{ ?>
                        <div class="col-xs-12">
                        <?php } ?>
                        <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th >Name</th>
                            <?php echo isAdmin()
                              ? "<th >Edit</th>
                            <th >Delete</th>"
                              : null; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <!--  FIND ALL CATEGORIES -->
                            <?php
                            $cats_result = find_all_rows('categories');
                            while ($row = mysqli_fetch_assoc($cats_result)) {
                              $cat_id = $row['cat_id'];
                              $cat_title = $row['cat_title'];
                              delete_modal(
                                'categories',
                                "Are you sure you want to comment of $cat_title?",
                                "$cat_id",
                                ''
                              );
                              echo "<tr>
                                    <td>$cat_id</td>
                                    <td>$cat_title</td>";
                              echo isAdmin()
                                ? "<td ><a class='text-success' href='categories.php?edit=$cat_id'><i class='fa fa-pencil'></i></a></td>
                                    <td><a class='text-danger' href='' data-toggle='modal' data-target='#categories-$cat_id'><i class='fa fa-trash'></i></a></td>
                                </tr>"
                                : null;
                            }
                            ?>
                            
                            <!--  DELETE CATEGORY -->
                            <?php isAdmin()
                              ? delete_row(
                                'categories',
                                'cat_id',
                                'categories.php'
                              )
                              : null; ?>
                        </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


    <!-- footer -->
<?php include './includes/admin_footer.php'; ?>
