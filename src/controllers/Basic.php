<?php
/**
 * Created by PhpStorm.
 * User: nmoller
 * Date: 05/11/17
 * Time: 11:27 AM
 */

namespace controllers;
use models\Builder as Builder;
use models\Plugin as Plugin;
use \Slim\Http\Stream as Stream;


class Basic
{
    function __construct($request, $response, $args, $extras = []) {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
        $this->extras = $extras;
    }

    function form() {
        $b = new Builder();
        $config = $b->getConfig();
        $plugins = array();
        foreach ($config['plugins'] as $plugin) {
            $p = new Plugin(
                $plugin['name'],
                $plugin['dir'],
                $plugin['url'],
                $plugin['version']
            );
            $plugins[] = $p;
        }
        return $this->extras['view']->render($this->response, 'forms/creation.html', [
            'root' => $config['basedir'] .'/'. $config['main']['dir'],
            'moodle_branch' => $config['main']['version'],
            'moodle_repo' => $config['main']['url'],
            'components' => $plugins

        ]);

    }

    function postCreation() {
        $data = $this->request->getParsedBody();
        $b = new Builder();
        $content = $b->buildFromData($data);
        file_put_contents(__DIR__.'/../../assets/tmp/test.json', $content);
        return $this->extras['view']->render($this->response, 'debug.html', [
            //'data' => $data // utile pour déboguer les valeurs soumises.
            'data' => $content
        ]);
    }

    function download($file) {
        $this->downloadHeaders($file);
    }

    private function downloadHeaders($file) {
        $fh = fopen($file, 'rb');
        $stream = new Stream($fh); // create a stream instance for the response body;
        $response = $this->response;
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
    }

}