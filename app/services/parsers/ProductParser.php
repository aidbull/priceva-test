<?php

namespace services\parsers;

use app\models\dto\Product;
use DefaultParser;
use DOMDocument;
use ParserInterface;

class ProductParser {

    /**
     * Здесь хранится маппинг от которого зависит как будет парситься страница с товаром
     */
    public const PARSER_CONFIG = [
        'pleer.ru' => PleerRuParser::class
    ];

    public const DEFAULT_PARSER = DefaultParser::class;

    public $domain;

    public $targetUrl;

    public $config = ['userAgent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:15.0) Gecko/20100101 Firefox/15.0.1', 'refererUrl' => 'google.com'];

    public function __construct($url) {
        $this->domain = getDomain($url);
        $this->targetUrl = $url;
    }

    public function getPageContent() {
        $ch = curl_init($this->targetUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        /**
         * Без указания user-agent запрос отфильтровывается и нельзя получить содержимое страницы
         */
        curl_setopt($ch, CURLOPT_USERAGENT, $this->config['userAgent']);
        curl_setopt($ch, CURLOPT_REFERER, $this->config['refererUrl']);

        $pageContent = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception('ошибка запроса: ' . curl_error($ch));
        }

        curl_close($ch);


        $dom = new DOMDocument;
        /**
         * эта хрень нужна чтобы не ругалось на теги <video> на сайте pleer.ru
        **/
        libxml_use_internal_errors(true);
        $dom->loadHTML($pageContent);

        return $dom;
    }

    public function getPriceObject() {
        $parserClass = isset(self::PARSER_CONFIG[$this->domain])
            ? self::PARSER_CONFIG[$this->domain] : self::DEFAULT_PARSER;

        /**
         * @var $parserObject ParserInterface
         */
        $parserObject = new $parserClass;
        $pageContent = $this->getPageContent();

        /**
         * @var $productItem Product
         */
        $productItem = $parserObject->preparePriceObject($pageContent);
        $productItem->parsedAt = date('d/m/Y H:i:s',time());
        $productItem->origin = $this->targetUrl;

        return $productItem;
    }
}