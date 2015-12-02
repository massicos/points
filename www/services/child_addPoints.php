<?php
require_once('../config.php');

require_once(RACINE . '/points-' . NIVEAU .  '/classes/Familly.php');
require_once(RACINE . '/points-' . NIVEAU .  '/classes/Child.php');

try {
    session_start();
    
    $idFamille = 1;
    $familly = Familly::loadFromJson(PATHDATA . '/familly-' . $idFamille . '.json');
    
    if (array_key_exists('parentMode', $_SESSION)) {
        $familly->setParentMode($_SESSION['parentMode']);
    } else {
        $familly->setParentMode(false);
    }
    
    if ($familly->isParentModeActive()) {

        $child = $familly->getChildByFirstName($_REQUEST['firstName']);
        if ($child != false) {
            $child->addPoints($_REQUEST['points']);
            $familly->saveToJson(PATHDATA, 'familly-' . $idFamille . '.json');
            echo json_encode($child->toStdClass());
        } else {
            header('500: Error', true, 500);
            echo "ERREUR !!";
        }
    } else {
        header('500: Error', true, 500);
        echo "ERREUR pas en mode parent !!";
    }
} catch (Exception $ex) {
    $stdObj = new stdClass();
    $stdObj->erreur = 1;
    $stdObj->messageErreur = $ex->getMessage();

    header('500: Error', true, 500);
    echo json_encode($stdObj);
}