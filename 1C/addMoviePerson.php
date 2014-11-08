<?php include 'base.php' ?>

<?php startblock('title') ?>
Associate a Movie and an Actor
<?php endblock() ?>

<?php 
$query = "SELECT title, id, year FROM Movie ORDER BY title"; 
$db = mysql_connect("localhost", "cs143", "");
mysql_select_db("CS143", $db);
$movieResults = mysql_query($query, $db);

$aQuery = "SELECT first, last, dob, id FROM Actor ORDER BY first"; 
$actors = mysql_query($aQuery, $db);

$dQuery = "SELECT first, last, dob, id FROM Director ORDER BY first"; 
$directors = mysql_query($dQuery, $db);
?>

<?php startblock('article') ?>

    <form action="addPerson.php" method="POST"> 
        <b>Select a Movie </b><select name="movie">
            <?php while($row=mysql_fetch_assoc($movieResults)) {
                      echo '<option value="' . htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["title"] . " (" . $row["year"] . ")") . '</option>' . "\n";
                  } ?>
        </select> <br/>
        <b>Association: </b><input onclick="retrievePersons('Actor');" type="radio" name="type" value="Actor" checked="true">Actor<input onclick="retrievePersons('Director');" type="radio" name="type" value="Director">Director
         
        <b>Select a Movie </b><select name="movie">
            <?php while($row=mysql_fetch_assoc($actors)) {
                      echo '<option value="' . htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["first"] . $row["last"] . " (" . $row["dob"] . ")") . '</option>' . "\n";
                  } ?>
        </select> <br/>

         <b>Select a Movie </b><select name="movie" display="none">
            <?php while($row=mysql_fetch_assoc($directors)) {
                      echo '<option value="' . htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["first"] . $row["last"] . " (" . $row["dob"] . ")") . '</option>' . "\n";
                  } ?>
        </select> <br/>

        <br/><input type="submit" value="Submit" />
    </form>

<script type="text/javascript">
    function retrievePersons(personType){
        switch(personType){
            case 'Actor':
               
        }
    }
</script>
<?php endblock() ?>