<?php
require_once('../config.php');

require_once(RACINE . '/points-' . NIVEAU .  '/classes/Familly.php');
require_once(RACINE . '/points-' . NIVEAU .  '/classes/Child.php');

try {
    $idFamille = 1;
    $familly = Familly::loadFromJson(PATHDATA . '/familly-' . $idFamille . '.json');

    if ($familly->validatePassword($_REQUEST['password'])) {
        session_start();
        $_SESSION['parentMode'] = true;
        $stdObject = new stdClass();
        $stdObject->parentMode = true;
        echo json_encode($stdObject);
    }
    else {
        header('500: Error', true, 500);
        echo "ERREUR !!";
    }
} catch (Exception $ex) {
    $stdObj = new stdClass();
    $stdObj->erreur = 1;
    $stdObj->messageErreur = $ex->getMessage();

    header('500: Error', true, 500);
    echo json_encode($stdObj);
}