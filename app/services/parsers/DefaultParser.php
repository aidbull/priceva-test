<?php

use app\models\dto\Product;

class DefaultParser implements ParserInterface {

    public function preparePriceObject(DOMDocument $pageContent): Product
    {
        // TODO: дефолт поиск по meta тегам.
        throw new Exception('Дефолтного парсера пока не существует');
    }
}