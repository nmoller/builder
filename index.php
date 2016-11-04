<?php
/**
 * Created by PhpStorm.
 * User: nmoller
 * Date: 03/11/16
 * Time: 6:00 PM
 */

require __DIR__ . '/vendor/autoload.php';

// Create Slim app
$app = new \Slim\App();

// Fetch DI Container
$container = $app->getContainer();

// Register Twig View helper
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('src/views', [
        'cache' => 'cache',
        'debug' => true,
    ]);

    $view->addExtension(new Twig_Extension_Debug());

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};

// Define named route


$app->get('/form/{name}', function ($request, $response, $args) {
    $t1 = new stdClass();
    $t1->name = 'test';
    $t1->autre = 'salut';
    $t2 = new stdClass();
    $t2->name = 'test1';
    $t2->autre = 'salut 1';
    return $this->view->render($response, 'forms/creation.html', [
        'components' => [
            $t1,
            $t2
        ]
    ]);
})->setName('form');

$app->post('/creation', function ($request, $response, $args)  use ($app){
    $data = $request->getParsedBody();
    return $this->view->render($response, 'profile.html', [
        'data' => $data
    ]);
})->setName('creation');

// Run app
$app->run();