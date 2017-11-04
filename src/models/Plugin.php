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

    function multiSCMElement() {
        $ret_val =  'git { ' . PHP_EOL;
        $ret_val .= '  remote {' . PHP_EOL;
        $ret_val .= '    url(' .  $this->getHttpsUrl() . ')'. PHP_EOL;
        $ret_val .= '    credentials(\'uqamena-BB\')' . PHP_EOL;
        $ret_val .= '    branch(\''. $this->version . '\')'. PHP_EOL;
        $ret_val .= '  }'. PHP_EOL;
        $ret_val .= '  extensions {'. PHP_EOL;
        $ret_val .= '    cloneOptions {'. PHP_EOL;
        $ret_val .= '      shallow()'. PHP_EOL;
	    $ret_val .= '    }'. PHP_EOL;
		$ret_val .= '    cleanAfterCheckout()'. PHP_EOL;
		$ret_val .= '    relativeTargetDirectory(\'component/' . $this->dir . '\')'. PHP_EOL;
	    $ret_val .= '  }' . PHP_EOL;
        $ret_val .= '}' . PHP_EOL;

        return $ret_val;
    }

    function moveCompToMoodle(){
        $ret = PHP_EOL . '# ' . $this->name . PHP_EOL;
        $ret .= 'rm -rf \$WORKSPACE/component/'. $this->dir .'/.git'.PHP_EOL;
        $ret .= 'rm -rf \$WORKSPACE/moodle/' . $this->dir .PHP_EOL;
        $ret .= 'cp -r \$WORKSPACE/'. 'component/'. $this->dir . ' \$WORKSPACE/moodle/'. $this->dir .PHP_EOL;
        $ret .= 'rm -rf \$WORKSPACE/component/'. $this->dir .PHP_EOL;
        return $ret;
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