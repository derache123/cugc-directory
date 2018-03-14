<?php

// open connection to database
$db = new PDO('sqlite:directory.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// messages for user
$messages = array();

// function to execute sql query
function exec_sql_query($db, $sql, $params) {
  try {
    $query = $db->prepare($sql);
    if ($query and $query->execute($params)) {
      return $query;
    }
  } catch (PDOException $e) {
    if ($e->getCode() == 23000) {
      // prevents fatal constraint violation error from messing up webpage
    } else {
        throw $e;
    }
  }

  return NULL;
}

// initialize
$do_search = FALSE;
$do_add = FALSE;
$do_remove = FALSE;
$confirm_remove = FALSE;

$netid = "";
$first_name = "";
$last_name = "";
$voice_part = "";
$class_year = "";
$major = "";
$phone_number = "";

// if form has been submitted, filter the POST parameters
if (isset($_POST['search_submit']) || isset($_POST['add_submit']) || isset($_POST['remove_submit']) || isset($_POST['confirm_remove'])) {

  if (isset($_POST['netid'])) {
    $netid = trim(filter_input(INPUT_POST, 'netid', FILTER_SANITIZE_STRING));
  } if (isset($_POST['first_name'])) {
    $first_name = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING));
  } if (isset($_POST['last_name'])) {
    $last_name = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING));
  } if (isset($_POST['voice_part'])) {
    $voice_part = trim(filter_input(INPUT_POST, 'voice_part', FILTER_SANITIZE_STRING));
  } if (isset($_POST['class_year'])) {
    $class_year = trim(filter_input(INPUT_POST, 'class_year', FILTER_SANITIZE_STRING));
  } if (isset($_POST['major'])) {
    $major = trim(filter_input(INPUT_POST, 'major', FILTER_SANITIZE_STRING));
  } if (isset($_POST['phone_number'])) {
    $phone_number = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_NUMBER_INT);
  }

  // specify what type of action to perform according to the type of submission received
  if (isset($_POST['search_submit'])) {
    $do_search = TRUE;
  } if (isset($_POST['add_submit'])) {
    $do_add = TRUE;
  } if (isset($_POST['remove_submit'])) {
    $do_remove = TRUE;
  } if (isset($_POST['confirm_remove'])) {
    $confirm_remove = TRUE;
  }
}

// function to echo a member record in an HTML table
function echoRow($row) {
  ?>
  <tr>
    <td><?php echo htmlspecialchars($row["first_name"]);?></td>
    <td><?php echo htmlspecialchars($row["last_name"]);?></td>
    <td><?php echo "<a href=\"mailto:" . htmlspecialchars($row["netid"] . "@cornell.edu") . "\">" . htmlspecialchars($row["netid"] . "@cornell.edu") . "</a>";?></td>
    <td><?php echo htmlspecialchars($row["voice_part"]);?></td>
    <td><?php echo htmlspecialchars($row["class_year"]);?></td>
    <td><?php echo htmlspecialchars($row["major"]);?></td>
    <td><?php echo htmlspecialchars($row["phone_number"]);?></td>
  </tr>
  <?php
}

?>
