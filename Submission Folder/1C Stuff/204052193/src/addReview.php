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
Add a Movie Review
<?php endblock() ?>

<?php startblock('article') ?>
<div id="loading" style="font-size:20px; font-weight:bold;">Loading...<br><br></div>
<form action="addReview.php" method="POST">
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
            <br />
    <table border="1">
    <tr><td><b>Your Name</b></td><td><input type="text" name="name" maxlength="20" /></td></tr>
    <tr><td><b>Rating (Number of Stars)</b></td><td><input type="radio" name="rating" value="1">1&nbsp;<input type="radio" name="rating" value="2">2&nbsp;<input type="radio" name="rating" value="3">3&nbsp;<input type="radio" name="rating" value="4">4&nbsp;<input type="radio" name="rating" value="5">5&nbsp;</td></tr>
    <tr><td><b>Comment</b></td><td><textarea name="comment" cols=40 rows=5></textarea></td></tr>
    </table><br>
<input type="submit" value="Go!" />
</form>

<?php
if(isset($_POST["id"])) {
    if($_POST["id"]==="" || empty($_POST["name"]) || empty($_POST["rating"]) || empty($_POST["comment"])) {
        errorMessage("Invalid input.");
    } else {
        $sid = mysql_real_escape_string($_POST["id"]);
        $srating = mysql_real_escape_string($_POST["rating"]);
        $scomment = mysql_real_escape_string($_POST["comment"]);
        $sname = mysql_real_escape_string($_POST["name"]);
        $results = mysql_query("INSERT INTO Review VALUES ('$sname', NOW(), '$sid', '$srating', '$scomment');", $db);
        if($results == FALSE) {
            errorMessage("Query failed.");
        } else {
            successMessage('Review added. <a href="viewMovie.php?id='.htmlspecialchars(urlencode($_POST["id"])).'">Click here to see your new review!</a>');

        }
    }
}
?>
<script type="text/javascript">document.getElementById("loading").style.display="None";</script>

<?php endblock() ?>
