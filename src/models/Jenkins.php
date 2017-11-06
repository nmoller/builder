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
    function buildFromData(array $data, $twig) {
        $path = explode("/", $data['moodle_root']);
        $base = $path[count($path) - 1];
        $ret = $twig->render('@jenkins/header.jkn');

        foreach ($data as $nom => $values) {
            if ($this->isVersion($nom) || in_array($nom, self::excludes()))
                continue;
            else
                $comp = $this->treatModule($nom, $values, $data[$nom . '|version'], true);
                $ret .= $comp->multiSCMElement($twig) .PHP_EOL;
        }
        //Fermer multiscm
        $ret .= $twig->render('@jenkins/center.jkn') . PHP_EOL;
        $ret .= $twig->render('@jenkins/gitBase.jkn');
        foreach ($data as $nom => $values) {
            if ($this->isVersion($nom) || in_array($nom, self::excludes()))
                continue;
            else
                $comp = $this->treatModule($nom, $values, $data[$nom . '|version'], true);
            $ret .= $comp->moveCompToMoodle($twig);
        }
        $ret .= $twig->render('@jenkins/footer.jkn');
        return trim($ret);
    }

}