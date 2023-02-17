<?php
// $host = getenv('DB_HOST');
// $username = getenv('DB_USER');
// $password = getenv('DB_PASS');
// $database = getenv('DB_NAME');

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'api_coba';

$connection = mysqli_connect($host, $username, $password, $database);
