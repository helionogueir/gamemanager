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

    $gstmt = $db->prepare('SELECT g.* FROM `group` g');
    $gmstmt = $db->prepare('SELECT gm.* FROM group_members gm WHERE gm.groupid = :groupid');
    $mstmt = $db->prepare('INSERT INTO `match` VALUES (DEFAULT, :amemberid, :bmemberid, 16, 15, 16, 1546308000, 1546308000)');

    $gstmt->execute();
    foreach ($gstmt->fetchAll() as $group) {
        $teams = array();
        $gmstmt->execute(array('groupid' => $group->id));
        foreach ($gmstmt->fetchAll() as $member) {
            array_push($teams, $member->id);
        }
        for ($i = 0; $i <= count($teams); $i++) {
            for ($k = ($i + 1); $k <= (count($teams) - 1); $k++) {
                $mstmt->execute(array(
                    'amemberid' => $teams[$i],
                    'bmemberid' => $teams[$k]
                ));
            }
        }
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
    echo $ex->getTraceAsString();
}
