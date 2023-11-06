<?php
/**
 * @var $name string
 * @var $currency string
 * @var $price string
 * @var $imgPath string
 * @var $origin string
 * @var $parsedAt string
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Получите цену в один клик</title>
</head>
<body>
<h1>СТРАНИЦА ПРОДУКТА</h1>
<p>ORIGIN: <a href="<?=$origin; ?>"><?=$origin; ?></a></p>
<h3><i>ДАТА СКАНА: <?= $parsedAt?></i></h3>
<h2>НАЗВАНИЕ ТОВАРА: <?=$name; ?></h2>
<img src="<?=$imgPath?>" width="400"/>
<h2>ЦЕНА: <strong><?= "$price"?></strong> &nbsp&nbsp&nbsp ВАЛЮТА: <i><?= "$currency"?></i></h2>


</body>
</html>