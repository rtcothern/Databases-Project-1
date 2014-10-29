<?php
$query = null;
$db = null;
if(isset($_GET["query"])) {
    $query = $_GET["query"];
    if($query) {
        $db = mysql_connect("localhost", "cs143", "");
        mysql_select_db("CS143", $db);
    }
}
?>
<html>
<head>
    <title>Queries</title>
</head>
<body>
    <h2>Query Interface</h2>
    <hr />
    <p>Written by Ray Cothern and George Chassiakos.</p>
    <p><i>Please enter a valid SELECT statement into the following field, and then press <b>Submit</b>.</i></p>
    <form method="GET">
        <div>
            <textarea
                name="query"
                cols="60"
                rows="8"><?php if($query) {
                              echo htmlspecialchars($query);
                           }
          ?></textarea>
        </div><br />
        <input type="submit" value="Submit" />
    </form>
<?php
if($query && $db) {
?>
    <h2>Result Set</h2>
    <hr />
<?php
    $results = mysql_query($query, $db);
    if(mysql_num_rows($results) > 0) {
        echo '<table border="1">'."\n";
        // Have to get first row for header, since
        // mysql_list_fields is apparently deprecated :(
        $row = mysql_fetch_assoc($results);

        echo "<tr>\n";
        // Header row
        foreach(array_keys($row) as $key) {
            echo "\t<th>";
            if(empty($key)) {
                echo "<i>&lt;empty name&gt;</i>";
            } else {
                echo htmlspecialchars($key);
            }
            echo "</th>\n";
        }

        // Rest of the rows. Using a do-while since the
        // first row was already retrieved but not yet
        // fully processed
        do {
            echo "<tr>\n";
            foreach($row as $value) {
                echo "\t<td>";
                if(is_null($value)) {
                    echo "<i>NULL</i>";
                } else if(empty($value)) {
                    echo "<i>&lt;empty string&gt;</i>";
                } else {
                    echo htmlspecialchars($value);
                }
                echo "</td>\n";
            }
            echo "</tr>\n";
        } while($row = mysql_fetch_array($results, MYSQL_NUM));
        echo "</table>\n";
    } else {
        echo "<p>No result rows</p>\n";
    }
}
?>
</body>
</html>
<?php
if($db) {
    mysql_close($db);
}
?>