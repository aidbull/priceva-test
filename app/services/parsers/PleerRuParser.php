<?php

namespace services\parsers;

use app\models\dto\Product;
use DOMDocument;
use DOMXPath;
use ParserInterface;

class PleerRuParser implements ParserInterface {

    public function preparePriceObject(DOMDocument $pageContent): Product
    {
        $xpath = new DOMXPath($pageContent);
        $productItem = new Product([]);

        /**
         * mainContainer содержит в себе всё необходимое
         * сначала достаем контейнер, смотрим что xpath его нашел и дальше уже его разбираем
         */
        $mainContainer = $xpath->query('//div[contains(@class, "content_main")]');
        if ($mainContainer->length > 0) {
            $mainContainer = $mainContainer->item(0);

            // Достаем название товара
            $name = $xpath->query('//meta[@itemprop="name"]/@content', $mainContainer);
            if ($name->length > 0) {
                $nameValue = $name->item(0)->nodeValue;
                $productItem->name = $nameValue;
            } else {
                $productItem->name = 'Не найдено.';
            }

            // Валюта
            $currency = $xpath->query('//meta[@itemprop="priceCurrency"]/@content', $mainContainer);
            if ($currency->length > 0) {
                $currencyVal = $currency->item(0)->nodeValue;
                $productItem->currency = $currencyVal;
            } else {
                $productItem->currency = 'Не найдено.';
            }

            // Изображение
            $image = $xpath->query('//meta[@itemprop="image"]/@content', $mainContainer);
            if ($image->length > 0) {
                $imageSrc = $image->item(0)->nodeValue;
                $productItem->imgPath = $imageSrc;
            } else {
                $productItem->imgPath = 'Не найдено.';
            }

            // Цена
            $price = $xpath->query('//div[contains(@class, "product_buy_buttons")]//div[contains(@class, "product_price_color1")]//div[@itemprop="price"]', $mainContainer);
            if ($price->length > 0) {
                $priceValue = $price->item(0)->nodeValue;
                $productItem->price = $priceValue;
            } else {
                $productItem->price = 'Не найдено.';
            }
        } else {
            throw new \Exception('Товар не найден.');
        }

        return $productItem;
    }
}