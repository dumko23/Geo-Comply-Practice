<?php
session_start();

include 'head.php';

$_SESSION['answer2'] = $_POST['age'];

?>

<div>
    <form action="result.php" method="post">
        <p>And do you agree ...?</p>
        <input id="agree" type="radio" name="agreement" value="agree">
        <label for="agree">I'm agree</label>
        <input id="disagree" type="radio" name="agreement" value="disagree">
        <label for="disagree">I'm disagree</label>
        <input type="submit">
    </form>
</div>
</body>
</html>