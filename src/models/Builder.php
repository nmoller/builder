<?php
/**
 * Created by PhpStorm.
 * User: nmoller
 * Date: 04/11/16
 * Time: 8:46 AM
 */

namespace models;


class Builder {
    use Builder_Trait;

    protected $config;
    protected $HOME;

    /**
     * Builder constructor.
     * @param string $file dans le dossier /data choisir le bon json
     * @param string $HOME
     */
    function __construct($file = '/data/UQAM_31_DEV.json', $HOME = __DIR__.'/../..') {
        $this->config = \Zend\Config\Factory::fromFile($HOME.$file);
    }

    function getConfig() {
        return $this->config;
    }

    /**
     *
     * @param array $data
     * @return string
     */
    function buildFromData(array $data) {
        $path = explode("/", $data['moodle_root']);
        $base = $path[count($path) - 1];
        $json ='{"basedir":"' . $this->rebuildPath($path) . '",' .PHP_EOL;
        $json .= '"main":{"name":"moodle","dir":"' . $base ;
        $json .=  '","url":"' .$data['moodle_repo'] .
                  '","version":"' . $data['moodle_branch'] .
                  '","action":"install"},' . PHP_EOL;
        $json .= '"plugins":[' . PHP_EOL;

        foreach ($data as $nom => $values) {
            if ($this->isVersion($nom) || in_array($nom, self::excludes()))
                continue;
            else
                $json .= $this->treatModule($nom, $values, $data[$nom . '|version']);
        }
        $json_end = ','. PHP_EOL .
             '"required":['. PHP_EOL .
             '{"name":"moodledata","type":"directory","path":"/tmp/hdata/moodledata/moodle30"}' . PHP_EOL .
               ']' . PHP_EOL .
             '}';
        return rtrim($json, ",".PHP_EOL) . ']' . $json_end;
    }

}