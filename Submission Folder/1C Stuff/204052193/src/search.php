<?php include 'base.php' ?>

<?php startblock('title') ?>
Search for an Actor or Movie
<?php endblock() ?>

<?php startblock('article') ?>
    <form action="search.php" method="POST">
        <b>Search: </b><input type="text" name="search" maxlength="20"> <input type="submit" value="Go!" />
    </form>

<?php endblock() ?>

<?php
  if(isset($_POST["search"])){
    $db = mysql_connect("localhost", "cs143", "");
    mysql_select_db("CS143", $db);
    $search = $_POST["search"];
    $split = explode(" ", $search);
    $aQuery = "SELECT first, last, id, dob FROM Actor WHERE ";
    $mQuery = "SELECT title, year, id FROM Movie WHERE ";
    $sSize = count($split);
    foreach ($split as $key => $val) {
      $val = mysql_real_escape_string(strtolower($val));
      if($key != $sSize - 1)
        $aQuery .= "LOWER(first) LIKE '%$val%' OR LOWER(last) LIKE '%$val%' OR ";
      else
        $aQuery .= "LOWER(first) LIKE '%$val%' OR LOWER(last) LIKE '%$val%' ORDER BY first;";
    }
    foreach ($split as $key => $val) {
      $val = mysql_real_escape_string(strtolower($val));
      if($key != $sSize - 1)
        $mQuery .= "LOWER(title) LIKE '%$val%' OR ";
      else
        $mQuery .= "LOWER(title) LIKE '%$val%' ORDER BY title;";
    }

    $aResult = mysql_query($aQuery, $db);
    $mResult = mysql_query($mQuery, $db);

    if($aResult){
      ?>
      <h3>Perform search on your query "<?php echo $search ?>"...</h3>
      <div id="aDiv">
           <b>Actors matching your search query: </b><ul name="actors">
                <?php while($row=mysql_fetch_assoc($aResult)) {
                          echo '<li><a href="viewActor.php?id=' . htmlspecialchars($row["id"]). '">' . htmlspecialchars($row["first"] . " " . $row["last"] . " (" . $row["dob"] . ")") . '</a></li>' . "<br/>";
                      } ?>
            </ul> <br/>
      </div>

      <div id="mDiv">
           <b>Movies matching your search query: </b><ul name="movies">
                <?php while($row=mysql_fetch_assoc($mResult)) {
                          echo '<li><a href="viewMovie.php?id=' . htmlspecialchars($row["id"]). '">' . htmlspecialchars($row["title"] . " (" . $row["year"] . ")") . '</a></li>' . "<br/>";
                      } ?>
            </ul> <br/>
      </div>
      <?php
    }
  }
?>