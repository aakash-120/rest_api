<?php
//http://localhost:8080/view/234/id-12,name-asda/24/6
require '../vendor/autoload.php';

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Config;
use Phalcon\Mvc\Micro;
// use IntegrationTester;

$config = new Config([]);

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . "/controllers/",
        APP_PATH . "/models/",
    ]
);

$loader->registerNamespaces(
    [
        'Api\Handlers' => './handlers'
    ]
);

$loader->register();

$prod = new Api\Handlers\Product();

$app  = new Micro();

$app->get(
    '/view/{id}/{where}/{limit}/{page}',
    [
        $prod,
        'get'
    ]
);

$app->handle(
    $_SERVER['REQUEST_URI']
);





$container = new FactoryDefault();

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

// $di->set(
//     'collectionManager',
//     function () {
//         return new Manager();
//     }
// );

$application = new Application($container);



// $container->set(
//     'db',
//     function () {
//         return new Mysql(
//             [
//                 'host'     => 'mysql-server',
//                 'username' => 'root',
//                 'password' => 'secret',
//                 'dbname'   => 'store',
//                 ]
//             );
//         }
// );



$container->set(
    'mongo',
    function () {
        $mongo = new \MongoDB\Client("mongodb://mongo", array("username" => "root", "password" => "password123"));
        return $mongo;
    },
    true
);


// try {
//     // Handle the request
//     $response = $application->handle(
//         $_SERVER["REQUEST_URI"]
//     );

//     $response->send();
// } catch (\Exception $e) {
//     echo 'Exception: ', $e->getMessage();
// }
