<?php startblock('title') ?>
Add a Movie
<?php endblock() ?>

<?php startblock('article') ?>

    <form action="addMovie.php" method="POST"> 
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