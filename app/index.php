<?php

/**
 * Нужен autoload и контейнер или сервис-локатор, чтобы не подгружать каждый класс через require.
 */
require 'services/helpers.php';
require 'services/parsers/ParserInterface.php';
require 'services/parsers/ProductParser.php';
require 'services/parsers/PleerRuParser.php';
require 'services/parsers/DefaultParser.php';
require 'models/dto/Product.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

/**
 * Простейший роутинг, но работает как надо
 * Принцип роутинга похож на Yii2 у нас есть контроллер вида SiteController
 * и у него есть action-методы. В _GET поступает значение вида site/index
 * где первая часть это название контроллера, а вторая это action-метод.
 **/
$url = isset($_GET['url']) ? $_GET['url'] : 'site/index';
list($controllerName, $actionName) = explode('/', $url);
$controllerClassName = ucfirst($controllerName) . 'Controller';
$controllerFile = 'controllers/' . $controllerClassName . '.php';

if (file_exists($controllerFile)) {
    require $controllerFile;
    $controller = new ("app\\controllers\\".$controllerClassName)();

    if (method_exists($controller, $actionName)) {
        echo $controller->$actionName();
    } else {
        echo $controller->displayError(404, 'Такого action-метода не существует.');
    }
} else {
    echo 'Надо обрабатывать кейс когда запрошен некорректный контроллер.';
}
