<?php
/**
 * @var $errorCode string
 * @var $errorMsg string
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Произошла ошибка</title>
</head>
<body style="background-color: red; color: white;">
    <h1>ОШИБКА <?=$errorCode?></h1>

    <div>
        <h2><?=$errorMsg?></h2>
    </div>

    <a href="/"><h2>На главную</h2></a>
</body>
</html>