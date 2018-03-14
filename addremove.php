<?php

$page_name = "addremove";

include("includes/query.php");

// initialize and declare variables that indicate whether certain elements should be displayed
$show_form = TRUE;
$show_results = FALSE;

// if the form has been submitted to add a new member
if ($do_add) {
  // check if any of the fields have been left blank or filled in the wrong format
  if (empty($netid) || empty($first_name) || empty($last_name) || empty($voice_part) || empty($class_year) || empty($major) || empty($phone_number)) {
    $messages[] = "Cannot add member - some fields unfilled or incorrectly filled!";
  } else {

    // sql query and parameter markers
    $sql = "INSERT INTO members (netid, first_name, last_name, voice_part, class_year, major, phone_number) VALUES (:netid, :first_name, :last_name, :voice_part, :class_year, :major, :phone_number);";
    $params = array(':netid' => $netid, ':first_name' => $first_name, ':last_name' => $last_name, ':voice_part' => $voice_part, ':class_year' => $class_year, ':major' => $major, ':phone_number' => $phone_number);

    $result = exec_sql_query($db, $sql, $params);
    if ($result) {
      $messages[] = "New member has been added to directory.";
    } else {
      $messages[] = "Failed to add new member.";
    }
  }
}
// if the form has been submitted to remove member(s)
elseif ($do_remove) {
  $show_form = FALSE; // don't show the search form

  // sql query and parameter markers
  $sql = "SELECT * FROM members WHERE netid LIKE '%' || :netid || '%' AND first_name LIKE '%' || :first_name || '%' AND last_name LIKE '%' || :last_name || '%' AND voice_part LIKE '%' || :voice_part || '%' AND class_year LIKE '%' || :class_year || '%' AND major LIKE '%' || :major || '%' AND phone_number LIKE '%' || :phone_number || '%';";
  $params = array(':netid' => $netid, ':first_name' => $first_name, ':last_name' => $last_name, ':voice_part' => $voice_part, ':class_year' => $class_year, ':major' => $major, ':phone_number' => $phone_number);

  $records = exec_sql_query($db, $sql, $params)->fetchAll();
  if (isset($records) and !empty($records)) { // if members found
    $show_form = FALSE; // don't show the search form
    $show_results = TRUE; // display the returned members
  } else {
    $messages[] = "No such members found.";
  }
}
// if the form has been submitted to confirm the removal of members
elseif ($confirm_remove) {
  // sql query and parameter markers
  $sql = "DELETE FROM members WHERE netid LIKE '%' || :netid || '%' AND first_name LIKE '%' || :first_name || '%' AND last_name LIKE '%' || :last_name || '%' AND voice_part LIKE '%' || :voice_part || '%' AND class_year LIKE '%' || :class_year || '%' AND major LIKE '%' || :major || '%' AND phone_number LIKE '%' || :phone_number || '%'";
  $params = array(':netid' => $netid, ':first_name' => $first_name, ':last_name' => $last_name, ':voice_part' => $voice_part, ':class_year' => $class_year, ':major' => $major, ':phone_number' => $phone_number);

  $result = exec_sql_query($db, $sql, $params);
  if ($result) {
    $messages[] = "Selected members have been deleted from the directory.";
  } else {
    $messages[] = "Deletion failed.";
  }
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="stylesheet" type="text/css" href="styles/style.css" media="all" />
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" />

  <title>Cornell University Glee Club Member Directory | Add or Remove a Member</title>
</head>

<body>

  <?php include("includes/header.php");?>

  <h1>Add/Remove Member(s)</h1>

  <?php
  // Echo user messages
  foreach ($messages as $message) {
    echo "<p class=\"message\">" . htmlspecialchars($message) . "</p>\n";
  }

  if ($show_form) {
    include("includes/form.php");
  }

  if ($show_results) {
    ?>
    <p><strong>Are you sure</strong> you would like to <strong>remove</strong> the following member(s) from the CUGC directory? This action is irreversible.</p>
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

      // display table of returned members
      foreach($records as $record) {
        echoRow($record);
      }
      ?>
    </table>
    <!-- form that confirms the removal of the above returned members -->
    <form method="post" action="addremove.php">
      <input type="hidden" name="netid" value="<?php echo "$netid"; ?>" hidden />
      <input type="hidden" name="first_name" value="<?php echo "$first_name"; ?>" hidden />
      <input type="hidden" name="last_name" value="<?php echo "$last_name"; ?>" hidden />
      <input type="hidden" name="voice_part" value="<?php echo "$voice_part"; ?>" hidden />
      <input type="hidden" name="class_year" value="<?php echo "$class_year"; ?>" hidden />
      <input type="hidden" name="major" value="<?php echo "$major"; ?>" hidden />
      <input type="hidden" name="phone_number" value="<?php echo "$phone_number"; ?>" hidden />
      <input class="button remove-button" type="submit" name="confirm_remove" value="Confirm Removal" />
      <a href="addremove.php"><button class="button remove-button" type="button">Cancel</button></a>
    </form>
    <?php
  }

  ?>

  <?php include("includes/footer.php");?>

</body>
</html>
