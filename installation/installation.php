<?php

echo "Parametre : " . $argv[1] . "\n";
$niveau = $argv[1];
require_once('config.' . $niveau . '.php' );

echo "-----------------------\n";
if (file_exists(CHEMIN_DESTINATION)) {
    echo "Destruction du contenu de " . CHEMIN_DESTINATION . "\n";
    shell_exec("rm -fr " . CHEMIN_DESTINATION . "/*");
} else {
    echo "Repertoire inexistant - Creation de " . CHEMIN_DESTINATION . "\n";
    mkdir(CHEMIN_DESTINATION, 0755);
}
if (file_exists(CHEMIN_DESTINATION_PHP)) {
    echo "Destruction du contenu de " . CHEMIN_DESTINATION_PHP . "\n";
    shell_exec("rm -fr " . CHEMIN_DESTINATION_PHP . "/*");
} else {
    echo "Repertoire inexistant - Creation de " . CHEMIN_DESTINATION_PHP . "\n";
    mkdir(CHEMIN_DESTINATION_PHP, 0755);
}

echo "Copie des fichiers\n";
shell_exec("cp -R ../www/* " . CHEMIN_DESTINATION);
shell_exec("cp -R ../src/* " . CHEMIN_DESTINATION_PHP);
shell_exec("cp -R ../../mustache.php-master/src/Mustache " . CHEMIN_DESTINATION_PHP);

//echo "Installation des fichiers de config\n";
shell_exec("mv " . CHEMIN_DESTINATION . "/config." . $niveau . ".php " . CHEMIN_DESTINATION . "/config.php");
shell_exec("rm -f " . CHEMIN_DESTINATION . "/config.*.php");

//$gitLog = shell_exec("git log -1 --format=%cd --date=short");
//$gitLog = trim(preg_replace('/\s\s+/', ' ', $gitLog));
//shell_exec('sed -i "s/GITLOG/' . $gitLog . '/" ' . CHEMIN_DESTINATION . "/config.php");

<<<<<<< HEAD
if ($niveau == "prod" || $niveau == "preprod") {
    echo "Conversion des fichiers\n";
    shell_exec("chown -R " . USAGER_APACHE . ":" . USAGER_APACHE . " " . CHEMIN_DESTINATION);
    shell_exec("chmod -R 755 " . CHEMIN_DESTINATION);
    shell_exec("chown -R " . USAGER_APACHE . ":" . USAGER_APACHE . " " . CHEMIN_DESTINATION_PHP);
    shell_exec("chmod -R 755 " . CHEMIN_DESTINATION_PHP);
}

=======
>>>>>>> cb066fb76c600b85a47b9a982337c066ef2c7094
echo "-----------------------\n";
echo "Fin de l'installation\n";