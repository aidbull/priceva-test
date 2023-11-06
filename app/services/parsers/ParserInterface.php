<?php

use app\models\dto\Product;

interface ParserInterface {

    public function preparePriceObject(DOMDocument $pageContent): Product;

}