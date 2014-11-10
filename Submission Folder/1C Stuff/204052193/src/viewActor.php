<?php include 'base.php' ?>

<?php
$actorid = null;
$laterstyle="";
if(isset($_GET["id"])) {
    $actorid = $_GET["id"];
    if(!preg_match('/^\\d+$/', $actorid)) {
        $actorid = null;
    } else {
        $laterstyle='style="display:None"';
    }
}

$db = mysql_connect("localhost", "cs143", "");
mysql_select_db("CS143", $db);

$actors = mysql_query("SELECT first, last, dob, dod, id, sex FROM Actor ORDER BY first", $db);

$info = null;

?>

<?php startblock('title') ?>
View Information About an Actor
<?php endblock() ?>

<?php startblock('article') ?>
<div id="loading" style="font-size:20px; font-weight:bold;">Loading...<br><br></div>
<form action="viewActor.php" method="GET" id="latershow" <?php echo $laterstyle; ?>>
    <b>Select an Actor:</b><br><select name="id">
                <?php while($row=mysql_fetch_assoc($actors)) {
                            $id = $row["id"];
                            $selectedtext = "";
                            if($actorid !== null && $id == $actorid) {
                                $info = array();
                                foreach($row as $key=>$value) {
                                    $info[$key] = $value;
                                }
                                $selectedtext='selected="selected"';
                            }
                          echo '<option value="' . htmlspecialchars($id) . '" '. $selectedtext .'>' . htmlspecialchars($row["first"] . " " . $row["last"] . " (" . $row["dob"] . ")") . '</option>' . "\n";
                      } ?>
            </select> <br/>
<input type="submit" value="Go!" />
</form>

<?php
if($actorid !== null) {
    if($info === null) {
        errorMessage("Invalid actor ID");
    } else {
        ?>
        <p><b>Actor Information</b></p>
        <table border="1">
        <tr><td><b>Name</b></td><td><?php echo htmlspecialchars($info["first"] . " " . $info["last"]); ?></td></tr>
        <tr><td><b>Date of Birth</b></td><td><?php echo htmlspecialchars($info["dob"]); ?></td></tr>
        <?php if($info["dod"]) { ?>
            <tr><td><b>Date of Death</b></td><td><?php echo htmlspecialchars($info["dod"]); ?></td></tr>
        <?php } ?>
        <tr><td><b>Sex</b></td><td><?php echo htmlspecialchars($info["sex"]); ?></td></tr>
        </table>
        <p><b>Movies</b></p>
        <?php
            $results = mysql_query("SELECT mid, title, role FROM MovieActor ma JOIN Movie m ON ma.mid=m.id WHERE aid=$actorid ORDER BY title;", $db);
            if(mysql_num_rows($results) == 0) {
                echo "<p><i>Actor is not in any movies.</i></p>";
            } else {
                echo '<table border = "1"><tr><th>Title</th><th>Role</th></tr>';
                while($row = mysql_fetch_assoc($results)) {
                    echo '<tr><td><a href="viewMovie.php?id='.htmlspecialchars(urlencode($row['mid'])).'">'.htmlspecialchars($row['title']).'</a></td><td>'.htmlspecialchars($row["role"])."</td></tr>\n";
                }
                echo '</table>';
            }
         ?>
         <br>
        <?php
    }
}
?>
<script type="text/javascript">document.getElementById("loading").style.display="None";document.getElementById("latershow").style.display="block";</script>

<?php endblock() ?>
