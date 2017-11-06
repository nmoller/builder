# Création des fichers pour produire une installation

On peut produire les manifest json ou les fichiers pour batir une distro dans jenkins.

### À utiliser avec:

https://bitbucket.org/nm71/mdlinstaller

ou 

https://bitbucket.org/uqam/uqambuild

ou votre jenkins (avoir: jenkins DSL, multiSCM)

### Implémentation avec Slim et Twig.

Un petit exemple de MVC.

https://github.com/slimphp/Twig-View

http://foundation.zurb.com/sites/getting-started.html


## Usage

Aller à la racine du projet et lancer 

php -S localhost:8000

Par la suite aller à

http://localhost:8000

## Notes

Si vous utilisez php5.5, vous allez recevoir un message d'erreur dans le constructeur de Builder.php

Pour s'en sortir, changez le chemin absolut de HOME à '.'.

## Inpiration jenkins

Regarder les fichiers dans

https://github.com/nmoller/jenkins-dsl