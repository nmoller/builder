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

// Define named route

/**
 * C'est la route pour fournir le formulaire de création du fichier
 */
$app->get('/form', function ($request, $response, $args) {
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
        'root' => $config['basedir'] .'/'. $config['main']['dir'],
        'moodle_branch' => $config['main']['version'],
        'moodle_repo' => $config['main']['url'],
        'components' => $plugins

    ]);
})->setName('form');
// avoir de routes nomées nous permet de les référer comme {{path_for('form')}}
// dans la vue (voir debug).

/**
 * C'est la route responsable du traitement lors de la réception des données du
 * formulaire.
 */
$app->post('/creation', function ($request, $response, $args) {
    $data = $request->getParsedBody();
    $b = new models\Builder();
    $content = $b->buildFromData($data);
    file_put_contents(__DIR__.'/assets/tmp/test.json', $content);
    return $this->view->render($response, 'debug.html', [
       //'data' => $data // utile pour déboguer les valeurs soumises.
      'data' => $content
    ]);
})->setName('creation');


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
    $fh = fopen($file, 'rb');

    $stream = new \Slim\Http\Stream($fh); // create a stream instance for the response body;

    return $response->withHeader('Content-Type', 'application/force-download')
      ->withHeader('Content-Type', 'application/octet-stream')
      ->withHeader('Content-Type', 'application/download')
      ->withHeader('Content-Description', 'File Transfer')
      ->withHeader('Content-Transfer-Encoding', 'binary')
      ->withHeader('Content-Disposition', 'attachment; filename="' . basename($file) . '"')
      ->withHeader('Expires', '0')
      ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
      ->withHeader('Pragma', 'public')
      ->withBody($stream); // all stream contents will be sent to the response
})->setName('download');

// Run app
$app->run();