<?php

require_once __DIR__ . '/../core/autoload.php';

/**
 * Так как это тестовый пример, маршрутизация написана здесь,
 * хотя нужно вынести в отдельные классы.
 * также в целом нет полноценного REST api для простоты примера
 */

$routes = [
    '~^/api/testspa/get$~' => [\api\controller\TestspaController::class, 'list']
];

try {
    $url = parse_url(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL));
    $path = $url['path'];

    $isRoute = false;

    foreach ($routes as $route => $controllerAndAction) {
        preg_match($route, $path, $matches);
        if (!empty($matches)) {
            $isRoute = true;
            break;
        }
    }

    if(!$isRoute){
        throw new Exception('Route not found');
    }

    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

    $controller = new $controllerName();
    $controller->$actionName();     // для простоты нет реализации параметров $controller->$actionName(...$args)

} catch (Throwable $ex) {
    echo json_encode(['error' => 'failed to load api']);
}



