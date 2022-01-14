<?php
session_start();


include 'head.php';
?>

<div>
    <form action="second.php" method="post">
        <p>You are a ...?</p>
        <input id="male" type="radio" name="gender" value="male">
        <label for="male">Male</label>
        <input id="female" type="radio" name="gender" value="female">
        <label for="female">Female</label>
        <input type="submit">
    </form>
</div>
</body>
</html>