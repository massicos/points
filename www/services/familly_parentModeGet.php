<?php
require_once('../config.php');

require_once(RACINE . '/points-' . NIVEAU .  '/classes/Familly.php');
require_once(RACINE . '/points-' . NIVEAU .  '/classes/Child.php');

try {
    session_start();
    $stdObject = new stdClass();
    if (array_key_exists('parentMode', $_SESSION)) {
        $stdObject->parentMode = $_SESSION['parentMode'];
    } else {
        $stdObject->parentMode = false;
    }
    echo json_encode($stdObject);
} catch (Exception $ex) {
    $stdObj = new stdClass();
    $stdObj->erreur = 1;
    $stdObj->messageErreur = $ex->getMessage();

    header('500: Error', true, 500);
    echo json_encode($stdObj);
}