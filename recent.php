        <?php

        echo '<p><strong>Recent Forum Topics</strong></p>';
        // Connect to the database
        if (!isset($dbc)) {
        require_once('connectvars.php');
          $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        }
          
          // Retrieve recent sport topics
          $query = "SELECT * FROM topics ORDER BY topic_id DESC LIMIT 10";
         $result = mysqli_query($dbc, $query);
          while ($row = mysqli_fetch_array($result)) {
          $topic = $row['topic_id'];
          
          if (is_file(GW_UPLOADPATH . $row['picture']) && filesize(GW_UPLOADPATH . $row['picture']) > 0) {
              echo '<img src="' . GW_UPLOADPATH . $row['picture'] . '" class="img-responsive" alt="image" /><br />';
            }
          echo '<strong><a href="sportforums.php?topic='.$topic.'&category='.$row['category'].'">' .$row['topic']. '</a></strong>'; 
          echo '<p class="text-justify">' . substr($row['text'], 0, 70) . '...</p>';
          $query2 = "SELECT * FROM topics_reply WHERE topic_id = ".$row['topic_id']."";
          $result2 = mysqli_query($dbc, $query2);
          $numrows = mysqli_num_rows ($result2);
            echo '<small>by <a href="viewprofile.php?username='.$row['username'].'">'.$row['username'].'</a>, ' . substr($row['date'], 0, 10) . ',  <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> '.$numrows.'</small>';
            echo '<hr width="90%" size="2" align="center">';
          }

        ?>