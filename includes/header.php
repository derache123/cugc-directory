<header>

  <h1>Cornell University Glee Club Member Directory</h1>

  <nav>
    <ul>
      <?php
      echo "<li";
      if ($page_name == "directory") {
        echo " class=\"current\"";
      }
      echo "><a href=\"index.php\">Directory</a></li>\n";
      echo "<li";
      if ($page_name == "addremove") {
        echo " class=\"current\"";
      }
      echo "><a href=\"addremove.php\">Add/Remove Members</a></li>\n";

      ?>
    </ul>
  </nav>
</header>
