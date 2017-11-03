<?php
/**
 * Created by PhpStorm.
 * User: nmoller
 * Date: 03/11/17
 * Time: 1:43 PM
 */

namespace models;

trait Builder_Trait {



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