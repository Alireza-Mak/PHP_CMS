 <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Label", "Count", { role: "style" } ],
  <?php
  $published_posts_count = table_num_rows_conditionable(
      "posts",
      "post_status",
      "Published"
  );
  $draft_posts_count = table_num_rows_conditionable(
      "posts",
      "post_status",
      "Draft"
  );
  $unapproved_comments_count = table_num_rows_conditionable(
      "comments",
      "comment_status",
      "Unapproved"
  );
  $subscriber_users_count = table_num_rows_conditionable(
      "users",
      "user_role",
      "Subscriber"
  );
  $labels = [
      "All Posts",
      "Published Posts",
      "Draft Posts",
      "All Comments",
      "Pending Comments",
      "All Users",
      "Subscribers",
      "Categories",
  ];
  $values = [
      ($posts_count = table_num_rows("posts")),
      $published_posts_count,
      $draft_posts_count,
      ($comments_count = table_num_rows("comments")),
      $unapproved_comments_count,
      ($users_count = table_num_rows("users")),
      $subscriber_users_count,
      ($categories_count = table_num_rows("categories")),
  ];
  $colors = [
      "#337AB7",
      "#75aad6",
      "#939393",
      "#5CB85C",
      "#a7e8a7",
      "#F0AD4E",
      "#efc283",
      "#D9534F",
  ];
  for ($i = 0; $i < count($labels); $i++) {
      echo '["' .
          $labels[$i] .
          '",' .
          $values[$i] .
          ',"' .
          $colors[$i] .
          '"], ';
  }
  ?>
      ]);
      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "none" },
                       2]);
      var options = {
        legend: { position: "none" },
        hAxis: {
      title: "Types" // Label for the x-axis
    },
    vAxis: {
      title: "Count" // Label for the y-axis
    }
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>