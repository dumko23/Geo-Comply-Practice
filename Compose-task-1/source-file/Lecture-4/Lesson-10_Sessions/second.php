<?php

session_start();

include 'head.php';

$_SESSION['answer1'] = $_POST['gender'];
?>
<div>
    <form action="third.php?<?php echo htmlspecialchars(SID); ?>" method="post">
        <p>Your age is ...?</p>
        <input id="mature" type="radio" name="age" value="18+">
        <label for="mature" >18+</label>
        <input id="immature" type="radio" name="age" value="< 18">
        <label for="immature" >< 18</label>
        <div>
            <input type="submit">
        </div>
    </form>
</div>
</body>
</html>
