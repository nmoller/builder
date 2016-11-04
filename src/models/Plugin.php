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

    function __construct($name, $dir, $url, $version) {
        $this->name = $name;
        $this->dir = $dir;
        $this->url = $url;
        $this->version = $version;
        $this->cleanName();
    }

    function cleanName(){
        $this->name = str_replace('.', '_', $this->name);
    }

}