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

<?php 
    if(isset($_POST["type"]) and isset($_POST["movie"])){
        $type = $_POST["type"];
        $mid = $_POST["movie"];
        $role = $_POST["role"];
        if(empty($role) && $type=="Actor") {
            errorMessage("Must specify a role for an actor");
        } else {
            $role = mysql_real_escape_string($role);
            $insertQuery = "INSERT INTO Movie" . $type . " VALUES($mid, ";
            if($type == 'Actor'){
                $insertQuery .= $_POST["actorSelect"] . ", '$role')";
            }
            else if($type == 'Director'){
                $insertQuery .= $_POST["directorSelect"] . ")";
            }
            $insertResult = mysql_query($insertQuery, $db);
            if($insertQuery == TRUE){
                successMessage(null);
            } else {
                errorMessage(null);
            }
        }
    }
 ?>

    <form action="addMoviePerson.php" method="POST"> 
        <b>Select a Movie </b><select name="movie">
            <?php while($row=mysql_fetch_assoc($movieResults)) {
                      echo '<option value="' . htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["title"] . " (" . $row["year"] . ")") . '</option>' . "\n";
                  } ?>
        </select> <br/>
        <b>Association: </b><input onclick="switchPersons('Actor');" type="radio" name="type" value="Actor" checked="true">Actor<input onclick="switchPersons('Director');" type="radio" name="type" value="Director">Director
         
       <div id="aDiv"> 
           <b>Select an Actor </b><select name="actorSelect">
                <?php while($row=mysql_fetch_assoc($actors)) {
                          echo '<option value="' . htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["first"] . " " . $row["last"] . " (" . $row["dob"] . ")") . '</option>' . "\n";
                      } ?>
            </select> <br/>
            <b>Actor Role </b><input type="text" name="role" maxlength="20">
        </div>

        <div id="dDiv" style="display:none">
             <b>Select a Director </b><select name="directorSelect">
                <?php while($row=mysql_fetch_assoc($directors)) {
                          echo '<option value="' . htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["first"] . " " . $row["last"] . " (" . $row["dob"] . ")") . '</option>' . "\n";
                      } ?>
            </select> 
        </div><br/>

        <br/><input type="submit" value="Submit" />
    </form>

<script type="text/javascript">
    function switchPersons(personType){
        switch(personType){
            case 'Actor':
               document.getElementById("aDiv").style.display = "block";
               document.getElementById("dDiv").style.display = "none";
               break;
           case 'Director':
               document.getElementById("dDiv").style.display = "block";
               document.getElementById("aDiv").style.display = "none";
               break;
        }
    }
</script>
<?php endblock() ?>
