<?php
/**
 * Created by PhpStorm.
 * User: nmoller
 * Date: 04/11/16
 * Time: 8:46 AM
 */

namespace models;


class Builder {
    protected $config;
    protected $HOME;
    function __construct($file = '/data/UQAM_30_DEV.json', $HOME = __DIR__.'/../..') {
        $this->config = \Zend\Config\Factory::fromFile($HOME.$file);
    }

    function getConfig() {
        return $this->config;
    }
}