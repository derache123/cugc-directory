<?php

$page_name = "directory";

include("includes/query.php");

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="stylesheet" type="text/css" href="styles/style.css" media="all" />
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" />

  <title>Cornell University Glee Club Member Directory</title>
</head>

<body>

  <?php include("includes/header.php");?>

  <h1>Search</h1>

  <?php include("includes/form.php");?>

  <?php

  // Echo user messages
  foreach ($messages as $message) {
    echo "<p class=\"message\">" . htmlspecialchars($message) . "</p>\n";
  }

  if ($do_search) {
    ?>
    <h1>Search Results</h1>
    <?php

    // sql query and parameter markers
    $sql = "SELECT * FROM members WHERE netid LIKE '%' || :netid || '%' AND first_name LIKE '%' || :first_name || '%' AND last_name LIKE '%' || :last_name || '%' AND voice_part LIKE '%' || :voice_part || '%' AND class_year LIKE '%' || :class_year || '%' AND major LIKE '%' || :major || '%' AND phone_number LIKE '%' || :phone_number || '%';";
    $params = array(':netid' => $netid, ':first_name' => $first_name, ':last_name' => $last_name, ':voice_part' => $voice_part, ':class_year' => $class_year, ':major' => $major, ':phone_number' => $phone_number);

  } else {
    // No search made
    ?>
    <h1>All Members</h1>
    <?php

    // sql query and parameter markers
    $sql = "SELECT * FROM members";
    $params = array();
  }

  $records = exec_sql_query($db, $sql, $params)->fetchAll();
  if (isset($records) and !empty($records)) {
    ?>
    <table>
      <tr>
        <th>First name</th>
        <th>Last name</th>
        <th>Email</th>
        <th>Voice part</th>
        <th>Class year</th>
        <th>Major</th>
        <th>Phone number</th>
      </tr>
      <?php

      foreach($records as $record) {
        echoRow($record);
      }
      ?>
    </table>
    <?php
  } else {
    echo "<p>No such members found in directory!</p>";
  }
  ?>

  <?php include("includes/footer.php");?>

</body>
</html>
