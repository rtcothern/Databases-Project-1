<?php
include 'base.php';

function validate_year($year) {
    return preg_match('/^\\d\\d\\d\\d$/', $year);
}

?>

<?php startblock('title') ?>
Add a Movie
<?php endblock() ?>

?>
<?php startblock('article') ?>

<?php
    $success = false;
    $message = null;

    $title = null;
    $company = null;
    $year = null;
    $rating = null;
    $genres = null;

    $someInput = false;
    
    if(isset($_POST["title"])) {
        $title = $_POST["title"];
        $someInput = true;
    }
    if(isset($_POST["company"])) {
        $company = $_POST["company"];
        $someInput = true;
    }
    if(isset($_POST["year"])) {
        $year = $_POST["year"];
        $someInput = true;
    }
    if(isset($_POST["rating"])) {
        $rating = $_POST["rating"];
        // Not someInput!
    }
    if(isset($_POST["genre"])) {
        $genres = $_POST["genre"];
        $someInput = true;
    }

    
    if($someInput) {
        do {
            $db = mysql_connect("localhost", "cs143", "");
            mysql_select_db("CS143", $db);
            
            if(empty($title) || empty($company)) {
                $message = "Invalid title or company.";
                break;
            }
            
            $titleQuoted = "'" . mysql_real_escape_string($title) . "'";
            $companyQuoted = "'" . mysql_real_escape_string($company) . "'";
            if(!validate_year($year)) {
                $message = "Invalid year.";
                break;
            }
            
            $yearQuoted = "'" . mysql_real_escape_string($year) . "'";
            
            $ratingQuoted = "'" . mysql_real_escape_string($rating) . "'";

            $idQuery = "SELECT id FROM MaxMovieID";
            $idArr = mysql_fetch_array(mysql_query($idQuery, $db));
            $id = $idArr["id"] + 1;
            $results = mysql_query("INSERT INTO Movie VALUES ($id, $titleQuoted, $yearQuoted, $ratingQuoted, $companyQuoted);", $db);
            
            if($results == TRUE){
                $maxIdUpdate = "UPDATE MaxMovieID SET id=$id";
                $upRes = mysql_query($maxIdUpdate, $db);
                if($upRes == TRUE){
                    $success_genres = True;
                    if(!empty($genres)) {
                        foreach($genres as $genre) {
                            $genre_escaped = mysql_real_escape_string($genre);
                            $results = mysql_query("INSERT INTO MovieGenre VALUES ($id, '$genre_escaped');");
                            if(!$results) {
                                $success_genres = False;
                                break;
                            }
                        }
                    }
                    if($success_genres) {
                        $message = "Movie successfully added. Please see <a href=\"viewMovie.php?id=$id\">more information about the movie.</a>";
                        $success = True;
                    } else {
                        $message = "Movie was added but a genre could not be added.";
                    }
                } else {
                    $message = "Added movie, but could not update ID.";
                }
            } else {
                $message = "Movie could not be initially added.";
            }
        } while(false);


        if($success) {
            successMessage($message);
        } else {
            errorMessage($message);
        }
    }
?>

    <form action="addMovie.php" method="POST">
    <table border="1">
    <tr><td><b>Title</b></td><td><input type="text" name="title" maxlength="100"/></td></tr>
    <tr><td><b>Year</b></td><td><input type="number" name="year" min="1000" max="9999" /></td></tr>
    <tr><td><b>Rating</b></td><td><span style="white-space:nowrap; display:block;"><input type="radio" name="rating" value="G" checked="true"/>G <i>(General Audiences)</i></span><span style="white-space:nowrap; display:block"><input type="radio" name="rating" value="PG" />PG <i>(Parental Guidance)</i></span><span style="white-space:nowrap; display:block"><input type="radio" name="rating" value="PG-13" />PG-13 <i>(Parental Guidance Under 13)</i></span><span style="white-space:nowrap; display:block"><input type="radio" name="rating" value="R" />R <i>(Restricted)</i></span><span style="white-space:nowrap; display:block"><input type="radio" name="rating" value="NC-17" />NC-17 <i>(No Children Under 17)</i></span><span style="white-space:nowrap; display:block"></td></tr>
    <tr><td><b>Genres</b></td><td><table><tr><td><input type="checkbox" name="genre[]" value="Drama" />Drama</td><td><input type="checkbox" name="genre[]" value="Comedy" />Comedy</td><td><input type="checkbox" name="genre[]" value="Romance" />Romance</td></tr><tr><td><input type="checkbox" name="genre[]" value="Crime" />Crime</td><td><input type="checkbox" name="genre[]" value="Horror" />Horror</td><td><input type="checkbox" name="genre[]" value="Mystery" />Mystery</td></tr><tr><td><input type="checkbox" name="genre[]" value="Thriller" />Thriller</td><td><input type="checkbox" name="genre[]" value="Action" />Action</td><td><input type="checkbox" name="genre[]" value="Adventure" />Adventure</td></tr><tr><td><input type="checkbox" name="genre[]" value="Fantasy" />Fantasy</td><td><input type="checkbox" name="genre[]" value="Documentary" />Documentary</td><td><input type="checkbox" name="genre[]" value="Family" />Family</td></tr><tr><td><input type="checkbox" name="genre[]" value="Sci-Fi" />Sci-Fi</td><td><input type="checkbox" name="genre[]" value="Animation" />Animation</td><td><input type="checkbox" name="genre[]" value="Musical" />Musical</td></tr><tr><td><input type="checkbox" name="genre[]" value="War" />War</td><td><input type="checkbox" name="genre[]" value="Western" />Western</td><td><input type="checkbox" name="genre[]" value="Adult" />Adult</td></tr><tr><td><input type="checkbox" name="genre[]" value="Short" />Short</td></tr></table></td></tr>
    <tr><td><b>Company</b></td><td><input type="text" name="company" maxlength="50"/></td></tr>
    </table><br>
    <input type="submit" value="Submit" />
    </form>
<?php endblock(); ?>