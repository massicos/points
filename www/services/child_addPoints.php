<?php
require_once('../config.php');

require_once(RACINE . '/points-' . NIVEAU .  '/classes/Familly.php');
require_once(RACINE . '/points-' . NIVEAU .  '/classes/Child.php');

try {
    $idFamille = 1;
    $familly = Familly::loadFromJson(PATHDATA . '/familly-' . $idFamille . '.json');

    $child = $familly->getChildByFirstName($_REQUEST['firstName']);
    if ($child != false) {
        $child->addPoints($_REQUEST['points']);
        $familly->saveToJson(PATHDATA, 'familly-' . $idFamille . '.json');
        echo json_encode($child->toStdClass());
    }
    else {
        echo "ERREUR !!";
    }
} catch (Exception $ex) {
    $stdObj = new stdClass();
    $stdObj->erreur = 1;
    $stdObj->messageErreur = $ex->getMessage();

    echo json_encode($stdObj);
}