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

    private $components = [];

    /**
     *
     * @param array $data
     * @return string
     */
    function buildFromData(array $data, $twig) {
        $ret = $twig->render('@jenkins/header.jkn');

        foreach ($data as $nom => $values) {
            if ($this->isVersion($nom) || in_array($nom, self::excludes()))
                continue;
            else
                $comp = $this->treatModule($nom, $values, $data[$nom . '|version'], true);
            $this->components[] = $comp;
            $ret .= $comp->multiSCMElement($twig) .PHP_EOL;
        }
        //Fermer multiscm
        $ret .= $twig->render('@jenkins/center.jkn') . PHP_EOL;
        $ret .= $twig->render('@jenkins/gitBase.jkn');
        foreach ($this->components as $comp) {
            $ret .= $comp->moveCompToMoodle($twig);
        }
        $ret .= 'cd \$WORKSPACE/moodle' . PHP_EOL;
        $ret .= 'git add --all ';
        $count = 0;
        foreach ($this->components as $comp) {
            $ret .= "$comp->dir ";
            $count ++;
            if ($count % 5 == 0) {
                $ret .= PHP_EOL . 'git add --all ';
            }
        }
        $ret .= PHP_EOL . $twig->render('@jenkins/footer.jkn');
        return trim($ret);
    }
}