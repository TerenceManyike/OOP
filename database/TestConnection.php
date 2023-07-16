<?php

include_once('Database.php');

$db_conn = new Database();

//echo $db_conn->getError().PHP_EOL;

$db_conn->query('select * from test_table');

var_dump($db_conn->getAll());