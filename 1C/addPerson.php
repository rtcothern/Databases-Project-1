<?php
include 'base.php';

function validate_date($date) {
    return preg_match('/^\\d\\d\\d\\d-\\d\\d-\\d\\d$/', $date);
}

?>

<?php startblock('title') ?>
Add an Actor or Director
<?php endblock() ?>

<?php startblock('article');
    $success = false;
    $message = null;

    $type = null;
    $first = null;
    $last = null;
    $dob = null;
    $dod = null;
    $hasdod = null;
    $sex = null;
    $type = null;

    $someInput = false;
    
    if(isset($_POST["firstName"])) {
        $first = $_POST["firstName"];
        $someInput = true;
    }
    if(isset($_POST["lastName"])) {
        $last = $_POST["lastName"];
        $someInput = true;
    }
    if(isset($_POST["dob"])) {
        $dob = $_POST["dob"];
        $someInput = true;
    }
    if(isset($_POST["dod"])) {
        $dod = $_POST["dod"];
        $someInput = true;
    }
    if(isset($_POST["HasDod"])) {
        $hasdod = $_POST["HasDod"];
    }
    if(isset($_POST["sex"])) {
        $sex = $_POST["sex"];
    }
    if(isset($_POST["type"])) {
        $type = $_POST["type"];
    }
    
    if($someInput) {
        do {
            $db = mysql_connect("localhost", "cs143", "");
            mysql_select_db("CS143", $db);
            
            if(empty($first) || empty($last)) {
                $message = "Invalid name.";
                break;
            }
            
            $firstQuoted = "'" . mysql_real_escape_string($first) . "'";
            $lastQuoted  = "'" . mysql_real_escape_string($last)  . "'";

            if(!validate_date($dob) || $hasdod === "True" && !empty($dod) && !validate_date($dod)) {
                $message = "Invalid date.";
                break;
            }
            
            $dobQuoted = "'" . mysql_real_escape_string($dob) . "'";
            $dodQuoted = ($hasdod === "False" || empty($dod)) ? "NULL" : "'" . mysql_real_escape_string($dod) . "'";

            $idQuery = "SELECT id FROM MaxPersonID";
            $idArr = mysql_fetch_array(mysql_query($idQuery, $db));
            $id = $idArr["id"] + 1;
            if($type == "Actor") {
                $query = "INSERT INTO Actor VALUES($id, $lastQuoted, $firstQuoted, '$sex', $dobQuoted, $dodQuoted)";
            } else if($type == "Director")
                $query = "INSERT INTO Director VALUES($id, $lastQuoted, $firstQuoted, $dobQuoted, $dodQuoted)";
                // Director has no sex
                
            $results = mysql_query($query, $db);
            
            if($results == TRUE){
                $maxIdUpdate = "UPDATE MaxPersonID SET id=$id";
                $upRes = mysql_query($maxIdUpdate, $db);
            }
            if($results == TRUE and $upRes == TRUE){
                $success = true;
            } else {
                $message = "SQL query failed.";
            }
        } while(false);


        if($success) {
            successMessage($message);
            ?>
            <div style="color:green;">
            <p>The following person was added:</p>
            <table border="1" style="color: green;">
            <tr><td><b>First Name</b></td><td><?php echo htmlspecialchars($first); ?></td></tr>
            <tr><td><b>Last Name</b></td><td><?php echo htmlspecialchars($last); ?></td></tr>
            <tr><td><b>Date of Birth</b></td><td><?php echo htmlspecialchars($dob); ?></td></tr>
            <tr><td><b>Date of Death</b></td><td><?php echo (!empty($dod) && $hasdod === "True") ? htmlspecialchars($dod) : "None"; ?></td></tr>
            <tr><td><b>Type</b></td><td><?php echo htmlspecialchars($type); ?></td></tr>
            <?php if($type == "Actor") { ?>
            <tr><td><b>Gender</b></td><td><?php echo $sex=="male" ? "Male" : "Female"; ?></td></tr>
            <?php } ?>
            </table>

            <?php
            if($type=="Actor") {
                echo '<a href="viewActor.php?id='.htmlspecialchars(urlencode($id)).'">Click here for the new actor\'s full information!</a><br>';
            }
            ?>            </div>
                        <br>
         <?php
        } else {
            errorMessage($message);
        }
    }
?>

    <form action="addPerson.php" method="POST">
    <table border="1">
    <tr><td><b>First Name</b></td><td><input id="first" type="text" name="firstName" maxlength="20" width="100%" /></td></tr>
    <tr><td><b>Last Name</b></td><td><input id="last" type="text" name="lastName" maxlength="20" width="100%" /></td></tr>
    <tr><td><b>Date of Birth</b></td><td><input type="date" name="dob" width="100%" /></td></tr>
    <tr><td><b>Date of Death</b></td><td><input type="radio" name="HasDod" value="False" checked="true" onclick="document.getElementById('dodbox').disabled='disabled';" />None&nbsp;&nbsp;<input type="radio" name="HasDod" value="True" onclick="document.getElementById('dodbox').disabled='';" /><input type="date" name="dod" disabled="disabled" width="100%" id="dodbox" /></td></tr>
    <tr><td><b>Type</b></td><td><input type="radio" name="type" value="Actor" checked="true" width="100%" onclick="document.getElementById('sex1').disabled=''; document.getElementById('sex2').disabled='';" />Actor<input type="radio" name="type" value="Director" onclick="document.getElementById('sex1').disabled='disabled'; document.getElementById('sex2').disabled='disabled';"/>Director</td></tr>
    <tr><td><b>Gender</b></td><td><input type="radio" name="sex" value="male" checked="true" width="100%" id="sex1" />Female<input type="radio" name="sex" value="male" id="sex2" />Male</td></tr>
    </table><br>
    <input type="submit" value="Submit" />
    </form>
<?php
    endblock();
?>