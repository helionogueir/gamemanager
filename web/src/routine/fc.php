<?php

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/Sao_Paulo');

try {
    $db = new PDO("mysql:host=dbsql;dbname=challenge;port=3306;charset=utf8", 'root', 'root', array(
        PDO::ATTR_AUTOCOMMIT => true,
        PDO::ATTR_PERSISTENT => false,
        PDO::ATTR_EMULATE_PREPARES => true,
        PDO::ATTR_TIMEOUT => 1800,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ));

    $tstmt = $db->prepare('SELECT t.* FROM team t');
    $tstmt->execute();
    $teams = array();
    $count = 1;
    foreach ($tstmt->fetchAll() as $team) {
        if (empty($teams[$count]))
            $teams[$count] = array();
        array_push($teams[$count], $team->id);
        if (($team->id % 5) == 0)
            $count++;
    }

    $mstmt = $db->prepare('INSERT INTO `match` VALUES (DEFAULT, :groupid, :ateamid, :bteamid, 16, 15, 16, 1546308000, 1546308000)');
    foreach ($teams as $groupid => $values) {
        for ($i = 0; $i < count($values); $i++) {
            $ateamid = $values[$i];
            for ($k = ($i + 1); $k <= (count($values) - 1); $k++) {
                $bteamid = $values[$k];
                $mstmt->execute(array(
                    'groupid' => $groupid,
                    'ateamid' => $ateamid,
                    'bteamid' => $bteamid
                ));
            }
        }
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
    echo $ex->getTraceAsString();
}
