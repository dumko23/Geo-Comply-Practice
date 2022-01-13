<?php
session_start();


include 'head.php';
?>

<div>
    <form action="second.php?<?php echo htmlspecialchars(SID); ?>" method="post">
        <input id="male" type="radio" name="gender" value="male">
        <label for="male">Male</label>
        <input id="female" type="radio" name="gender" value="female">
        <label for="female">Female</label>
        <button>
            <a href="second.php?<?php echo htmlspecialchars(SID); ?>">Нажмите
                сюда</a>
        </button>
    </form>
</div>
</body>
</html>