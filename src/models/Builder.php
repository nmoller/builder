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

    function rebuildPath(array $path, $isAbsolute = true) {
        $ret = '';
        //if ($isAbsolute) $ret = '/';
        for ($i = 0; $i < count($path) - 1; $i++) {
            $ret .= $path[$i] . '/';
        }
        return rtrim($ret, '/'); //On enlève le dernier /
    }

    private function treatModule($nom, $module, $version) {
        if (in_array($nom, self::excludes())) return;
        $data = $this->exploser($module);
        $base = array(
          'name' => $nom,
          'dir' => $data[0],
          'url' => $data[1]
        );

        $comp = Plugin::createFromArray($base);
        $comp->version = $version;
        $comp->setAction();
        return $comp->toJson() . ',' . PHP_EOL;
    }

    /**
     * Les valeurs à ignorer ne sont pas de plugins
     * @return array
     */
    private static function excludes() {
        return array(
          'moodle_root',
          'moodle_repo',
          'moodle_branch'
        );
    }

    private function isVersion($def){
        return count($this->exploser($def)) === 2;
    }

    private function exploser($def) {
        return explode('|', $def);
    }
}