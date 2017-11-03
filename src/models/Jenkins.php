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

        $ret = 'job(\'Moodle-new-version\') {

    parameters {
     stringParam(\'COMMITMSG\', \'Commit de test\', \'Message pour commit.\') 
     stringParam(\'BRANCH\', \'UQAM_DEV_TEMP\', \'Nom de la branche a creer.\')
    }'. PHP_EOL;

        $ret .= '  wrappers {
        credentialsBinding {
            usernamePassword(\'BB_USER\', \'BB_PASS\', \'uqamena-BB\')
          }
        }' .PHP_EOL;
        $ret .= 'multiscm {' .PHP_EOL;
        $json = $this->rebuildPath($path) ;

        foreach ($data as $nom => $values) {
            if ($this->isVersion($nom) || in_array($nom, self::excludes()))
                continue;
            else
                $comp = $this->treatModule($nom, $values, $data[$nom . '|version'], true);
                $ret .= '     ' . $comp->multiSCMElement() .PHP_EOL;
        }
        //Fermer multiscm
        $ret .= '}' .PHP_EOL;


        $ret .= 'steps {' . PHP_EOL;
        $ret .= '  shell(\'\'\' ' . PHP_EOL;
        $ret .= '# Commencer clean
if [ -d \$WORKSPACE/moodle ]
then
   rm -rf \$WORKSPACE/moodle
fi
# Verifier si la branche existe
CLONE_BRANCH=${BRANCH}
FIRST=`git ls-remote --heads https://\$BB_USER:\$BB_PASS@bitbucket.org/uqam/moodle.git ${BRANCH} | wc -l `
# Si la branche n\'existe pas encore prendre autre
if [ "${FIRST}" -eq 0 ]
then
  CLONE_BRANCH=\'UQAM_30_INT\'
fi
git clone --depth 1 --branch ${CLONE_BRANCH} --single-branch git@bitbucket.org:uqam/moodle.git \$WORKSPACE/moodle';
        foreach ($data as $nom => $values) {
            if ($this->isVersion($nom) || in_array($nom, self::excludes()))
                continue;
            else
                $comp = $this->treatModule($nom, $values, $data[$nom . '|version'], true);
            $ret .= '     ' . $comp->moveCompToMoodle();
        }

        $ret .= '# Committer
cd \$WORKSPACE/moodle
git add --all
git commit -m "${COMMITMSG}"
git remote add bb https://\$BB_USER:\$BB_PASS@bitbucket.org/uqam/moodle.git

if [ "${CLONE_BRANCH}"  != "${BRANCH}" ]
then
    git checkout -b ${BRANCH}
fi
git push bb ${BRANCH}:${BRANCH}' . PHP_EOL;
        $ret .= '\'\'\')' . PHP_EOL;
        $ret .= '';
        //Fin steps
        $ret .= '}' . PHP_EOL;
        return trim($ret);
    }

}