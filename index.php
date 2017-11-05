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
    // Pour que la function dump soit utilisable dans la vue,
    // il nous faut 'debug' => true et l'ajout de l'extension
    $view->addExtension(new Twig_Extension_Debug());

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};


//Register extra Twig stuff
$container['twig'] = function() {
    $loader = new Twig_Loader_Filesystem('src/templates');
    $twig = new Twig_Environment($loader);
    return $twig;
};

// Define named route

/**
 * C'est la route pour fournir le formulaire de création du fichier
 */
$app->get('/[form]', function ($request, $response, $args) {
    $controller = new controllers\Basic($request, $response, $args, ['view' => $this->view]);
    $controller->form();
})->setName('form');
// avoir de routes nomées nous permet de les référer comme {{path_for('form')}}
// dans la vue (voir debug).

$app->get('/test', function($request, $response, $args){
    return $this->twig->render('jenkins.jkn');
});
/**
 * C'est la route responsable du traitement lors de la réception des données du
 * formulaire.
 */
$app->post('/creation', function ($request, $response, $args) {
    $controller = new controllers\Basic($request, $response, $args, ['view' => $this->view]);
    $controller->postCreation();
})->setName('creation');

/**
 * C'est la route responsable du traitement lors de la réception des données du
 * formulaire.
 */
$app->post('/jenkins', function ($request, $response, $args) {
    $data = $request->getParsedBody();
    $b = new models\Jenkins();
    $content = $b->buildFromData($data, $this->twig);
    file_put_contents(__DIR__.'/assets/tmp/moodleJenkins', $content);
    return $this->view->render($response, 'debug.html', [
        //'data' => $data // utile pour déboguer les valeurs soumises.
      'data' => $content
    ]);
})->setName('jenkins');


$app->get('/creation', function ($request, $response, $args) {
    $b = new models\Builder();
    $comp = $b->getConfig();
    $comp = $comp['plugins'][1];
    $p = new models\Plugin($comp['name'], $comp['dir'], $comp['url'], $comp['version']);
    return $this->view->render($response, 'debug.html', [
      //'data' => $b->getConfig()
      'data' => $p->toJson()
    ]);
})->setName('debug');

$app->get('/download', function($request, $response, $args) {
    $file = __DIR__ . '/assets/tmp/test.json';
    $controller = new controllers\Basic($request, $response, $args);
    return $controller->download($file);

})->setName('download');

$app->get('/downloadJenk', function($request, $response, $args) {
    $file = __DIR__ . '/assets/tmp/moodleJenkins';
    $controller = new controllers\Basic($request, $response, $args);
    return $controller->download($file);

})->setName('downloadJenk');

// Run app
$app->run();