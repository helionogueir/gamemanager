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

    $sql = 'SELECT t.* FROM team t';
    $stmt = $db->prepare($sql);
    $stmt->execute(array());

    $groupid = 1;
    $insert = 'INSERT INTO group_members VALUES (DEFAULT, :groupid, :teamid, 1546308000)';
    $stmtInsert = $db->prepare($insert);

    $count = 1;
    foreach ($stmt->fetchAll() as $row) {
        $stmtInsert->execute(array(
            'groupid' => $groupid,
            'teamid' => $row->id
        ));
        if (($count % 5) == 0) $groupid++;
        $count++;
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
    echo $ex->getTraceAsString();
}
