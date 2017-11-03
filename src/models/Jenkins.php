<?php
/**
 * Created by PhpStorm.
 * User: nmoller
 * Date: 03/11/17
 * Time: 1:38 PM
 */

namespace models;


class Jenkins {

    use Builder_Trait;

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