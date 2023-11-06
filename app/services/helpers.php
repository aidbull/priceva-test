<?php

/**
 * Простой шаблонизатор, для передачи переменных во view
 *
 * @param $view
 * @param array $data
 * @return false|string
 */
function render($view, $data = []) {
    if (file_exists('views/' . $view . '.php')) {
        ob_start();
        extract($data);
        require 'views/' . $view . '.php';
        return ob_get_clean();
    }
}

/**
 * Простая валидация url-ссылок
 *
 * @param $url
 * @return bool
 */
function validateUrl($url) {
    $pattern = '/^(http|https):\/\/([a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)+)(:[0-9]+)?(\/[^\s]*)?$/';

    if (preg_match($pattern, $url)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Получаем доменное имя, чтобы матчить с парсерами
 *
 * @param $url
 * @return mixed|null
 */
function getDomain($url) {
    $urlParts = parse_url($url);

    if (isset($urlParts['host'])) {
        return preg_replace('/^www\./', '', $urlParts['host']);
    } else {
        return null;
    }
}


