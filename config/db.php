<?php
    $host = 'localhost';
    $port = '5432';
    $db = 'scheduler';
    $username = 'gaetano';
    $password = 'tirocinio';

    $connection_string = "host=$host port=$port dbname=$db user=$username password=$password";
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
?>
