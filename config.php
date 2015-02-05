<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
$host_name = "localhost";
$db_name = "dataiku";
$table_name = "census_learn_sql";
$user_name = "root";
$user_password = "toor";
$db_file = 'us-census.db';

try {
    $db = new PDO('mysql:host=' . $host_name . ';dbname=' . $db_name, $user_name, $user_password);
    //$db = new PDO('sqlite:'.dirname(__FILE__).$db_file);
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

$file = "log.txt";
//file_put_contents($file, date("Y-m-d H:i:s") . "\n" .$_SERVER['HTTP_USER_AGENT'] . "\n" . $_SERVER['REMOTE_ADDR'] . "\n" . $_SERVER['SCRIPT_FILENAME'] . "\n==============\n", FILE_APPEND);
