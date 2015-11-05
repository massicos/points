<?php

require_once('config.php');
require_once(RACINE . '/points-' . NIVEAU .  '/classes/Familly.php');
require_once(RACINE . '/points-' . NIVEAU .  '/classes/Child.php');
require RACINE . '/points-' . NIVEAU .  '/Mustache/Autoloader.php';
Mustache_Autoloader::register();

$m = new Mustache_Engine;

$familly = Familly::loadFromJson(PATHDATA . '/familly-1.json');
//echo $m->render(file_get_contents(RACINE . '/points-' . NIVEAU .  '/templates/dashboard.mustache.html'), array('name' => 'Massicotte'));
$famillyStdObj = new StdClass();
$famillyStdObj->name = "bozo";
echo $m->render(file_get_contents(RACINE . '/points-' . NIVEAU .  '/templates/dashboard.mustache.html'), $familly->toStdClass());