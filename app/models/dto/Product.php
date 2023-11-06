<?php

namespace app\models\dto;

class Product {

    public $price;

    public $name;

    public $currency;

    public $imgPath;

    public $origin;

    public $parsedAt;

    public function __construct(array $data) {
        $this->name = $data['name'] ?? '';
        $this->currency = $data['currency'] ?? '';
        $this->price = $data['price'] ?? '';
        $this->imgPath = $data['imgPath'] ?? '';
        $this->origin = $data['origin'] ?? '';
        $this->parsedAt = $data['parsedAt'] ?? '';
    }

    public function toArray() {
        return [
          'name' => $this->name,
          'currency' => $this->currency,
          'price' => $this->price,
          'imgPath' => $this->imgPath,
          'origin' => $this->origin,
          'parsedAt' => $this->parsedAt,
        ];
    }
}