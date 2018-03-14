 <?php
echo "<form class=\"theform\" method=\"post\"";
if ($page_name == "directory") {
  echo " action=\"index.php\">";
} elseif ($page_name == "addremove") {
  echo " action=\"addremove.php\">";
}
?>
  <span class="left">First name</span>
  <span class="right">Last name</span>
  <input class="left" type="text" name="first_name" />
  <input class="right" type="text" name="last_name" />
  <span class="left">Voice part</span>
  <span class="right">Class year</span>
  <select class="left" name="voice_part">
    <option value="" selected disabled>Select</option>
    <option value="Tenor 1">Tenor 1</option>
    <option value="Tenor 2">Tenor 2</option>
    <option value="Baritone">Baritone</option>
    <option value="Bass">Bass</option>
  </select>
  <input class="right" type="text" name="class_year" />
  <span class="left">Major</span>
  <span class="right">NetID</span>
  <input class="left" type="text" name="major" />
  <input class="right" type="text" name="netid" />
  <span class="whole">Phone number</span>
  <input class="whole" type="tel" name="phone_number" />
  <?php
  if ($page_name == "directory") {
    echo "<input class=\"button\" type=\"submit\" name=\"search_submit\" value=\"Search\" />";
    if ($do_search) {
      echo "<a href=\"index.php\"><button class=\"button\" type=\"button\">Back</button></a>";
    }
  } elseif ($page_name == "addremove") {
    echo "<input class=\"button\" type=\"submit\" name=\"add_submit\" value=\"Add Member\" /><input class=\"button\" type=\"submit\" name=\"remove_submit\" value=\"Remove Member(s)\" />";
  }
  ?>
</form>
