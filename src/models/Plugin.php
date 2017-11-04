<?php
/**
 * Created by PhpStorm.
 * User: nmoller
 * Date: 04/11/16
 * Time: 9:08 AM
 */

namespace models;


class Plugin {
    public $name;
    public $dir;
    public $url;
    public $version;
    public $action;

    function __construct($name, $dir, $url, $version = 'UQAM_30_DEV') {
        $this->name = $name;
        $this->dir = $dir;
        $this->url = $url;
        $this->version = $version;
        $this->cleanName();
    }

    function cleanName(){
        $this->name = str_replace('.', '_', $this->name);
    }

    function getHttpsUrl() {
        $temp = str_replace('git@', '', $this->url);
        $temp = str_replace('ssh://', '', $temp);
        return 'https://' . $temp;
    }

    function multiSCMElement($twig) {
        return $twig->render('multiSCMElement.jkn',
            [
                'url' => $this->getHttpsUrl(),
                'branch' => $this->version,
                'folder' => 'component/' . $this->dir
            ]
        );
    }

    function moveCompToMoodle($twig){
        return $twig->render('moveCompToMoodle.jkn',
            [
                'component' => $this->name,
                'folder' => $this->dir
            ]
        );
    }

    function setAction($action = 'install') {
        $this->action = $action;
    }

    function toJson() {
        return json_encode($this, JSON_UNESCAPED_SLASHES);
    }

    static function createFromArray(array $data) {
        return new Plugin($data['name'], $data['dir'], $data['url']);
    }

}