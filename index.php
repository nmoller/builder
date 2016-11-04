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

/**
 * C'est la route pour fournir le formulaire de création du fichier
 */
$app->get('/form/{name}', function ($request, $response, $args) {
    $b = new models\Builder();
    $config = $b->getConfig();
    $plugins = array();
    foreach ($config['plugins'] as $plugin) {
        $p = new models\Plugin(
              $plugin['name'],
              $plugin['dir'],
              $plugin['url'],
              $plugin['version']
          );
        $plugins[] = $p;
    }
    return $this->view->render($response, 'forms/creation.html', [
        'components' => $plugins

    ]);
})->setName('form');

/**
 * C'est la route responsable du traitement lors de la réception des données du
 * formulaire.
 */
$app->post('/creation', function ($request, $response, $args) {
    $data = $request->getParsedBody();
    return $this->view->render($response, 'debug.html', [
        'data' => $data
    ]);
})->setName('creation');


$app->get('/creation', function ($request, $response, $args) {
    $b = new models\Builder();
    return $this->view->render($response, 'debug.html', [
      'data' => $b->getConfig()
    ]);
})->setName('debug');

// Run app
$app->run();