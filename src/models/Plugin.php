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