<?php
if (isset($companyName)) {
    echo "<footer>
        Copyright &copy;  {$companyName}
            </footer>
    </body>
</html>";
}

/*  Если выводить переменную не используя глобал - выдаёт ошибку, которая будет отображаться,
    если запускать футер как отдельный файл.
    В index и about эта переменная глобальна, потому включается в область видимости include
    и футер отображается корректно.
*/