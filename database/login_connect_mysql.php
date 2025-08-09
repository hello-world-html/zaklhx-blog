<?php

// $servername ="127.0.0.1";
// $mysqlusername = "admin";
// $mysqlpassword = "xc7788";
// $dbname = "huserver_cn_org";
// $port = 3306;

// error_reporting(0);
// $conn = new mysqli($servername, $mysqlusername, $mysqlpassword, $dbname, $port);
// if ($conn->connect_error) {
//     die("连接失败: ". $conn->connect_error);
// }

// $servername ="127.0.0.1";
// $mysqlusername = "administrator";
// $mysqlpassword = "xc7788";
// $dbname = "huserver_cn_org_administrator";
// $port = 3306;

// error_reporting(0);
// $conn = new mysqli($servername, $mysqlusername, $mysqlpassword, $dbname, $port);
// if ($conn->connect_error) {
//     die("连接失败: ". $conn->connect_error);
// }

// ------------------------------------------------------------------------------------------------------------------------

// Database connection configuration
$config = [
    'servername' => '127.0.0.1',
    'username' => 'admin',
    'password' => 'xc7788',
    'dbname' => 'zakolhx_blog',
    'port' => 3306
];

// Set error reporting based on environment
if (getenv('ENVIRONMENT') === 'production') {
    error_reporting(0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Establish database connection
try {
    $conn = new mysqli(
        $config['servername'],
        $config['username'],
        $config['password'],
        $config['dbname'],
        $config['port']
    );

    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    // Log the error and display a generic message
    error_log($e->getMessage());
    die("An error occurred while connecting to the database. Please try again later.");
}
