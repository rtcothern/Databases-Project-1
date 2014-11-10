<?php
error_reporting(0);

require_once 'ti.php';

function errorMessage($message) {
    $messagePart = $message ? ": $message" : ".";
    echo '<p><span style="color: red;">Operation failed' . $messagePart . '</span></p>' . "\n";

}

function successMessage($message) {
    $messagePart = $message ? ": $message" : ".";
    echo '<p><span style="color: green;">Operation successful' . $messagePart . '</span></p>' . "\n";
}

?>
<html>
    <body>
        <h1>
            <?php startblock('title') ?>
            <?php endblock() ?>
        </h1>
        <div id='article'>
            <?php startblock('article') ?>
            <?php endblock() ?>
        </div>
        <div>
            <a href="home.php">Click here to return to the home page</a>
        </div>
    </body>
</html>