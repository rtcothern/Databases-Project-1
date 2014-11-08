<?php include 'base.php' ?>

<?php
$type = null;
$first = null;
$last = null;
$dob = null;
$dod = null;
$sex = null;
$type = null;

if(isset($_POST["firstName"])) {
    $first = $_POST["firstName"];
}
if(isset($_POST["lastName"])) {
    $last = $_POST["lastName"];
}
if(isset($_POST["dob"])) {
    $dob = $_POST["dob"];
}
if(isset($_POST["dod"])) {
    $dod = $_POST["dod"];
}
if(isset($_POST["sex"])) {
    $sex = $_POST["sex"];
}
if(isset($_POST["type"])) {
    $type = $_POST["type"];
}
$all = $type and
$first and 
$last and
$dob and
$dod and
$sex and
$type;

if($all) {
        $db = mysql_connect("localhost", "cs143", "");
        mysql_select_db("CS143", $db);
    }
?>

<?php startblock('title') ?>
Add an Actor or Director
<?php endblock() ?>

<?php startblock('article') ?>

    <form action="addPerson.php" method="POST"> 
    <b>First Name </b><input id="first" type="text" name="firstName" maxlength="20"> <br/>   
    <b>Last Name </b><input id="last" type="text" name="lastName" maxlength="20"> <br/>
    <b>Date of Birth </b><input type="text" name="dob"> <br/>
    <b>Date of Death </b><input type="text" name="dod"> <span>(Please leave blank if the person is still alive)</span> <br/>
    <b>Gender: </b><input type="radio" name="sex" value="male" checked="true">Female<input type="radio" name="sex" value="male">Male<br>
    <b>Type: </b><input type="radio" name="type" value="Actor" checked="true">Actor<input type="radio" name="type" value="Director">Director
    <br/>
    <input type="submit" value="Submit" />
    </form>

<?php endblock() ?>

<?php 
    if($all){
        $idQuery = "SELECT id FROM MaxPersonID";
        $idArr = mysql_fetch_array(mysql_query($idQuery, $db));
        $id = $idArr["id"] + 1;
        if($type == "Actor")
            $query = "INSERT INTO Actor VALUES($id, '$last', '$first', '$sex', $dob, $dob)";
        else if($type == "Director")
            $query = "INSERT INTO Director VALUES($id, '$last', '$first', $dob, $dob)";
        echo "$query\n";
        $results = mysql_query($query, $db);
        echo "\nResults: $results";
        if($results == TRUE){
            $maxIdUpdate = "UPDATE MaxPersonID SET id=$id";
            $upRes = mysql_query($maxIdUpdate, $db);
        }
        if($results == TRUE and $upRes == TRUE){
            echo "SUCCESS!";
        }
    }
?>