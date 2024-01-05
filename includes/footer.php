      <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p class='text-center'><?php echo _COPYRIGHT ?></p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="/portfolio/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/portfolio/js/bootstrap.min.js"></script>
    <!-- This setup belongs to post.php  -->
    <script>
        $(document).ready(function() {
            var post_id = <?php echo $post_id; ?>;
            var user_id = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : -1 ?>;

            $("[data-toggle='tooltip']").tooltip();
            $('a[title]').tooltip();
            $('.like').click(function() {
                $.ajax({
                    url: `/portfolio/post/${post_id}`,
                    type: 'post',
                    data: {
                        'liked': 1,
                        'post_id': post_id,
                        'user_id': user_id
                    }
                })
            })

            $('.dislike').click(function() {
                $.ajax({
                    url: `/portfolio/post/${post_id}`,
                    type: 'post',
                    data: {
                        'disliked': 1,
                        'post_id': post_id,
                        'user_id': user_id
                    }
                })
            })



        })
    </script>

</body>

</html>
