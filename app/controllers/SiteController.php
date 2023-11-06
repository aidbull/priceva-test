<?php

namespace app\controllers;

use Exception;
use services\parsers\ProductParser;

class SiteController {

    // TODO: внедряь зависимости через конструктор

    public function index() {
        echo render('main');
    }

    public function getPrice() {
        $productUrl = $_POST['product_url'];

        if (empty($productUrl) || !validateUrl($productUrl)) {
            return $this->displayError('400', 'URL-ссылка не валидна.');
        }

        $parser = new ProductParser($productUrl);
        try {
            $product = $parser->getPriceObject();
        } catch (Exception $exception) {
            return $this->displayError($exception->getCode(), $exception->getMessage());
        }

        return render('product_info', $product->toArray());
    }

    public function displayError(int $code, string $message) {
        return render('error', ['errorCode' => $code, 'errorMsg' => $message]);
    }
}