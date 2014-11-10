<?php include 'base.php' ?>

<?php
$movieid = null;
if(isset($_GET["id"])) {
    $movieid = $_GET["id"];
    if(!preg_match('/^\\d+$/', $movieid)) {
        $movieid = null;
    }
}

$db = mysql_connect("localhost", "cs143", "");
mysql_select_db("CS143", $db);

$movies = mysql_query("SELECT id, title, year, rating, company FROM Movie ORDER BY title", $db);

$info = null;

?>

<?php startblock('title') ?>
View Information About a Movie
<?php endblock() ?>

<?php startblock('article') ?>
<div id="loading" style="font-size:20px; font-weight:bold;">Loading...<br><br></div>
<form action="viewMovie.php" method="GET">
    <b>Select a Movie:</b><br><select name="id">
                <?php while($row=mysql_fetch_assoc($movies)) {
                            $id = $row["id"];
                            $selectedtext = "";
                            if($movieid !== null && $id == $movieid) {
                                $info = array();
                                foreach($row as $key=>$value) {
                                    $info[$key] = $value;
                                }
                                $selectedtext='selected="selected"';
                            }
                          echo '<option value="' . htmlspecialchars($id) . '" '. $selectedtext .'>' . htmlspecialchars($row["title"] . " (" . $row["year"] . ")") . '</option>' . "\n";
                      } ?>
            </select> <br/>
<input type="submit" value="Go!" />
</form>

<?php
if($movieid !== null) {
    if($info === null) {
        errorMessage("Invalid movie ID");
    } else {
        ?>
        <p><b>Movie Information</b></p>
        <table border="1">
        <tr><td><b>Title</b></td><td><?php echo htmlspecialchars($info["title"]); ?></td></tr>
        <tr><td><b>Year</b></td><td><?php echo htmlspecialchars($info["year"]); ?></td></tr>
        <tr><td><b>MPAA Rating</b></td><td><?php echo htmlspecialchars($info["rating"]); ?></td></tr>
        <tr><td><b>Company</b></td><td><?php echo htmlspecialchars($info["company"]); ?></td></tr>
        </table>
        <p><b>Actors</b></p>
        <?php
            $results = mysql_query("SELECT aid, first, last, role FROM MovieActor ma JOIN Actor a ON ma.aid=a.id WHERE mid=$movieid ORDER BY first;", $db);
            if(mysql_num_rows($results) == 0) {
                echo "<p><i>This movie has no actors.</i></p>";
            } else {
                echo '<table border = "1"><tr><th>Name</th><th>Role</th></tr>';
                while($row = mysql_fetch_assoc($results)) {
                    echo '<tr><td><a href="viewActor.php?id='.htmlspecialchars(urlencode($row['aid'])).'">'.htmlspecialchars($row['first'] . " " . $row['last']).'</a></td><td>'.htmlspecialchars($row["role"])."</td></tr>\n";
                }
                echo '</table>';
            }
         ?>
        <p><b>Comments</b></p>
        <a href="addReview.php?id=<?php echo $movieid; ?>">Add a comment to this movie!</a><br>
        <?php
            $results1 = mysql_query("SELECT AVG(rating) as av FROM Review WHERE mid=$movieid;", $db);
            $query = "SELECT name, time, rating, comment FROM Review WHERE mid=$movieid ORDER BY time DESC;";
            $results = mysql_query($query, $db);
            if(mysql_num_rows($results) == 0) {
                echo "<p><i>This movie has no comments.</i></p>";
            } else {
                $avg = mysql_fetch_assoc($results1);
                $avg = $avg['av'];
                echo "<br><b>Average user rating: $avg stars</b><br><br>";
                echo '<table border = "1"><tr><th>Time</th><th>Commenter</th><th>Rating</th><th>Comment</th></tr>';
                while($row = mysql_fetch_assoc($results)) {
                    echo '<tr><td>'.htmlspecialchars($row['time']).'</td><td align="center">'.htmlspecialchars($row['name']).'</a></td><td>'.htmlspecialchars($row['rating']).' stars</td><td>'.htmlspecialchars($row['comment']).'</td></tr>'."\n";
                }
                echo '</table>';
            }
         ?>
         <br>
        <?php
    }
}
?>
<script type="text/javascript">document.getElementById("loading").style.display="None";</script>

<?php endblock() ?>
